<?php

namespace Database\Seeders;

use App\Enums\FacilityType;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed facility data (production and distribution) with associated business users.
     *
     * @return void
     */
    public function run(): void
    {
        $facilities = [
            // === SARANA PRODUKSI ===
            [
                'name' => 'CV Kahayan Jaya Pangan',
                'facility_type' => FacilityType::Production,
                'commodity_type' => 'Kerupuk Ikan dan Amplang',
                'address' => 'Jl. Tjilik Riwut Km 2.5 No. 14, Kel. Bukit Tunggal',
                'regency' => 'Kota Palangka Raya',
                'latitude' => -2.216200,
                'longitude' => 113.916400,
                'pic_name' => 'Hendra Wijaya',
                'phone' => '081377889900',
                'email' => 'hendra@cvkahayanjaya.com',
                'nib' => '1234567890001',
                'npwp' => '01.111.222.3-901.000',
                'nie_number' => 'MD 123456789012',
                'cppob_certificate_number' => 'CPPOB-2025-KPR-001',
                'cppob_certificate_valid_until' => '2027-06-30',
                'is_active' => true,
                'business_email' => 'hendra@cvkahayanjaya.com',
            ],
            [
                'name' => 'UD Katingan Makmur',
                'facility_type' => FacilityType::Production,
                'commodity_type' => 'Abon Ikan Haruan dan Ikan Asin',
                'address' => 'Jl. G. Obos XII No. 23, Kel. Menteng',
                'regency' => 'Kota Palangka Raya',
                'latitude' => -2.211300,
                'longitude' => 113.908800,
                'pic_name' => 'Slamet Riyadi',
                'phone' => '081488990011',
                'email' => 'slamet@ud-katingan.com',
                'nib' => '1234567890002',
                'npwp' => '02.222.333.4-901.000',
                'nie_number' => 'MD 234567890123',
                'cppob_certificate_number' => 'CPPOB-2024-KPR-007',
                'cppob_certificate_valid_until' => '2026-12-31',
                'is_active' => true,
                'business_email' => 'slamet@ud-katingan.com',
            ],
            [
                'name' => 'PT Kahayan Berkah Sentosa',
                'facility_type' => FacilityType::Production,
                'commodity_type' => 'Minuman Sari Buah dan Sirup',
                'address' => 'Jl. Cilik Riwut Km 5, Kawasan Industri Block A-3',
                'regency' => 'Kota Palangka Raya',
                'latitude' => -2.185000,
                'longitude' => 113.934000,
                'pic_name' => 'Yuliana Putri',
                'phone' => '081599001122',
                'email' => 'yuliana@pt-kahayan.com',
                'nib' => '1234567890003',
                'npwp' => '03.333.444.5-901.000',
                'nie_number' => 'MD 345678901234',
                'cppob_certificate_number' => 'CPPOB-2026-KPR-003',
                'cppob_certificate_valid_until' => '2028-09-30',
                'is_active' => true,
                'business_email' => 'yuliana@pt-kahayan.com',
            ],
            [
                'name' => 'UMKM Ibu Sari Pangan',
                'facility_type' => FacilityType::Production,
                'commodity_type' => 'Keripik Singkong dan Pisang',
                'address' => 'Jl. RTA Milono Km 1.5 No. 7, Kel. Langkai',
                'regency' => 'Kota Palangka Raya',
                'latitude' => -2.208700,
                'longitude' => 113.921100,
                'pic_name' => 'Sari Dewi',
                'phone' => '082144556677',
                'email' => 'saridewi.umkm@gmail.com',
                'nib' => '1234567890004',
                'npwp' => '04.444.555.6-901.000',
                'nie_number' => 'MD 456789012345',
                'cppob_certificate_number' => null,
                'cppob_certificate_valid_until' => null,
                'is_active' => true,
                'business_email' => null,
            ],
            [
                'name' => 'CV Barito Hasil Laut',
                'facility_type' => FacilityType::Production,
                'commodity_type' => 'Terasi Udang dan Ikan Fermentasi',
                'address' => 'Jl. Pangeran Antasari No. 45',
                'regency' => 'Kab. Barito Selatan',
                'latitude' => -1.864300,
                'longitude' => 114.836700,
                'pic_name' => 'Rahmad Hidayat',
                'phone' => '082255667788',
                'email' => 'cv.baritohasillaut@gmail.com',
                'nib' => '1234567890005',
                'npwp' => '05.555.666.7-901.000',
                'nie_number' => null,
                'cppob_certificate_number' => null,
                'cppob_certificate_valid_until' => null,
                'is_active' => true,
                'business_email' => null,
            ],

            // === SARANA DISTRIBUSI ===
            [
                'name' => 'Toko Distributor Pangan Palangka',
                'facility_type' => FacilityType::Distribution,
                'commodity_type' => 'Pangan Olahan Umum',
                'address' => 'Jl. Ahmad Yani No. 12, Pasar Besar Palangka Raya',
                'regency' => 'Kota Palangka Raya',
                'latitude' => -2.213500,
                'longitude' => 113.912800,
                'pic_name' => 'Agus Prabowo',
                'phone' => '081600112233',
                'email' => 'agus@distributor-palangka.com',
                'nib' => '1234567890006',
                'npwp' => '06.666.777.8-901.000',
                'nie_number' => null,
                'cppob_certificate_number' => null,
                'cppob_certificate_valid_until' => null,
                'is_active' => true,
                'business_email' => 'agus@distributor-palangka.com',
            ],
            [
                'name' => 'Minimarket Swalayan Central Palangka',
                'facility_type' => FacilityType::Distribution,
                'commodity_type' => 'Pangan Olahan Umum dan Minuman',
                'address' => 'Jl. Imam Bonjol No. 88',
                'regency' => 'Kota Palangka Raya',
                'latitude' => -2.217800,
                'longitude' => 113.920500,
                'pic_name' => 'Indra Setiawan',
                'phone' => '082333445566',
                'email' => 'centralpalangka@swalayan.com',
                'nib' => '1234567890007',
                'npwp' => '07.777.888.9-901.000',
                'nie_number' => null,
                'cppob_certificate_number' => null,
                'cppob_certificate_valid_until' => null,
                'is_active' => true,
                'business_email' => null,
            ],
            [
                'name' => 'Depot Air Minum Isi Ulang "Bening"',
                'facility_type' => FacilityType::Distribution,
                'commodity_type' => 'Air Minum Dalam Kemasan (AMDK)',
                'address' => 'Jl. Yos Sudarso No. 55, Kel. Pahandut',
                'regency' => 'Kota Palangka Raya',
                'latitude' => -2.220000,
                'longitude' => 113.906000,
                'pic_name' => 'Eko Santoso',
                'phone' => '081711223344',
                'email' => 'depot.bening@gmail.com',
                'nib' => '1234567890008',
                'npwp' => '08.888.999.0-901.000',
                'nie_number' => null,
                'cppob_certificate_number' => null,
                'cppob_certificate_valid_until' => null,
                'is_active' => true,
                'business_email' => null,
            ],
            [
                'name' => 'Toko Sembako UD Kalimantan Jaya',
                'facility_type' => FacilityType::Distribution,
                'commodity_type' => 'Sembako dan Pangan Olahan',
                'address' => 'Jl. Diponegoro No. 17',
                'regency' => 'Kab. Kotawaringin Barat',
                'latitude' => -2.729900,
                'longitude' => 111.672300,
                'pic_name' => 'Wahyudi',
                'phone' => '082444556677',
                'email' => null,
                'nib' => '1234567890009',
                'npwp' => '09.999.000.1-901.000',
                'nie_number' => null,
                'cppob_certificate_number' => null,
                'cppob_certificate_valid_until' => null,
                'is_active' => true,
                'business_email' => null,
            ],
        ];

        foreach ($facilities as $facilityData) {
            $businessEmail = $facilityData['business_email'];
            unset($facilityData['business_email']);

            $facility = Facility::firstOrCreate(
                ['name' => $facilityData['name'], 'regency' => $facilityData['regency']],
                $facilityData
            );

            // Link business user to their facility if they have an account
            if ($businessEmail) {
                $businessUser = User::where('email', $businessEmail)->first();
                if ($businessUser && ! $facility->users()->where('user_id', $businessUser->id)->exists()) {
                    $facility->users()->attach($businessUser->id);
                }
            }
        }
    }
}
