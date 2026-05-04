<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jenis_dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('kode_jenis_dokumen')->unique();
            $table->string('nama_jenis_dokumen');
            $table->text('deskripsi')->nullable();
            $table->integer('durasi_reminder')->default(30); // Durasi reminder dalam hari
            $table->timestamps();
        });

        // Insert data awal untuk jenis dokumen
        DB::table('jenis_dokumen')->insert([
            [
                'kode_jenis_dokumen' => 'SIP',
                'nama_jenis_dokumen' => 'Surat Izin Praktik',
                'deskripsi' => 'Surat izin praktik untuk tenaga medis',
                'durasi_reminder' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode_jenis_dokumen' => 'PKS',
                'nama_jenis_dokumen' => 'Surat Perjanjian Kerja',
                'deskripsi' => 'Surat perjanjian kerja untuk mitra (non ASN)',
                'durasi_reminder' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_dokumen');
    }
};
