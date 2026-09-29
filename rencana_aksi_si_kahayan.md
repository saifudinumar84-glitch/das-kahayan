# 🗺️ Rencana Aksi — Si Kahayan Dashboard (Filament v5)

> **Proyek:** Sistem Informasi Kawal Hasil Pengawasan — BBPOM Palangka Raya
> **Stack:** Laravel 13 · Filament v5.8 · PostgreSQL · Livewire 4 · Tailwind CSS
> **Tanggal:** 25 September 2026

---

## Status Proyek Saat Ini

| Komponen | Status |
|----------|--------|
| Migrations (21 file + spatie permission) | ✅ Selesai |
| Models (18 file + Spatie Role/Permission) | ✅ Selesai |
| Enums (14 file, termasuk `PermissionType` & `UserRole`) | ✅ Selesai |
| Seeders (9 file, termasuk `RolePermissionSeeder`) | ✅ Selesai & Dijalankan |
| Panel Providers | ✅ Selesai (`AdminPanelProvider`, `PimpinanPanelProvider`, `PortalPanelProvider`) |
| Policies & Authorization (10 Policy) | ✅ Selesai (Permission-based "kelola" + Role-based access) |
| Manajemen Role & Permission | ✅ Selesai (`RoleResource`, `PermissionResource`, `RolePolicy`, `PermissionPolicy`) |
| Filament Resources Data Master | ✅ Selesai (Users dengan multi-role Spatie, Facilities, FoodCategories, FoodTypes, TestParameters, InspectionRequirements, SupervisionPlans) |
| Modul Sampling & Pengujian | ✅ Selesai (`SamplingResource`, `TestResultsRelationManager`, `AttachmentsRelationManager`, `StatusHistoriesRelationManager`, aksi publikasi) |
| Modul Inspeksi & Temuan | ✅ Selesai (`InspectionResource`, `InspectionFindingsRelationManager` dengan penutupan/pembukaan temuan, penerbitan BAP resmi & token QR, publikasi) |
| Alur Evaluasi CAPA & Closed CAPA | ✅ Selesai (`CapaSubmissionsRelationManager` review terima/tolak, `CapaClosureResource` alur verifikasi Ketua Tim & pengesahan Kepala Balai) |
| Dashboard Widget & Export Excel/PDF | ✅ Selesai (Export PDF domPDF & Excel Maatwebsite dengan permission `export_laporan`) |
| Portal Pelaku Usaha | ✅ Selesai (Livewire 4 Frontend & Portal dengan pembatasan hak akses) |

---

## Ikhtisar Fase

```mermaid
gantt
    title Rencana Aksi Si Kahayan
    dateFormat  YYYY-MM-DD
    axisFormat  %d %b

    section Fase 1 - Fondasi
    Panel Providers & Auth           :f1, 2026-09-25, 2d

    section Fase 2 - Data Master
    Resources Data Master            :f2, after f1, 2d

    section Fase 3 - Sampling
    Resource Sampling & Uji          :f3, after f2, 3d

    section Fase 4 - Inspeksi
    Resource Inspeksi & Temuan       :f4, after f3, 4d

    section Fase 5 - CAPA
    Alur CAPA & Closed CAPA          :f5, after f4, 4d

    section Fase 6 - Portal
    Portal Pelaku Usaha              :f6, after f5, 3d

    section Fase 7 - Dashboard
    Widgets & Dashboard              :f7, after f4, 3d

    section Fase 8 - Publik
    Halaman Publik & Verifikasi      :f8, after f7, 3d
```

---

## Fase 1 — Fondasi Panel & Otorisasi (±2 hari)

Menyiapkan 3 panel Filament, middleware autentikasi, dan sistem role-based access.

### 1.1 Panel Providers

| Panel | File Provider | Path | Peran yang Boleh Akses |
|-------|---------------|------|------------------------|
| Admin | `AdminPanelProvider.php` | `/admin` | `admin`, `inspector`, `team_leader` |
| Pimpinan | `PimpinanPanelProvider.php` | `/pimpinan` | `team_leader`, `head` |
| Portal | `PortalPanelProvider.php` | `/portal` | `business` |

