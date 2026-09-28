<?php

namespace App\Livewire\Public;

use App\Models\Inspection;
use App\Models\Sampling;
use Livewire\Component;

class InspectionDetail extends Component
{
    public ?string $id = null;

    public string $activeTab = 'lab';

    public ?Sampling $sampling = null;

    public ?Inspection $inspection = null;

    public function mount(?string $id = null): void
    {
        $this->id = $id;

        if ($id) {
            $this->sampling = Sampling::with(['facility', 'foodType.foodCategory', 'testResults.testParameter'])
                ->where('publication_status', 'published')
                ->where('id', $id)
                ->first();

            $this->inspection = Inspection::with(['facility', 'findings.requirement', 'bapDocument'])
                ->where('publication_status', 'published')
                ->where('id', $id)
                ->first();

            if ($this->inspection && ! $this->sampling) {
                $this->activeTab = 'sarana';
            }
        }

        if (! $this->sampling) {
            $this->sampling = Sampling::with(['facility', 'foodType.foodCategory', 'testResults.testParameter'])
                ->where('publication_status', 'published')
                ->latest('sampling_date')
                ->first();
        }

        if (! $this->inspection) {
            $this->inspection = Inspection::with(['facility', 'findings.requirement', 'bapDocument'])
                ->where('publication_status', 'published')
                ->latest('inspection_date')
                ->first();
        }
    }

    public function switchTab(string $tab): void
    {
        if (in_array($tab, ['lab', 'sarana'], true)) {
            $this->activeTab = $tab;
        }
    }

    public function render()
    {
        return view('livewire.public.inspection-detail', [
            'sampling' => $this->sampling,
            'inspection' => $this->inspection,
        ])->layout('layouts.public', [
            'title' => 'Detail Hasil Pengujian & Pemeriksaan — Si Kahayan BBPOM Palangka Raya',
            'description' => 'Detail transparan hasil pengujian sampel pangan olahan dan pemeriksaan sarana oleh BBPOM di Palangka Raya.',
        ]);
    }
}
