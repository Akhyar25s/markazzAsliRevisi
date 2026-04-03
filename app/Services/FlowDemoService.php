<?php

namespace App\Services;

use App\Models\AbsensiItikaf;
use App\Models\AbsensiKegiatan;
use App\Models\AmirItikaf;
use App\Models\Laporan;
use App\Models\NotifikasiLaporan;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FlowDemoService
{
    public function assignAmir(array $validated): AmirItikaf
    {
        $assigner = User::findOrFail($validated['assigned_by']);
        if ($assigner->role !== 'admin_jamaah') {
            throw ValidationException::withMessages([
                'assigned_by' => 'assigned_by harus user dengan role admin_jamaah.',
            ]);
        }

        $durasiHari = $validated['durasi_hari'] ?? 3;
        $tanggalMulai = Carbon::parse($validated['tanggal_mulai']);
        $tanggalSelesai = $tanggalMulai->copy()->addDays($durasiHari - 1);

        return DB::transaction(function () use ($validated, $tanggalMulai, $tanggalSelesai) {
            return AmirItikaf::create([
                'kelompok_id' => $validated['kelompok_id'],
                'user_id' => $validated['user_id'],
                'assigned_by' => $validated['assigned_by'],
                'tanggal_mulai' => $tanggalMulai->toDateString(),
                'tanggal_selesai' => $tanggalSelesai->toDateString(),
                'status' => 'aktif',
                'created_at' => now(),
            ]);
        });
    }

    public function inputAbsensiKegiatan(array $validated): AbsensiKegiatan
    {
        return AbsensiKegiatan::create([
            'user_id' => $validated['user_id'],
            'jenis_kegiatan' => $validated['jenis_kegiatan'],
            'tanggal' => $validated['tanggal'],
            'status' => $validated['status'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'verified_at' => ($validated['verified'] ?? false) ? now() : null,
        ]);
    }

    public function inputAbsensiItikaf(array $validated): AbsensiItikaf
    {
        return AbsensiItikaf::create([
            'user_id' => $validated['user_id'],
            'jadwal_itikaf_id' => $validated['jadwal_itikaf_id'],
            'tanggal' => $validated['tanggal'],
            'status' => $validated['status'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'verified_at' => ($validated['verified'] ?? false) ? now() : null,
        ]);
    }

    public function kirimLaporan(array $validated): array
    {
        return DB::transaction(function () use ($validated) {
            $laporan = Laporan::create([
                'judul' => $validated['judul'],
                'jenis' => $validated['jenis'],
                'filter_value' => $validated['filter_value'] ?? null,
                'dikirim_oleh' => $validated['dikirim_oleh'],
                'diterima_oleh' => $validated['diterima_oleh'],
                'status' => 'terkirim',
                'file_path' => $validated['file_path'],
                'created_at' => now(),
            ]);

            $notifikasi = NotifikasiLaporan::create([
                'laporan_id' => $laporan->id,
                'user_id' => $validated['diterima_oleh'],
                'pesan' => $validated['pesan'] ?? ('Laporan baru diterima: ' . $laporan->judul),
                'is_read' => false,
                'created_at' => now(),
            ]);

            return [
                'laporan' => $laporan,
                'notifikasi' => $notifikasi,
            ];
        });
    }
}