**Langkah:**

- [ ] Buat `PimpinanPanelProvider` dan `PortalPanelProvider` via `php artisan make:filament-panel`
- [ ] Konfigurasi setiap panel: `->id()`, `->path()`, `->login()`, `->colors()`, `->brandName()`
- [ ] Set `->discoverResources()`, `->discoverPages()`, `->discoverWidgets()` ke namespace masing-masing panel:
  - Admin → `App\Filament\Resources`, `App\Filament\Pages`, `App\Filament\Widgets`
  - Pimpinan → `App\Filament\Pimpinan\Resources`, `App\Filament\Pimpinan\Pages`, `App\Filament\Pimpinan\Widgets`
  - Portal → `App\Filament\Portal\Resources`, `App\Filament\Portal\Pages`, `App\Filament\Portal\Widgets`
- [ ] Update `AdminPanelProvider` yang sudah ada: tambahkan konfigurasi `->brandName('Si Kahayan — Admin')`

### 1.2 Middleware & Akses Panel

- [ ] Buat middleware `CheckPanelAccess` atau gunakan fitur `->canAccess()` pada masing-masing panel provider berdasarkan `UserRole` enum
- [ ] Pastikan `User` model mengimplementasikan `FilamentUser` dan method `canAccessPanel(Panel $panel): bool`
- [ ] Konfigurasi redirect setelah login ke panel yang sesuai dengan role user

### 1.3 Hak Akses & Policies (Spatie Laravel Permission + Module-based "Kelola")

Sistem otorisasi menggunakan perpaduan **Role** (`UserRole` enum & Spatie `roles`) serta **Permission** (`PermissionType` enum & Spatie `permissions`) dengan pendekatan modul "Kelola":

- **Enum `PermissionType` (14 permissions):**
  - `ManageInspections` (`kelola_inspeksi`)
  - `ManageSamplings` (`kelola_sampling`)
  - `ManageSupervisionPlans` (`kelola_rencana_kerja`)
  - `SubmitCapa` (`kirim_capa`)
  - `ReviewCapa` (`review_capa`)
  - `VerifyCapa` (`verifikasi_capa`)
  - `ApproveCapa` (`setujui_capa`)
  - `ManageFacilities` (`kelola_sarana`)
  - `ManageFoodData` (`kelola_pangan`)
  - `ManageInspectionRequirements` (`kelola_persyaratan_inspeksi`)
  - `ManageTestParameters` (`kelola_parameter_uji`)
  - `ManageUsers` (`kelola_pengguna`)
  - `ViewReports` (`lihat_laporan`)
  - `ExportReports` (`export_laporan`)

- **Policy class untuk setiap model utama:**

| Policy | Model | Aturan Kunci |
|--------|-------|--------------|
| `SupervisionPlanPolicy` | `SupervisionPlan` | `hasPermissionTo('kelola_rencana_kerja')` |
| `SamplingPolicy` | `Sampling` | `hasPermissionTo('kelola_sampling')`, publikasi oleh `admin`/`team_leader` |
| `InspectionPolicy` | `Inspection` | `hasPermissionTo('kelola_inspeksi')`, publikasi oleh `admin`/`team_leader` |
| `InspectionFindingPolicy` | `InspectionFinding` | `hasPermissionTo('kelola_inspeksi')` |
| `CapaSubmissionPolicy` | `CapaSubmission` | `hasPermissionTo('kirim_capa')` untuk pelaku usaha, `hasPermissionTo('review_capa')` untuk inspektur |
| `CapaClosurePolicy` | `CapaClosure` | `hasPermissionTo('verifikasi_capa')` (Ketua Tim), `hasPermissionTo('setujui_capa')` (Kepala Balai) |
| `FacilityPolicy` | `Facility` | `hasPermissionTo('kelola_sarana')`, pelaku usaha hanya data miliknya |
| `UserPolicy` | `User` | `hasPermissionTo('kelola_pengguna')`, delete dibatasi admin |
| `RolePolicy` | `Role` (Spatie) | `hasPermissionTo('kelola_pengguna')`, peran bawaan sistem dilindungi |
| `PermissionPolicy` | `Permission` (Spatie) | `hasPermissionTo('kelola_pengguna')`, manipulasi mutasi hanya admin |

