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
        Schema::create('keaktifan_anggota', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->enum('jenis_kegiatan', ['kunjungan_guru', 'kunjungan_pelmas', 'duduk_talim_masjid', 'hadir_malam_markaz', 'itikaf', 'semua']);
            $table->date('tanggal');
            $table->integer('total_hadir');
            $table->integer('total_kegiatan');
            $table->decimal('persentase', 5, 2);
            $table->string('periode', 20);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keaktifan_anggota');
    }
};
