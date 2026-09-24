<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use App\Models\FoodType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed food categories and food types based on BPOM food category codes.
     *
     * @return void
     */
    public function run(): void
    {
        $categories = [
            [
                'code' => '01',
                'name' => 'Produk Susu dan Analognya',
                'types' => [
                    'Susu Pasteurisasi',
                    'Susu UHT',
                    'Susu Kental Manis',
                    'Keju',
                    'Mentega',
                    'Krim',
                    'Yogurt',
                    'Es Krim',
                ],
            ],
            [
                'code' => '02',
                'name' => 'Lemak, Minyak, dan Emulsi Lemak',
                'types' => [
                    'Minyak Goreng Kelapa Sawit',
                    'Minyak Goreng Kelapa',
                    'Margarin',
                    'Lemak Hewan',
                    'Minyak Ikan',
                ],
            ],
            [
                'code' => '03',
                'name' => 'Es untuk Dimakan (Edible Ice)',
                'types' => [
                    'Es Krim',
                    'Sorbet',
                    'Es Lilin',
                ],
            ],
            [
                'code' => '04',
                'name' => 'Buah dan Sayur (Termasuk Jamur, Umbi, Kacang-kacangan)',
                'types' => [
                    'Sayur Olahan Kalengan',
                    'Buah Olahan Kalengan',
                    'Keripik Sayur dan Buah',
                    'Buah Kering',
                    'Acar dan Pikel',
                    'Selai dan Jeli Buah',
                    'Manisan Buah',
                ],
            ],
            [
                'code' => '05',
                'name' => 'Kembang Gula / Permen dan Cokelat',
                'types' => [
                    'Permen Keras',
                    'Permen Lunak (Soft Candy)',
                    'Cokelat dan Produk Cokelat',
                    'Permen Karet',
                    'Marshmallow',
                ],
            ],
            [
                'code' => '06',
                'name' => 'Serealia dan Produk Serealia',
                'types' => [
                    'Beras Olahan',
                    'Tepung Terigu',
                    'Tepung Beras',
                    'Mi Instan',
                    'Mi Kering',
                    'Bihun',
                    'Soun',
                    'Makaroni / Pasta',
                    'Roti dan Produk Roti',
                    'Biskuit dan Kue Kering',
                    'Sereal Sarapan',
                ],
            ],
            [
                'code' => '07',
                'name' => 'Produk Bakeri',
                'types' => [
                    'Roti Tawar',
                    'Roti Manis',
                    'Kue Basah',
                    'Donat',
                    'Pastri',
                ],
            ],
            [
                'code' => '08',
                'name' => 'Daging dan Produk Daging',
                'types' => [
                    'Daging Olahan Beku',
                    'Sosis',
                    'Nugget',
                    'Kornet',
                    'Bakso',
                    'Dendeng',
                    'Abon Sapi',
                    'Daging Kalengan',
                ],
            ],
            [
                'code' => '09',
                'name' => 'Ikan dan Produk Perikanan',
                'types' => [
                    'Ikan Olahan Beku',
                    'Ikan Asap',
                    'Ikan Kalengan',
                    'Kerupuk Ikan',
                    'Amplang (Kerupuk Ikan Khas Kalimantan)',
                    'Abon Ikan',
                    'Terasi',
                    'Ikan Asin',
                    'Udang Olahan',
                    'Kepiting Olahan',
                ],
            ],
            [
                'code' => '10',
                'name' => 'Telur dan Produk Telur',
                'types' => [
                    'Telur Asin',
                    'Telur Olahan / Telur Pindang',
                    'Produk Telur Cair Pasteurisasi',
                ],
            ],
            [
                'code' => '11',
                'name' => 'Pemanis, Termasuk Madu',
                'types' => [
                    'Gula Pasir',
                    'Gula Merah / Gula Aren',
                    'Madu',
                    'Sirup',
                    'Pemanis Buatan',
                ],
            ],
            [
                'code' => '12',
                'name' => 'Garam, Rempah, Sup, Saus, Salad, dan Protein',
                'types' => [
                    'Garam Beriodium',
                    'Bumbu Instan / Bumbu Masak',
                    'Saus Sambal',
                    'Saus Tomat',
                    'Kecap',
                    'Terasi Olahan',
                    'Kaldu Bubuk',
                    'Mayonais',
                ],
            ],
            [
                'code' => '13',
                'name' => 'Pangan untuk Keperluan Gizi Khusus',
                'types' => [
                    'Susu Formula Bayi',
                    'Susu Pertumbuhan',
                    'MP-ASI',
                    'Pangan Fungsional',
                    'Suplemen Makanan',
                ],
            ],
            [
                'code' => '14',
                'name' => 'Minuman (Tidak Termasuk Produk Susu)',
                'types' => [
                    'Air Minum Dalam Kemasan (AMDK)',
                    'Minuman Ringan Berkarbonasi',
                    'Minuman Jus Buah',
                    'Minuman Teh dalam Kemasan',
                    'Minuman Kopi dalam Kemasan',
                    'Minuman Berenergi',
                    'Minuman Isotonik / Olahraga',
                    'Sirup Siap Minum',
                ],
            ],
            [
                'code' => '15',
                'name' => 'Pangan Siap Saji',
                'types' => [
                    'Makanan Kalengan Siap Saji',
                    'Makanan Beku Siap Saji',
                    'Makanan Kering Siap Saji (Instan)',
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $types = $categoryData['types'];
            unset($categoryData['types']);

            $category = FoodCategory::firstOrCreate(
                ['code' => $categoryData['code']],
                $categoryData
            );

            foreach ($types as $typeName) {
                FoodType::firstOrCreate(
                    ['food_category_id' => $category->id, 'name' => $typeName],
                    ['is_active' => true]
                );
            }
        }
    }
}
