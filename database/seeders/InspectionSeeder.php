<?php

namespace Database\Seeders;

use App\Enums\CapaClosureStatus;
use App\Enums\CapaSubmissionStatus;
use App\Enums\FindingStatus;
use App\Enums\InspectionStandard;
use App\Enums\InspectionStatus;
use App\Enums\PublicationStatus;
use App\Enums\SupervisionPlanStatus;
use App\Enums\SupervisionPlanType;
use App\Models\BapDocument;
use App\Models\CapaClosure;
use App\Models\CapaSubmission;
use App\Models\Facility;
use App\Models\FollowUpLetter;
use App\Models\Inspection;
use App\Models\InspectionFinding;
use App\Models\InspectionRequirement;
use App\Models\StatusHistory;
use App\Models\SupervisionPlan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InspectionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed inspection data with complete Layanan B workflow:
     * Planning → In Progress (geotagging) → BAP → Follow-up Letter
     * → CAPA Submission → CAPA Review → CAPA Closure (Verify → Approve → Send).
     *
     * @return void
     */
    public function run(): void
    {
        $teamLeader = User::where('role', 'team_leader')->first();
        $head = User::where('role', 'head')->first();
        $inspectors = User::where('role', 'inspector')->get();
        $inspector1 = $inspectors->first();
        $inspector2 = $inspectors->skip(1)->first();
        $inspector3 = $inspectors->skip(2)->first();

        $facilities = Facility::all();
        $facilityProd1 = $facilities->first(fn ($f) => str_contains($f->name, 'Kahayan Jaya'));
        $facilityProd2 = $facilities->first(fn ($f) => str_contains($f->name, 'Katingan'));
        $facilityProd3 = $facilities->first(fn ($f) => str_contains($f->name, 'Kahayan Berkah'));
        $facilityDist1 = $facilities->first(fn ($f) => str_contains($f->name, 'Distributor Pangan'));
        $facilityDist2 = $facilities->first(fn ($f) => str_contains($f->name, 'Swalayan Central'));

        // === Perencanaan Inspeksi Sarana ===
        $planInspection = SupervisionPlan::firstOrCreate(
            ['title' => 'Perencanaan Inspeksi Sarana Produksi dan Distribusi TW I-II 2026'],
            [
                'plan_type' => SupervisionPlanType::Both,
                'period_start' => '2026-01-01',
                'period_end' => '2026-06-30',
                'status' => SupervisionPlanStatus::Completed,
                'created_by' => $teamLeader->id,
                'notes' => 'Prioritas sarana produksi pangan berisiko tinggi (ikan olahan) dan sarana distribusi skala menengah.',
            ]
        );

        $planInspectionQ3 = SupervisionPlan::firstOrCreate(
            ['title' => 'Perencanaan Inspeksi Sarana TW III 2026'],
            [
                'plan_type' => SupervisionPlanType::Inspection,
                'period_start' => '2026-07-01',
                'period_end' => '2026-09-30',
                'status' => SupervisionPlanStatus::Active,
                'created_by' => $teamLeader->id,
                'notes' => 'Tindak lanjut inspeksi TW I-II dan pemeriksaan sarana baru yang belum pernah diperiksa.',
            ]
        );

        // === INSPEKSI 1: Completed — Full CAPA Cycle (CV Kahayan Jaya) ===
        $req21 = InspectionRequirement::where('code', 'CPPOB-2.1')->first();
        $req25 = InspectionRequirement::where('code', 'CPPOB-2.5')->first();
        $req51 = InspectionRequirement::where('code', 'CPPOB-5.1')->first();
        $req71 = InspectionRequirement::where('code', 'CPPOB-7.1')->first();

        $inspection1 = Inspection::firstOrCreate(
            ['inspection_number' => 'INSP-2026-0001'],
            [
                'plan_id' => $planInspection->id,
                'facility_id' => $facilityProd1->id,
                'inspector_id' => $inspector1->id,
                'inspection_date' => '2026-02-10',
                'status' => InspectionStatus::Completed,
                'geo_latitude' => -2.216200,
                'geo_longitude' => 113.916400,
                'geo_accuracy_m' => 4.3,
                'geo_captured_at' => '2026-02-10 09:05:17',
                'grade' => 'B',
                'conclusion' => 'Sarana produksi memenuhi sebagian besar persyaratan CPPOB. Terdapat 2 temuan ketidaksesuaian minor dan 1 temuan mayor yang harus segera ditindaklanjuti.',
                'publication_status' => PublicationStatus::Published,
                'published_at' => '2026-02-15 10:00:00',
                'published_by' => $teamLeader->id,
            ]
        );

        // Findings for inspection 1 (semua sudah Closed)
        $finding1a = InspectionFinding::firstOrCreate(
            ['inspection_id' => $inspection1->id, 'description' => 'Ventilasi ruang produksi tidak dilengkapi kasa anti-serangga pada 3 dari 5 lubang ventilasi yang ada.'],
            [
                'requirement_id' => $req25->id,
                'standard' => InspectionStandard::Cppob,
                'recommendation' => 'Pasang kasa anti-serangga berbahan stainless pada seluruh lubang ventilasi ruang produksi paling lambat 30 hari setelah surat tindak lanjut diterima.',
                'due_date' => '2026-03-15',
                'status' => FindingStatus::Closed,
                'closed_at' => '2026-03-20 14:00:00',
                'closed_by' => $inspector1->id,
            ]
        );

        $finding1b = InspectionFinding::firstOrCreate(
            ['inspection_id' => $inspection1->id, 'description' => 'Pekerja di bagian pengemasan tidak menggunakan penutup kepala dan masker secara konsisten.'],
            [
                'requirement_id' => $req71->id,
                'standard' => InspectionStandard::Cppob,
                'recommendation' => 'Buat prosedur tertulis dan wajibkan penggunaan APD (celemek, penutup kepala, masker) bagi seluruh pekerja di area produksi. Lakukan pelatihan dan pengawasan internal.',
                'due_date' => '2026-03-15',
                'status' => FindingStatus::Closed,
                'closed_at' => '2026-03-18 10:30:00',
                'closed_by' => $inspector1->id,
            ]
        );

        // BAP for inspection 1
        BapDocument::firstOrCreate(
            ['inspection_id' => $inspection1->id],
            [
                'document_number' => 'BAP-2026-BBPOM-0001',
                'file_path' => 'bap/BAP-2026-BBPOM-0001.pdf',
                'qr_token' => 'qr-' . Str::random(28),
                'content_snapshot' => [
                    'inspection_number' => 'INSP-2026-0001',
                    'facility_name' => $facilityProd1->name,
                    'facility_address' => $facilityProd1->address,
                    'inspector_name' => $inspector1->name,
                    'inspection_date' => '2026-02-10',
                    'grade' => 'B',
                    'findings_count' => 2,
                    'conclusion' => 'Terdapat ketidaksesuaian yang harus ditindaklanjuti.',
                    'generated_at' => '2026-02-10 17:00:00',
                ],
                'generated_at' => '2026-02-10 17:00:00',
                'sent_to_email' => $facilityProd1->email,
                'sent_at' => '2026-02-10 17:05:00',
            ]
        );

        // Follow-up letter for inspection 1
        FollowUpLetter::firstOrCreate(
            ['inspection_id' => $inspection1->id],
            [
                'file_path' => 'letters/TL-INSP-2026-0001.pdf',
                'sent_by' => $inspector1->id,
                'sent_to_email' => $facilityProd1->email,
                'sent_at' => '2026-02-13 09:00:00',
            ]
        );

        // CAPA Submissions for finding 1a
        $capa1a = CapaSubmission::firstOrCreate(
            ['finding_id' => $finding1a->id, 'round' => 1],
            [
                'corrective_action' => 'Telah dipasang kawat kasa anti-serangga berbahan stainless pada seluruh 5 lubang ventilasi ruang produksi pada tanggal 5 Maret 2026. Pekerjaan dilakukan oleh CV Teknik Bangunan Palangka.',
                'preventive_action' => 'Dibuat jadwal inspeksi keutuhan kasa setiap bulan oleh penanggung jawab produksi. Tersedia form pemeriksaan mingguan APD dan sanitasi pekerja.',
                'submitted_by' => $facilityProd1->users()->first()?->id ?? User::where('role', 'business')->first()->id,
                'submitted_at' => '2026-03-08 14:23:00',
                'status' => CapaSubmissionStatus::Accepted,
                'reviewed_by' => $inspector1->id,
                'reviewed_at' => '2026-03-18 11:00:00',
                'review_notes' => 'Telah dilakukan verifikasi lapangan pada 18 Maret 2026. Kasa anti-serangga telah terpasang pada seluruh ventilasi dalam kondisi baik. Temuan dinyatakan Closed.',
            ]
        );

        // CAPA Submissions for finding 1b
        $capa1b = CapaSubmission::firstOrCreate(
            ['finding_id' => $finding1b->id, 'round' => 1],
            [
                'corrective_action' => 'Seluruh pekerja produksi telah diberikan APD lengkap (celemek, penutup kepala, masker). Telah dilakukan briefing dan pelatihan higiene personal pada 1 Maret 2026.',
                'preventive_action' => 'Dibuat SOP Higiene Personal yang ditempelkan di area produksi. Pengawas produksi bertanggung jawab memastikan kepatuhan APD setiap hari.',
                'submitted_by' => $facilityProd1->users()->first()?->id ?? User::where('role', 'business')->first()->id,
                'submitted_at' => '2026-03-05 10:00:00',
                'status' => CapaSubmissionStatus::Accepted,
                'reviewed_by' => $inspector1->id,
                'reviewed_at' => '2026-03-16 09:30:00',
                'review_notes' => 'Dokumen SOP Higiene Personal diterima. Foto bukti distribusi APD diterima. Temuan dinyatakan Closed.',
            ]
        );

        // CAPA Closure for inspection 1 (Completed/Sent)
        $closure1 = CapaClosure::firstOrCreate(
            ['inspection_id' => $inspection1->id],
            [
                'letter_number' => 'CLOSED-CAPA-2026-BBPOM-0001',
                'status' => CapaClosureStatus::Sent,
                'verified_by' => $teamLeader->id,
                'verified_at' => '2026-03-22 10:00:00',
                'approved_by' => $head->id,
                'approved_at' => '2026-03-24 14:00:00',
                'file_path' => 'closed_capa/CLOSED-CAPA-2026-BBPOM-0001.pdf',
                'sent_at' => '2026-03-24 16:00:00',
            ]
        );

        // Status histories for inspection 1
        $statusChanges1 = [
            ['old' => null, 'new' => 'planned', 'actor' => $teamLeader->id, 'at' => '2026-01-20 08:00:00', 'notes' => 'Perencanaan inspeksi dibuat.'],
            ['old' => 'planned', 'new' => 'in_progress', 'actor' => $inspector1->id, 'at' => '2026-02-10 09:05:17', 'notes' => 'Inspeksi dimulai di lokasi sarana produksi.'],
            ['old' => 'in_progress', 'new' => 'bap_issued', 'actor' => $inspector1->id, 'at' => '2026-02-10 17:00:00', 'notes' => 'BAP diterbitkan dan dikirim ke email pelaku usaha.'],
            ['old' => 'bap_issued', 'new' => 'awaiting_capa', 'actor' => $inspector1->id, 'at' => '2026-02-13 09:00:00', 'notes' => 'Surat tindak lanjut dikirim. Menunggu CAPA dari pelaku usaha.'],
            ['old' => 'awaiting_capa', 'new' => 'capa_review', 'actor' => $inspector1->id, 'at' => '2026-03-08 14:23:00', 'notes' => 'CAPA telah diterima dari pelaku usaha. Sedang dalam evaluasi.'],
            ['old' => 'capa_review', 'new' => 'awaiting_signature', 'actor' => $inspector1->id, 'at' => '2026-03-20 14:00:00', 'notes' => 'Semua temuan telah Closed. Menunggu verifikasi dan pengesahan Closed CAPA.'],
            ['old' => 'awaiting_signature', 'new' => 'completed', 'actor' => $head->id, 'at' => '2026-03-24 16:00:00', 'notes' => 'Surat Closed CAPA telah disahkan Kepala Balai dan dikirim ke pelaku usaha.'],
        ];

        foreach ($statusChanges1 as $change) {
            StatusHistory::firstOrCreate(
                [
                    'statusable_type' => Inspection::class,
                    'statusable_id' => $inspection1->id,
                    'new_status' => $change['new'],
                ],
                [
                    'statusable_type' => Inspection::class,
                    'statusable_id' => $inspection1->id,
                    'old_status' => $change['old'],
                    'new_status' => $change['new'],
                    'user_id' => $change['actor'],
                    'notes' => $change['notes'],
                    'created_at' => $change['at'],
                    'updated_at' => $change['at'],
                ]
            );
        }

        // === INSPEKSI 2: CAPA Review Stage (UD Katingan) — Temuan TMS Abon Ikan ===
        $reqBangunan = InspectionRequirement::where('code', 'CPPOB-5.4')->first();
        $reqStorage = InspectionRequirement::where('code', 'CPPOB-8.1')->first();
        $reqPest = InspectionRequirement::where('code', 'CPPOB-6.2')->first();

        $inspection2 = Inspection::firstOrCreate(
            ['inspection_number' => 'INSP-2026-0002'],
            [
                'plan_id' => $planInspection->id,
                'facility_id' => $facilityProd2->id,
                'inspector_id' => $inspector2->id,
                'inspection_date' => '2026-03-05',
                'status' => InspectionStatus::CapaReview,
                'geo_latitude' => -2.211300,
                'geo_longitude' => 113.908800,
                'geo_accuracy_m' => 5.7,
                'geo_captured_at' => '2026-03-05 10:15:42',
                'grade' => 'C',
                'conclusion' => 'Sarana produksi memerlukan perbaikan signifikan. Ditemukan 3 ketidaksesuaian termasuk 1 temuan mayor (keberadaan hama di ruang produksi). Proses produksi ditangguhkan sementara hingga perbaikan dilakukan.',
                'publication_status' => PublicationStatus::Published,
                'published_at' => '2026-03-12 10:00:00',
                'published_by' => $teamLeader->id,
            ]
        );

        $finding2a = InspectionFinding::firstOrCreate(
            ['inspection_id' => $inspection2->id, 'description' => 'Ditemukan kotoran tikus di sudut ruang penyimpanan bahan baku.'],
            [
                'requirement_id' => $reqPest->id,
                'standard' => InspectionStandard::Cppob,
                'recommendation' => 'Segera lakukan pengendalian hama (pest control) secara menyeluruh menggunakan jasa profesional. Tutup semua celah masuk tikus. Bersihkan seluruh area penyimpanan.',
                'due_date' => '2026-04-05',
                'status' => FindingStatus::Open,
                'closed_at' => null,
                'closed_by' => null,
            ]
        );

        $finding2b = InspectionFinding::firstOrCreate(
            ['inspection_id' => $inspection2->id, 'description' => 'Program sanitasi tidak terdokumentasi. Tidak tersedia jadwal pembersihan dan catatan pelaksanaan sanitasi.'],
            [
                'requirement_id' => $reqBangunan->id,
                'standard' => InspectionStandard::Cppob,
                'recommendation' => 'Buat dan implementasikan program sanitasi tertulis yang mencakup jadwal, metode, penanggung jawab, dan bahan sanitasi yang digunakan.',
                'due_date' => '2026-04-05',
                'status' => FindingStatus::Open,
                'closed_at' => null,
                'closed_by' => null,
            ]
        );

        $finding2c = InspectionFinding::firstOrCreate(
            ['inspection_id' => $inspection2->id, 'description' => 'Bahan kimia (deterjen pembersih) disimpan bersamaan dengan bahan baku pangan di rak yang sama.'],
            [
                'requirement_id' => $reqStorage->id,
                'standard' => InspectionStandard::Cppob,
                'recommendation' => 'Pisahkan penyimpanan bahan kimia dari bahan baku pangan. Beri label dan kunci penyimpanan bahan kimia.',
                'due_date' => '2026-04-05',
                'status' => FindingStatus::Open,
                'closed_at' => null,
                'closed_by' => null,
            ]
        );

        BapDocument::firstOrCreate(
            ['inspection_id' => $inspection2->id],
            [
                'document_number' => 'BAP-2026-BBPOM-0002',
                'file_path' => 'bap/BAP-2026-BBPOM-0002.pdf',
                'qr_token' => 'qr-' . Str::random(28),
                'content_snapshot' => [
                    'inspection_number' => 'INSP-2026-0002',
                    'facility_name' => $facilityProd2->name,
                    'facility_address' => $facilityProd2->address,
                    'inspector_name' => $inspector2->name,
                    'inspection_date' => '2026-03-05',
                    'grade' => 'C',
                    'findings_count' => 3,
                    'conclusion' => 'Sarana memerlukan perbaikan signifikan.',
                    'generated_at' => '2026-03-05 16:30:00',
                ],
                'generated_at' => '2026-03-05 16:30:00',
                'sent_to_email' => $facilityProd2->email,
                'sent_at' => '2026-03-05 16:35:00',
            ]
        );

        FollowUpLetter::firstOrCreate(
            ['inspection_id' => $inspection2->id],
            [
                'file_path' => 'letters/TL-INSP-2026-0002.pdf',
                'sent_by' => $inspector2->id,
                'sent_to_email' => $facilityProd2->email,
                'sent_at' => '2026-03-10 09:00:00',
            ]
        );

        // CAPA ditolak, ronde 2 masih direview
        $businessUser2 = $facilityProd2->users()->first() ?? User::where('role', 'business')->skip(1)->first();

        $capa2a_r1 = CapaSubmission::firstOrCreate(
            ['finding_id' => $finding2a->id, 'round' => 1],
            [
                'corrective_action' => 'Sudah dilakukan pest control oleh pihak ketiga pada 20 Maret 2026.',
                'preventive_action' => 'Akan dipasang perangkap tikus setiap bulan.',
                'submitted_by' => $businessUser2->id,
                'submitted_at' => '2026-03-22 11:00:00',
                'status' => CapaSubmissionStatus::Rejected,
                'reviewed_by' => $inspector2->id,
                'reviewed_at' => '2026-04-02 10:00:00',
                'review_notes' => 'Sertifikat pest control tidak dilampirkan. Celah masuk tikus di dinding bagian barat belum ditutup berdasarkan hasil verifikasi lapangan. Mohon lengkapi bukti dan perbaikan fisik.',
            ]
        );

        $capa2a_r2 = CapaSubmission::firstOrCreate(
            ['finding_id' => $finding2a->id, 'round' => 2],
            [
                'corrective_action' => 'Sertifikat pest control dari CV Pest Control Kalimantan terlampir (tanggal 20 Maret 2026). Celah dinding bagian barat telah ditutup dengan adukan semen pada 10 April 2026.',
                'preventive_action' => 'Pest control rutin dijadwalkan setiap 3 bulan. Pemasangan trapping station dilakukan di 4 titik area penyimpanan.',
                'submitted_by' => $businessUser2->id,
                'submitted_at' => '2026-04-15 14:00:00',
                'status' => CapaSubmissionStatus::Submitted,
                'reviewed_by' => null,
                'reviewed_at' => null,
                'review_notes' => null,
            ]
        );

        // === INSPEKSI 3: Awaiting CAPA (PT Kahayan Berkah — Distribusi) ===
        $reqCperpob31 = InspectionRequirement::where('code', 'CPERPOB-3.1')->first();
        $reqCperpob12 = InspectionRequirement::where('code', 'CPERPOB-1.2')->first();
        $reqCperpob34 = InspectionRequirement::where('code', 'CPERPOB-3.4')->first();

        $inspection3 = Inspection::firstOrCreate(
            ['inspection_number' => 'INSP-2026-0003'],
            [
                'plan_id' => $planInspection->id,
                'facility_id' => $facilityDist1->id,
                'inspector_id' => $inspector3->id,
                'inspection_date' => '2026-05-08',
                'status' => InspectionStatus::AwaitingCapa,
                'geo_latitude' => -2.213500,
                'geo_longitude' => 113.912800,
                'geo_accuracy_m' => 4.1,
                'geo_captured_at' => '2026-05-08 10:05:33',
                'grade' => 'B',
                'conclusion' => 'Sarana distribusi perlu melakukan perbaikan pada pengelolaan produk kedaluwarsa dan kelengkapan izin edar produk yang beredar.',
                'publication_status' => PublicationStatus::Published,
                'published_at' => '2026-05-15 10:00:00',
                'published_by' => $teamLeader->id,
            ]
        );

        $finding3a = InspectionFinding::firstOrCreate(
            ['inspection_id' => $inspection3->id, 'description' => 'Ditemukan 3 (tiga) produk minuman kemasan yang beredar tanpa nomor izin edar BPOM (tidak ada nomor MD/ML pada kemasan).'],
            [
                'requirement_id' => $reqCperpob31->id,
                'standard' => InspectionStandard::Cperpob,
                'recommendation' => 'Segera tarik produk tanpa izin edar dari peredaran. Pastikan seluruh produk yang beredar memiliki nomor izin edar yang valid.',
                'due_date' => '2026-06-08',
                'status' => FindingStatus::Open,
                'closed_at' => null,
                'closed_by' => null,
            ]
        );

        $finding3b = InspectionFinding::firstOrCreate(
            ['inspection_id' => $inspection3->id, 'description' => 'Ditemukan 8 (delapan) produk makanan ringan telah melampaui tanggal kedaluwarsa dan masih tersimpan bercampur dengan produk yang masih berlaku.'],
            [
                'requirement_id' => $reqCperpob34->id,
                'standard' => InspectionStandard::Cperpob,
                'recommendation' => 'Segera pisahkan dan musnahkan produk kedaluwarsa. Terapkan sistem FEFO secara konsisten dan beri penanda/stiker pada produk yang mendekati kedaluwarsa.',
                'due_date' => '2026-06-08',
                'status' => FindingStatus::Open,
                'closed_at' => null,
                'closed_by' => null,
            ]
        );

        BapDocument::firstOrCreate(
            ['inspection_id' => $inspection3->id],
            [
                'document_number' => 'BAP-2026-BBPOM-0003',
                'file_path' => 'bap/BAP-2026-BBPOM-0003.pdf',
                'qr_token' => 'qr-' . Str::random(28),
                'content_snapshot' => [
                    'inspection_number' => 'INSP-2026-0003',
                    'facility_name' => $facilityDist1->name,
                    'inspector_name' => $inspector3->name,
                    'inspection_date' => '2026-05-08',
                    'grade' => 'B',
                    'findings_count' => 2,
                    'generated_at' => '2026-05-08 16:00:00',
                ],
                'generated_at' => '2026-05-08 16:00:00',
                'sent_to_email' => $facilityDist1->email,
                'sent_at' => '2026-05-08 16:10:00',
            ]
        );

        FollowUpLetter::firstOrCreate(
            ['inspection_id' => $inspection3->id],
            [
                'file_path' => 'letters/TL-INSP-2026-0003.pdf',
                'sent_by' => $inspector3->id,
                'sent_to_email' => $facilityDist1->email,
                'sent_at' => '2026-05-12 09:00:00',
            ]
        );

        // === INSPEKSI 4: BAP Issued (No findings — Sarana Distribusi Swalayan) ===
        $inspection4 = Inspection::firstOrCreate(
            ['inspection_number' => 'INSP-2026-0004'],
            [
                'plan_id' => $planInspectionQ3->id,
                'facility_id' => $facilityDist2->id,
                'inspector_id' => $inspector1->id,
                'inspection_date' => '2026-08-20',
                'status' => InspectionStatus::Completed,
                'geo_latitude' => -2.217800,
                'geo_longitude' => 113.920500,
                'geo_accuracy_m' => 3.9,
                'geo_captured_at' => '2026-08-20 09:45:00',
                'grade' => 'A',
                'conclusion' => 'Sarana distribusi memenuhi seluruh persyaratan CPerPOB. Tidak ditemukan ketidaksesuaian. Pengelolaan produk dan sanitasi sarana dalam kondisi baik.',
                'publication_status' => PublicationStatus::Published,
                'published_at' => '2026-08-25 10:00:00',
                'published_by' => $teamLeader->id,
            ]
        );

        BapDocument::firstOrCreate(
            ['inspection_id' => $inspection4->id],
            [
                'document_number' => 'BAP-2026-BBPOM-0004',
                'file_path' => 'bap/BAP-2026-BBPOM-0004.pdf',
                'qr_token' => 'qr-' . Str::random(28),
                'content_snapshot' => [
                    'inspection_number' => 'INSP-2026-0004',
                    'facility_name' => $facilityDist2->name,
                    'inspector_name' => $inspector1->name,
                    'inspection_date' => '2026-08-20',
                    'grade' => 'A',
                    'findings_count' => 0,
                    'conclusion' => 'Memenuhi seluruh persyaratan CPerPOB.',
                    'generated_at' => '2026-08-20 16:00:00',
                ],
                'generated_at' => '2026-08-20 16:00:00',
                'sent_to_email' => $facilityDist2->email,
                'sent_at' => '2026-08-20 16:05:00',
            ]
        );

        // === INSPEKSI 5: In Progress (Sedang berlangsung hari ini) ===
        if ($facilityProd3) {
            $inspection5 = Inspection::firstOrCreate(
                ['inspection_number' => 'INSP-2026-0005'],
                [
                    'plan_id' => $planInspectionQ3->id,
                    'facility_id' => $facilityProd3->id,
                    'inspector_id' => $inspector2->id,
                    'inspection_date' => '2026-09-24',
                    'status' => InspectionStatus::InProgress,
                    'geo_latitude' => -2.185000,
                    'geo_longitude' => 113.934000,
                    'geo_accuracy_m' => 5.0,
                    'geo_captured_at' => '2026-09-24 09:30:00',
                    'grade' => null,
                    'conclusion' => null,
                    'publication_status' => PublicationStatus::Unpublished,
                    'published_at' => null,
                    'published_by' => null,
                ]
            );
        }
    }
}