- [x] Daftarkan `RolePolicy` dan `PermissionPolicy` di `AppServiceProvider` / `Gate`

---

## Fase 2 — Resources Data Master & Manajemen Akses (±2 hari)

CRUD untuk tabel referensi data master dan konfigurasi hak akses pengguna.

### 2.1 Admin Panel Resources

| Resource | Model | Fitur & Konfigurasi |
|----------|-------|---------------------|
| `UserResource` | `User` | Tabel, create, edit. Pengaturan **Peran Utama** (System Role `UserRole`) dan multi-select **Peran Spatie** (`roles` relationship). Filter by role, Spatie role, & status. |
| `RoleResource` | `Role` (Spatie) | Kelola peran aplikasi, guard web, serta penugasan multi-permission via checkbox list interaktif. |
| `PermissionResource` | `Permission` (Spatie) | Kelola daftar izin aplikasi dengan referensi otomatis ke enum `PermissionType`. |
| `FacilityResource` | `Facility` | Tabel, create, edit. Filter by type, regency, status. Kolom sensitif (NIB, NPWP) terenkripsi. |
| `FoodCategoryResource` | `FoodCategory` | CRUD data kategori pangan. |
| `FoodTypeResource` | `FoodType` | CRUD jenis pangan dengan relasi ke `FoodCategory`. |
| `TestParameterResource` | `TestParameter` | CRUD parameter uji, toggle `is_active`. |
| `InspectionRequirementResource` | `InspectionRequirement` | CRUD persyaratan inspeksi, filter by `standard` (CPPOB/CPerPOB). |
| `SupervisionPlanResource` | `SupervisionPlan` | CRUD rencana pengawasan, filter by status/period. |

**Langkah per Resource:**

- [x] Definisikan `form()` schema dengan field dan validasi sesuai migration
- [x] Definisikan `table()` dengan kolom, filter, badge peran, dan search
- [x] Integrasikan Spatie Role & Permission di `RoleResource` dan `PermissionResource`
- [x] Sediakan relasi `roles` pada form `UserResource` agar admin leluasa mengatur role pengguna
- [x] Jalankan Pint: `vendor/bin/pint --dirty --format agent`

---

## Fase 3 — Modul Sampling & Pengujian (±3 hari)

### 3.1 SamplingResource (Admin Panel)

**Form Schema:**

```
Section "Informasi Sampling"
├── Grid(2)
│   ├── TextInput sampling_number (auto-generate, readonly)
│   ├── Select plan_id → relationship SupervisionPlan
│   ├── Select inspector_id → relationship User (role=inspector)
│   ├── DatePicker sampling_date
│   ├── TextInput product_name
│   ├── TextInput brand
│   ├── Select food_type_id → relationship FoodType (grouped by FoodCategory)
│   ├── TextInput sampling_location
│   ├── Select sampling_facility_id → relationship Facility (opsional)
│   └── TextInput purchase_price (numeric, prefix "Rp")
│
Section "Geolokasi" (readonly, diisi otomatis)
├── TextInput geo_latitude (disabled)
├── TextInput geo_longitude (disabled)
├── TextInput geo_accuracy_m (disabled)
└── DateTimePicker geo_captured_at (disabled)
│
Section "Hasil Pengujian"
├── DatePicker test_date
├── Select status → SamplingStatus enum (live)
├── Select conclusion → SamplingConclusion enum (visible jika status=completed)
├── Textarea conclusion_notes (required jika conclusion=non_compliant)
└── Textarea recommendation (required jika conclusion=non_compliant)
```

**Langkah:**

