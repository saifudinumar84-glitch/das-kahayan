<?php

namespace App\Livewire\Portal;

use App\Models\BapDocument;
use App\Models\CapaClosure;
use App\Models\Facility;
use App\Models\FollowUpLetter;
use App\Models\Inspection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Documents extends Component
{
    public string $type = 'all';

    public string $year = 'all';

    public ?Facility $facility = null;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user && $user->facilities()->exists()) {
            $this->facility = $user->facilities()->first();
        } else {
            $this->facility = Facility::first();
        }
    }

    public function filterType(string $type): void
    {
        $this->type = $type;
    }

    public function render()
    {
        $facilityId = $this->facility?->id;
        $inspectionIds = Inspection::where('facility_id', $facilityId)->pluck('id');

        $bapDocs = BapDocument::whereIn('inspection_id', $inspectionIds)
            ->with('inspection')
            ->latest('generated_at')
            ->get();

        $closureDocs = CapaClosure::whereIn('inspection_id', $inspectionIds)
            ->with('inspection')
            ->latest('approved_at')
            ->get();

        $followUpDocs = FollowUpLetter::whereIn('inspection_id', $inspectionIds)
            ->with(['inspection', 'sender'])
            ->latest('sent_at')
            ->get();

        return view('livewire.portal.documents', [
            'facility' => $this->facility,
            'bapDocs' => $bapDocs,
            'closureDocs' => $closureDocs,
            'followUpDocs' => $followUpDocs,
            'totalDocsCount' => $bapDocs->count() + $closureDocs->count() + $followUpDocs->count(),
        ])->layout('layouts.portal', [
            'title' => 'Repositori Dokumen & BAP — Si Kahayan BBPOM Palangka Raya',
            'description' => 'Arsip resmi Berita Acara Pemeriksaan (BAP) dan Surat Pengesahan Closed CAPA dengan legalitas TTE BSrE BSSN.',
        ]);
    }
}
