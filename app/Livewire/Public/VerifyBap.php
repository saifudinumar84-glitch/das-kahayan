<?php

namespace App\Livewire\Public;

use App\Models\BapDocument;
use Livewire\Component;

class VerifyBap extends Component
{
    public string $token = '';

    public bool $isSearched = false;

    public ?BapDocument $document = null;

    public function mount(?string $token = null): void
    {
        if ($token) {
            $this->token = $token;
            $this->verify();
        }
    }

    public function verify(): void
    {
        $this->isSearched = true;

        if (trim($this->token) === '') {
            $this->document = null;

            return;
        }

        $this->document = BapDocument::with('inspection.facility', 'inspection.inspector')
            ->where('qr_token', trim($this->token))
            ->first();
    }

    public function render()
    {
        return view('livewire.public.verify-bap')
            ->layout('layouts.public', [
                'title' => 'Validasi BAP — Si Kahayan BBPOM Palangka Raya',
            ]);
    }
}
