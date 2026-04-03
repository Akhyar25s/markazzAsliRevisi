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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 150);
            $table->enum('jenis', ['tanggal', 'kegiatan', 'nama_pengguna']);
            $table->string('filter_value', 100)->nullable();
            $table->unsignedBigInteger('dikirim_oleh');
            $table->unsignedBigInteger('diterima_oleh');
            $table->enum('status', ['terkirim', 'diterima']);
            $table->string('file_path', 255);
            $table->timestamp('created_at')->nullable();

            $table->foreign('dikirim_oleh')->references('id')->on('users');
            $table->foreign('diterima_oleh')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
