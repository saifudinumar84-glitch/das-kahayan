<?php

namespace App\Livewire\Public;

use App\Models\CapaClosure;
use App\Models\Facility;
use App\Models\Inspection;
use App\Models\Sampling;
use Livewire\Component;

class Home extends Component
{
    public string $search = '';

    public string $activeTab = 'sampel';

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function searchProducts(): void
    {
        if (trim($this->search) !== '') {
            $this->redirectRoute('publik.cari', ['q' => $this->search]);
        }
    }

    public function render()
    {
        return view('livewire.public.home', [
            'statSampel' => Sampling::where('publication_status', 'published')->count(),
            'statSarana' => Facility::count(),
            'statKepatuhan' => $this->calculateComplianceRate(),
            'statTemuan' => $this->countClosedFindings(),
            'recentSamplings' => Sampling::with('foodType.foodCategory')
                ->where('publication_status', 'published')
                ->latest('sampling_date')
                ->limit(5)
                ->get(),
            'recentInspections' => Inspection::with('facility')
                ->where('publication_status', 'published')
                ->latest('inspection_date')
                ->limit(5)
                ->get(),
        ])->layout('layouts.public', [
            'title' => 'Beranda — Si Kahayan BBPOM Palangka Raya',
            'description' => 'Portal keterbukaan informasi pengawasan pangan olahan Balai Besar POM di Palangka Raya, Kalimantan Tengah.',
        ]);
    }

    private function calculateComplianceRate(): string
    {
        $total = Sampling::where('publication_status', 'published')
            ->whereNotNull('conclusion')
            ->count();

        if ($total === 0) {
            return '0%';
        }

        $compliant = Sampling::where('publication_status', 'published')
            ->where('conclusion', 'compliant')
            ->count();

        return number_format(($compliant / $total) * 100, 1).'%';
    }

    private function countClosedFindings(): int
    {
        return CapaClosure::where('status', 'sent')->count();
    }
}