- [ ] Generate `SamplingResource` dengan `--generate`
- [ ] Kustomisasi form schema sesuai di atas
- [ ] Tambahkan Relation Manager `TestResultsRelationManager` untuk mengelola hasil uji per parameter
- [ ] Buat Action **"Mulai Sampling"** yang merekam geolokasi via JavaScript → Livewire (Geolocation API browser)
- [ ] Buat Action **"Publikasikan"** untuk mengubah `publication_status` → `published` (hanya `team_leader`)
- [ ] Setiap perubahan status → insert ke `status_histories` (Model Observer atau Action class)
- [ ] Tambahkan Infolist untuk halaman View/detail

### 3.2 TestResultsRelationManager

- [ ] Kolom: `test_parameter_id` (Select), `result_value`, `unit`, `requirement_limit`, `compliance_status` (Select enum)
- [ ] Inline editing via Relation Manager table

### 3.3 Tabel & Filter Sampling

- [ ] Kolom tabel: `sampling_number`, `sampling_date`, `product_name`, `food_type.name`, `status` (Badge), `conclusion` (Badge warna), `publication_status`
- [ ] Filter: `status`, `conclusion`, `publication_status`, `food_type_id`, periode tanggal
- [ ] Search: `product_name`, `brand`, `sampling_number`
- [ ] Bulk action: Publikasi massal (team_leader)

---

## Fase 4 — Modul Inspeksi, Temuan & BAP (±4 hari)

### 4.1 InspectionResource (Admin Panel)

**Form Schema:**

```
Section "Informasi Inspeksi"
├── Grid(2)
│   ├── TextInput inspection_number (auto-generate, readonly)
│   ├── Select plan_id → relationship SupervisionPlan
│   ├── Select facility_id → relationship Facility (required)
│   ├── Select inspector_id → relationship User (role=inspector)
│   ├── DatePicker inspection_date
│   ├── Select status → InspectionStatus enum
│   ├── TextInput grade
│   └── Textarea conclusion
│
Section "Geolokasi" (readonly)
├── (sama seperti Sampling)
│
Section "Publikasi"
├── Select publication_status
```

**Langkah:**

- [ ] Generate `InspectionResource`
- [ ] Kustomisasi form schema
- [ ] Buat Action **"Mulai Pemeriksaan"** → rekam geotagging (koordinat tidak bisa diubah)
- [ ] Buat Action **"Publikasikan"** → `publication_status = published` (team_leader)

### 4.2 InspectionFindingsRelationManager

- [ ] Relation Manager di dalam `InspectionResource`
- [ ] Form: `requirement_id` (Select, opsional), `standard` (Select enum), `description`, `recommendation`, `due_date`, `status` (readonly, diubah via Action)
- [ ] Action **"Tutup Temuan"** → set `status = closed`, `closed_at`, `closed_by` (inspector)
- [ ] Action **"Buka Kembali"** → set `status = open` jika CAPA ditolak
- [ ] Badge warna untuk status: `open` = merah, `closed` = hijau
- [ ] Indikator **"Terlambat"** jika `due_date < now()` dan masih `open`

### 4.3 AttachmentsRelationManager (Polymorphic)

- [ ] Buat Relation Manager reusable untuk `Attachments` (dipakai di Inspection, Finding, CapaSubmission)
- [ ] Form: `FileUpload`, caption, otomatis isi `uploaded_by`, `mime`, `size_kb`

### 4.4 BAP Document — Generasi PDF & QR

**Dependensi baru (minta persetujuan user):**

- `barryvdh/laravel-dompdf` — generate PDF
- `simplesoftwareio/simple-qrcode` — generate QR Code

**Langkah:**

- [ ] Install paket setelah persetujuan user
- [ ] Buat Blade template BAP (layout resmi: header instansi, isi pemeriksaan, tanda tangan)
- [ ] Action **"Terbitkan BAP"** pada InspectionResource:
  1. Generate `qr_token` unik
  2. Simpan `content_snapshot` (JSONB berisi salinan data inspeksi + temuan)
  3. Generate PDF dengan QR Code yang mengarah ke `/verify/{qr_token}`
  4. Simpan file PDF
  5. Kirim email + notifikasi ke pelaku usaha
  6. Update `inspection.status → bap_issued`
