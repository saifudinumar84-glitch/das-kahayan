<?php

namespace App\Livewire\Public;

use Livewire\Component;

class Guide extends Component
{
    public string $activeSection = 'pelaku-usaha';

    public function switchSection(string $section): void
    {
        $this->activeSection = $section;
    }

    public function render()
    {
        return view('livewire.public.guide')
            ->layout('layouts.public', [
                'title' => 'Panduan — Si Kahayan BBPOM Palangka Raya',
            ]);
    }
}
