<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('users')->insert([
            [
                'id' => 1,
                'nama' => 'Admin Masjid',
                'no_hp' => '081100000001',
                'alamat' => 'Markaz Pusat',
                'password' => Hash::make('password123'),
                'role' => 'admin_masjid',
                'face_data' => null,
                'created_at' => $now,
            ],
            [
                'id' => 2,
                'nama' => 'Admin Jamaah A',
                'no_hp' => '081100000002',
                'alamat' => 'Jl. Ikhlas No. 10',
                'password' => Hash::make('password123'),
                'role' => 'admin_jamaah',
                'face_data' => null,
                'created_at' => $now,
            ],
            [
                'id' => 3,
                'nama' => 'Admin Jamaah B',
                'no_hp' => '081100000003',
                'alamat' => 'Jl. Amanah No. 22',
                'password' => Hash::make('password123'),
                'role' => 'admin_jamaah',
                'face_data' => null,
                'created_at' => $now,
            ],
            [
                'id' => 4,
                'nama' => 'Anggota 1',
                'no_hp' => '081100000004',
                'alamat' => 'Jl. Melati No. 1',
                'password' => Hash::make('password123'),
                'role' => 'anggota_jamaah',
                'face_data' => null,
                'created_at' => $now,
            ],
            [
                'id' => 5,
                'nama' => 'Anggota 2',
                'no_hp' => '081100000005',
                'alamat' => 'Jl. Melati No. 2',
                'password' => Hash::make('password123'),
                'role' => 'anggota_jamaah',
                'face_data' => null,
                'created_at' => $now,
            ],
            [
                'id' => 6,
                'nama' => 'Anggota 3',
                'no_hp' => '081100000006',
                'alamat' => 'Jl. Melati No. 3',
                'password' => Hash::make('password123'),
                'role' => 'anggota_jamaah',
                'face_data' => null,
                'created_at' => $now,
            ],
        ]);

        DB::table('kelompok_itikaf')->insert([
            [
                'id' => 1,
                'nama_kelompok' => 'Kelompok Al-Falah',
                'admin_jamaah_id' => 2,
                'created_at' => $now,
            ],
            [
                'id' => 2,
                'nama_kelompok' => 'Kelompok Al-Hikmah',
                'admin_jamaah_id' => 3,
                'created_at' => $now,
            ],
        ]);

        DB::table('amir_itikaf')->insert([
            [
                'id' => 1,
                'kelompok_id' => 1,
                'user_id' => 4,
                'assigned_by' => 2,
                'tanggal_mulai' => '2026-03-10',
                'tanggal_selesai' => '2026-03-12',
                'status' => 'aktif',
                'created_at' => $now,
            ],
            [
                'id' => 2,
                'kelompok_id' => 2,
                'user_id' => 5,
                'assigned_by' => 3,
                'tanggal_mulai' => '2026-03-08',
                'tanggal_selesai' => '2026-03-10',
                'status' => 'selesai',
                'created_at' => $now,
            ],
        ]);

        DB::table('anggota_kelompok')->insert([
            [
                'id' => 1,
                'kelompok_id' => 1,
                'user_id' => 4,
                'status' => 'aktif',
                'joined_at' => $now,
            ],
            [
                'id' => 2,
                'kelompok_id' => 1,
                'user_id' => 5,
                'status' => 'aktif',
                'joined_at' => $now,
            ],
            [
                'id' => 3,
                'kelompok_id' => 2,
                'user_id' => 6,
                'status' => 'aktif',
                'joined_at' => $now,
            ],
        ]);

        DB::table('jadwal_itikaf')->insert([
            [
                'id' => 1,
                'kelompok_id' => 1,
                'tanggal_mulai' => '2026-03-10',
                'tanggal_selesai' => '2026-03-12',
                'keterangan' => 'Jadwal pekan 1 kelompok Al-Falah',
                'created_by' => 2,
                'created_at' => $now,
            ],
            [
                'id' => 2,
                'kelompok_id' => 2,
                'tanggal_mulai' => '2026-03-13',
                'tanggal_selesai' => '2026-03-15',
                'keterangan' => 'Jadwal pekan 1 kelompok Al-Hikmah',
                'created_by' => 3,
                'created_at' => $now,
            ],
        ]);

        DB::table('absensi_itikaf')->insert([
            [
                'id' => 1,
                'user_id' => 4,
                'jadwal_itikaf_id' => 1,
                'tanggal' => '2026-03-10',
                'status' => 'hadir',
                'latitude' => '-6.20000000',
                'longitude' => '106.81666600',
                'verified_at' => $now,
            ],
            [
                'id' => 2,
                'user_id' => 5,
                'jadwal_itikaf_id' => 1,
                'tanggal' => '2026-03-10',
                'status' => 'tidak_hadir',
                'latitude' => null,
                'longitude' => null,
                'verified_at' => null,
            ],
        ]);

        DB::table('absensi_kegiatan')->insert([
            [
                'id' => 1,
                'user_id' => 4,
                'jenis_kegiatan' => 'kunjungan_guru',
                'tanggal' => '2026-03-10',
                'status' => 'hadir',
                'latitude' => '-6.20111111',
                'longitude' => '106.81111111',
                'verified_at' => $now,
            ],
            [
                'id' => 2,
                'user_id' => 5,
                'jenis_kegiatan' => 'hadir_malam_markaz',
                'tanggal' => '2026-03-10',
                'status' => 'izin',
                'latitude' => null,
                'longitude' => null,
                'verified_at' => null,
            ],
            [
                'id' => 3,
                'user_id' => 6,
                'jenis_kegiatan' => 'duduk_talim_masjid',
                'tanggal' => '2026-03-10',
                'status' => 'hadir',
                'latitude' => '-6.20555555',
                'longitude' => '106.82555555',
                'verified_at' => $now,
            ],
        ]);

        DB::table('keaktifan_anggota')->insert([
            [
                'id' => 1,
                'user_id' => 4,
                'jenis_kegiatan' => 'semua',
                'tanggal' => '2026-03-10',
                'total_hadir' => 8,
                'total_kegiatan' => 10,
                'persentase' => 80.00,
                'periode' => '2026-03',
            ],
            [
                'id' => 2,
                'user_id' => 5,
                'jenis_kegiatan' => 'itikaf',
                'tanggal' => '2026-03-10',
                'total_hadir' => 5,
                'total_kegiatan' => 9,
                'persentase' => 55.56,
                'periode' => '2026-03',
            ],
        ]);

        DB::table('laporan')->insert([
            [
                'id' => 1,
                'judul' => 'Rekap Kehadiran Pekan 1',
                'jenis' => 'kegiatan',
                'filter_value' => 'hadir_malam_markaz',
                'dikirim_oleh' => 2,
                'diterima_oleh' => 1,
                'status' => 'terkirim',
                'file_path' => 'exports/laporan-pekan-1.pdf',
                'created_at' => $now,
            ],
            [
                'id' => 2,
                'judul' => 'Rekap Itikaf Bulanan',
                'jenis' => 'tanggal',
                'filter_value' => '2026-03',
                'dikirim_oleh' => 3,
                'diterima_oleh' => 1,
                'status' => 'diterima',
                'file_path' => 'exports/rekap-itikaf-2026-03.pdf',
                'created_at' => $now,
            ],
        ]);

        DB::table('notifikasi_laporan')->insert([
            [
                'id' => 1,
                'laporan_id' => 1,
                'user_id' => 1,
                'pesan' => 'Laporan baru diterima: Rekap Kehadiran Pekan 1',
                'is_read' => 0,
                'created_at' => $now,
            ],
            [
                'id' => 2,
                'laporan_id' => 2,
                'user_id' => 1,
                'pesan' => 'Laporan baru diterima: Rekap Itikaf Bulanan',
                'is_read' => 1,
                'created_at' => $now,
            ],
        ]);

        DB::table('face_recognition_log')->insert([
            [
                'id' => 1,
                'user_id' => 4,
                'jenis_absen' => 'kegiatan',
                'referensi_id' => 1,
                'hasil' => 'berhasil',
                'latitude' => '-6.20111111',
                'longitude' => '106.81111111',
                'scanned_at' => $now,
            ],
            [
                'id' => 2,
                'user_id' => 5,
                'jenis_absen' => 'itikaf',
                'referensi_id' => 2,
                'hasil' => 'gagal',
                'latitude' => '-6.20222222',
                'longitude' => '106.81222222',
                'scanned_at' => $now,
            ],
        ]);

        DB::table('role_log')->insert([
            [
                'id' => 1,
                'user_id' => 6,
                'role_lama' => 'anggota_jamaah',
                'role_baru' => 'anggota_jamaah',
                'diubah_oleh' => 1,
                'changed_at' => $now,
            ],
        ]);

        DB::table('deleted_users_log')->insert([
            [
                'id' => 1,
                'user_id_lama' => 99,
                'nama' => 'User Lama',
                'no_hp' => '081199999999',
                'role' => 'anggota_jamaah',
                'dihapus_oleh' => 1,
                'deleted_at' => $now,
            ],
        ]);
    }
}
