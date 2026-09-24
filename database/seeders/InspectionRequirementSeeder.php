<?php

namespace Database\Seeders;

use App\Enums\InspectionStandard;
use App\Models\InspectionRequirement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InspectionRequirementSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed CPPOB (production) and CPerPOB (distribution) inspection requirement clauses
     * based on BPOM regulations used by BBPOM Palangka Raya.
     *
     * @return void
     */
    public function run(): void
    {
        $cppobRequirements = [
            // Aspek 1 — Lingkungan Produksi
            ['code' => 'CPPOB-1.1', 'description' => 'Lokasi sarana produksi tidak terletak di daerah yang berpotensi menjadi sumber cemaran (banjir, polusi, hama).'],
            ['code' => 'CPPOB-1.2', 'description' => 'Halaman sarana produksi bersih, tidak berdebu, tidak becek, dan bebas dari sampah.'],
            ['code' => 'CPPOB-1.3', 'description' => 'Selokan/drainase di sekitar sarana produksi berfungsi dengan baik dan tidak menimbulkan genangan air.'],

            // Aspek 2 — Bangunan dan Fasilitas
            ['code' => 'CPPOB-2.1', 'description' => 'Bangunan sarana produksi dirancang dan dibangun sesuai dengan persyaratan higiene (mudah dibersihkan, tidak menjadi tempat bersarang hama).'],
            ['code' => 'CPPOB-2.2', 'description' => 'Lantai ruang produksi terbuat dari bahan yang kedap air, rata, tidak retak, dan mudah dibersihkan.'],
            ['code' => 'CPPOB-2.3', 'description' => 'Dinding ruang produksi bersih, tidak retak, tidak berlumut, dan mudah dibersihkan.'],
            ['code' => 'CPPOB-2.4', 'description' => 'Langit-langit atau atap ruang produksi bersih, tidak berlubang, dan tidak menimbulkan kondensasi.'],
            ['code' => 'CPPOB-2.5', 'description' => 'Ventilasi ruang produksi memadai, dilengkapi kasa anti-serangga yang terpasang dengan baik dan bersih.'],
            ['code' => 'CPPOB-2.6', 'description' => 'Pencahayaan ruang produksi memadai dan lampu dilindungi dengan penutup anti-pecah.'],
            ['code' => 'CPPOB-2.7', 'description' => 'Pintu masuk ruang produksi terbuat dari bahan yang kuat, kedap hama, dan dapat ditutup rapat.'],

            // Aspek 3 — Peralatan Produksi
            ['code' => 'CPPOB-3.1', 'description' => 'Peralatan produksi terbuat dari bahan yang aman pangan (food-grade), tidak berkarat, mudah dibersihkan dan didesinfeksi.'],
            ['code' => 'CPPOB-3.2', 'description' => 'Peralatan produksi dibersihkan dan didesinfeksi secara rutin sesuai prosedur yang terdokumentasi.'],
            ['code' => 'CPPOB-3.3', 'description' => 'Tersedia program perawatan (maintenance) peralatan produksi yang terdokumentasi.'],
            ['code' => 'CPPOB-3.4', 'description' => 'Peralatan pengukur (timbangan, termometer) dikalibrasi secara berkala dan tersedia bukti kalibrasi.'],

            // Aspek 4 — Suplai Air
            ['code' => 'CPPOB-4.1', 'description' => 'Air yang digunakan untuk produksi memenuhi syarat air minum (sesuai standar BPOM/Kemenkes).'],
            ['code' => 'CPPOB-4.2', 'description' => 'Tersedia bukti pemeriksaan kualitas air secara berkala (minimal 1 kali setahun).'],
            ['code' => 'CPPOB-4.3', 'description' => 'Saluran air bersih tidak terhubung atau berpotensi terkontaminasi dengan saluran air limbah.'],

            // Aspek 5 — Fasilitas Sanitasi
            ['code' => 'CPPOB-5.1', 'description' => 'Tersedia toilet yang memadai, bersih, tidak berhubungan langsung dengan ruang produksi, dan dilengkapi fasilitas cuci tangan.'],
            ['code' => 'CPPOB-5.2', 'description' => 'Tersedia fasilitas cuci tangan (wastafel, sabun, air mengalir, pengering tangan) di area produksi.'],
            ['code' => 'CPPOB-5.3', 'description' => 'Tersedia tempat sampah tertutup di ruang produksi yang dikosongkan setiap hari.'],
            ['code' => 'CPPOB-5.4', 'description' => 'Program pembersihan dan sanitasi terdokumentasi dengan baik (jadwal, penanggung jawab, bahan sanitasi).'],

            // Aspek 6 — Pengendalian Hama
            ['code' => 'CPPOB-6.1', 'description' => 'Tersedia program pengendalian hama (pest control) yang terdokumentasi dan dilaksanakan secara rutin.'],
            ['code' => 'CPPOB-6.2', 'description' => 'Tidak ditemukan tanda-tanda keberadaan hama (kotoran, bekas gigitan, sarang) di ruang produksi dan penyimpanan.'],
            ['code' => 'CPPOB-6.3', 'description' => 'Bahan kimia pengendali hama disimpan terpisah dari bahan baku dan produk pangan.'],

            // Aspek 7 — Karyawan / Higiene Personal
            ['code' => 'CPPOB-7.1', 'description' => 'Karyawan yang terlibat langsung dalam produksi menggunakan pakaian kerja bersih (celemek, penutup kepala, masker).'],
            ['code' => 'CPPOB-7.2', 'description' => 'Karyawan dilarang menggunakan perhiasan, jam tangan, atau kuku panjang saat bekerja di area produksi.'],
            ['code' => 'CPPOB-7.3', 'description' => 'Karyawan yang sakit atau memiliki luka terbuka dilarang bekerja langsung dengan produk pangan.'],
            ['code' => 'CPPOB-7.4', 'description' => 'Tersedia pelatihan higiene dan keamanan pangan bagi karyawan yang terdokumentasi.'],

            // Aspek 8 — Penyimpanan Bahan Baku dan Produk
            ['code' => 'CPPOB-8.1', 'description' => 'Bahan baku disimpan terpisah dari produk jadi, bahan kimia, dan bahan berbahaya lainnya.'],
            ['code' => 'CPPOB-8.2', 'description' => 'Kondisi penyimpanan (suhu, kelembapan) sesuai persyaratan bahan yang disimpan.'],
            ['code' => 'CPPOB-8.3', 'description' => 'Sistem FIFO (First In First Out) atau FEFO (First Expired First Out) diterapkan dalam penyimpanan.'],
            ['code' => 'CPPOB-8.4', 'description' => 'Bahan baku dan produk tidak langsung bersentuhan dengan lantai (menggunakan palet/rak).'],

            // Aspek 9 — Pengendalian Proses Produksi
            ['code' => 'CPPOB-9.1', 'description' => 'Tersedia prosedur/instruksi kerja tertulis untuk setiap tahap proses produksi.'],
            ['code' => 'CPPOB-9.2', 'description' => 'Proses produksi kritis (suhu pemanasan, lama waktu proses) dipantau dan dicatat.'],
            ['code' => 'CPPOB-9.3', 'description' => 'Tersedia sistem pengendalian mutu (QC) termasuk pengujian produk sebelum didistribusikan.'],

            // Aspek 10 — Label dan Keterangan Produk
            ['code' => 'CPPOB-10.1', 'description' => 'Label produk memuat informasi sesuai ketentuan (nama produk, berat bersih, komposisi, tanggal kedaluwarsa, nomor izin edar).'],
            ['code' => 'CPPOB-10.2', 'description' => 'Klaim pada label produk sesuai dengan komposisi yang tercantum dan tidak menyesatkan konsumen.'],

            // Aspek 11 — Penelusuran (Traceability)
            ['code' => 'CPPOB-11.1', 'description' => 'Tersedia sistem pencatatan yang memungkinkan penelusuran produk dari bahan baku hingga distribusi (traceability).'],
            ['code' => 'CPPOB-11.2', 'description' => 'Tersedia prosedur penarikan produk (product recall) yang terdokumentasi dan diuji coba secara berkala.'],
        ];

        $cperpobRequirements = [
            // Aspek 1 — Bangunan dan Fasilitas Distribusi
            ['code' => 'CPERPOB-1.1', 'description' => 'Gudang penyimpanan produk pangan bersih, kering, dan berventilasi baik.'],
            ['code' => 'CPERPOB-1.2', 'description' => 'Gudang bebas dari hama (tikus, serangga, burung) dan tidak terdapat tanda keberadaan hama.'],
            ['code' => 'CPERPOB-1.3', 'description' => 'Produk pangan disimpan terpisah dari bahan berbahaya, bahan kimia, dan produk non-pangan.'],
            ['code' => 'CPERPOB-1.4', 'description' => 'Produk pangan tidak disimpan langsung di lantai (menggunakan palet atau rak).'],

            // Aspek 2 — Pengelolaan Produk
            ['code' => 'CPERPOB-2.1', 'description' => 'Sistem FIFO/FEFO diterapkan dalam pengelolaan stok produk pangan.'],
            ['code' => 'CPERPOB-2.2', 'description' => 'Produk yang mendekati atau melewati tanggal kedaluwarsa dipisahkan dan tidak dipasarkan.'],
            ['code' => 'CPERPOB-2.3', 'description' => 'Produk rusak, kembung, bocor, atau kemasan tidak layak dipisahkan dari produk layak jual.'],
            ['code' => 'CPERPOB-2.4', 'description' => 'Tersedia catatan penerimaan dan pengeluaran produk (administrasi stok) yang teratur.'],

            // Aspek 3 — Label dan Keabsahan Produk
            ['code' => 'CPERPOB-3.1', 'description' => 'Semua produk pangan yang beredar di sarana distribusi memiliki izin edar (BPOM MD/ML) yang masih berlaku.'],
            ['code' => 'CPERPOB-3.2', 'description' => 'Label produk terbaca dengan jelas, tidak rusak, tidak diubah, dan sesuai ketentuan pelabelan.'],
            ['code' => 'CPERPOB-3.3', 'description' => 'Tidak ditemukan produk pangan ilegal, palsu, atau tanpa izin edar di sarana distribusi.'],
            ['code' => 'CPERPOB-3.4', 'description' => 'Tidak ditemukan produk pangan kadaluwarsa yang masih dipasarkan.'],

            // Aspek 4 — Sarana Transportasi
            ['code' => 'CPERPOB-4.1', 'description' => 'Alat transportasi produk pangan bersih dan tidak berpotensi mencemari produk.'],
            ['code' => 'CPERPOB-4.2', 'description' => 'Produk pangan yang memerlukan suhu khusus (dingin/beku) diangkut dengan alat transportasi berpendingin.'],

            // Aspek 5 — Higiene dan Sanitasi Sarana
            ['code' => 'CPERPOB-5.1', 'description' => 'Sarana distribusi memiliki fasilitas toilet dan cuci tangan yang memadai dan bersih.'],
            ['code' => 'CPERPOB-5.2', 'description' => 'Karyawan yang menangani produk pangan menjaga kebersihan diri dan menggunakan perlengkapan higiene yang sesuai.'],
            ['code' => 'CPERPOB-5.3', 'description' => 'Tersedia prosedur pembersihan dan sanitasi gudang yang dilaksanakan secara rutin.'],
        ];

        foreach ($cppobRequirements as $req) {
            InspectionRequirement::firstOrCreate(
                ['code' => $req['code']],
                array_merge($req, ['standard' => InspectionStandard::Cppob, 'is_active' => true])
            );
        }

        foreach ($cperpobRequirements as $req) {
            InspectionRequirement::firstOrCreate(
                ['code' => $req['code']],
                array_merge($req, ['standard' => InspectionStandard::Cperpob, 'is_active' => true])
            );
        }
    }
}
