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
        Schema::create('dokumen_kepegawaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')->constrained('pegawai')->onDelete('cascade');
            $table->foreignId('jenis_dokumen_id')->constrained('jenis_dokumen')->onDelete('cascade');
            $table->string('nomor_dokumen');
            $table->date('tanggal_terbit');
            $table->date('tanggal_berakhir');
            $table->string('file_path')->nullable();
            $table->string('status')->default('aktif'); // Status dokumen: aktif, kadaluarsa, atau peringatan
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_kepegawaian');
    }
};
