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
        Schema::table('pegawai', function (Blueprint $table) {
            $table->string('posisi_jabatan_sebelumnya')->nullable()->after('kelas_jabatan');
            $table->integer('lama_bekerja')->nullable()->after('posisi_jabatan_sebelumnya');
            $table->string('status_keahlian')->nullable()->after('lama_bekerja');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropColumn('posisi_jabatan_sebelumnya');
            $table->dropColumn('lama_bekerja');
            $table->dropColumn('status_keahlian');
        });
    }
};
