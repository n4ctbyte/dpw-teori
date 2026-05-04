<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id();
            $table->string('akad_tanggal')->nullable();
            $table->string('akad_waktu')->nullable();
            $table->string('resepsi_tanggal')->nullable();
            $table->string('resepsi_waktu')->nullable();
            $table->string('lokasi_nama')->nullable();
            $table->text('lokasi_alamat')->nullable();
            $table->text('lokasi_url')->nullable();
            $table->text('lokasi_iframe')->nullable();
            $table->string('tanggal_countdown')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};