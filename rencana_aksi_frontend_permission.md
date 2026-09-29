# Rencana Aksi — Frontend Livewire dan Permission Policy

> **Proyek:** Sistem Informasi Kawal Hasil Pengawasan — BBPOM Palangka Raya
> **Stack:** Laravel 13 · Filament v5 · PostgreSQL · Livewire 4 · Tailwind CSS
> **Tanggal:** 29 September 2026

---

## Bagian A — Analisis: Halaman Mana yang Belum Muncul di Aplikasi

### Pemetaan Template ke Livewire

Direktori `template/` memiliki **16 folder HTML** yang merupakan desain dari Google Stitch. Berikut status implementasinya:

| # | Folder Template | Halaman | Route | Livewire Component | Status |
|---|---|---|---|---|---|
| 1 | `beranda_...` | Beranda | `GET /` | `Public\Home` | ✅ Ada |
| 2 | `hasil_pengawasan_...` | Hasil Pengawasan | `GET /hasil-pengawasan` | `Public\SupervisionResults` | ✅ Ada |
| 3 | `cari_produk_sarana_...` | Cari Produk & Sarana | `GET /cari` | `Public\SearchProducts` | ✅ Ada |
| 4 | `detail_hasil_pengujian_...` | Detail Pengujian | `GET /pengujian/{id}` | `Public\InspectionDetail` | ✅ Ada |
| 5 | `validasi_bap_...` | Validasi BAP | `GET /validasi-bap/{token?}` | `Public\VerifyBap` | ✅ Ada |
| 6 | `panduan_...` | Panduan | `GET /panduan` | `Public\Guide` | ✅ Ada |
| 7 | `login_pelaku_usaha_...` | Login Portal | `GET /portal-usaha/login` | `Portal\Login` | ✅ Ada |
| 8 | `dashboard_portal_...` | Dashboard Portal | `GET /portal-usaha/dashboard` | `Portal\Dashboard` | ✅ Ada |
| 9 | `daftar_temuan_dan_capa_...` | Temuan & CAPA | `GET /portal-usaha/temuan-capa` | `Portal\FindingsCapa` | ✅ Ada |
| 10 | `detail_temuan_kirim_capa_...` | Detail Temuan & CAPA | `GET /portal-usaha/capa/kirim/{id?}` | `Portal\SubmitCapa` | ✅ Ada |
| 11 | `dokumen_...` | Dokumen | `GET /portal-usaha/dokumen` | `Portal\Documents` | ✅ Ada |
| 12 | `profil_sarana_...` | Profil Sarana | `GET /portal-usaha/profil` | `Portal\FacilityProfile` | ✅ Ada |
| 13 | `login_pelaku_usaha_mobile_...` | Login Mobile | — | — | ⚠️ Versi responsif, bukan halaman terpisah |
| 14 | `dashboard_portal_mobile_...` | Dashboard Mobile | — | — | ⚠️ Versi responsif, bukan halaman terpisah |
| 15 | `validasi_dokumen_bap_mobile_...` | Validasi BAP Mobile | — | — | ⚠️ Versi responsif, bukan halaman terpisah |
| 16 | `si_kahayan_public_trust_system` | Design System | — | — | ℹ️ Hanya DESIGN.md, bukan halaman |

> **Catatan:** Folder `_mobile_` adalah varian tampilan responsif — bukan halaman Livewire terpisah. Perlu diintegrasikan sebagai breakpoint CSS di view yang sudah ada.

### Kesimpulan

Semua 12 halaman utama sudah memiliki Livewire component dan view blade-nya. Yang perlu dilakukan:

1. **Mengintegrasikan desain HTML template** ke dalam view blade (saat ini mungkin masih placeholder)
2. **Menambahkan responsive breakpoint** dari template mobile ke view yang sudah ada
3. **Menghubungkan view dengan data nyata** dari model Eloquent melalui Livewire component

---

## Bagian B — Integrasi Template Frontend ke Livewire

### B.1 Arsitektur

```
resources/views/
├── layouts/
│   ├── public.blade.php    (sudah ada)
│   └── portal.blade.php    (sudah ada)
└── livewire/
    ├── public/
    │   ├── home.blade.php                   → template: beranda_...
    │   ├── supervision-results.blade.php    → template: hasil_pengawasan_...
    │   ├── search-products.blade.php        → template: cari_produk_sarana_...
    │   ├── inspection-detail.blade.php      → template: detail_hasil_pengujian_...
    │   ├── verify-bap.blade.php             → template: validasi_bap_... + mobile
    │   └── guide.blade.php                  → template: panduan_...
    └── portal/
        ├── login.blade.php                  → template: login_pelaku_usaha_... + mobile
        ├── dashboard.blade.php              → template: dashboard_portal_... + mobile
        ├── findings-capa.blade.php          → template: daftar_temuan_dan_capa_...
        ├── submit-capa.blade.php            → template: detail_temuan_kirim_capa_...
        ├── documents.blade.php              → template: dokumen_...
        └── facility-profile.blade.php       → template: profil_sarana_...
```

