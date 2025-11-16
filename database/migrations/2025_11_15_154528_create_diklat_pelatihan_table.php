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
        Schema::create('diklat_pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            $table->foreignId('diklat_jenis_id')->constrained('diklat_jenis')->onDelete('cascade');
            $table->foreignId('diklat_kategori_id')->constrained('diklat_kategori')->onDelete('cascade');
            $table->foreignId('diklat_metode_id')->constrained('diklat_metode')->onDelete('cascade');
            $table->string('judul');
            $table->string('penyelenggara')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('peran')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->integer('biaya')->nullable()->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diklat_pelatihan');
    }
};
