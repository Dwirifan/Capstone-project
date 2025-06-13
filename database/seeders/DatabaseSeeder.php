<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Nonaktifkan pengecekan foreign key untuk memastikan proses berjalan lancar
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Kosongkan tabel agar tidak ada data duplikat setiap kali seeder dijalankan
        // Urutan truncate dari tabel anak ke tabel induk
        DB::table('beras')->truncate();
        DB::table('gabah')->truncate();
        DB::table('tebas')->truncate();
        DB::table('search_history_user')->truncate();
        DB::table('produk')->truncate();
        DB::table('produksi')->truncate();
        DB::table('pertanian')->truncate();
        DB::table('cuaca')->truncate();
        DB::table('panen')->truncate();
        DB::table('lahan')->truncate();
        DB::table('petani')->truncate();
        DB::table('user')->truncate();
        
        // =================================================================
        // DATA PENGGUNA DAN PETANI
        // =================================================================

        // 1. User (Prasyarat untuk Petani, Search History)
        DB::table('user')->insert([
            [
                'id_user' => 1,
                'name' => 'Rifan Kurniawan',
                'email' => 'rifan@example.com',
                'password' => Hash::make('rahasia123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user' => 2,
                'name' => 'Azwar Maulana',
                'email' => 'azwar@example.com',
                'password' => Hash::make('secure456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        

        // =================================================================
        // DATA DASAR PERTANIAN (Lahan, dan turunannya)
        // =================================================================

        // 3. Lahan (Prasyarat untuk Panen, Cuaca, Pertanian)
        DB::table('lahan')->insert([
            ['id_lahan' => 1, 'id_petani' => 1, 'lokasi_lahan' => 'Sawah Subur, Magelang', 'latitude' => -7.475, 'longitude' => 110.218, 'bentuk_lahan' => '[{"x":10,"y":20}]', 'ukuran_lahan' => 3.5, 'ph_tanah' => 6.5, 'ketersediaan_air' => 80.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_lahan' => 2, 'id_petani' => 1, 'lokasi_lahan' => 'Tanah Makmur, Sleman', 'latitude' => -7.795, 'longitude' => 110.369, 'bentuk_lahan' => '[{"x":20,"y":30}]', 'ukuran_lahan' => 4.1, 'ph_tanah' => 6.2, 'ketersediaan_air' => 75.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_lahan' => 3, 'id_petani' => 1, 'lokasi_lahan' => 'Area Hijau, Bantul', 'latitude' => -7.882, 'longitude' => 110.322, 'bentuk_lahan' => '[{"x":30,"y":40}]', 'ukuran_lahan' => 2.9, 'ph_tanah' => 5.9, 'ketersediaan_air' => 60.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_lahan' => 4, 'id_petani' => 1, 'lokasi_lahan' => 'Lembah Asri, Kulon Progo', 'latitude' => -7.863, 'longitude' => 110.162, 'bentuk_lahan' => '[{"x":40,"y":50}]', 'ukuran_lahan' => 5.0, 'ph_tanah' => 6.8, 'ketersediaan_air' => 70.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_lahan' => 5, 'id_petani' => 1, 'lokasi_lahan' => 'Dataran Jaya, Klaten', 'latitude' => -7.705, 'longitude' => 110.597, 'bentuk_lahan' => '[{"x":50,"y":60}]', 'ukuran_lahan' => 3.2, 'ph_tanah' => 6.4, 'ketersediaan_air' => 65.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_lahan' => 6, 'id_petani' => 1, 'lokasi_lahan' => 'Perbukitan Indah, Boyolali', 'latitude' => -7.530, 'longitude' => 110.597, 'bentuk_lahan' => '[{"x":60,"y":70}]', 'ukuran_lahan' => 4.5, 'ph_tanah' => 6.6, 'ketersediaan_air' => 72.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_lahan' => 7, 'id_petani' => 1, 'lokasi_lahan' => 'Kawasan Sejuk, Salatiga', 'latitude' => -7.332, 'longitude' => 110.505, 'bentuk_lahan' => '[{"x":70,"y":80}]', 'ukuran_lahan' => 2.7, 'ph_tanah' => 6.0, 'ketersediaan_air' => 68.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_lahan' => 8, 'id_petani' => 1, 'lokasi_lahan' => 'Zona Tani, Sragen', 'latitude' => -7.426, 'longitude' => 111.025, 'bentuk_lahan' => '[{"x":80,"y":90}]', 'ukuran_lahan' => 3.3, 'ph_tanah' => 5.8, 'ketersediaan_air' => 77.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_lahan' => 9, 'id_petani' => 1, 'lokasi_lahan' => 'Sentra Padi, Karanganyar', 'latitude' => -7.618, 'longitude' => 110.950, 'bentuk_lahan' => '[{"x":90,"y":100}]', 'ukuran_lahan' => 4.0, 'ph_tanah' => 6.3, 'ketersediaan_air' => 74.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_lahan' => 10, 'id_petani' => 1, 'lokasi_lahan' => 'Agro Tani, Sukoharjo', 'latitude' => -7.691, 'longitude' => 110.831, 'bentuk_lahan' => '[{"x":100,"y":110}]', 'ukuran_lahan' => 3.8, 'ph_tanah' => 6.1, 'ketersediaan_air' => 79.0, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 4. Data Terkait Lahan (Panen, Cuaca, Pertanian)
        DB::table('panen')->insert([
            ['id_panen' => 1, 'id_lahan' => 1, 'teknik_panen' => 'manual', 'jenis_pengeringan' => 'matahari', 'durasi_pengeringan' => '02:00:00', 'created_at' => now(), 'updated_at' => now()],
            ['id_panen' => 2, 'id_lahan' => 2, 'teknik_panen' => 'combie', 'jenis_pengeringan' => 'mesin', 'durasi_pengeringan' => '01:30:00', 'created_at' => now(), 'updated_at' => now()],
            ['id_panen' => 3, 'id_lahan' => 3, 'teknik_panen' => 'manual', 'jenis_pengeringan' => 'matahari', 'durasi_pengeringan' => '03:00:00', 'created_at' => now(), 'updated_at' => now()],
            ['id_panen' => 4, 'id_lahan' => 4, 'teknik_panen' => 'combie', 'jenis_pengeringan' => 'mesin', 'durasi_pengeringan' => '01:45:00', 'created_at' => now(), 'updated_at' => now()],
            ['id_panen' => 5, 'id_lahan' => 5, 'teknik_panen' => 'manual', 'jenis_pengeringan' => 'matahari', 'durasi_pengeringan' => '02:30:00', 'created_at' => now(), 'updated_at' => now()],
            ['id_panen' => 6, 'id_lahan' => 6, 'teknik_panen' => 'combie', 'jenis_pengeringan' => 'mesin', 'durasi_pengeringan' => '01:15:00', 'created_at' => now(), 'updated_at' => now()],
            ['id_panen' => 7, 'id_lahan' => 7, 'teknik_panen' => 'manual', 'jenis_pengeringan' => 'matahari', 'durasi_pengeringan' => '02:45:00', 'created_at' => now(), 'updated_at' => now()],
            ['id_panen' => 8, 'id_lahan' => 8, 'teknik_panen' => 'combie', 'jenis_pengeringan' => 'mesin', 'durasi_pengeringan' => '02:00:00', 'created_at' => now(), 'updated_at' => now()],
            ['id_panen' => 9, 'id_lahan' => 9, 'teknik_panen' => 'manual', 'jenis_pengeringan' => 'matahari', 'durasi_pengeringan' => '01:00:00', 'created_at' => now(), 'updated_at' => now()],
            ['id_panen' => 10, 'id_lahan' => 10, 'teknik_panen' => 'combie', 'jenis_pengeringan' => 'mesin', 'durasi_pengeringan' => '01:20:00', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('cuaca')->insert([
            ['id_cuaca' => 1, 'id_lahan' => 1, 'curah_hujan_harian' => 80.2, 'intensitas_cahaya_matahari' => 750.5, 'created_at' => now(), 'updated_at' => now()],
            ['id_cuaca' => 2, 'id_lahan' => 2, 'curah_hujan_harian' => 90.4, 'intensitas_cahaya_matahari' => 800.1, 'created_at' => now(), 'updated_at' => now()],
            ['id_cuaca' => 3, 'id_lahan' => 3, 'curah_hujan_harian' => 70.0, 'intensitas_cahaya_matahari' => 820.3, 'created_at' => now(), 'updated_at' => now()],
            ['id_cuaca' => 4, 'id_lahan' => 4, 'curah_hujan_harian' => 60.7, 'intensitas_cahaya_matahari' => 790.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_cuaca' => 5, 'id_lahan' => 5, 'curah_hujan_harian' => 85.9, 'intensitas_cahaya_matahari' => 760.4, 'created_at' => now(), 'updated_at' => now()],
            ['id_cuaca' => 6, 'id_lahan' => 6, 'curah_hujan_harian' => 88.2, 'intensitas_cahaya_matahari' => 780.2, 'created_at' => now(), 'updated_at' => now()],
            ['id_cuaca' => 7, 'id_lahan' => 7, 'curah_hujan_harian' => 92.5, 'intensitas_cahaya_matahari' => 800.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_cuaca' => 8, 'id_lahan' => 8, 'curah_hujan_harian' => 75.1, 'intensitas_cahaya_matahari' => 770.5, 'created_at' => now(), 'updated_at' => now()],
            ['id_cuaca' => 9, 'id_lahan' => 9, 'curah_hujan_harian' => 65.3, 'intensitas_cahaya_matahari' => 750.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_cuaca' => 10, 'id_lahan' => 10, 'curah_hujan_harian' => 77.8, 'intensitas_cahaya_matahari' => 730.2, 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('pertanian')->insert([
            ['id_pertanian' => 1, 'id_lahan' => 1, 'tgl_tanam' => '2024-03-01', 'metode_tanam' => 'tabur', 'jenis_pupuk' => 'urea', 'dosis_pupuk_HA' => 25.0, 'jumlah_gabah_percabang' => 100, 'presentase_gabah_isi_hampa' => 90.5, 'created_at' => now(), 'updated_at' => now()],
            ['id_pertanian' => 2, 'id_lahan' => 2, 'tgl_tanam' => '2024-03-03', 'metode_tanam' => 'tugal', 'jenis_pupuk' => 'kompos', 'dosis_pupuk_HA' => 30.0, 'jumlah_gabah_percabang' => 110, 'presentase_gabah_isi_hampa' => 85.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_pertanian' => 3, 'id_lahan' => 3, 'tgl_tanam' => '2024-03-05', 'metode_tanam' => 'tabur', 'jenis_pupuk' => 'npk', 'dosis_pupuk_HA' => 20.0, 'jumlah_gabah_percabang' => 95, 'presentase_gabah_isi_hampa' => 88.3, 'created_at' => now(), 'updated_at' => now()],
            ['id_pertanian' => 4, 'id_lahan' => 4, 'tgl_tanam' => '2024-03-07', 'metode_tanam' => 'tugal', 'jenis_pupuk' => 'organik', 'dosis_pupuk_HA' => 35.0, 'jumlah_gabah_percabang' => 105, 'presentase_gabah_isi_hampa' => 92.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_pertanian' => 5, 'id_lahan' => 5, 'tgl_tanam' => '2024-03-09', 'metode_tanam' => 'tabur', 'jenis_pupuk' => 'urea', 'dosis_pupuk_HA' => 28.0, 'jumlah_gabah_percabang' => 98, 'presentase_gabah_isi_hampa' => 89.5, 'created_at' => now(), 'updated_at' => now()],
            ['id_pertanian' => 6, 'id_lahan' => 6, 'tgl_tanam' => '2024-03-11', 'metode_tanam' => 'tugal', 'jenis_pupuk' => 'npk', 'dosis_pupuk_HA' => 22.0, 'jumlah_gabah_percabang' => 120, 'presentase_gabah_isi_hampa' => 87.7, 'created_at' => now(), 'updated_at' => now()],
            ['id_pertanian' => 7, 'id_lahan' => 7, 'tgl_tanam' => '2024-03-13', 'metode_tanam' => 'tabur', 'jenis_pupuk' => 'kompos', 'dosis_pupuk_HA' => 27.0, 'jumlah_gabah_percabang' => 102, 'presentase_gabah_isi_hampa' => 86.2, 'created_at' => now(), 'updated_at' => now()],
            ['id_pertanian' => 8, 'id_lahan' => 8, 'tgl_tanam' => '2024-03-15', 'metode_tanam' => 'tugal', 'jenis_pupuk' => 'organik', 'dosis_pupuk_HA' => 26.0, 'jumlah_gabah_percabang' => 108, 'presentase_gabah_isi_hampa' => 91.0, 'created_at' => now(), 'updated_at' => now()],
            ['id_pertanian' => 9, 'id_lahan' => 9, 'tgl_tanam' => '2024-03-17', 'metode_tanam' => 'tabur', 'jenis_pupuk' => 'npk', 'dosis_pupuk_HA' => 24.0, 'jumlah_gabah_percabang' => 97, 'presentase_gabah_isi_hampa' => 84.8, 'created_at' => now(), 'updated_at' => now()],
            ['id_pertanian' => 10, 'id_lahan' => 10, 'tgl_tanam' => '2024-03-19', 'metode_tanam' => 'tugal', 'jenis_pupuk' => 'urea', 'dosis_pupuk_HA' => 31.0, 'jumlah_gabah_percabang' => 115, 'presentase_gabah_isi_hampa' => 90.0, 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // 5. Produksi (Prasyarat untuk Beras)
        DB::table('produksi')->insert([
            ['id_produksi' => 1, 'id_panen' => 1, 'tgl_pengemasan' => '2024-04-01', 'metode_pembersihan' => 'cuci air', 'jenis_penggilingan' => 'penggilingan basah', 'kondisi_penyimpanan' => 'kering', 'created_at' => now(), 'updated_at' => now()],
            ['id_produksi' => 2, 'id_panen' => 2, 'tgl_pengemasan' => '2024-04-03', 'metode_pembersihan' => 'saring', 'jenis_penggilingan' => 'penggilingan kering', 'kondisi_penyimpanan' => 'dingin', 'created_at' => now(), 'updated_at' => now()],
            ['id_produksi' => 3, 'id_panen' => 3, 'tgl_pengemasan' => '2024-04-05', 'metode_pembersihan' => 'cuci air', 'jenis_penggilingan' => 'penggilingan basah', 'kondisi_penyimpanan' => 'kering', 'created_at' => now(), 'updated_at' => now()],
            ['id_produksi' => 4, 'id_panen' => 4, 'tgl_pengemasan' => '2024-04-07', 'metode_pembersihan' => 'saring', 'jenis_penggilingan' => 'penggilingan kering', 'kondisi_penyimpanan' => 'dingin', 'created_at' => now(), 'updated_at' => now()],
            ['id_produksi' => 5, 'id_panen' => 5, 'tgl_pengemasan' => '2024-04-09', 'metode_pembersihan' => 'cuci air', 'jenis_penggilingan' => 'penggilingan basah', 'kondisi_penyimpanan' => 'kering', 'created_at' => now(), 'updated_at' => now()],
            ['id_produksi' => 6, 'id_panen' => 6, 'tgl_pengemasan' => '2024-04-11', 'metode_pembersihan' => 'saring', 'jenis_penggilingan' => 'penggilingan kering', 'kondisi_penyimpanan' => 'dingin', 'created_at' => now(), 'updated_at' => now()],
            ['id_produksi' => 7, 'id_panen' => 7, 'tgl_pengemasan' => '2024-04-13', 'metode_pembersihan' => 'cuci air', 'jenis_penggilingan' => 'penggilingan basah', 'kondisi_penyimpanan' => 'kering', 'created_at' => now(), 'updated_at' => now()],
            ['id_produksi' => 8, 'id_panen' => 8, 'tgl_pengemasan' => '2024-04-15', 'metode_pembersihan' => 'saring', 'jenis_penggilingan' => 'penggilingan kering', 'kondisi_penyimpanan' => 'dingin', 'created_at' => now(), 'updated_at' => now()],
            ['id_produksi' => 9, 'id_panen' => 9, 'tgl_pengemasan' => '2024-04-17', 'metode_pembersihan' => 'cuci air', 'jenis_penggilingan' => 'penggilingan basah', 'kondisi_penyimpanan' => 'kering', 'created_at' => now(), 'updated_at' => now()],
            ['id_produksi' => 10, 'id_panen' => 10, 'tgl_pengemasan' => '2024-04-19', 'metode_pembersihan' => 'saring', 'jenis_penggilingan' => 'penggilingan kering', 'kondisi_penyimpanan' => 'dingin', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // =================================================================
        // DATA PRODUK DAN DETAILNYA
        // =================================================================
        
        // 6. Produk (Master Data untuk Beras, Gabah, Tebas)
        DB::table('produk')->insert([
            // 4 Beras
            ['id_produk' => 1, 'id_petani' => 1, 'tipe_produk' => 'beras', 'nama' => 'Beras Pandan Wangi Super', 'rating' => 5, 'jumlah_penjualan' => 120, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => 2, 'id_petani' => 1, 'tipe_produk' => 'beras', 'nama' => 'Beras Rojolele Asli Delanggu', 'rating' => 5, 'jumlah_penjualan' => 95, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => 3, 'id_petani' => 1, 'tipe_produk' => 'beras', 'nama' => 'Beras Merah Organik', 'rating' => 4, 'jumlah_penjualan' => 75, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => 4, 'id_petani' => 1, 'tipe_produk' => 'beras', 'nama' => 'Beras Hitam Pilihan', 'rating' => 4, 'jumlah_penjualan' => 50, 'created_at' => now(), 'updated_at' => now()],
            // 3 Gabah
            ['id_produk' => 5, 'id_petani' => 1, 'tipe_produk' => 'gabah', 'nama' => 'Gabah Kering Giling (GKG) Ciherang', 'rating' => 5, 'jumlah_penjualan' => 250, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => 6, 'id_petani' => 1, 'tipe_produk' => 'gabah', 'nama' => 'Gabah Kering Panen (GKP) IR64', 'rating' => 4, 'jumlah_penjualan' => 310, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => 7, 'id_petani' => 1, 'tipe_produk' => 'gabah', 'nama' => 'Gabah Kualitas Sedang', 'rating' => 3, 'jumlah_penjualan' => 400, 'created_at' => now(), 'updated_at' => now()],
            // 3 Tebas
            ['id_produk' => 8, 'id_petani' => 1, 'tipe_produk' => 'tebas', 'nama' => 'Tebasan Sawah 2 Hektar Siap Panen', 'rating' => null, 'jumlah_penjualan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => 9, 'id_petani' => 1, 'tipe_produk' => 'tebas', 'nama' => 'Tebasan Padi Organik 1 Hektar', 'rating' => null, 'jumlah_penjualan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id_produk' => 10, 'id_petani' => 1, 'tipe_produk' => 'tebas', 'nama' => 'Tebasan Sawah Dekat Jalan Raya', 'rating' => null, 'jumlah_penjualan' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 7. Detail Produk (Beras, Gabah, Tebas)
        DB::table('beras')->insert([
            ['id_beras' => 1, 'id_produksi' => 1, 'id_produk' => 1, 'kualitas_beras' => 'premium', 'harga_kg' => 15500, 'stok_kg' => 250.5, 'deskripsi' => 'Beras pulen dengan aroma pandan wangi yang khas, cocok untuk keluarga.', 'created_at' => now(), 'updated_at' => now()],
            ['id_beras' => 2, 'id_produksi' => 2, 'id_produk' => 2, 'kualitas_beras' => 'premium', 'harga_kg' => 14000, 'stok_kg' => 300.0, 'deskripsi' => 'Beras legendaris dari Delanggu, kualitas terjamin.', 'created_at' => now(), 'updated_at' => now()],
            ['id_beras' => 3, 'id_produksi' => 3, 'id_produk' => 3, 'kualitas_beras' => 'medium', 'harga_kg' => 18000, 'stok_kg' => 150.0, 'deskripsi' => 'Kaya serat dan antioksidan, baik untuk penderita diabetes dan diet.', 'created_at' => now(), 'updated_at' => now()],
            ['id_beras' => 4, 'id_produksi' => 4, 'id_produk' => 4, 'kualitas_beras' => 'medium', 'harga_kg' => 22000, 'stok_kg' => 100.0, 'deskripsi' => 'Beras langka dengan kandungan gizi tinggi.', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('gabah')->insert([
            ['id_gabah' => 1, 'id_panen' => 5, 'id_produk' => 5, 'kualitas_gabah' => 'bagus', 'harga_gabah' => 7500, 'stok_kg' => 1500.0, 'deskripsi' => 'Gabah kering siap giling, kadar air rendah, rendemen tinggi.', 'created_at' => now(), 'updated_at' => now()],
            ['id_gabah' => 2, 'id_panen' => 6, 'id_produk' => 6, 'kualitas_gabah' => 'bagus', 'harga_gabah' => 6800, 'stok_kg' => 2200.0, 'deskripsi' => 'Gabah hasil panen mesin combie, bersih dan berkualitas.', 'created_at' => now(), 'updated_at' => now()],
            ['id_gabah' => 3, 'id_panen' => 7, 'id_produk' => 7, 'kualitas_gabah' => 'sedang', 'harga_gabah' => 6200, 'stok_kg' => 3000.0, 'deskripsi' => 'Cocok untuk kebutuhan industri atau pakan ternak.', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('tebas')->insert([
            ['id_tebas' => 1, 'id_lahan' => 8, 'id_produk' => 8, 'umur_padi' => 95, 'rendeman_padi' => 75.5, 'harga' => 25000000, 'deskripsi' => 'Lokasi strategis, padi siap dipanen dalam 1 minggu. Varietas unggul.', 'created_at' => now(), 'updated_at' => now()],
            ['id_tebas' => 2, 'id_lahan' => 9, 'id_produk' => 9, 'umur_padi' => 100, 'rendeman_padi' => 80.0, 'harga' => 18000000, 'deskripsi' => 'Sawah bebas pestisida kimia, hasil panen dijamin sehat.', 'created_at' => now(), 'updated_at' => now()],
            ['id_tebas' => 3, 'id_lahan' => 10, 'id_produk' => 10, 'umur_padi' => 90, 'rendeman_padi' => 78.2, 'harga' => 16500000, 'deskripsi' => 'Akses mudah untuk truk dan mesin panen. Estimasi hasil panen melimpah.', 'created_at' => now(), 'updated_at' => now()],
        ]);

          DB::table('transaksi')->insert([
            ['id_transaksi' => 1, 'id_produk' => 1, 'id_user' => 2, 'tgl_transaksi' => '2024-05-01', 'metode_transaksi' => 'transfer', 'jumlah_barang' => 10, 'harga_item' => 15500.00, 'total_transaksi' => 155000.00, 'status_transaksi' => 'lunas', 'created_at' => now(), 'updated_at' => now()],
            ['id_transaksi' => 2, 'id_produk' => 2, 'id_user' => 2, 'tgl_transaksi' => '2024-05-02', 'metode_transaksi' => 'DP', 'jumlah_barang' => 15, 'harga_item' => 14000.00, 'total_transaksi' => 210000.00, 'status_transaksi' => 'belum_lunas', 'created_at' => now(), 'updated_at' => now()],
            ['id_transaksi' => 3, 'id_produk' => 3, 'id_user' => 2, 'tgl_transaksi' => '2024-05-03', 'metode_transaksi' => 'transfer', 'jumlah_barang' => 5, 'harga_item' => 18000.00, 'total_transaksi' => 90000.00, 'status_transaksi' => 'lunas', 'created_at' => now(), 'updated_at' => now()],
            ['id_transaksi' => 4, 'id_produk' => 5, 'id_user' => 2, 'tgl_transaksi' => '2024-05-04', 'metode_transaksi' => 'transfer', 'jumlah_barang' => 100, 'harga_item' => 7500.00, 'total_transaksi' => 750000.00, 'status_transaksi' => 'lunas', 'created_at' => now(), 'updated_at' => now()],
            ['id_transaksi' => 5, 'id_produk' => 6, 'id_user' => 2, 'tgl_transaksi' => '2024-05-05', 'metode_transaksi' => 'DP', 'jumlah_barang' => 200, 'harga_item' => 6800.00, 'total_transaksi' => 1360000.00, 'status_transaksi' => 'belum_lunas', 'created_at' => now(), 'updated_at' => now()],
            ['id_transaksi' => 6, 'id_produk' => 8, 'id_user' => 2, 'tgl_transaksi' => '2024-05-06', 'metode_transaksi' => 'DP', 'jumlah_barang' => 1, 'harga_item' => 25000000.00, 'total_transaksi' => 25000000.00, 'status_transaksi' => 'belum_lunas', 'created_at' => now(), 'updated_at' => now()],
            ['id_transaksi' => 7, 'id_produk' => 4, 'id_user' => 2, 'tgl_transaksi' => '2024-05-07', 'metode_transaksi' => 'transfer', 'jumlah_barang' => 3, 'harga_item' => 22000.00, 'total_transaksi' => 66000.00, 'status_transaksi' => 'lunas', 'created_at' => now(), 'updated_at' => now()],
            ['id_transaksi' => 8, 'id_produk' => 7, 'id_user' => 2, 'tgl_transaksi' => '2024-05-08', 'metode_transaksi' => 'transfer', 'jumlah_barang' => 150, 'harga_item' => 6200.00, 'total_transaksi' => 930000.00, 'status_transaksi' => 'lunas', 'created_at' => now(), 'updated_at' => now()],
            ['id_transaksi' => 9, 'id_produk' => 9, 'id_user' => 2, 'tgl_transaksi' => '2024-05-09', 'metode_transaksi' => 'transfer', 'jumlah_barang' => 1, 'harga_item' => 18000000.00, 'total_transaksi' => 18000000.00, 'status_transaksi' => 'lunas', 'created_at' => now(), 'updated_at' => now()],
            ['id_transaksi' => 10, 'id_produk' => 10, 'id_user' => 2, 'tgl_transaksi' => '2024-05-10', 'metode_transaksi' => 'DP', 'jumlah_barang' => 1, 'harga_item' => 16500000.00, 'total_transaksi' => 16500000.00, 'status_transaksi' => 'belum_lunas', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // 9. Transfer (Untuk transaksi dengan metode transfer)
      // 9. Transfer (Untuk transaksi dengan metode transfer)
        DB::table('transfer')->insert([
            [
                'id' => 1, 
                'id_transaksi' => 1, 
                // Diperbaiki: 'BCA' menjadi 'bank bca'
                'bank_pengirim' => 'bank bca', 
                'nama_pengirim' => 'Azwar Maulana', 
                'no_rekening_pengirim' => '1234567890', 
                'bukti_transfer' => 'transfer_001.jpg', 
                'tgl_transfer' => '2024-05-01 14:30:00', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'id' => 2, 
                'id_transaksi' => 3, 
                // Diperbaiki: 'Mandiri' menjadi 'bank mandiri'
                'bank_pengirim' => 'bank mandiri', 
                'nama_pengirim' => 'Rifan Kurniawan', 
                'no_rekening_pengirim' => '9876543210', 
                'bukti_transfer' => 'transfer_002.jpg', 
                'tgl_transfer' => '2024-05-03 10:15:00', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'id' => 3, 
                'id_transaksi' => 4, 
                // Diperbaiki: 'BNI' menjadi 'bank bni'
                'bank_pengirim' => 'bank bni', 
                'nama_pengirim' => 'Azwar Maulana', 
                'no_rekening_pengirim' => '5555666677', 
                'bukti_transfer' => 'transfer_003.jpg', 
                'tgl_transfer' => '2024-05-04 16:45:00', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'id' => 4, 
                'id_transaksi' => 7, 
                // Diperbaiki: 'BRI' menjadi 'bank bri'
                'bank_pengirim' => 'bank bri', 
                'nama_pengirim' => 'Rifan Kurniawan', 
                'no_rekening_pengirim' => '1111222233', 
                'bukti_transfer' => 'transfer_004.jpg', 
                'tgl_transfer' => '2024-05-07 11:20:00', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'id' => 5, 
                'id_transaksi' => 8, 
                // Diperbaiki: 'CIMB Niaga' menjadi 'bank cmb_niaga'
                'bank_pengirim' => 'bank cmb_niaga', 
                'nama_pengirim' => 'Azwar Maulana', 
                'no_rekening_pengirim' => '7777888899', 
                'bukti_transfer' => 'transfer_005.jpg', 
                'tgl_transfer' => '2024-05-08 13:10:00', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
            [
                'id' => 6, 
                'id_transaksi' => 9, 
                // Diperbaiki: 'Danamon' (tidak valid) diganti dengan salah satu nilai enum yang valid, contoh: 'bank mandiri'
                'bank_pengirim' => 'bank mandiri', 
                'nama_pengirim' => 'Rifan Kurniawan', 
                'no_rekening_pengirim' => '4444555566', 
                'bukti_transfer' => 'transfer_006.jpg', 
                'tgl_transfer' => '2024-05-09 09:30:00', 
                'created_at' => now(), 
                'updated_at' => now()
            ],
        ]);
        
        // 10. DP (Untuk transaksi dengan metode DP)
        DB::table('dp')->insert([
            ['id' => 1, 'id_transaksi' => 2, 'jumlah_dp' => 105000.00, 'bank_pengirim' => 'BCA', 'nama_pengirim' => 'Azwar Maulana', 'no_rekening_pengirim' => '1234567890', 'bukti_dp' => 'dp_001.jpg', 'tgl_dp' => '2024-05-02 15:00:00', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'id_transaksi' => 5, 'jumlah_dp' => 680000.00, 'bank_pengirim' => 'Mandiri', 'nama_pengirim' => 'Rifan Kurniawan', 'no_rekening_pengirim' => '9876543210', 'bukti_dp' => 'dp_002.jpg', 'tgl_dp' => '2024-05-05 12:30:00', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'id_transaksi' => 6, 'jumlah_dp' => 12500000.00, 'bank_pengirim' => 'BNI', 'nama_pengirim' => 'Azwar Maulana', 'no_rekening_pengirim' => '5555666677', 'bukti_dp' => 'dp_003.jpg', 'tgl_dp' => '2024-05-06 14:45:00', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'id_transaksi' => 10, 'jumlah_dp' => 8250000.00, 'bank_pengirim' => 'BRI', 'nama_pengirim' => 'Azwar Maulana', 'no_rekening_pengirim' => '7777888899', 'bukti_dp' => 'dp_004.jpg', 'tgl_dp' => '2024-05-10 10:15:00', 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // 11. Keuangan (Ringkasan keuangan berdasarkan transaksi)
      DB::table('keuangan')->insert([
            ['id' => 1, 'id_transaksi' => 1, 'id_petani' => 1, 'id_produk' => 1, 'jenis' => 'masuk', 'jumlah' => 155000.00, 'saldo_setelah' => 155000.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'id_transaksi' => 2, 'id_petani' => 1, 'id_produk' => 2, 'jenis' => 'masuk', 'jumlah' => 105000.00, 'saldo_setelah' => 105000.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'id_transaksi' => 3, 'id_petani' => 1, 'id_produk' => 3, 'jenis' => 'masuk', 'jumlah' => 90000.00, 'saldo_setelah' => 90000.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'id_transaksi' => 4, 'id_petani' => 1, 'id_produk' => 5, 'jenis' => 'masuk', 'jumlah' => 750000.00, 'saldo_setelah' => 750000.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'id_transaksi' => 5, 'id_petani' => 1, 'id_produk' => 6, 'jenis' => 'masuk', 'jumlah' => 680000.00, 'saldo_setelah' => 680000.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'id_transaksi' => 6, 'id_petani' => 1, 'id_produk' => 8, 'jenis' => 'masuk', 'jumlah' => 12500000.00, 'saldo_setelah' => 12500000.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'id_transaksi' => 7, 'id_petani' => 1, 'id_produk' => 4, 'jenis' => 'masuk', 'jumlah' => 66000.00, 'saldo_setelah' => 66000.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'id_transaksi' => 8, 'id_petani' => 1, 'id_produk' => 7, 'jenis' => 'masuk', 'jumlah' => 930000.00, 'saldo_setelah' => 930000.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'id_transaksi' => 9, 'id_petani' => 1, 'id_produk' => 9, 'jenis' => 'masuk', 'jumlah' => 18000000.00, 'saldo_setelah' => 18000000.00, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'id_transaksi' => 10, 'id_petani' => 1, 'id_produk' => 10, 'jenis' => 'masuk', 'jumlah' => 8250000.00, 'saldo_setelah' => 8250000.00, 'created_at' => now(), 'updated_at' => now()],
        ]);
        
        // =================================================================
        // DATA HISTORI PENCARIAN
        // =================================================================
        $searches = [
            'Harga beras organik terbaru', 'Gabah kualitas ekspor', 'Tebasan sawah musim panen',
            'Beras merah rendah gula', 'Gabah kering panen Jogja', 'Tebas sawah luas 1 hektar',
            'Beras super premium Jawa Tengah', 'Gabah siap giling', 'Tebasan padi jenis Ciherang',
            'Beras IR64 kemasan 5kg', 'Gabah hasil panen Februari', 'Harga pasaran gabah hari ini',
            'Tebasan sawah 2 hektar Bantul', 'Rekomendasi beras sehat', 'Gabah organik Subang',
            'Paket tebas sawah panen cepat', 'Harga beras bulog', 'Gabah premium untuk pabrik',
            'Cari petani jual tebasan', 'Tebasan siap panen minggu ini', 'Beras putih pulen murah',
            'Gabah kering simpan', 'Tebasan sawah di Kulon Progo', 'Jenis gabah unggul Indonesia',
            'Tebasan luas dan strategis', 'Beras hitam kaya antioksidan', 'Gabah lokal vs impor',
            'Tebasan sawah petani terpercaya', 'Pasar beras online', 'Gabah bersih dan siap jual',
            'Tebasan panen 3 minggu lagi', 'Beras murah untuk warung makan', 'Gabah varietas Inpari 32',
            'Tebasan daerah Sleman',
        ];

        $data = [];
        foreach ($searches as $i => $query) {
            $data[] = [
                'id_user' => ($i % 2) + 1,
                'query' => $query,
                'created_at' => now()->subMinutes($i),
                'updated_at' => now()->subMinutes($i),
            ];
        }
        DB::table('search_history_user')->insert($data);


        // Aktifkan kembali pengecekan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
