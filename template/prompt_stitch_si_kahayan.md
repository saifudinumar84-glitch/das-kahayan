# Prompt Stitch — Portal Layanan Si Kahayan

**Sistem:** Si Kahayan — Sistem Informasi Kawal Hasil Pengawasan
**Instansi:** Balai Besar POM di Palangka Raya
**Sumber:** PRD Si Kahayan (24 September 2026)
**Tools:** [Stitch – Design with AI](https://stitch.withgoogle.com/)

---

## Cara Pemakaian

1. Setiap prompt halaman di bawah dapat dijalankan sendiri. **Tempel Blok Gaya Global (bagian 0) di awal setiap prompt halaman** agar gaya visual konsisten.
2. Jalankan halaman satu per satu (satu prompt = satu layar) di project Stitch yang sama.
3. Mulai dari **Beranda (halaman 1)** untuk mengunci gaya visual, lalu lanjutkan ke halaman lain.
4. Jika hasil terlalu ramai, revisi dengan instruksi singkat, misalnya: *"Reduce the number of sections, make the hero smaller, and increase whitespace."*
5. Mode **Web** cocok untuk semua layar. Halaman 5 (Validasi BAP) dan 7 (Login) bisa dicoba juga di mode **App** untuk versi mobile.
6. Hasil ekspor kode Stitch (HTML/Tailwind) dapat dijadikan referensi tampilan halaman publik dan portal. Panel `/admin` dan `/pimpinan` sebaiknya tetap memakai komponen bawaan Filament.

## Daftar Halaman

| # | Halaman | Area | Rute (PRD) |
|---|---------|------|-----------|
| 0 | Blok Gaya Global | — | — |
| 1 | Beranda | Publik | `/` |
| 2 | Hasil Pengawasan (dashboard publik dan peta) | Publik | `/` |
| 3 | Cari Produk dan Sarana | Publik | `/` |
| 4 | Detail Hasil Pengujian dan Pemeriksaan | Publik | `/` |
| 5 | Validasi BAP | Publik | `/verify/{token}` |
| 6 | Panduan | Publik | `/` |
| 7 | Login Pelaku Usaha | Portal | `/portal` |
| 8 | Dashboard Portal | Portal | `/portal` |
| 9 | Daftar Temuan dan CAPA | Portal | `/portal` |
| 10 | Detail Temuan dan Form CAPA | Portal | `/portal` |
| 11 | Dokumen (BAP dan Surat) | Portal | `/portal` |
| 12 | Profil Sarana | Portal | `/portal` |

---

## 0. Blok Gaya Global (tempel di awal setiap prompt halaman)

```
Project: "Si Kahayan – Sistem Informasi Kawal Hasil Pengawasan", public service portal of Balai Besar POM di Palangka Raya (Indonesian food supervision authority, Central Kalimantan). Web, desktop-first 1440px with responsive mobile variant. All UI text in Bahasa Indonesia.
Style: trustworthy Indonesian government institution, modern, clean, airy. Primary deep green #0F6B4F, secondary teal #0E8A8A, accent amber #F5A623, slate gray neutrals, white background with soft gray sections. Status colors: green = MS (Memenuhi Syarat), red = TMS (Tidak Memenuhi Syarat), amber = Terlambat/Menunggu, blue = Dalam proses. Font Inter or Plus Jakarta Sans, 12px rounded corners, subtle shadows, accessible contrast. Public pages must never show NIB, NPWP, NIE, phone numbers, person-in-charge names, full addresses, photos, CAPA documents or signatures.
```

---

# A. Halaman Publik (tanpa login)

## 1. Beranda

```
Design the public home page "Beranda".
1. Sticky navbar: logo placeholder + "Si Kahayan" wordmark with caption "Balai Besar POM di Palangka Raya"; menu Beranda, Hasil Pengawasan, Cari Produk & Sarana, Validasi BAP, Panduan; primary button "Masuk Pelaku Usaha".
2. Hero with subtle Dayak/Kahayan river-wave pattern: headline "Kawal Hasil Pengawasan Pangan Olahan, Terbuka dan Dapat Ditelusuri", short subtext, large search bar "Cari nama produk atau nama sarana...", and buttons "Validasi BAP dengan QR" and "Masuk sebagai Pelaku Usaha".
3. Stats strip, 4 cards: Sampel Diuji, Sarana Diperiksa, Persentase Memenuhi Syarat (MS), Temuan Ditindaklanjuti.
4. Preview of latest results: tabs "Hasil Pengujian Sampel" | "Hasil Pemeriksaan Sarana" with 5-row tables and a "Lihat Semua" link.
5. "Cara Kerja Pengawasan" 4-step horizontal timeline: Sampling & Inspeksi → BAP Terbit (QR) → CAPA Pelaku Usaha → Closed CAPA Disahkan.
6. Notice box "Data pribadi dan rahasia usaha tidak ditampilkan ke publik."
7. Footer with address placeholder, email, quick links, copyright.
```

## 2. Hasil Pengawasan (dashboard publik dan peta)

```
Design the public page "Hasil Pengawasan" (public dashboard).
- Page header with filter bar: Periode (bulan/triwulan/tahun), Kategori Pangan, Jenis Sarana (Produksi/Distribusi), Kabupaten/Kota, plus note "Data diperbarui otomatis secara berkala".
- 4 stat cards: Sampel Diuji, Sarana Diperiksa, % Memenuhi Syarat, Temuan Closed.
- Large map of Kalimantan Tengah at kabupaten/kota level only (choropleth, NO exact pin points), with legend and hover tooltip showing counts per region.
- Charts grid: stacked bar "Sampel Diuji per Bulan (MS vs TMS)", bar "Sarana Diperiksa per Bulan", donut "Sarana Produksi vs Distribusi", horizontal bar "Sampel per Kategori Pangan", donut "Grade Sarana".
- Below: tabs with data tables for sampel and sarana, pagination, and disclaimer about data privacy.
```

## 3. Cari Produk dan Sarana

```
Design the public page "Cari Produk & Sarana".
- Large search input with segmented toggle "Produk | Sarana".
- Left sidebar filters: Periode, Kategori Pangan, Jenis Pangan, Jenis Sarana, Kabupaten/Kota, Kesimpulan (MS/TMS), Grade.
- Result list of cards. Produk card: product name and brand, food category chip, sampling place, sampling date, test date, MS/TMS badge. Sarana card: facility name, kabupaten/kota, jenis sarana chip, inspection date, grade badge, status.
- Result count, sort dropdown, pagination, and empty state illustration "Tidak ada hasil ditemukan".
```

## 4. Detail Hasil Pengujian dan Pemeriksaan

```
Design the public detail page "Detail Hasil Pengujian" (with a variant for "Detail Hasil Pemeriksaan Sarana").
- Breadcrumb and back button.
- Header card: product name, brand, category/type chips, big MS/TMS conclusion badge.
- Info grid: tanggal sampling, tempat sampling, harga produk, tanggal uji.
- Table "Hasil per Parameter Uji": Parameter, Satuan, Hasil, Keterangan.
- For TMS: highlighted red-tinted box with "Keterangan" and "Rekomendasi".
- Horizontal status timeline: Sampling → Pengujian → Selesai → Dipublikasikan.
- Sarana variant: nama sarana, kabupaten/kota, jenis sarana, tanggal pemeriksaan, grade, kesimpulan penilaian, without full address or contacts.
```

## 5. Validasi BAP (`/verify/{token}`)

```
Design the public page "Validasi Dokumen BAP", opened by scanning a QR code. Mobile-first, minimal navbar, centered card.
- Valid variant: big green check icon, "Dokumen Asli / Valid", with Nomor BAP, Tanggal Terbit, Nama Sarana, Kabupaten/Kota, Nama Petugas Pemeriksa, Jumlah Temuan, Status Pemeriksaan.
- Invalid variant: red icon, "Dokumen Tidak Ditemukan atau Tidak Valid" with a hint to check the QR code or contact Balai.
- Note: "Halaman ini hanya menampilkan informasi ringkas. Isi lengkap dikirim kepada pelaku usaha."
- Also provide an input field to validate manually by entering a BAP number.
```

## 6. Panduan

```
Design the public page "Panduan".
- Hero with title "Panduan Penggunaan Si Kahayan" and search box.
- Three audience tabs: Masyarakat, Pelaku Usaha, Cara Validasi BAP.
- Content as accordion FAQ and numbered step cards with icons (e.g., cara mencari produk, cara membaca hasil MS/TMS, cara membuat dan mengirim CAPA, cara memindai QR Code BAP).
- Right sticky card "Butuh bantuan?" with email and office hours placeholder.
```

---

# B. Portal Pelaku Usaha (login)

## 7. Login

```
Design a split-screen login page "Masuk Portal Pelaku Usaha".
- Left half deep green with subtle river-wave pattern, logo, headline "Pantau dan Tindak Lanjuti Hasil Pengawasan Sarana Anda", and 3 bullets: Lihat temuan dan rekomendasi, Kirim CAPA secara online, Terima BAP dan Surat Closed CAPA.
- Right half white card: Email, Kata Sandi with show/hide toggle, "Lupa kata sandi?" link, primary button "Masuk", link "Kembali ke Beranda".
- Show an error state variant and helper text "Akun dibuat oleh Balai Besar POM di Palangka Raya".
```

## 8. Dashboard Portal

```
Design the logged-in "Dashboard" of Portal Pelaku Usaha, sidebar layout.
- Left sidebar: logo, menu Dashboard, Pemeriksaan Sarana, Temuan & CAPA, Dokumen, Riwayat, Profil Sarana; bottom user avatar, name, "Keluar".
- Top bar: facility switcher dropdown, notification bell with badge, user menu.
- Greeting "Selamat datang, [Nama Sarana]".
- 4 stat cards: Temuan Terbuka, Menunggu CAPA Anda, CAPA Dalam Review, Temuan Closed.
- Amber/red alert banner: "2 temuan melewati batas waktu tindak lanjut".
- Table "Temuan yang Perlu Ditindaklanjuti": Nomor Pemeriksaan, Tanggal, Standar (CPPOB/CPerPOB), Ringkasan Temuan, Batas Waktu with Terlambat badge, Status, button "Buat CAPA".
- Right column: "Aktivitas Terbaru" timeline (BAP terbit, CAPA diterima, hasil evaluasi, Surat Closed CAPA) and "Dokumen Terbaru" with PDF download buttons.
```

## 9. Daftar Temuan dan CAPA

```
Design the "Temuan & CAPA" list page in the same portal layout.
- Header with page title and filter bar: Status temuan (Open/Closed), Standar (CPPOB/CPerPOB), Periode, Terlambat toggle, search.
- Tabs: Semua, Perlu CAPA, Dalam Review, Ditolak, Closed, each with count.
- Table: Nomor Pemeriksaan, Tanggal, Ringkasan Temuan, Standar, Batas Waktu, Status Temuan, Status CAPA, Ronde, action "Lihat".
- Row highlight for overdue items, pagination, and empty state illustration.
```

## 10. Detail Temuan dan Form CAPA

```
Design the "Detail Temuan & Kirim CAPA" page in the same portal layout.
- Breadcrumb: Temuan & CAPA > Nomor Pemeriksaan > Detail Temuan.
- Summary card: nomor dan tanggal pemeriksaan, standar (CPPOB/CPerPOB), persyaratan tidak sesuai, uraian temuan, rekomendasi petugas, batas waktu, status badge, inspector photo evidence thumbnails.
- Right vertical stepper: Temuan Dicatat → CAPA Dikirim → Direview Petugas → Diverifikasi Ketua Tim → Disahkan Kepala Balai → Surat Closed CAPA Terkirim.
- Accordion "Riwayat Ronde CAPA" with status Diterima/Ditolak and reviewer notes.
- Form "Kirim CAPA (Ronde 2)": textarea Tindakan Perbaikan, textarea Tindakan Pencegahan, date picker Target Penyelesaian, drag-and-drop upload for data dukung (foto, PDF) with file list and size hint, buttons "Simpan Draft" and "Kirim CAPA" (primary). Include confirmation modal before sending, and a read-only variant when CAPA is under review.
```

## 11. Dokumen (BAP dan Surat)

```
Design the "Dokumen" page in the same portal layout.
- Tabs: BAP, Surat Tindak Lanjut, Surat Closed CAPA.
- Table/list: Nomor Dokumen, Tanggal Terbit, Nomor Pemeriksaan, Jenis, Status, actions "Lihat" and "Unduh PDF".
- Clicking a row opens a right-side preview drawer with PDF preview placeholder, QR Code validation info and link "Buka halaman validasi".
- Filter by tahun and jenis dokumen, plus empty state.
```

## 12. Profil Sarana

```
Design the "Profil Sarana" page in the same portal layout (data is read-only, managed by Balai).
- Header card: nama sarana, jenis sarana chip (Produksi/Distribusi), jenis komoditas, nama penanggung jawab.
- Info sections in cards: Kontak (telepon, email), Legalitas (NIB, NPWP, NIE, nomor dan masa berlaku sertifikat IP CPPOB with expiry badge), Alamat lengkap with small map showing facility coordinate.
- Sidebar card "Akun Terhubung" listing users linked to this facility.
- Note: "Untuk perubahan data, hubungi Balai Besar POM di Palangka Raya."
- Here private data is allowed since this is the logged-in portal for the facility owner only.
```

---

## Catatan Kepatuhan terhadap PRD

- Halaman publik (1 sampai 6) hanya menampilkan kolom **whitelist**: nama produk, kategori dan jenis pangan, tempat sampling, tanggal, hasil per parameter, kesimpulan MS/TMS, nama sarana, kabupaten/kota, grade, dan status.
- Peta publik hanya sampai tingkat **kabupaten/kota**, tanpa titik koordinat.
- Data NIB, NPWP, NIE, kontak, penanggung jawab, alamat lengkap, foto, CAPA, dan tanda tangan hanya tampil di **portal pelaku usaha setelah login**, dan hanya untuk sarana milik pengguna itu sendiri.
- Alur pengesahan CAPA berurutan: review petugas → verifikasi Ketua Tim → pengesahan digital Kepala Balai → surat Closed CAPA terkirim.
