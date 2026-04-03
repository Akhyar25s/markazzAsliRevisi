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
        Schema::create('deleted_users_log', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id_lama');
            $table->string('nama', 100);
            $table->string('no_hp', 20);
            $table->string('role', 50);
            $table->unsignedBigInteger('dihapus_oleh');
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('dihapus_oleh')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_users_log');
    }
};
