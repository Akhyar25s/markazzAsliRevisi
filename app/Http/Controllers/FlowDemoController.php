<?php

namespace App\Http\Controllers;

use App\Http\Requests\AbsensiItikafRequest;
use App\Http\Requests\AbsensiKegiatanRequest;
use App\Http\Requests\AssignAmirRequest;
use App\Http\Requests\KirimLaporanRequest;
use App\Services\FlowDemoService;
use Illuminate\Http\JsonResponse;

class FlowDemoController extends Controller
{
    public function __construct(private readonly FlowDemoService $service)
    {
    }

    /**
     * Flow 1: Assign amir ke kelompok.
     */
    public function assignAmir(AssignAmirRequest $request): JsonResponse
    {
        $amir = $this->service->assignAmir($request->validated());

        return response()->json([
            'message' => 'Amir berhasil di-assign ke kelompok.',
            'data' => $amir->load(['kelompok', 'user', 'assignedBy']),
        ], 201);
    }

    /**
     * Flow 2A: Input absensi kegiatan.
     */
    public function inputAbsensiKegiatan(AbsensiKegiatanRequest $request): JsonResponse
    {
        $absensi = $this->service->inputAbsensiKegiatan($request->validated());

        return response()->json([
            'message' => 'Absensi kegiatan berhasil disimpan.',
            'data' => $absensi->load('user'),
        ], 201);
    }

    /**
     * Flow 2B: Input absensi itikaf.
     */
    public function inputAbsensiItikaf(AbsensiItikafRequest $request): JsonResponse
    {
        $absensi = $this->service->inputAbsensiItikaf($request->validated());

        return response()->json([
            'message' => 'Absensi itikaf berhasil disimpan.',
            'data' => $absensi->load(['user', 'jadwalItikaf']),
        ], 201);
    }

    /**
     * Flow 3: Kirim laporan + buat notifikasi otomatis.
     */
    public function kirimLaporan(KirimLaporanRequest $request): JsonResponse
    {
        $payload = $this->service->kirimLaporan($request->validated());

        return response()->json([
            'message' => 'Laporan berhasil dikirim dan notifikasi dibuat otomatis.',
            'data' => [
                'laporan' => $payload['laporan']->load(['dikirimOleh', 'diterimaOleh']),
                'notifikasi' => $payload['notifikasi']->load(['laporan', 'user']),
            ],
        ], 201);
    }
}
