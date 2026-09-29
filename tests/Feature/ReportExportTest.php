<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Inspection;
use App\Models\Sampling;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportExportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_guest_can_export_public_supervision_to_excel(): void
    {
        $response = $this->get(route('export.public.excel'));

        $response->assertStatus(200);
        $response->assertHeader('content-disposition');
    }

    public function test_guest_can_export_public_supervision_to_pdf(): void
    {
        $response = $this->get(route('export.public.pdf'));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type', ''));
    }

    public function test_guest_cannot_access_executive_reports(): void
    {
        $response = $this->get(route('export.executive.excel'));
        $response->assertRedirect(route('portal.login'));

        $pdfResponse = $this->get(route('export.executive.pdf'));
        $pdfResponse->assertRedirect(route('portal.login'));
    }

    public function test_admin_can_export_executive_report_to_excel(): void
    {
        $admin = User::where('role', UserRole::Admin)->first();
        if (! $admin) {
            $this->markTestSkipped('No admin user in database.');
        }

        $response = $this->actingAs($admin)->get(route('export.executive.excel'));

        $response->assertStatus(200);
        $response->assertHeader('content-disposition');
    }

    public function test_admin_can_export_executive_report_to_pdf(): void
    {
        $admin = User::where('role', UserRole::Admin)->first();
        if (! $admin) {
            $this->markTestSkipped('No admin user in database.');
        }

        $response = $this->actingAs($admin)->get(route('export.executive.pdf'));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type', ''));
    }

    public function test_can_export_bap_pdf_for_inspection(): void
    {
        $admin = User::where('role', UserRole::Admin)->first();
        $inspection = Inspection::first();

        if (! $admin || ! $inspection) {
            $this->markTestSkipped('No admin or inspection found.');
        }

        $response = $this->actingAs($admin)->get(route('export.bap.pdf', $inspection->id));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type', ''));
    }

    public function test_can_export_sampling_lab_test_pdf(): void
    {
        $admin = User::where('role', UserRole::Admin)->first();
        $sampling = Sampling::first();

        if (! $admin || ! $sampling) {
            $this->markTestSkipped('No admin or sampling found.');
        }

        $response = $this->actingAs($admin)->get(route('export.sampling.pdf', $sampling->id));

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('content-type', ''));
    }

    public function test_business_user_can_export_capa_to_excel_and_pdf(): void
    {
        $businessUser = User::where('role', UserRole::Business)->first();

        if (! $businessUser) {
            $this->markTestSkipped('No business user found.');
        }

        $excelResponse = $this->actingAs($businessUser)->get(route('export.portal.capa.excel'));
        $excelResponse->assertStatus(200);

        $pdfResponse = $this->actingAs($businessUser)->get(route('export.portal.capa.pdf'));
        $pdfResponse->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $pdfResponse->headers->get('content-type', ''));
    }
}
