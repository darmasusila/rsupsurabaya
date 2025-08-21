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
        Schema::create('kebugaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('biodata_id')->constrained('biodata')->onDelete('cascade');
            $table->date('tanggal');
            $table->integer('berat_badan')->nullable();
            $table->integer('tinggi_badan')->nullable();
            $table->integer('indeks_massa_tubuh')->nullable();
            $table->integer('lingkar_perut')->nullable();
            $table->integer('tekanan_darah_sistolik')->nullable();
            $table->integer('tekanan_darah_diastolik')->nullable();
            $table->integer('denyut_nadi')->nullable();
            $table->integer('gula_darah')->nullable();
            $table->integer('kolesterol')->nullable();
            $table->string('hasil_kesehatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kebugaran');
    }
};
