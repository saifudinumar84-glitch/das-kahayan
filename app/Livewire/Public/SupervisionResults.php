<?php

namespace App\Livewire\Public;

use App\Models\Inspection;
use App\Models\Sampling;
use Livewire\Component;
use Livewire\WithPagination;

class SupervisionResults extends Component
{
    use WithPagination;

    public string $year = '';

    public string $category = '';

    public string $regency = '';

    public string $conclusion = '';

    public string $activeTab = 'sampel';

    public function mount(): void
    {
        $this->year = (string) date('Y');
    }

    public function switchTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatedYear(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function updatedRegency(): void
    {
        $this->resetPage();
    }

    public function updatedConclusion(): void
    {
        $this->resetPage();
    }

    public function resetFilters(): void
    {
        $this->year = (string) date('Y');
        $this->category = '';
        $this->regency = '';
        $this->conclusion = '';
        $this->resetPage();
    }

    public function render()
    {
        $samplings = Sampling::with('foodType.foodCategory')
            ->where('publication_status', 'published')
            ->when($this->year, fn ($q) => $q->whereYear('sampling_date', $this->year))
            ->when($this->category, fn ($q) => $q->whereHas('foodType.foodCategory', fn ($sq) => $sq->where('name', 'like', "%{$this->category}%")))
            ->when($this->regency, fn ($q) => $q->where('sampling_location', 'like', "%{$this->regency}%"))
            ->when($this->conclusion, fn ($q) => $q->where('conclusion', $this->conclusion))
            ->latest('sampling_date')
            ->paginate(10, pageName: 'samplingPage');

        $inspections = Inspection::with('facility')
            ->where('publication_status', 'published')
            ->when($this->year, fn ($q) => $q->whereYear('inspection_date', $this->year))
            ->when($this->regency, fn ($q) => $q->whereHas('facility', fn ($sq) => $sq->where('regency', 'like', "%{$this->regency}%")))
            ->latest('inspection_date')
            ->paginate(10, pageName: 'inspectionPage');

        return view('livewire.public.supervision-results', [
            'samplings' => $samplings,
            'inspections' => $inspections,
            'totalSamplings' => Sampling::where('publication_status', 'published')->count(),
            'totalInspections' => Inspection::where('publication_status', 'published')->count(),
        ])->layout('layouts.public', [
            'title' => 'Hasil Pengawasan — Si Kahayan BBPOM Palangka Raya',
        ]);
    }
}
