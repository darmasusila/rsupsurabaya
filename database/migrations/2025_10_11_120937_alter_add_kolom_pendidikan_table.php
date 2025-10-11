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
        Schema::table('pendidikan', function (Blueprint $table) {
            $table->string('institusi_spesialis')->nullable()->after('program_studi');
            $table->string('institusi_subspesialis')->nullable()->after('institusi_spesialis');
            $table->string('no_ijasah')->nullable()->after('institusi_subspesialis');
            $table->string('no_ijasah_subspesialis')->nullable()->after('no_ijasah');
            $table->string('no_ijasah_spesialis')->nullable()->after('no_ijasah_subspesialis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendidikan', function (Blueprint $table) {
            $table->dropColumn('institusi_spesialis');
            $table->dropColumn('institusi_subspesialis');
            $table->dropColumn('no_ijasah');
            $table->dropColumn('no_ijasah_subspesialis');
            $table->dropColumn('no_ijasah_spesialis');
        });
    }
};