### B.2 Halaman Publik — Data yang Perlu Disambungkan

| Halaman | Template Sumber | Data Livewire |
|---|---|---|
| `home.blade.php` | `beranda_...` | Stats cards (total sampling, inspeksi, %MS, temuan), tabel 5 baris terbaru |
| `supervision-results.blade.php` | `hasil_pengawasan_...` | Filter periode/kategori/kabupaten, stats cards, charts, peta kabupaten, tabel paginasi |
| `search-products.blade.php` | `cari_produk_sarana_...` | Toggle Produk/Sarana, sidebar filters, result cards, full-text search via `search_vector` |
| `inspection-detail.blade.php` | `detail_hasil_pengujian_...` | Detail sampling/inspeksi, tabel hasil parameter, status timeline, kolom whitelist |
| `verify-bap.blade.php` | `validasi_bap_...` + mobile | Lookup BapDocument by `qr_token`, variant valid/invalid, form manual BAP number |
| `guide.blade.php` | `panduan_...` | Konten statis + accordion FAQ (Masyarakat, Pelaku Usaha, Cara Validasi BAP) |

### B.3 Portal Pelaku Usaha — Data yang Perlu Disambungkan

| Halaman | Template Sumber | Data Livewire |
|---|---|---|
| `login.blade.php` | `login_...` + mobile | Auth logic sudah ada, verifikasi error state & remember me |
| `dashboard.blade.php` | `dashboard_portal_...` + mobile | Stats cards, alert overdue, tabel temuan aktif, aktivitas terbaru — filter by facility_users |
| `findings-capa.blade.php` | `daftar_temuan_...` | Tabs (Semua/Perlu CAPA/Dalam Review/Ditolak/Closed), filter status, highlight overdue |
| `submit-capa.blade.php` | `detail_temuan_...` | Detail temuan, stepper status, riwayat ronde CAPA, form textarea + file upload, modal konfirmasi |
| `documents.blade.php` | `dokumen_...` | Tabs (BAP/Surat TL/Surat Closed CAPA), tabel, preview drawer, download PDF |
| `facility-profile.blade.php` | `profil_sarana_...` | Data sarana termasuk NIB/NPWP (OK, hanya untuk pemilik), akun terhubung |

### B.4 Aturan Whitelist Data Publik

> [!IMPORTANT]
> Halaman publik HANYA boleh menampilkan kolom berikut. Livewire component wajib `select()` hanya kolom ini, bukan memuat model penuh.

| Entitas | Kolom Publik yang Boleh Tampil |
|---|---|
| **Sampling** | `sampling_date`, `product_name`, `food_type.name`, `food_category.name`, `sampling_location`, `conclusion`, `test_results` |
| **Inspeksi** | `inspection_date`, `facility.name`, `facility.regency`, `facility.facility_type`, `grade`, `conclusion` |
| **Filter wajib** | Hanya jika `publication_status = 'published'` |

**TIDAK BOLEH** tampil: NIB, NPWP, NIE, telepon, email, penanggung jawab, alamat lengkap, koordinat GPS penuh, foto bukti, dokumen CAPA, tanda tangan.

---

## Bagian C — Rencana Permission Policy dengan Spatie Laravel Permission v8

### C.1 Strategi

Aplikasi sudah menggunakan RBAC via:
- `App\Enums\UserRole` (5 role)
- `User::canAccessPanel()` untuk panel Filament
- 8 Policy class di `app/Policies/`

**Strategi Hybrid (Direkomendasikan):** Tetap gunakan Policy yang sudah ada untuk Filament, tambahkan Spatie untuk:
- Middleware `role`/`permission` di route portal
- Blade directives `@role`, `@can` di view
- Granular permission di database yang fleksibel
- Seeder permission terdokumentasi

### C.2 Langkah Instalasi Spatie Permission v8

#### Langkah 1 — Install

```bash
composer require spatie/laravel-permission
```

#### Langkah 2 — Publish Config & Migration

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

> [!WARNING]
> Proyek menggunakan UUID (`HasUuids`). **WAJIB** sesuaikan migration sebelum `migrate`.

#### Langkah 3 — Sesuaikan Migration untuk UUID

Buka `database/migrations/xxxx_create_permission_tables.php`, ganti morph biasa menjadi UUID:

```php
// Ganti $table->morphs('model') dengan:
$table->uuidMorphs('model');
```

Sesuaikan `config/permission.php`:

