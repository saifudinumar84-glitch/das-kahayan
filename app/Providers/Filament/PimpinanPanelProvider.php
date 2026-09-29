<?php

namespace App\Providers\Filament;

use App\Filament\Pages\LaporanPengawasan;
use App\Filament\Resources\CapaClosures\CapaClosureResource;
use App\Filament\Resources\Inspections\InspectionResource;
use App\Filament\Resources\Samplings\SamplingResource;
use App\Filament\Widgets\CapaStatsWidget;
use App\Filament\Widgets\CapaStatusChart;
use App\Filament\Widgets\FindingByCategoryChart;
use App\Filament\Widgets\InspectionPerMonthChart;
use App\Filament\Widgets\InspectionStatsWidget;
use App\Filament\Widgets\SamplingPerMonthChart;
use App\Filament\Widgets\SamplingStatsWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class PimpinanPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('pimpinan')
            ->path('pimpinan')
            ->login()
            ->brandName('Si Kahayan — Pimpinan')
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->discoverResources(in: app_path('Filament/Pimpinan/Resources'), for: 'App\Filament\Pimpinan\Resources')
            ->resources([
                CapaClosureResource::class,
                InspectionResource::class,
                SamplingResource::class,
            ])
            ->discoverPages(in: app_path('Filament/Pimpinan/Pages'), for: 'App\Filament\Pimpinan\Pages')
            ->pages([
                Dashboard::class,
                LaporanPengawasan::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Pimpinan/Widgets'), for: 'App\Filament\Pimpinan\Widgets')
            ->widgets([
                SamplingStatsWidget::class,
                InspectionStatsWidget::class,
                CapaStatsWidget::class,
                SamplingPerMonthChart::class,
                InspectionPerMonthChart::class,
                FindingByCategoryChart::class,
                CapaStatusChart::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
