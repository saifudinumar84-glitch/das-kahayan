<?php

namespace App\Livewire\Portal;

use App\Models\Facility;
use App\Models\Inspection;
use App\Models\InspectionFinding;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public ?Facility $facility = null;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user && $user->facilities()->exists()) {
            $this->facility = $user->facilities()->first();
        } else {
            // Fallback to first facility for demonstration
            $this->facility = Facility::first();
        }
    }

    public function render()
    {
        $facilityId = $this->facility?->id;

        $inspectionsQuery = Inspection::where('facility_id', $facilityId);
        $inspectionIds = (clone $inspectionsQuery)->pluck('id');

        $findingsQuery = InspectionFinding::whereIn('inspection_id', $inspectionIds);

        $openFindingsCount = (clone $findingsQuery)->where('status', '!=', 'closed')->count();
        $closedFindingsCount = (clone $findingsQuery)->where('status', 'closed')->count();
        $overdueCount = (clone $findingsQuery)
            ->where('status', '!=', 'closed')
            ->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->count();

        $recentFindings = (clone $findingsQuery)
            ->with(['inspection', 'requirement', 'capaSubmissions' => function ($q) {
                $q->latest();
            }])
            ->latest()
            ->limit(5)
            ->get();

        $recentInspections = (clone $inspectionsQuery)
            ->with(['findings', 'bapDocument'])
            ->latest('inspection_date')
            ->limit(3)
            ->get();

        return view('livewire.portal.dashboard', [
            'facility' => $this->facility,
            'openFindingsCount' => $openFindingsCount,
            'closedFindingsCount' => $closedFindingsCount,
            'overdueCount' => $overdueCount,
            'recentFindings' => $recentFindings,
            'recentInspections' => $recentInspections,
        ])->layout('layouts.portal', [
            'title' => 'Dashboard Pelaku Usaha — Si Kahayan BBPOM Palangka Raya',
            'description' => 'Dashboard sentra layanan pemantauan pengawasan sarana dan tindak lanjut CAPA BBPOM Palangka Raya.',
        ]);
    }
}
