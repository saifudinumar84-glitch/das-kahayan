<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Filament\Pimpinan\Widgets\AwaitingApprovalWidget;
use App\Filament\Pimpinan\Widgets\OverdueCapaWidget;
use App\Filament\Widgets\CapaStatsWidget;
use App\Filament\Widgets\CapaStatusChart;
use App\Filament\Widgets\FindingByCategoryChart;
use App\Filament\Widgets\InspectionPerMonthChart;
use App\Filament\Widgets\InspectionStatsWidget;
use App\Filament\Widgets\SamplingPerMonthChart;
use App\Filament\Widgets\SamplingStatsWidget;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardWidgetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_user_can_access_admin_dashboard(): void
    {
        $admin = User::where('role', UserRole::Admin)->first();

        if (! $admin) {
            $this->markTestSkipped('Admin user not found.');
        }

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_pimpinan_user_can_access_pimpinan_dashboard(): void
    {
        $head = User::where('role', UserRole::Head)->first();

        if (! $head) {
            $this->markTestSkipped('Head user not found.');
        }

        $response = $this->actingAs($head)->get('/pimpinan');
        $response->assertStatus(200);
    }

    public function test_stats_and_chart_widgets_render_without_error(): void
    {
        $admin = User::where('role', UserRole::Admin)->first();

        if (! $admin) {
            $this->markTestSkipped('Admin user not found.');
        }

        $this->actingAs($admin);

        Livewire::test(SamplingStatsWidget::class)->assertSuccessful();
        Livewire::test(InspectionStatsWidget::class)->assertSuccessful();
        Livewire::test(CapaStatsWidget::class)->assertSuccessful();
        Livewire::test(SamplingPerMonthChart::class)->assertSuccessful();
        Livewire::test(InspectionPerMonthChart::class)->assertSuccessful();
        Livewire::test(FindingByCategoryChart::class)->assertSuccessful();
        Livewire::test(CapaStatusChart::class)->assertSuccessful();
        Livewire::test(OverdueCapaWidget::class)->assertSuccessful();
        Livewire::test(AwaitingApprovalWidget::class)->assertSuccessful();
    }
}
