<?php

namespace Database\Seeders;

use App\Enums\PublicationStatus;
use App\Enums\SamplingConclusion;
use App\Enums\SamplingStatus;
use App\Enums\SupervisionPlanStatus;
use App\Enums\SupervisionPlanType;
use App\Models\Facility;
use App\Models\FoodType;
use App\Models\Sampling;
use App\Models\SupervisionPlan;
use App\Models\TestParameter;
use App\Models\TestResult;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SamplingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed supervision plans and sampling data for Layanan A (Informasi Hasil Sampling & Pengujian).
     *
     * @return void
     */
    public function run(): void
    {
        $teamLeader = User::where('role', 'team_leader')->first();
        $inspectors = User::where('role', 'inspector')->get();
        $inspector1 = $inspectors->first();
        $inspector2 = $inspectors->skip(1)->first();
        $inspector3 = $inspectors->skip(2)->first();

        // === Perencanaan Sampling TW I 2026 ===
        $planTw1 = SupervisionPlan::firstOrCreate(
            ['title' => 'Perencanaan Sampling Produk Pangan TW I 2026'],
            [
                'plan_type' => SupervisionPlanType::Sampling,
                'period_start' => '2026-01-01',
                'period_end' => '2026-03-31',
                'status' => SupervisionPlanStatus::Completed,
                'created_by' => $teamLeader->id,
                'notes' => 'Fokus pada produk olahan ikan lokal dan produk AMDK beredar di Kota Palangka Raya.',
            ]
        );

        // === Perencanaan Sampling TW II & III 2026 ===
        $planTw2 = SupervisionPlan::firstOrCreate(
            ['title' => 'Perencanaan Sampling Produk Pangan TW II-III 2026'],
            [
                'plan_type' => SupervisionPlanType::Sampling,
                'period_start' => '2026-04-01',
                'period_end' => '2026-09-30',
                'status' => SupervisionPlanStatus::Active,
                'created_by' => $teamLeader->id,
                'notes' => 'Target produk berisiko tinggi: olahan daging beku, produk minuman kemasan kecil, dan jajanan kemasan.',
            ]
        );

        $facilities = Facility::all()->keyBy('name');
        $palangkaFacility = $facilities->first(fn ($f) => str_contains($f->name, 'Kahayan Jaya'));
        $katinganFacility = $facilities->first(fn ($f) => str_contains($f->name, 'Katingan'));
        $distributorFacility = $facilities->first(fn ($f) => str_contains($f->regency, 'Palangka') && $f->facility_type->value === 'distribution');

        // Get food types
        $typeKrupukIkan = FoodType::where('name', 'like', '%Kerupuk Ikan%')->first()
            ?? FoodType::whereHas('category', fn ($q) => $q->where('code', '09'))->first();
        $typeAmplang = FoodType::where('name', 'like', '%Amplang%')->first() ?? $typeKrupukIkan;
        $typeAbonIkan = FoodType::where('name', 'like', '%Abon Ikan%')->first() ?? $typeKrupukIkan;
        $typeMinumanJus = FoodType::where('name', 'like', '%Minuman Jus%')->first()
            ?? FoodType::whereHas('category', fn ($q) => $q->where('code', '14'))->first();
        $typeAmdk = FoodType::where('name', 'like', '%AMDK%')->first() ?? $typeMinumanJus;
        $typeIkanAsin = FoodType::where('name', 'like', '%Ikan Asin%')->first() ?? $typeKrupukIkan;
        $typeMiInstan = FoodType::where('name', 'like', '%Mi Instan%')->first()
            ?? FoodType::whereHas('category', fn ($q) => $q->where('code', '06'))->first();
        $typeSaus = FoodType::where('name', 'like', '%Saus Sambal%')->first()
            ?? FoodType::whereHas('category', fn ($q) => $q->where('code', '12'))->first();

        // Get test parameters
        $paramBoraks = TestParameter::where('code', 'BTP-001')->first();
        $paramFormalin = TestParameter::where('code', 'BTP-002')->first();
        $paramRhodamin = TestParameter::where('code', 'BTP-003')->first();
        $paramAlt = TestParameter::where('code', 'MIK-001')->first();
        $paramEcoli = TestParameter::where('code', 'MIK-002')->first();
        $paramSalmonella = TestParameter::where('code', 'MIK-003')->first();
        $paramBenzoat = TestParameter::where('code', 'BTP-010')->first();
        $paramPb = TestParameter::where('code', 'CEM-001')->first();

        $samplingData = [
            // --- TW I 2026 (Selesai & Dipublikasikan) ---
            [
                'sampling_number' => 'SMP-2026-0001',
                'plan_id' => $planTw1->id,
                'inspector_id' => $inspector1->id,
                'sampling_date' => '2026-01-15',
                'product_name' => 'Amplang Kahayan Crispy',
                'brand' => 'Kahayan Jaya',
                'food_type' => $typeAmplang,
                'sampling_location' => 'Pasar Besar Palangka Raya',
                'sampling_facility_id' => $palangkaFacility?->id,
                'purchase_price' => 25000.00,
                'geo_latitude' => -2.213500,
                'geo_longitude' => 113.912800,
                'geo_accuracy_m' => 4.2,
                'geo_captured_at' => '2026-01-15 09:14:22',
                'test_date' => '2026-01-20',
                'status' => SamplingStatus::Completed,
                'conclusion' => SamplingConclusion::Compliant,
                'conclusion_notes' => 'Seluruh parameter uji memenuhi syarat sesuai SNI dan PerBPOM.',
                'recommendation' => 'Pertahankan konsistensi proses produksi dan sanitasi.',
                'publication_status' => PublicationStatus::Published,
                'published_at' => '2026-01-25 10:00:00',
                'published_by' => $teamLeader->id,
                'test_results' => [
                    ['parameter' => $paramBoraks, 'result_value' => 'Negatif', 'unit' => null, 'requirement_limit' => 'Negatif', 'compliant' => true],
                    ['parameter' => $paramFormalin, 'result_value' => 'Negatif', 'unit' => null, 'requirement_limit' => 'Negatif', 'compliant' => true],
                    ['parameter' => $paramRhodamin, 'result_value' => 'Negatif', 'unit' => null, 'requirement_limit' => 'Negatif', 'compliant' => true],
                    ['parameter' => $paramAlt, 'result_value' => '1.2 x 10²', 'unit' => 'koloni/g', 'requirement_limit' => 'Maks. 1 x 10⁵ koloni/g', 'compliant' => true],
                ],
            ],
            [
                'sampling_number' => 'SMP-2026-0002',
                'plan_id' => $planTw1->id,
                'inspector_id' => $inspector1->id,
                'sampling_date' => '2026-01-22',
                'product_name' => 'Abon Ikan Haruan Spesial',
                'brand' => 'UD Katingan',
                'food_type' => $typeAbonIkan,
                'sampling_location' => 'Toko Oleh-oleh Jl. Ahmad Yani',
                'sampling_facility_id' => $katinganFacility?->id,
                'purchase_price' => 45000.00,
                'geo_latitude' => -2.209100,
                'geo_longitude' => 113.913200,
                'geo_accuracy_m' => 5.1,
                'geo_captured_at' => '2026-01-22 10:33:07',
                'test_date' => '2026-01-28',
                'status' => SamplingStatus::Completed,
                'conclusion' => SamplingConclusion::NonCompliant,
                'conclusion_notes' => 'Ditemukan penggunaan formalin sebagai pengawet yang tidak diizinkan untuk produk pangan.',
                'recommendation' => 'Hentikan penggunaan formalin. Gunakan bahan pengawet yang diizinkan (natrium benzoat) sesuai batas maksimum. Lakukan pembinaan dan pengujian ulang sebelum produk dipasarkan kembali.',
                'publication_status' => PublicationStatus::Published,
                'published_at' => '2026-02-03 10:00:00',
                'published_by' => $teamLeader->id,
                'test_results' => [
                    ['parameter' => $paramBoraks, 'result_value' => 'Negatif', 'unit' => null, 'requirement_limit' => 'Negatif', 'compliant' => true],
                    ['parameter' => $paramFormalin, 'result_value' => 'Positif', 'unit' => null, 'requirement_limit' => 'Negatif', 'compliant' => false],
                    ['parameter' => $paramAlt, 'result_value' => '3.5 x 10³', 'unit' => 'koloni/g', 'requirement_limit' => 'Maks. 1 x 10⁵ koloni/g', 'compliant' => true],
                ],
            ],
            [
                'sampling_number' => 'SMP-2026-0003',
                'plan_id' => $planTw1->id,
                'inspector_id' => $inspector2->id,
                'sampling_date' => '2026-02-05',
                'product_name' => 'Air Minum Dalam Kemasan "Bening" 600ml',
                'brand' => 'Bening',
                'food_type' => $typeAmdk,
                'sampling_location' => 'Depot Air Minum Isi Ulang Bening',
                'sampling_facility_id' => null,
                'purchase_price' => 3500.00,
                'geo_latitude' => -2.219800,
                'geo_longitude' => 113.906100,
                'geo_accuracy_m' => 3.8,
                'geo_captured_at' => '2026-02-05 08:45:11',
                'test_date' => '2026-02-10',
                'status' => SamplingStatus::Completed,
                'conclusion' => SamplingConclusion::Compliant,
                'conclusion_notes' => 'Seluruh parameter uji memenuhi persyaratan standar AMDK (SNI 3553).',
                'recommendation' => 'Pertahankan higiene peralatan pengisian dan lakukan pengujian berkala mandiri.',
                'publication_status' => PublicationStatus::Published,
                'published_at' => '2026-02-17 10:00:00',
                'published_by' => $teamLeader->id,
                'test_results' => [
                    ['parameter' => $paramAlt, 'result_value' => '< 1', 'unit' => 'koloni/mL', 'requirement_limit' => 'Maks. 1.0 x 10² koloni/mL', 'compliant' => true],
                    ['parameter' => $paramEcoli, 'result_value' => '< 1.1', 'unit' => 'APM/100mL', 'requirement_limit' => '< 1.1 APM/100mL', 'compliant' => true],
                    ['parameter' => $paramPb, 'result_value' => '< 0.005', 'unit' => 'mg/L', 'requirement_limit' => 'Maks. 0.01 mg/L', 'compliant' => true],
                ],
            ],
            [
                'sampling_number' => 'SMP-2026-0004',
                'plan_id' => $planTw1->id,
                'inspector_id' => $inspector2->id,
                'sampling_date' => '2026-02-18',
                'product_name' => 'Kerupuk Ikan Tengiri Gurih',
                'brand' => 'Barito Seafood',
                'food_type' => $typeKrupukIkan,
                'sampling_location' => 'Toko Distributor Pangan Palangka, Jl. Ahmad Yani',
                'sampling_facility_id' => $distributorFacility?->id,
                'purchase_price' => 18000.00,
                'geo_latitude' => -2.213500,
                'geo_longitude' => 113.912800,
                'geo_accuracy_m' => 4.9,
                'geo_captured_at' => '2026-02-18 11:02:45',
                'test_date' => '2026-02-25',
                'status' => SamplingStatus::Completed,
                'conclusion' => SamplingConclusion::NonCompliant,
                'conclusion_notes' => 'Ditemukan penggunaan Rhodamin B (pewarna tekstil yang dilarang untuk pangan) pada produk.',
                'recommendation' => 'Tarik produk dari peredaran. Peringatkan produsen dan sarana distribusi. Koordinasi untuk tindak lanjut hukum jika diperlukan.',
                'publication_status' => PublicationStatus::Published,
                'published_at' => '2026-03-04 10:00:00',
                'published_by' => $teamLeader->id,
                'test_results' => [
                    ['parameter' => $paramRhodamin, 'result_value' => 'Positif', 'unit' => null, 'requirement_limit' => 'Negatif', 'compliant' => false],
                    ['parameter' => $paramBoraks, 'result_value' => 'Negatif', 'unit' => null, 'requirement_limit' => 'Negatif', 'compliant' => true],
                    ['parameter' => $paramAlt, 'result_value' => '4.1 x 10³', 'unit' => 'koloni/g', 'requirement_limit' => 'Maks. 1 x 10⁵ koloni/g', 'compliant' => true],
                ],
            ],
            [
                'sampling_number' => 'SMP-2026-0005',
                'plan_id' => $planTw1->id,
                'inspector_id' => $inspector3->id,
                'sampling_date' => '2026-03-10',
                'product_name' => 'Saus Sambal Pedas Manis Rasa Nusantara',
                'brand' => 'Nusantara Hot Sauce',
                'food_type' => $typeSaus,
                'sampling_location' => 'Minimarket Swalayan Central Palangka',
                'sampling_facility_id' => null,
                'purchase_price' => 12000.00,
                'geo_latitude' => -2.217800,
                'geo_longitude' => 113.920500,
                'geo_accuracy_m' => 5.3,
                'geo_captured_at' => '2026-03-10 14:11:29',
                'test_date' => '2026-03-17',
                'status' => SamplingStatus::Completed,
                'conclusion' => SamplingConclusion::NonCompliant,
                'conclusion_notes' => 'Kandungan natrium benzoat melebihi batas maksimum yang diizinkan PerBPOM No. 11 Tahun 2019.',
                'recommendation' => 'Informasikan produsen untuk menyesuaikan formula. Uji ulang sebelum produk beredar kembali. Koordinasi dengan Kantor BPOM setempat produsen.',
                'publication_status' => PublicationStatus::Published,
                'published_at' => '2026-03-25 10:00:00',
                'published_by' => $teamLeader->id,
                'test_results' => [
                    ['parameter' => $paramRhodamin, 'result_value' => 'Negatif', 'unit' => null, 'requirement_limit' => 'Negatif', 'compliant' => true],
                    ['parameter' => $paramBenzoat, 'result_value' => '1850', 'unit' => 'mg/kg', 'requirement_limit' => 'Maks. 1000 mg/kg', 'compliant' => false],
                    ['parameter' => $paramAlt, 'result_value' => '2.3 x 10²', 'unit' => 'koloni/g', 'requirement_limit' => 'Maks. 1 x 10⁴ koloni/g', 'compliant' => true],
                ],
            ],

            // --- TW II-III 2026 (Sedang Berjalan) ---
            [
                'sampling_number' => 'SMP-2026-0006',
                'plan_id' => $planTw2->id,
                'inspector_id' => $inspector1->id,
                'sampling_date' => '2026-09-10',
                'product_name' => 'Mi Instan Rasa Rendang Lokal',
                'brand' => 'Kahayan Mie',
                'food_type' => $typeMiInstan,
                'sampling_location' => 'Minimarket Swalayan Central Palangka',
                'sampling_facility_id' => null,
                'purchase_price' => 4500.00,
                'geo_latitude' => -2.217800,
                'geo_longitude' => 113.920500,
                'geo_accuracy_m' => 6.1,
                'geo_captured_at' => '2026-09-10 09:22:14',
                'test_date' => '2026-09-17',
                'status' => SamplingStatus::InTesting,
                'conclusion' => null,
                'conclusion_notes' => null,
                'recommendation' => null,
                'publication_status' => PublicationStatus::Unpublished,
                'published_at' => null,
                'published_by' => null,
                'test_results' => [],
            ],
            [
                'sampling_number' => 'SMP-2026-0007',
                'plan_id' => $planTw2->id,
                'inspector_id' => $inspector2->id,
                'sampling_date' => '2026-09-18',
                'product_name' => 'Ikan Asin Sepat Kering',
                'brand' => 'Tanpa Merek (Produsen Lokal)',
                'food_type' => $typeIkanAsin,
                'sampling_location' => 'Pasar Kahayan, Jl. Diponegoro',
                'sampling_facility_id' => null,
                'purchase_price' => 35000.00,
                'geo_latitude' => -2.208000,
                'geo_longitude' => 113.907300,
                'geo_accuracy_m' => 7.2,
                'geo_captured_at' => '2026-09-18 10:45:31',
                'test_date' => null,
                'status' => SamplingStatus::Sampled,
                'conclusion' => null,
                'conclusion_notes' => null,
                'recommendation' => null,
                'publication_status' => PublicationStatus::Unpublished,
                'published_at' => null,
                'published_by' => null,
                'test_results' => [],
            ],
        ];

        foreach ($samplingData as $data) {
            $testResults = $data['test_results'];
            $foodType = $data['food_type'];
            unset($data['test_results'], $data['food_type']);

            $sampling = Sampling::firstOrCreate(
                ['sampling_number' => $data['sampling_number']],
                array_merge($data, ['food_type_id' => $foodType?->id])
            );

            foreach ($testResults as $resultData) {
                if (! $resultData['parameter']) {
                    continue;
                }

                TestResult::firstOrCreate(
                    ['sampling_id' => $sampling->id, 'test_parameter_id' => $resultData['parameter']->id],
                    [
                        'result_value' => $resultData['result_value'],
                        'unit' => $resultData['unit'],
                        'requirement_limit' => $resultData['requirement_limit'],
                        'compliance_status' => $resultData['compliant'] ? 'compliant' : 'non_compliant',
                    ]
                );
            }
        }
    }
}
