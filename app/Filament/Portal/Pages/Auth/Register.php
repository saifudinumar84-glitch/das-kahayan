<?php

namespace App\Filament\Portal\Pages\Auth;

use App\Models\Facility;
use App\Models\User;
use Closure;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Facades\Filament;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Pendaftaran akun Pelaku Usaha (panel /portal).
 *
 * - Membuat 1 user (role = business) + 1 sarana + relasi di facility_users.
 * - Akun dan sarana dibuat NONAKTIF (is_active = false) sampai diverifikasi
 *   Administrator BBPOM, agar orang luar tidak bisa langsung melihat
 *   temuan/CAPA. Karena itu pengguna TIDAK di-login otomatis.
 * - role dan is_active diisi server (tidak dari form, tidak masuk $fillable).
 */
class Register extends BaseRegister
{
    /** Wilayah kerja BBPOM Palangka Raya (Kalimantan Tengah). */
    protected const REGENCIES = [
        'Kota Palangka Raya',
        'Kabupaten Barito Selatan',
        'Kabupaten Barito Timur',
        'Kabupaten Barito Utara',
        'Kabupaten Gunung Mas',
        'Kabupaten Kapuas',
        'Kabupaten Katingan',
        'Kabupaten Kotawaringin Barat',
        'Kabupaten Kotawaringin Timur',
        'Kabupaten Lamandau',
        'Kabupaten Murung Raya',
        'Kabupaten Pulang Pisau',
        'Kabupaten Sukamara',
        'Kabupaten Seruyan',
    ];

    public function getTitle(): string
    {
        return 'Pendaftaran Pelaku Usaha';
    }

    public function getHeading(): string
    {
        return 'Daftar Akun Pelaku Usaha';
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Data Akun')
                ->description('Akun ini dipakai penanggung jawab sarana untuk masuk ke Si Kahayan.')
                ->schema([
                    $this->getNameFormComponent()
                        ->label('Nama penanggung jawab'),
                    $this->getEmailFormComponent(),
                    TextInput::make('phone')
                        ->label('Nomor telepon')
                        ->tel()
                        ->required()
                        ->maxLength(20)
                        ->regex('/^[0-9+\-\s]{8,20}$/')
                        ->validationMessages([
                            'regex' => 'Nomor telepon hanya boleh berisi angka, spasi, tanda + dan -.',
                        ]),
                    $this->getPasswordFormComponent(),
                    $this->getPasswordConfirmationFormComponent(),
                ]),

            Section::make('Data Sarana')
                ->description('Data sarana produksi atau distribusi pangan olahan milik Anda.')
                ->schema([
                    TextInput::make('facility_name')
                        ->label('Nama sarana / perusahaan')
                        ->required()
                        ->maxLength(255),
                    Select::make('facility_type')
                        ->label('Jenis sarana')
                        ->options([
                            'production' => 'Produksi',
                            'distribution' => 'Distribusi',
                        ])
                        ->required(),
                    TextInput::make('commodity_type')
                        ->label('Jenis komoditas')
                        ->helperText('Contoh: makanan ringan, minuman serbuk, bumbu.')
                        ->required()
                        ->maxLength(255),
                    Textarea::make('address')
                        ->label('Alamat lengkap')
                        ->required()
                        ->rows(3)
                        ->maxLength(1000),
                    Select::make('regency')
                        ->label('Kabupaten/Kota')
                        ->options(array_combine(self::REGENCIES, self::REGENCIES))
                        ->searchable()
                        ->required(),
                    TextInput::make('nib')
                        ->label('NIB')
                        ->helperText('13 digit angka.')
                        ->required()
                        ->regex('/^\d{13}$/')
                        ->validationMessages(['regex' => 'NIB harus 13 digit angka.']),
                    TextInput::make('npwp')
                        ->label('NPWP')
                        ->helperText('15 atau 16 digit; titik dan strip boleh dipakai.')
                        ->required()
                        ->maxLength(24)
                        ->rules([
                            fn (): Closure => function (string $attribute, $value, Closure $fail): void {
                                $digits = preg_replace('/\D/', '', (string) $value);

                                if (! in_array(strlen($digits), [15, 16], true)) {
                                    $fail('NPWP harus 15 atau 16 digit.');
                                }
                            },
                        ])
                        ->dehydrateStateUsing(fn ($state) => preg_replace('/\D/', '', (string) $state)),
                ]),

            Section::make('Data Izin (opsional)')
                ->description('Boleh dikosongkan dan dilengkapi kemudian.')
                ->collapsed()
                ->schema([
                    TextInput::make('nie_number')
                        ->label('Nomor NIE')
                        ->maxLength(100),
                    TextInput::make('cppob_certificate_number')
                        ->label('Nomor sertifikat IP CPPOB')
                        ->maxLength(100),
                    DatePicker::make('cppob_certificate_valid_until')
                        ->label('Masa berlaku sertifikat CPPOB'),
                ]),
        ]);
    }

    /**
     * Ganti alur bawaan: jangan login otomatis (akun menunggu verifikasi),
     * arahkan ke halaman login dengan pemberitahuan.
     */
    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(3);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();

        $this->handleRegistration($data);

        Notification::make()
            ->title('Pendaftaran berhasil')
            ->body('Akun Anda menunggu verifikasi BBPOM Palangka Raya. Anda dapat masuk setelah akun diaktifkan.')
            ->success()
            ->persistent()
            ->send();

        $this->redirect(Filament::getLoginUrl());

        return null;
    }

    protected function handleRegistration(array $data): Model
    {
        return DB::transaction(function () use ($data): User {
            // Password sudah di-hash oleh komponen password bawaan Filament.
            $user = new User([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
            ]);
            $user->forceFill(['role' => 'business', 'is_active' => false])->save();

            // nib & npwp terenkripsi lewat encrypted cast di model Facility.
            $facility = new Facility([
                'name' => $data['facility_name'],
                'facility_type' => $data['facility_type'],
                'commodity_type' => $data['commodity_type'],
                'address' => $data['address'],
                'regency' => $data['regency'],
                'pic_name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'nib' => $data['nib'],
                'npwp' => $data['npwp'],
                'nie_number' => $data['nie_number'] ?? null,
                'cppob_certificate_number' => $data['cppob_certificate_number'] ?? null,
                'cppob_certificate_valid_until' => $data['cppob_certificate_valid_until'] ?? null,
            ]);
            $facility->forceFill(['is_active' => false])->save();

            DB::table('facility_users')->insert([
                'facility_id' => $facility->getKey(),
                'user_id' => $user->getKey(),
            ]);

            return $user;
        });
    }
}
