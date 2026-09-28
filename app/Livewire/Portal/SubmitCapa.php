<?php

namespace App\Livewire\Portal;

use App\Enums\CapaSubmissionStatus;
use App\Models\Attachment;
use App\Models\CapaSubmission;
use App\Models\InspectionFinding;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class SubmitCapa extends Component
{
    use WithFileUploads;

    public ?string $findingId = null;

    public ?InspectionFinding $finding = null;

    public string $rootCause = '';

    public string $correctiveAction = '';

    public string $preventiveAction = '';

    public $attachmentFile = null;

    public string $attachmentCaption = '';

    public bool $isSubmittedSuccessfully = false;

    public function mount(?string $findingId = null): void
    {
        $this->findingId = $findingId;

        if ($findingId) {
            $this->finding = InspectionFinding::with([
                'inspection.facility',
                'requirement',
                'capaSubmissions.attachments',
            ])->find($findingId);
        }

        if (! $this->finding) {
            // Find latest active finding for demo
            $this->finding = InspectionFinding::with([
                'inspection.facility',
                'requirement',
                'capaSubmissions.attachments',
            ])->latest()->first();

            $this->findingId = $this->finding?->id;
        }

        // Prepopulate if previous draft exists
        if ($this->finding) {
            $latest = $this->finding->capaSubmissions()->latest()->first();
            if ($latest && $latest->status === CapaSubmissionStatus::Submitted) {
                $this->correctiveAction = $latest->corrective_action ?? '';
                $this->preventiveAction = $latest->preventive_action ?? '';
            }
        }
    }

    public function submit(): void
    {
        $this->validate([
            'correctiveAction' => 'required|min:20',
            'preventiveAction' => 'required|min:20',
            'attachmentFile' => 'nullable|file|max:10240', // max 10MB
        ], [
            'correctiveAction.required' => 'Uraian Tindakan Koreksi (Corrective Action) wajib diisi.',
            'correctiveAction.min' => 'Uraian tindakan koreksi minimal 20 karakter.',
            'preventiveAction.required' => 'Uraian Tindakan Pencegahan (Preventive Action) wajib diisi.',
            'preventiveAction.min' => 'Uraian tindakan pencegahan minimal 20 karakter.',
            'attachmentFile.max' => 'Ukuran berkas bukti eviden maksimal 10 MB.',
        ]);

        if (! $this->finding) {
            return;
        }

        $user = Auth::user() ?? User::where('role', 'business')->first();
        $nextRound = ($this->finding->capaSubmissions()->max('round') ?? 0) + 1;

        $submission = CapaSubmission::create([
            'finding_id' => $this->finding->id,
            'round' => $nextRound,
            'corrective_action' => $this->correctiveAction,
            'preventive_action' => $this->preventiveAction,
            'submitted_by' => $user?->id,
            'submitted_at' => now(),
            'status' => CapaSubmissionStatus::Submitted,
        ]);

        if ($this->attachmentFile) {
            $path = $this->attachmentFile->store('attachments/capa', 'public');
            $originalName = $this->attachmentFile->getClientOriginalName();
            $mime = $this->attachmentFile->getMimeType();
            $size = (int) ($this->attachmentFile->getSize() / 1024);

            Attachment::create([
                'attachable_type' => CapaSubmission::class,
                'attachable_id' => $submission->id,
                'file_path' => $path,
                'file_name' => $originalName,
                'mime' => $mime,
                'size_kb' => $size,
                'caption' => $this->attachmentCaption ?: 'Bukti eviden perbaikan lapangan',
                'uploaded_by' => $user?->id,
            ]);
        }

        $this->isSubmittedSuccessfully = true;

        // Reload finding
        $this->finding->load('capaSubmissions.attachments');
    }

    public function resetForm(): void
    {
        $this->isSubmittedSuccessfully = false;
        $this->rootCause = '';
        $this->correctiveAction = '';
        $this->preventiveAction = '';
        $this->attachmentFile = null;
        $this->attachmentCaption = '';
    }

    public function render()
    {
        return view('livewire.portal.submit-capa', [
            'finding' => $this->finding,
        ])->layout('layouts.portal', [
            'title' => 'Tindak Lanjut & Pengajuan Bukti CAPA — Si Kahayan BBPOM Palangka Raya',
            'description' => 'Formulir resmi pelaporan Corrective and Preventive Action hasil pengawasan sarana.',
        ]);
    }
}