- [ ] Buat `BapDocumentResource` (readonly) atau tampilkan sebagai Infolist di InspectionResource

### 4.5 Follow-Up Letters

- [ ] Action **"Kirim Surat Tindak Lanjut"** di InspectionResource
- [ ] Upload file surat, isi `sent_by`, `sent_to_email`, kirim email
- [ ] Hanya aktif jika inspeksi punya temuan `open`

---

## Fase 5 — Alur CAPA & Closed CAPA (±4 hari)

### 5.1 CapaSubmission — Portal Pelaku Usaha

- [ ] Buat `CapaSubmissionResource` di Portal panel (`App\Filament\Portal\Resources`)
- [ ] Pelaku usaha hanya melihat temuan untuk sarana miliknya (scoped via `facility_users`)
- [ ] Form: `finding_id` (otomatis dari konteks), `corrective_action`, `preventive_action`, file upload bukti
- [ ] `round` auto-increment per finding
- [ ] Status otomatis `submitted` saat kirim

### 5.2 CapaSubmission — Review di Admin

- [ ] Tampilkan CAPA submissions sebagai Relation Manager di `InspectionFindingResource` atau nested di `InspectionResource`
- [ ] Action **"Terima CAPA"** → `status = accepted`, set `reviewed_by`, `reviewed_at`, tutup temuan (`finding.status = closed`)
- [ ] Action **"Tolak CAPA"** → `status = rejected`, `review_notes` (wajib), buka kembali kesempatan CAPA baru
- [ ] Notifikasi ke pelaku usaha setiap perubahan status

### 5.3 CapaClosure — Alur Pengesahan Berurutan

| Tahap | Aktor | Action | Status Berikutnya |
|-------|-------|--------|-------------------|
| 1 | Sistem | Seluruh temuan `closed` → buat record | `pending_verification` |
| 2 | Ketua Tim | **"Verifikasi"** | `pending_approval` |
| 3 | Kepala Balai | **"Sahkan"** (+ konfirmasi password) | `approved` |
| 4 | Sistem | Generate PDF surat + kirim | `sent` |
| — | Ketua Tim | **"Kembalikan"** | `returned` → kembali ke review CAPA |

**Langkah:**

- [ ] Buat `CapaClosureResource` di Admin panel (untuk Ketua Tim)
- [ ] Buat halaman/Action di Pimpinan panel untuk pengesahan Kepala Balai
- [ ] Generate PDF surat Closed CAPA dengan tanda tangan digital Kepala Balai
- [ ] Kirim surat via email + notifikasi ke pelaku usaha
- [ ] Validasi: Closed CAPA tidak bisa dibuat jika masih ada temuan `open`
- [ ] Setiap perubahan status → `status_histories`

### 5.4 StatusHistories — Tampilan Riwayat

- [ ] Buat Relation Manager `StatusHistoriesRelationManager` (polymorphic, readonly)
- [ ] Tabel: `old_status`, `new_status`, `user.name`, `notes`, `created_at`
- [ ] Pasang di `SamplingResource`, `InspectionResource`, `CapaClosureResource`

---

## Fase 6 — Portal Pelaku Usaha (±3 hari)

### 6.1 Setup Portal Panel

- [ ] Konfigurasi `PortalPanelProvider`: branding, warna, login khusus pelaku usaha
- [ ] Scope global: semua query di portal di-filter berdasarkan `facility_users` milik user yang login

### 6.2 Resources Portal

| Resource | Fitur |
|----------|-------|
| `PortalInspectionResource` | List inspeksi sarana milik user, Infolist detail, lihat temuan & rekomendasi (readonly) |
| `PortalCapaSubmissionResource` | List CAPA yang sudah dikirim, buat CAPA baru untuk temuan `open`, lihat status review |
| `PortalDocumentResource` | List & download BAP dan surat Closed CAPA |

### 6.3 Dashboard Portal

- [ ] Widget ringkasan: jumlah inspeksi, temuan open, CAPA pending, Closed CAPA
- [ ] Widget notifikasi: BAP baru, hasil review CAPA

