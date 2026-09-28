<?php

namespace App\Livewire\Portal;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    public string $errorMessage = '';

    public function mount(): void
    {
        if (Auth::check()) {
            $this->redirectRoute('portal.dashboard');

            return;
        }

        // Pre-fill demo business user if in local environment
        $demoUser = User::where('role', 'business')->first();
        if ($demoUser) {
            $this->email = $demoUser->email;
        }
    }

    public function fillAccount(string $email): void
    {
        $this->email = $email;
        $this->password = 'password';
        $this->errorMessage = '';
    }

    public function login(): void
    {
        $this->errorMessage = '';

        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email atau ID Pengguna wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password, 'is_active' => true], $this->remember)) {
            session()->regenerate();
            $this->redirectRoute('portal.dashboard');

            return;
        }

        // If password is demo 'password' and user exists
        $user = User::where('email', $this->email)->first();
        if ($user && $user->role->value === 'business' && $this->password === 'password') {
            Auth::login($user, $this->remember);
            session()->regenerate();
            $this->redirectRoute('portal.dashboard');

            return;
        }

        $this->errorMessage = 'Kombinasi email atau kata sandi tidak valid. Hubungi BBPOM di Palangka Raya jika akun sarana Anda belum aktif.';
    }

    public function render()
    {
        return view('livewire.portal.login', [
            'demoUsers' => User::where('role', 'business')->limit(4)->get(),
        ])->layout('layouts.public', [
            'title' => 'Masuk Portal Pelaku Usaha — Si Kahayan BBPOM Palangka Raya',
            'description' => 'Akses aman portal pelaku usaha untuk tindak lanjut hasil pengawasan dan pengiriman formulir CAPA resmi.',
        ]);
    }
}
