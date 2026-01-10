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
        Schema::create('magang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biodata_id')->constrained('biodata')->onDelete('cascade');
            $table->foreignId('jenis_tenaga_id')->nullable()->constrained('jenis_tenaga')->onDelete('set null');
            $table->foreignId('status_kepegawaian_id')->nullable()->constrained('status_kepegawaian')->onDelete('set null');
            $table->foreignId('unit_id')->nullable()->constrained('unit')->onDelete('set null');
            $table->foreignId('mentor_id')->nullable()->constrained('pegawai')->onDelete('set null');
            $table->float('ipk', 2)->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('instansi')->nullable();
            $table->string('pendidikan')->nullable();
            $table->string('posisi')->nullable();
            $table->string('penempatan')->nullable();
            $table->text('catatan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magang');
    }
};
