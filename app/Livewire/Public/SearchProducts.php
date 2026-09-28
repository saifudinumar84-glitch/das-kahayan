<?php

namespace App\Livewire\Public;

use App\Models\Facility;
use App\Models\Sampling;
use Livewire\Component;
use Livewire\WithPagination;

class SearchProducts extends Component
{
    use WithPagination;

    public string $query = '';

    public string $searchType = 'all';

    public function mount(?string $q = null): void
    {
        if ($q) {
            $this->query = $q;
        }
    }

    public function updatedQuery(): void
    {
        $this->resetPage();
    }

    public function updatedSearchType(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = collect();
        $facilities = collect();

        if (mb_strlen(trim($this->query)) >= 2) {
            if ($this->searchType === 'all' || $this->searchType === 'produk') {
                $products = Sampling::with('foodType.foodCategory')
                    ->where('publication_status', 'published')
                    ->where(function ($q) {
                        $q->where('product_name', 'ilike', "%{$this->query}%")
                            ->orWhere('brand', 'ilike', "%{$this->query}%");
                    })
                    ->latest('sampling_date')
                    ->paginate(10, pageName: 'produkPage');
            }

            if ($this->searchType === 'all' || $this->searchType === 'sarana') {
                $facilities = Facility::query()
                    ->where('is_active', true)
                    ->where(function ($q) {
                        $q->where('name', 'ilike', "%{$this->query}%")
                            ->orWhere('regency', 'ilike', "%{$this->query}%")
                            ->orWhere('commodity_type', 'ilike', "%{$this->query}%");
                    })
                    ->orderBy('name')
                    ->paginate(10, pageName: 'saranaPage');
            }
        }

        return view('livewire.public.search-products', [
            'products' => $products,
            'facilities' => $facilities,
        ])->layout('layouts.public', [
            'title' => 'Cari Produk & Sarana — Si Kahayan BBPOM Palangka Raya',
        ]);
    }
}