---

## Fase 7 — Dashboard & Widget (±3 hari)

Status: ✅ **Selesai Diimplementasikan & Diuji**

### 7.1 Dashboard Admin

| Widget | Tipe | Data & Implementasi | Status |
|--------|------|---------------------|--------|
| `SamplingStatsWidget` | `StatsOverviewWidget` | Total sampling, MS, TMS, dalam proses uji | ✅ Selesai |
| `InspectionStatsWidget` | `StatsOverviewWidget` | Total inspeksi, temuan open, closed, terlambat | ✅ Selesai |
| `CapaStatsWidget` | `StatsOverviewWidget` | CAPA submitted, accepted, rejected, Closed CAPA | ✅ Selesai |
| `SamplingPerMonthChart` | `ChartWidget` (Bar) | Jumlah sampling per bulan, grouped by conclusion (MS vs TMS) | ✅ Selesai |
| `InspectionPerMonthChart` | `ChartWidget` (Bar) | Jumlah inspeksi sarana per bulan | ✅ Selesai |
| `FindingByCategoryChart` | `ChartWidget` (Doughnut) | Temuan per standar (CPPOB vs CPerPOB) | ✅ Selesai |
| `CapaStatusChart` | `ChartWidget` (Pie) | Distribusi status penanganan CAPA | ✅ Selesai |

### 7.2 Dashboard Pimpinan

| Widget | Tipe | Data & Implementasi | Status |
|--------|------|---------------------|--------|
| Semua widget Admin | — | Inherited / didaftarkan pada `PimpinanPanelProvider` | ✅ Selesai |
| `OverdueCapaWidget` | `TableWidget` | Daftar temuan yang melewati batas waktu (`due_date < now()`) | ✅ Selesai |
| `AwaitingApprovalWidget` | `TableWidget` | CAPA Closure menunggu pengesahan Kepala Balai dengan aksi langsung | ✅ Selesai |

### 7.3 Laporan & Ekspor

- [x] Custom Page **"Laporan Pengawasan"** di panel Pimpinan (`LaporanPengawasan.php`)
- [x] Filter: periode (bulanan/triwulanan), kategori pangan, jenis sarana, kabupaten
- [x] Ekspor format: **Excel** (via `maatwebsite/excel`) dan **PDF** (via `barryvdh/laravel-dompdf`)
- [x] Isi laporan: rekap sampling + pengujian, rekap inspeksi + temuan, status tindak lanjut CAPA, diamankan dengan permission `export_laporan`

---

## Fase 8 — Halaman Publik (±3 hari)

### 8.1 Route & Controller Publik

Halaman publik bukan bagian dari panel Filament, melainkan route Laravel biasa dengan Blade/Livewire.

| Route | Fitur |
|-------|-------|
| `GET /` | Landing page + dashboard publik |
| `GET /sampling` | Daftar sampling & hasil uji yang sudah `published` |
| `GET /inspeksi` | Daftar inspeksi yang sudah `published` |
| `GET /peta` | Peta sebaran pengawasan (tingkat kabupaten/kota) |
| `GET /cari` | Pencarian produk & sarana (full-text search via `search_vector`) |
| `GET /verify/{token}` | Validasi BAP via QR Code token |

### 8.2 Aturan Whitelist Publik

Data yang ditampilkan ke publik **HANYA** kolom berikut (sesuai Lampiran B poin 4):

| Entitas | Kolom Publik |
|---------|-------------|
| Sampling | `sampling_date`, `product_name`, `food_type.name`, `food_category.name`, `sampling_location`, `conclusion`, `test_results` (parameter, value, compliance) |
| Inspeksi | `inspection_date`, `facility.name`, `facility.regency`, `facility.facility_type`, `grade`, `conclusion` |

**TIDAK** ditampilkan: NIB, NPWP, NIE, kontak, penanggung jawab, alamat lengkap, foto, CAPA, tanda tangan, koordinat GPS penuh.

### 8.3 Dashboard Publik

