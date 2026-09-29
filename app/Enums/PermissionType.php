<?php

namespace App\Enums;

use App\Filament\Resources\CapaClosures\CapaClosureResource;
use App\Filament\Resources\Facilities\FacilityResource;
use App\Filament\Resources\FoodCategories\FoodCategoryResource;
use App\Filament\Resources\FoodTypes\FoodTypeResource;
use App\Filament\Resources\InspectionRequirements\InspectionRequirementResource;
use App\Filament\Resources\Inspections\InspectionResource;
use App\Filament\Resources\Samplings\SamplingResource;
use App\Filament\Resources\SupervisionPlans\SupervisionPlanResource;
use App\Filament\Resources\TestParameters\TestParameterResource;
use App\Filament\Resources\Users\UserResource;

/**
 * Permission types for SI KAHAYAN BBPOM Palangka Raya.
 *
 * Menggunakan pendekatan "kelola" (manage) per modul, bukan CRUD granular.
 * Untuk aksi spesifik yang bukan CRUD (review, verifikasi, persetujuan),
 * tetap menggunakan nama aksi yang jelas.
 */
enum PermissionType: string
{
    // ── Modul Pengawasan ───────────────────────────────────────
    case KelolaInspeksi = 'kelola_inspeksi';
    case KelolaSampling = 'kelola_sampling';
    case KelolaRencanaKerja = 'kelola_rencana_kerja';

    // ── CAPA (Corrective and Preventive Action) ────────────────
    case KirimCapa = 'kirim_capa';
    case ReviewCapa = 'review_capa';
    case VerifikasiCapa = 'verifikasi_capa';
    case SetujuiCapa = 'setujui_capa';

    // ── Master Data ────────────────────────────────────────────
    case KelolaSarana = 'kelola_sarana';
    case KelolaPangan = 'kelola_pangan';
    case KelolaPersyaratanInspeksi = 'kelola_persyaratan_inspeksi';
    case KelolaParameterUji = 'kelola_parameter_uji';

    // ── Pengguna & Sistem ──────────────────────────────────────
    case KelolaPengguna = 'kelola_pengguna';

    // ── Laporan & Export ───────────────────────────────────────
    case LihatLaporan = 'lihat_laporan';
    case ExportLaporan = 'export_laporan';

    /**
     * Label yang ditampilkan di UI (bahasa Indonesia).
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::KelolaInspeksi => 'Kelola Inspeksi',
            self::KelolaSampling => 'Kelola Sampling',
            self::KelolaRencanaKerja => 'Kelola Rencana Kerja Pengawasan',
            self::KirimCapa => 'Kirim CAPA',
            self::ReviewCapa => 'Review CAPA',
            self::VerifikasiCapa => 'Verifikasi CAPA',
            self::SetujuiCapa => 'Setujui CAPA',
            self::KelolaSarana => 'Kelola Sarana',
            self::KelolaPangan => 'Kelola Data Pangan',
            self::KelolaPersyaratanInspeksi => 'Kelola Persyaratan Inspeksi',
            self::KelolaParameterUji => 'Kelola Parameter Uji',
            self::KelolaPengguna => 'Kelola Pengguna',
            self::LihatLaporan => 'Lihat Laporan',
            self::ExportLaporan => 'Export Laporan',
        };
    }

    /**
     * Mengembalikan semua permission values sebagai array string.
     *
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Mengembalikan peta resource Filament -> permission yang diperlukan.
     *
     * @return array<class-string, self>
     */
    public static function resourcePermissionMap(): array
    {
        return [
            InspectionResource::class => self::KelolaInspeksi,
            SamplingResource::class => self::KelolaSampling,
            SupervisionPlanResource::class => self::KelolaRencanaKerja,
            CapaClosureResource::class => self::VerifikasiCapa,
            FacilityResource::class => self::KelolaSarana,
            FoodCategoryResource::class => self::KelolaPangan,
            FoodTypeResource::class => self::KelolaPangan,
            InspectionRequirementResource::class => self::KelolaPersyaratanInspeksi,
            TestParameterResource::class => self::KelolaParameterUji,
            UserResource::class => self::KelolaPengguna,
        ];
    }
}