```php
'column_names' => [
    'model_morph_key' => 'model_id',
    // ...
],
```

#### Langkah 4 — Jalankan Migration

```bash
php artisan migrate
```

#### Langkah 5 — Tambahkan Trait ke User Model

```php
// app/Models/User.php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, HasUuids, Notifiable, HasRoles;
}
```

### C.3 Definisi Roles & Permissions

#### Tabel Permissions

| Area | Permission | Role |
|---|---|---|
| **Panel** | `access.admin-panel` | `admin`, `inspector`, `team_leader` |
| | `access.pimpinan-panel` | `team_leader`, `head`, `admin` |
| | `access.portal` | `business`, `admin` |
| **Sampling** | `sampling.view-any` | `admin`, `inspector`, `team_leader`, `head` |
| | `sampling.create` | `admin`, `inspector`, `team_leader` |
| | `sampling.update` | `admin`, `inspector`, `team_leader` |
| | `sampling.delete` | `admin`, `team_leader` |
| | `sampling.publish` | `admin`, `team_leader` |
| **Inspeksi** | `inspection.view-any` | `admin`, `inspector`, `team_leader`, `head` |
| | `inspection.create` | `admin`, `inspector`, `team_leader` |
| | `inspection.update` | `admin`, `inspector`, `team_leader` |
| | `inspection.delete` | `admin`, `team_leader` |
| | `inspection.publish` | `admin`, `team_leader` |
| | `inspection.issue-bap` | `admin`, `inspector`, `team_leader` |
| **Temuan** | `finding.close` | `admin`, `inspector` |
| | `finding.reopen` | `admin`, `inspector` |
| **CAPA** | `capa.submit` | `business` |
| | `capa.review` | `admin`, `inspector` |
| **Closed CAPA** | `capa-closure.verify` | `admin`, `team_leader` |
| | `capa-closure.approve` | `admin`, `head` |
| **Data Master** | `master.view-any` | `admin`, `inspector`, `team_leader`, `head` |
| | `master.manage` | `admin` |
| **Users** | `user.manage` | `admin` |
| **Perencanaan** | `plan.create` | `admin`, `team_leader` |
| | `plan.update` | `admin`, `team_leader` |
| **Portal** | `portal.view-own-facility` | `business` |
| | `portal.submit-capa` | `business` |
| | `portal.view-documents` | `business` |

### C.4 Middleware Route Portal

```php
// routes/web.php
Route::prefix('portal-usaha')->group(function () {
    Route::get('/login', Login::class)->name('portal.login');
    Route::post('/logout', ...)->name('portal.logout');

    // Rute yang dilindungi
    Route::middleware(['auth', 'role:business|admin'])->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('portal.dashboard');
        Route::get('/temuan-capa', FindingsCapa::class)->name('portal.temuan-capa');
        Route::get('/capa/kirim/{findingId?}', SubmitCapa::class)
            ->name('portal.submit-capa')
            ->middleware('permission:portal.submit-capa');
        Route::get('/dokumen', Documents::class)->name('portal.dokumen');
        Route::get('/profil', FacilityProfile::class)->name('portal.profil');
    });
});
```

### C.5 Daftarkan Middleware Alias

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role'               => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'permission'         => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ]);
})
```

### C.6 PermissionSeeder

File: `database/seeders/PermissionSeeder.php`

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'access.admin-panel', 'access.pimpinan-panel', 'access.portal',
            'sampling.view-any', 'sampling.create', 'sampling.update',
            'sampling.delete', 'sampling.publish',
            'inspection.view-any', 'inspection.create', 'inspection.update',
            'inspection.delete', 'inspection.publish', 'inspection.issue-bap',
            'finding.close', 'finding.reopen',
            'capa.submit', 'capa.review',
            'capa-closure.verify', 'capa-closure.approve',
            'master.view-any', 'master.manage',
            'user.manage',
            'plan.create', 'plan.update',
            'portal.view-own-facility', 'portal.submit-capa', 'portal.view-documents',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $rolePermissions = [
            'admin' => Permission::all()->pluck('name')->toArray(),
            'inspector' => [
                'access.admin-panel',
                'sampling.view-any', 'sampling.create', 'sampling.update',
                'inspection.view-any', 'inspection.create', 'inspection.update', 'inspection.issue-bap',
                'finding.close', 'finding.reopen', 'capa.review',
                'master.view-any',
            ],
            'team_leader' => [
                'access.admin-panel', 'access.pimpinan-panel',
                'sampling.view-any', 'sampling.create', 'sampling.update', 'sampling.delete', 'sampling.publish',
                'inspection.view-any', 'inspection.create', 'inspection.update',
                'inspection.delete', 'inspection.publish', 'inspection.issue-bap',
                'finding.close', 'finding.reopen', 'capa.review',
                'capa-closure.verify',
                'master.view-any', 'plan.create', 'plan.update',
            ],
            'head' => [
                'access.pimpinan-panel',
                'sampling.view-any', 'inspection.view-any',
                'capa-closure.approve', 'master.view-any',
            ],
            'business' => [
                'access.portal',
                'portal.view-own-facility', 'portal.submit-capa', 'portal.view-documents',
                'capa.submit',
            ],
        ];

        foreach ($rolePermissions as $roleName => $perms) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($perms);
        }
    }
}
```

