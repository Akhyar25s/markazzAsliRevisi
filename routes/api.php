<?php

use App\Http\Controllers\FlowDemoController;
use Illuminate\Support\Facades\Route;

Route::prefix('demo')->group(function (): void {
    Route::post('/assign-amir', [FlowDemoController::class, 'assignAmir']);
    Route::post('/absensi-kegiatan', [FlowDemoController::class, 'inputAbsensiKegiatan']);
    Route::post('/absensi-itikaf', [FlowDemoController::class, 'inputAbsensiItikaf']);
    Route::post('/kirim-laporan', [FlowDemoController::class, 'kirimLaporan']);
});
