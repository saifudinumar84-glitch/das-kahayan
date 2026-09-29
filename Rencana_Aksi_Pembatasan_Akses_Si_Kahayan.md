# Rencana Aksi: Pembatasan Akses Si Kahayan dengan spatie/laravel-permission

| | |
|--|--|
| **Sistem** | Si Kahayan, Sistem Informasi Kawal Hasil Pengawasan (BBPOM Palangka Raya) |
| **Basis** | PRD Si Kahayan (24 September 2026) |
| **Paket** | [spatie/laravel-permission v8](https://spatie.be/docs/laravel-permission/v8/installation-laravel) |
| **Stack** | Laravel 13, Filament v5, PostgreSQL ≥ 16 |

## Ruang Lingkup

"Pengunjung" dalam rencana ini mencakup dua kelompok:

- **Pengguna yang login** (5 peran di PRD): dibatasi dengan Spatie (peran, permission, policy).
- **Masyarakat tanpa login**: tidak memakai Spatie, karena paket ini hanya bekerja untuk user terautentikasi. Pembatasannya berupa whitelist kolom pada halaman publik (Fase 5).

---

## Fase 0: Keputusan sebelum coding

1. **Satu sumber peran.** PRD punya kolom `users.role` (enum). Setelah Spatie dipasang, peran disimpan di tabel `roles`, jadi hapus kolom enum dari migration `users`. Kalau tetap dipakai, ada dua sumber kebenaran yang bisa tidak sinkron.
2. **Tipe ID.** `users.id` memakai UUID, jadi migration Spatie harus diubah sebelum `migrate`. Pada `model_has_roles` dan `model_has_permissions`, kolom `model_morph_key` diganti dari `unsignedBigInteger` ke `uuid` (di dua tempat dalam migration). `roles` dan `permissions` boleh tetap ID integer. Kalau ingin UUID juga, extend model `Role` dan `Permission` dengan `HasUuids`, lalu daftarkan di `config/permission.php`.
3. **Guard tunggal `web`** untuk ketiga panel Filament. Pemisahan akses lewat peran dan `canAccessPanel`, bukan guard terpisah.
4. **Tanpa "super-admin" `Gate::before`.** Administrator di PRD mengelola data master dan pengguna, bukan menjalankan pengesahan CAPA. Kalau admin melewati semua gate, aturan pengesahan berurutan bisa dilangkahi. Konfirmasi dengan BBPOM.

## Fase 1: Instalasi

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
# edit migration create_permission_tables (UUID) sebelum lanjut
php artisan optimize:clear
php artisan migrate
```

- Tambahkan trait `HasRoles` pada model `User`.
- Kalau `CACHE_STORE=database`, pastikan migration cache Laravel sudah dijalankan.
- Jika sudah ada `config/permission.php`, ganti namanya atau hapus sebelum publish.

## Fase 2: Matriks peran dan permission

Penamaan permission: `<aksi> <resource>`, misalnya `view-any sampling`, `publish inspection`. Permission ditempelkan ke peran, bukan ke user.

| Peran | Panel | Permission utama |
|---|---|---|
| `admin` | Admin | CRUD pengguna, peran, dan data master (kategori dan jenis pangan, parameter uji, persyaratan CPPOB/CPerPOB, sarana). Tidak menyentuh input hasil dan pengesahan |
| `inspector` | Admin | Buat dan ubah sampling, hasil uji, inspeksi, temuan. Mulai pemeriksaan (geotag), kirim surat tindak lanjut, evaluasi CAPA (`accept` atau `reject`), set temuan `closed` atau `open` |
| `team_leader` | Admin dan Pimpinan | Kelola perencanaan, `publish` sampling dan inspeksi, `verify capa-closure`, lihat dashboard dan laporan |
| `head` | Pimpinan | Lihat dashboard dan laporan, `approve capa-closure` (satu-satunya aksi tulis) |
| `business` | Portal | Lihat temuan sarananya, buat dan kirim CAPA, unduh BAP dan surat Closed CAPA milik sarananya |

## Fase 3: Seeder

- `RolePermissionSeeder` idempoten dengan `firstOrCreate` dan `syncPermissions`, sehingga aman dijalankan ulang di production.
- Panggil `app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions()` di awal seeder.
- `AdminUserSeeder` membuat satu akun administrator awal dan memberinya peran `admin`.

## Fase 4: Penegakan akses (tiga lapis)

### 4.1 Masuk panel

Implementasikan `canAccessPanel()` pada `User` berdasarkan ID panel, dan cek juga `is_active`:

| Panel | Peran yang boleh |
|---|---|
| `admin` | `admin`, `inspector`, `team_leader` |
| `pimpinan` | `head`, `team_leader` |
| `portal` | `business` |

### 4.2 Aksi per model

Buat Policy untuk Sampling, Inspection, InspectionFinding, CapaSubmission, CapaClosure, User, dan data master, dengan pengecekan `$user->can('...')`. Filament otomatis memakai policy ini untuk menyembunyikan menu, tombol, dan Action.

### 4.3 Batas data (row-level)

Permission saja tidak cukup untuk `business`. Batasi query lewat `facility_users`, baik di `getEloquentQuery()` Resource portal maupun di Policy (`$user->facilities->contains($model->facility_id)`). Ini memenuhi aturan PRD bahwa pelaku usaha hanya melihat dan mengirim CAPA untuk sarananya sendiri.

### 4.4 Pengesahan berurutan

Dijaga di Action class, dengan permission dan status sebagai syarat bersamaan:

- Verifikasi: `verify capa-closure` dan status `pending_verification`.
- Pengesahan: `approve capa-closure` dan status `pending_approval`.

## Fase 5: Pengunjung tanpa login

- Route `/` dan `/verify/{token}` berada di luar middleware auth dan tidak memakai `permission:` atau `role:`.
- Query publik dibuat khusus: hanya kolom whitelist (Lampiran B #4 PRD) dan `publication_status = published`. Jangan mengembalikan model Eloquent penuh.
- Pastikan tidak ada route panel yang bisa dijangkau tanpa login.

## Fase 6: Pendaftaran pelaku usaha

- Peran `business` diberikan otomatis oleh server saat registrasi. Field peran tidak pernah diterima dari input form.
- Akun baru berstatus `is_active = false` sampai admin mengaktifkan dan menautkannya ke sarana lewat `facility_users`. Tanpa tautan itu, portal tidak menampilkan data apa pun.

## Fase 7: Pengujian

Buat feature test berupa matriks peran × panel × aksi:

- [ ] Setiap peran ditolak (403 atau redirect) di panel yang bukan miliknya.
- [ ] Peran `business` tidak bisa membuka temuan atau CAPA sarana lain, termasuk lewat URL langsung dengan UUID.
- [ ] Verifikasi dan pengesahan tidak bisa dilewati atau dibalik urutannya.
- [ ] Halaman publik tidak pernah memuat NIB, NPWP, kontak, dan koordinat penuh, serta tidak menampilkan data `unpublished`.
- [ ] Akun dengan `is_active = false` tidak bisa login.

## Poin yang perlu dikonfirmasi

1. Apakah Ketua Tim boleh melihat semua data atau hanya timnya sendiri (memengaruhi scoping)?
2. Apakah admin boleh melihat hasil pengawasan, atau hanya mengelola master dan pengguna?
3. Apakah pelaku usaha yang punya lebih dari satu sarana memakai satu akun?

## Referensi

- Instalasi: https://spatie.be/docs/laravel-permission/v8/installation-laravel
- UUID/ULID: https://spatie.be/docs/laravel-permission/v8/advanced-usage/uuid
- Model Policies: https://spatie.be/docs/laravel-permission/v8/best-practices/using-policies