### C.7 Sinkronisasi Spatie Role dengan UserRole Enum

```php
// app/Models/User.php — tambahkan method booted()
protected static function booted(): void
{
    static::saved(function (User $user) {
        if ($user->isDirty('role') && $user->role) {
            $user->syncRoles([$user->role->value]);
        }
    });
}
```

### C.8 Penggunaan di Blade

```blade
{{-- Tampilkan tombol hanya untuk role business --}}
@role('business')
    <a href="{{ route('portal.submit-capa', $finding->id) }}">Buat CAPA</a>
@endrole

{{-- Atau dengan permission --}}
@can('portal.submit-capa')
    <button>Kirim CAPA</button>
@endcan
```

### C.9 Penggunaan di Livewire Component

```php
// app/Livewire/Portal/SubmitCapa.php
public function submitCapa(): void
{
    $this->authorize('portal.submit-capa');
    // ...
}
```

---

## Bagian D — Urutan Eksekusi

```
Tahap 1 — Install Spatie Permission (1 hari)
  ├── composer require spatie/laravel-permission
  ├── Publish config + migration
  ├── Sesuaikan migration untuk UUID
  ├── php artisan migrate
  ├── Tambahkan HasRoles trait ke User model
  ├── Tambahkan booted() sync role di User model
  ├── Buat PermissionSeeder
  └── php artisan db:seed --class=PermissionSeeder

Tahap 2 — Middleware & Route (0.5 hari)
  ├── Daftarkan alias middleware di bootstrap/app.php
  └── Tambahkan middleware 'role:business|admin' ke portal routes

Tahap 3 — Integrasi Template Frontend (7 hari)
  ├── Verifikasi layouts (public.blade.php & portal.blade.php)
  ├── 6 Halaman Publik (3 hari):
  │   ├── home.blade.php ← beranda template
  │   ├── supervision-results.blade.php ← hasil_pengawasan template
  │   ├── search-products.blade.php ← cari_produk_sarana template
  │   ├── inspection-detail.blade.php ← detail_hasil_pengujian template
  │   ├── verify-bap.blade.php ← validasi_bap + mobile template
  │   └── guide.blade.php ← panduan template
  └── 6 Halaman Portal (3 hari):
      ├── login.blade.php ← login + mobile template
      ├── dashboard.blade.php ← dashboard + mobile template
      ├── findings-capa.blade.php ← daftar_temuan template
      ├── submit-capa.blade.php ← detail_temuan template
      ├── documents.blade.php ← dokumen template
      └── facility-profile.blade.php ← profil_sarana template

Tahap 4 — Sambungkan Data Nyata (2 hari)
  ├── Query dengan whitelist publik (select() hanya kolom yang diizinkan)
  ├── Filter & pagination Livewire
  ├── Full-text search via tsvector
  └── File download & preview dokumen

Tahap 5 — Pint & Tests (1 hari)
  ├── vendor/bin/pint --dirty --format agent
  └── php artisan test
```

---

## Bagian E — Catatan Penting

> [!IMPORTANT]
> **UUID & Spatie**: Wajib sesuaikan migration Spatie untuk UUID sebelum `php artisan migrate`.

> [!NOTE]
> **Policy tidak diubah**: 8 Policy class yang sudah ada tetap dipertahankan. Spatie bekerja secara hybrid, menambahkan layer middleware dan Blade directives.

> [!TIP]
> **Cache Permission**: Setelah seeder, jalankan `php artisan permission:cache-reset` jika perlu.

> [!WARNING]
> **Data Publik vs Privat**: Setiap Livewire component halaman publik wajib `->select([whitelist_columns])` dan filter `publication_status = 'published'`. Jangan load model penuh lalu sembunyikan kolom di Blade.

---

## Estimasi Waktu Total

| Tahap | Pekerjaan | Estimasi |
|---|---|---|
| 1 | Install & setup Spatie Permission | 1 hari |
| 2 | Middleware, route, sinkronisasi role | 0.5 hari |
| 3 | Integrasi template → 12 halaman + 2 layout | 7 hari |
| 4 | Sambungkan data nyata + whitelist publik | 2 hari |
| 5 | Pint, test, bug fix | 1 hari |
| **Total** | | **~11.5 hari kerja** |
