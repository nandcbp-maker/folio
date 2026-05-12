<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SuratMasuk;
use App\Models\SuratKeluar;
use App\Models\Setting;
use App\Models\Disposisi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@folio.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Pimpinan
        $pimpinan = User::create([
            'name' => 'Dr. Ahmad Fauzi, M.Kom',
            'email' => 'pimpinan@folio.com',
            'password' => Hash::make('password'),
            'role' => 'pimpinan',
        ]);

        // Create Setting
        Setting::create([
            'nama_institusi' => 'Dinas Komunikasi dan Informatika Provinsi',
            'alamat' => 'Jl. Merdeka No. 45, Kompleks Perkantoran Terpadu, Gedung B Lantai 2',
            'kota' => 'Jakarta Pusat',
            'kode_pos' => '10110',
            'telepon' => '(021) 3456789',
            'email' => 'admin@diskominfo.go.id',
            'format_nomor_surat' => '{order}/{code}/DISKOMINFO/{month}/{year}',
        ]);

        // Create Surat Masuk
        for ($i = 1; $i <= 5; $i++) {
            $surat = SuratMasuk::create([
                'no_berkas' => '02' . $i . '/M-OUT/VI/2024',
                'perihal' => 'Laporan Triwulan II - Unit ' . $i,
                'asal_instansi' => 'Kementerian Keuangan',
                'tanggal_surat' => now()->subDays($i + 5),
                'tanggal_terima' => now()->subDays($i),
                'kategori' => 'Arsip Elektronik',
                'status' => 'PENDING',
            ]);

            // Add Disposition
            Disposisi::create([
                'surat_masuk_id' => $surat->id,
                'pengirim_id' => $admin->id,
                'penerima_id' => $pimpinan->id,
                'instruksi' => 'Mohon ditindaklanjuti untuk laporan ini.',
                'status' => 'Segera',
            ]);
        }

        // Create Surat Keluar
        for ($i = 1; $i <= 3; $i++) {
            SuratKeluar::create([
                'no_surat' => '00' . $i . '/DISKOMINFO/VI/2024',
                'perihal' => 'Undangan Rapat Koordinasi ' . $i,
                'tujuan' => 'Seluruh Kepala Bidang',
                'tanggal_surat' => now()->subDays($i),
                'isi_surat' => 'Isi surat undangan...',
                'status' => 'SENT',
                'template_type' => 'Undangan Resmi',
            ]);
        }
    }
}
