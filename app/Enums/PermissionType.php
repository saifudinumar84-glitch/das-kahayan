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
    case ManageInspections = 'kelola_inspeksi';
    case ManageSamplings = 'kelola_sampling';
    case ManageSupervisionPlans = 'kelola_rencana_kerja';

    // ── CAPA (Corrective and Preventive Action) ────────────────
    case SubmitCapa = 'kirim_capa';
    case ReviewCapa = 'review_capa';
    case VerifyCapa = 'verifikasi_capa';
    case ApproveCapa = 'setujui_capa';

    // ── Master Data ────────────────────────────────────────────
    case ManageFacilities = 'kelola_sarana';
    case ManageFoodData = 'kelola_pangan';
    case ManageInspectionRequirements = 'kelola_persyaratan_inspeksi';
    case ManageTestParameters = 'kelola_parameter_uji';

    // ── Pengguna & Sistem ──────────────────────────────────────
    case ManageUsers = 'kelola_pengguna';

    // ── Laporan & Export ───────────────────────────────────────
    case ViewReports = 'lihat_laporan';
    case ExportReports = 'export_laporan';

    /**
     * Label yang ditampilkan di UI (bahasa Indonesia).
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::ManageInspections => 'Kelola Inspeksi',
            self::ManageSamplings => 'Kelola Sampling',
            self::ManageSupervisionPlans => 'Kelola Rencana Kerja Pengawasan',
            self::SubmitCapa => 'Kirim CAPA',
            self::ReviewCapa => 'Review CAPA',
            self::VerifyCapa => 'Verifikasi CAPA',
            self::ApproveCapa => 'Setujui CAPA',
            self::ManageFacilities => 'Kelola Sarana',
            self::ManageFoodData => 'Kelola Data Pangan',
            self::ManageInspectionRequirements => 'Kelola Persyaratan Inspeksi',
            self::ManageTestParameters => 'Kelola Parameter Uji',
            self::ManageUsers => 'Kelola Pengguna',
            self::ViewReports => 'Lihat Laporan',
            self::ExportReports => 'Export Laporan',
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
            InspectionResource::class => self::ManageInspections,
            SamplingResource::class => self::ManageSamplings,
            SupervisionPlanResource::class => self::ManageSupervisionPlans,
            CapaClosureResource::class => self::VerifyCapa,
            FacilityResource::class => self::ManageFacilities,
            FoodCategoryResource::class => self::ManageFoodData,
            FoodTypeResource::class => self::ManageFoodData,
            InspectionRequirementResource::class => self::ManageInspectionRequirements,
            TestParameterResource::class => self::ManageTestParameters,
            UserResource::class => self::ManageUsers,
        ];
    }
}
