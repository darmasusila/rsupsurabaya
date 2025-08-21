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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biodata_id')->constrained('biodata')->onDelete('cascade');
            $table->foreignId('fungsional_id')->nullable()->constrained('fungsional')->onDelete('set null');
            $table->foreignId('struktural_id')->nullable()->constrained('struktural')->onDelete('set null');
            $table->foreignId('jenis_tenaga_id')->nullable()->constrained('jenis_tenaga')->onDelete('set null');
            $table->foreignId('status_kepegawaian_id')->nullable()->constrained('status_kepegawaian')->onDelete('set null');
            $table->foreignId('unit_id')->nullable()->constrained('unit')->onDelete('set null');
            $table->string('nip')->nullable();
            $table->string('tingkat_ahli')->nullable();
            $table->string('kelas_jabatan')->nullable();
            $table->string('golongan')->nullable();
            $table->date('tmt_golongan')->nullable();
            $table->string('no_sk')->nullable();
            $table->string('no_str')->nullable();
            $table->string('no_sip')->nullable();
            $table->date('tanggal_akhir_berlaku')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
