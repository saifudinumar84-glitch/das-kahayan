<?php

use App\Livewire\Portal\Dashboard;
use App\Livewire\Portal\Documents;
use App\Livewire\Portal\FacilityProfile;
use App\Livewire\Portal\FindingsCapa;
use App\Livewire\Portal\Login;
use App\Livewire\Portal\SubmitCapa;
use App\Livewire\Public\Guide;
use App\Livewire\Public\Home;
use App\Livewire\Public\InspectionDetail;
use App\Livewire\Public\SearchProducts;
use App\Livewire\Public\SupervisionResults;
use App\Livewire\Public\VerifyBap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Pages (No Auth)
|--------------------------------------------------------------------------
*/

Route::get('/', Home::class)->name('publik.beranda');
Route::get('/hasil-pengawasan', SupervisionResults::class)->name('publik.hasil-pengawasan');
Route::get('/cari', SearchProducts::class)->name('publik.cari');
Route::get('/validasi-bap/{token?}', VerifyBap::class)->name('publik.validasi-bap');
Route::get('/panduan', Guide::class)->name('publik.panduan');
Route::get('/pengujian/{id?}', InspectionDetail::class)->name('publik.detail-pengujian');

/*
|--------------------------------------------------------------------------
| Portal Pelaku Usaha (Business Portal)
|--------------------------------------------------------------------------
*/

Route::prefix('portal-usaha')->group(function () {
    Route::get('/login', Login::class)->middleware('guest')->name('portal.login');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('portal.login');
    })->name('portal.logout');

    Route::middleware(['auth', 'role:business|admin'])->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('portal.dashboard');
        Route::get('/temuan-capa', FindingsCapa::class)->name('portal.temuan-capa');
        Route::get('/capa/kirim/{findingId?}', SubmitCapa::class)->name('portal.submit-capa');
        Route::get('/dokumen', Documents::class)->name('portal.dokumen');
        Route::get('/profil', FacilityProfile::class)->name('portal.profil');
    });
});

/*
|--------------------------------------------------------------------------
| Export Routes (PDF & Excel)
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ReportExportController;

Route::prefix('export')->group(function () {
    // Public Exports
    Route::get('/publik/excel', [ReportExportController::class, 'exportPublicExcel'])->name('export.public.excel');
    Route::get('/publik/pdf', [ReportExportController::class, 'exportPublicPdf'])->name('export.public.pdf');

    // Authenticated Exports
    Route::middleware('auth')->group(function () {
        // Executive Supervision Report (PDF & Excel)
        Route::get('/laporan/excel', [ReportExportController::class, 'exportExecutiveReportExcel'])->name('export.executive.excel');
        Route::get('/laporan/pdf', [ReportExportController::class, 'exportExecutiveReportPdf'])->name('export.executive.pdf');

        // BAP Document PDF
        Route::get('/bap/{id}/pdf', [ReportExportController::class, 'exportBapPdf'])->name('export.bap.pdf');

        // Sampling Lab Test Report PDF
        Route::get('/sampling/{id}/pdf', [ReportExportController::class, 'exportSamplingPdf'])->name('export.sampling.pdf');

        // Portal Pelaku Usaha CAPA
        Route::get('/portal/capa/excel', [ReportExportController::class, 'exportPortalCapaExcel'])->name('export.portal.capa.excel');
        Route::get('/portal/capa/pdf', [ReportExportController::class, 'exportPortalCapaPdf'])->name('export.portal.capa.pdf');
    });
});
