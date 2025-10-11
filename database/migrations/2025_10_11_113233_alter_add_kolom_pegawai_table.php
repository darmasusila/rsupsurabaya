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
            $table->foreignId('departemen_id')->constrained('departemen')->onDelete('cascade')->after('direktorat_id')->nullable();
            $table->string('jenjang_jabatan')->nullable()->after('departemen_id');
            $table->string('kewenangan_klinis')->nullable()->after('jenjang_jabatan');
            $table->string('no_npwp')->nullable()->after('kewenangan_klinis');
            $table->string('no_taspen')->nullable()->after('no_npwp');
            $table->string('instansi_sebelumnya')->nullable()->after('no_taspen');
            $table->date('tgl_promosi')->nullable()->after('instansi_sebelumnya');
            $table->date('tgl_mutasi')->nullable()->after('tgl_promosi');
            $table->date('tgl_pensiun')->nullable()->after('tgl_mutasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawai', function (Blueprint $table) {
            $table->dropForeign(['departemen_id']);
            $table->dropColumn('departemen_id');
            $table->dropColumn('jenjang_jabatan');
            $table->dropColumn('kewenangan_klinis');
            $table->dropColumn('no_npwp');
            $table->dropColumn('no_taspen');
            $table->dropColumn('instansi_sebelumnya');
            $table->dropColumn('tgl_promosi');
            $table->dropColumn('tgl_mutasi');
            $table->dropColumn('tgl_pensiun');
        });
    }
};
