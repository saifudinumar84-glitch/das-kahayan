<?php

namespace App\Livewire\Portal;

use App\Models\Facility;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FacilityProfile extends Component
{
    public ?Facility $facility = null;

    public function mount(): void
    {
        $user = Auth::user();

        if ($user && $user->facilities()->exists()) {
            $this->facility = $user->facilities()->with(['inspections.findings'])->first();
        } else {
            $this->facility = Facility::with(['inspections.findings'])->first();
        }
    }

    public function render()
    {
        $latestInspection = $this->facility?->inspections()->latest('inspection_date')->first();

        return view('livewire.portal.facility-profile', [
            'facility' => $this->facility,
            'latestInspection' => $latestInspection,
        ])->layout('layouts.portal', [
            'title' => 'Profil Sarana Usaha — Si Kahayan BBPOM Palangka Raya',
            'description' => 'Dossier profil legalitas, sertifikasi CPPOB/CPerPOB, dan rekam jejak kepatuhan sarana binaan.',
        ]);
    }
}
