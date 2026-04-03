<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi_kegiatan', function (Blueprint $table) {
              $table->id();
              $table->foreignId('user_id')->constrained('users');
              $table->enum('jenis_kegiatan', ['kunjungan_guru', 'kunjungan_pelmas', 'duduk_talim_masjid', 'hadir_malam_markaz']);
              $table->date('tanggal');
              $table->enum('status', ['hadir', 'tidak_hadir', 'izin']);
              $table->decimal('latitude', 10, 8)->nullable();
              $table->decimal('longitude', 11, 8)->nullable();
              $table->timestamp('verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_kegiatan');
    }
};
