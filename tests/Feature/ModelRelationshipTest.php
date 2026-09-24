<?php

namespace Tests\Feature;

use App\Enums\CapaClosureStatus;
use App\Enums\CapaSubmissionStatus;
use App\Enums\ComplianceStatus;
use App\Enums\FacilityType;
use App\Enums\FindingStatus;
use App\Enums\InspectionStandard;
use App\Enums\InspectionStatus;
use App\Enums\PublicationStatus;
use App\Enums\SamplingConclusion;
use App\Enums\SamplingStatus;
use App\Enums\SupervisionPlanStatus;
use App\Enums\SupervisionPlanType;
use App\Enums\UserRole;
use App\Models\Attachment;
use App\Models\AuditLog;
use App\Models\BapDocument;
use App\Models\CapaClosure;
use App\Models\CapaSubmission;
use App\Models\Facility;
use App\Models\FollowUpLetter;
use App\Models\FoodCategory;
use App\Models\FoodType;
use App\Models\Inspection;
use App\Models\InspectionFinding;
use App\Models\InspectionRequirement;
use App\Models\Sampling;
use App\Models\StatusHistory;
use App\Models\SupervisionPlan;
use App\Models\TestParameter;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_and_relate_all_models_according_to_prd(): void
    {
        // 1. Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'secret123',
            'role' => UserRole::Admin,
            'is_active' => true,
        ]);
        $this->assertTrue(Str::isUuid($admin->id));
        $this->assertEquals(UserRole::Admin, $admin->role);

        $inspector = User::create([
            'name' => 'Inspector User',
            'email' => 'inspector@example.com',
            'password' => 'secret123',
            'role' => UserRole::Inspector,
            'is_active' => true,
        ]);

        $teamLeader = User::create([
            'name' => 'Team Leader',
            'email' => 'leader@example.com',
            'password' => 'secret123',
            'role' => UserRole::TeamLeader,
            'is_active' => true,
        ]);

        $head = User::create([
            'name' => 'Head of Office',
            'email' => 'head@example.com',
            'password' => 'secret123',
            'role' => UserRole::Head,
            'is_active' => true,
        ]);

        $business = User::create([
            'name' => 'Business Owner',
            'email' => 'business@example.com',
            'password' => 'secret123',
            'role' => UserRole::Business,
            'is_active' => true,
        ]);

        // 2. Facility & User Pivot
        $facility = Facility::create([
            'name' => 'CV Pangan Berkah',
            'facility_type' => FacilityType::Production,
            'commodity_type' => 'Kerupuk Ikan',
            'address' => 'Jl. Tjilik Riwut Km 2',
            'regency' => 'Kota Palangka Raya',
            'latitude' => -2.216667,
            'longitude' => 113.916667,
            'pic_name' => 'Budi Santoso',
            'phone' => '081234567890',
            'email' => 'panganberkah@example.com',
            'nib' => '1234567890123',
            'npwp' => '01.234.567.8-901.000',
            'cppob_certificate_number' => 'CPPOB-2026-001',
            'cppob_certificate_valid_until' => '2028-12-31',
            'is_active' => true,
        ]);
        $this->assertTrue(Str::isUuid($facility->id));
        $this->assertEquals('1234567890123', $facility->nib); // Decrypted via cast

        $facility->users()->attach($business->id);
        $this->assertCount(1, $facility->fresh()->users);
        $this->assertCount(1, $business->fresh()->facilities);

        // 3. Supervision Plan
        $plan = SupervisionPlan::create([
            'title' => 'Pengawasan Tahap 1 TW I 2026',
            'plan_type' => SupervisionPlanType::Both,
            'period_start' => '2026-01-01',
            'period_end' => '2026-03-31',
            'status' => SupervisionPlanStatus::Active,
            'created_by' => $teamLeader->id,
            'notes' => 'Rencana pengawasan pangan berisiko tinggi',
        ]);
        $this->assertTrue(Str::isUuid($plan->id));
        $this->assertEquals($teamLeader->id, $plan->creator->id);

        // 4. Food Category & Food Type
        $category = FoodCategory::create([
            'code' => 'CAT-01',
            'name' => 'Produk Olahan Ikan',
        ]);
        $foodType = FoodType::create([
            'food_category_id' => $category->id,
            'name' => 'Kerupuk Ikan Pipih',
            'is_active' => true,
        ]);
        $this->assertCount(1, $category->fresh()->foodTypes);

        // 5. Test Parameter
        $parameter = TestParameter::create([
            'code' => 'BORAKS',
            'name' => 'Boraks',
            'result_unit' => 'Kualitatif',
            'is_active' => true,
        ]);

        // 6. Sampling & Test Result
        $sampling = Sampling::create([
            'sampling_number' => 'SMP-2026-0001',
            'plan_id' => $plan->id,
            'inspector_id' => $inspector->id,
            'sampling_date' => '2026-09-24',
            'product_name' => 'Kerupuk Ikan Pipih Renyah',
            'brand' => 'Kahayan Jaya',
            'food_type_id' => $foodType->id,
            'sampling_location' => 'Pasar Besar Palangka Raya',
            'sampling_facility_id' => $facility->id,
            'purchase_price' => 15000.00,
            'geo_latitude' => -2.210000,
            'geo_longitude' => 113.920000,
            'geo_accuracy_m' => 4.5,
            'geo_captured_at' => now(),
            'test_date' => '2026-09-25',
            'status' => SamplingStatus::Completed,
            'conclusion' => SamplingConclusion::Compliant,
            'conclusion_notes' => 'Memenuhi seluruh parameter uji',
            'recommendation' => 'Pertahankan sanitasi',
            'publication_status' => PublicationStatus::Published,
            'published_at' => now(),
            'published_by' => $teamLeader->id,
        ]);
        $this->assertTrue(Str::isUuid($sampling->id));

        $testResult = TestResult::create([
            'sampling_id' => $sampling->id,
            'test_parameter_id' => $parameter->id,
            'result_value' => 'Negatif',
            'unit' => 'Kualitatif',
            'requirement_limit' => 'Negatif',
            'compliance_status' => ComplianceStatus::Compliant,
        ]);
        $this->assertCount(1, $sampling->fresh()->testResults);

        // 7. Inspection Requirement & Inspection
        $requirement = InspectionRequirement::create([
            'standard' => InspectionStandard::Cppob,
            'code' => 'CPPOB-01.1',
            'description' => 'Lokasi sarana bebas dari pencemaran lingkungan',
            'is_active' => true,
        ]);

        $inspection = Inspection::create([
            'inspection_number' => 'INSP-2026-0001',
            'plan_id' => $plan->id,
            'facility_id' => $facility->id,
            'inspector_id' => $inspector->id,
            'inspection_date' => '2026-09-24',
            'status' => InspectionStatus::InProgress,
            'geo_latitude' => -2.216667,
            'geo_longitude' => 113.916667,
            'geo_accuracy_m' => 5.0,
            'geo_captured_at' => now(),
            'grade' => 'B',
            'conclusion' => 'Memerlukan perbaikan minor',
            'publication_status' => PublicationStatus::Unpublished,
        ]);
        $this->assertTrue(Str::isUuid($inspection->id));

        // 8. Finding & Attachment
        $finding = InspectionFinding::create([
            'inspection_id' => $inspection->id,
            'requirement_id' => $requirement->id,
            'standard' => InspectionStandard::Cppob,
            'description' => 'Terdapat ventilasi tanpa kasa serangga pada ruang produksi',
            'recommendation' => 'Pasang kasa serangga pada seluruh lubang ventilasi',
            'due_date' => '2026-10-24',
            'status' => FindingStatus::Open,
        ]);
        $this->assertCount(1, $inspection->fresh()->findings);

        $findingAttachment = Attachment::create([
            'attachable_type' => InspectionFinding::class,
            'attachable_id' => $finding->id,
            'file_path' => 'findings/ventilasi.jpg',
            'file_name' => 'ventilasi.jpg',
            'mime' => 'image/jpeg',
            'size_kb' => 250,
            'caption' => 'Foto lubang ventilasi ruang produksi',
            'uploaded_by' => $inspector->id,
        ]);
        $this->assertCount(1, $finding->fresh()->attachments);

        // 9. BAP Document
        $bap = BapDocument::create([
            'inspection_id' => $inspection->id,
            'document_number' => 'BAP-2026-0001',
            'file_path' => 'bap/BAP-2026-0001.pdf',
            'qr_token' => Str::random(32),
            'content_snapshot' => [
                'facility_name' => $facility->name,
                'inspector_name' => $inspector->name,
                'findings_count' => 1,
            ],
            'generated_at' => now(),
            'sent_to_email' => $facility->email,
            'sent_at' => now(),
        ]);
        $this->assertEquals($bap->id, $inspection->fresh()->bapDocument->id);
        $this->assertIsArray($bap->content_snapshot);

        // 10. Follow-up Letter
        $letter = FollowUpLetter::create([
            'inspection_id' => $inspection->id,
            'file_path' => 'letters/SURAT-TL-0001.pdf',
            'sent_by' => $inspector->id,
            'sent_to_email' => $facility->email,
            'sent_at' => now(),
        ]);
        $this->assertCount(1, $inspection->fresh()->followUpLetters);

        // 11. CAPA Submission
        $capa = CapaSubmission::create([
            'finding_id' => $finding->id,
            'round' => 1,
            'corrective_action' => 'Telah dipasang kawat kasa anti-serangga pada 4 lubang ventilasi.',
            'preventive_action' => 'Dibuat jadwal inspeksi kebersihan dan keutuhan kasa setiap bulan.',
            'submitted_by' => $business->id,
            'submitted_at' => now(),
            'status' => CapaSubmissionStatus::Accepted,
            'reviewed_by' => $inspector->id,
            'reviewed_at' => now(),
            'review_notes' => 'Perbaikan sesuai rekomendasi',
        ]);
        $this->assertCount(1, $finding->fresh()->capaSubmissions);

        // 12. CAPA Closure
        $closure = CapaClosure::create([
            'inspection_id' => $inspection->id,
            'letter_number' => 'CLOSED-CAPA-2026-0001',
            'status' => CapaClosureStatus::Approved,
            'verified_by' => $teamLeader->id,
            'verified_at' => now(),
            'approved_by' => $head->id,
            'approved_at' => now(),
            'file_path' => 'closed_capa/CLOSED-CAPA-2026-0001.pdf',
            'sent_at' => now(),
        ]);
        $this->assertEquals($closure->id, $inspection->fresh()->capaClosure->id);

        // 13. Polymorphic Status History
        $history = StatusHistory::create([
            'statusable_type' => Inspection::class,
            'statusable_id' => $inspection->id,
            'old_status' => 'planned',
            'new_status' => 'in_progress',
            'user_id' => $inspector->id,
            'notes' => 'Inspektur mulai pemeriksaan di lokasi',
        ]);
        $this->assertCount(1, $inspection->fresh()->statusHistories);

        // 14. Audit Log
        $audit = AuditLog::create([
            'user_id' => $inspector->id,
            'event' => 'updated',
            'auditable_type' => Facility::class,
            'auditable_id' => $facility->id,
            'old_values' => ['phone' => '081111111111'],
            'new_values' => ['phone' => '081234567890'],
            'ip_address' => '127.0.0.1',
        ]);
        $this->assertTrue(Str::isUuid($audit->id));
        $this->assertIsArray($audit->fresh()->old_values);
    }
}