- [ ] Stat cards: total sampling, total inspeksi, jumlah MS/TMS, jumlah sarana diperiksa
- [ ] Chart: sampling per bulan, distribusi MS/TMS
- [ ] Peta: hanya tingkat kabupaten/kota (tanpa koordinat penuh)
- [ ] Pencarian full-text dengan `tsvector`

### 8.4 Halaman Verifikasi BAP

- [ ] Route `GET /verify/{token}`
- [ ] Cari `BapDocument` by `qr_token`
- [ ] Tampilkan info BAP (nomor, tanggal, nama sarana) jika valid
- [ ] Tampilkan "Dokumen tidak ditemukan" jika invalid

---

## Paket Tambahan yang Dibutuhkan

> [!IMPORTANT]
> Perlu persetujuan sebelum menginstal paket baru.

| Paket | Kegunaan | Perintah |
|-------|----------|---------|
| `barryvdh/laravel-dompdf` | Generate PDF (BAP, surat Closed CAPA, laporan) | `composer require barryvdh/laravel-dompdf` |
| `simplesoftwareio/simple-qrcode` | QR Code untuk BAP | `composer require simplesoftwareio/simple-qrcode` |
| `maatwebsite/excel` | Ekspor laporan ke Excel | `composer require maatwebsite/excel` |

---

## Hal-Hal Teknis Cross-Cutting

### Notifikasi

| Event | Channel | Penerima |
|-------|---------|----------|
| BAP terbit | Email + in-app | Pelaku usaha |
| Surat tindak lanjut dikirim | Email + in-app | Pelaku usaha |
| CAPA dikirim pelaku usaha | In-app | Inspector |
| CAPA diterima/ditolak | Email + in-app | Pelaku usaha |
| Closed CAPA terbit | Email + in-app | Pelaku usaha |

### Audit Log

- [ ] Implementasikan Model Observer atau Trait `Auditable` untuk mencatat perubahan data penting ke tabel `audit_logs`
- [ ] Catat: `event`, `auditable_type`, `auditable_id`, `old_values`, `new_values`, `ip_address`, `user_id`

### Geotagging

- [ ] Buat komponen Livewire/Alpine.js reusable untuk merekam koordinat via Geolocation API browser
- [ ] Dipanggil saat Action "Mulai Pemeriksaan" atau "Mulai Sampling"
- [ ] Koordinat disimpan di field `geo_*` dan **tidak bisa diedit** (tidak masuk `$fillable`, diisi server-side)

---

## Urutan Eksekusi yang Disarankan

```
Fase 1 (Fondasi)
    │
    ▼
Fase 2 (Data Master)
    │
    ▼
Fase 3 (Sampling) ──────────────────┐
    │                                │
    ▼                                ▼
Fase 4 (Inspeksi) ──► Fase 7 (Dashboard/Widget)
    │                                │
    ▼                                ▼
Fase 5 (CAPA) ──────► Fase 8 (Halaman Publik)
    │
    ▼
Fase 6 (Portal Pelaku Usaha)
```

> [!TIP]
> Fase 7 (Dashboard) dan Fase 8 (Publik) bisa dimulai begitu Fase 4 (Inspeksi) selesai, karena data sampling dan inspeksi sudah bisa ditampilkan. Fase 5 dan 6 bisa berjalan paralel dengan 7-8.

---

## Estimasi Waktu Total

| Fase | Estimasi |
|------|----------|
| 1 — Fondasi Panel & Auth | 2 hari |
| 2 — Data Master | 2 hari |
| 3 — Sampling & Pengujian | 3 hari |
| 4 — Inspeksi, Temuan & BAP | 4 hari |
| 5 — CAPA & Closed CAPA | 4 hari |
| 6 — Portal Pelaku Usaha | 3 hari |
| 7 — Dashboard & Widget | 3 hari |
| 8 — Halaman Publik | 3 hari |
| **Total** | **~24 hari kerja** |

> [!NOTE]
> Estimasi ini belum termasuk testing (unit/feature test), debugging, dan polish UI. Disarankan menambah buffer ±30% untuk testing dan perbaikan.
