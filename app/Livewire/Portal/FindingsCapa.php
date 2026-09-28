<?php

namespace App\Livewire\Portal;

use App\Models\Facility;
use App\Models\Inspection;
use App\Models\InspectionFinding;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class FindingsCapa extends Component
{
    use WithPagination;

    public string $tab = 'all';

    public string $search = '';

    public string $standard = 'all';

    public ?Facility $facility = null;

    protected $queryString = [
        'tab' => ['except' => 'all'],
        'search' => ['except' => ''],
        'standard' => ['except' => 'all'],
    ];

    public function mount(): void
    {
        $user = Auth::user();

        if ($user && $user->facilities()->exists()) {
            $this->facility = $user->facilities()->first();
        } else {
            $this->facility = Facility::first();
        }
    }

    public function switchTab(string $tab): void
    {
        $this->tab = $tab;
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStandard(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $facilityId = $this->facility?->id;
        $inspectionIds = Inspection::where('facility_id', $facilityId)->pluck('id');

        $query = InspectionFinding::whereIn('inspection_id', $inspectionIds)
            ->with(['inspection', 'requirement', 'capaSubmissions' => function ($q) {
                $q->latest();
            }]);

        if (trim($this->search) !== '') {
            $search = '%'.$this->search.'%';
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', $search)
                    ->orWhere('recommendation', 'like', $search);
            });
        }

        if ($this->standard !== 'all') {
            $query->where('standard', $this->standard);
        }

        if ($this->tab === 'need_action') {
            $query->where('status', '!=', 'closed');
        } elseif ($this->tab === 'review') {
            $query->whereHas('capaSubmissions', function ($q) {
                $q->where('status', 'submitted');
            })->where('status', '!=', 'closed');
        } elseif ($this->tab === 'closed') {
            $query->where('status', 'closed');
        }

        $findings = $query->latest()->paginate(10);

        // Counts for tab badges
        $counts = [
            'all' => InspectionFinding::whereIn('inspection_id', $inspectionIds)->count(),
            'need_action' => InspectionFinding::whereIn('inspection_id', $inspectionIds)->where('status', '!=', 'closed')->count(),
            'closed' => InspectionFinding::whereIn('inspection_id', $inspectionIds)->where('status', 'closed')->count(),
        ];

        return view('livewire.portal.findings-capa', [
            'facility' => $this->facility,
            'findings' => $findings,
            'counts' => $counts,
        ])->layout('layouts.portal', [
            'title' => 'Daftar Temuan & CAPA — Si Kahayan BBPOM Palangka Raya',
            'description' => 'Kelola, pantau batas waktu, dan sampaikan bukti Corrective and Preventive Action (CAPA) hasil pengawasan.',
        ]);
    }
}
