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
        Schema::create('pendidikan', function (Blueprint $table) {
            $table->id();
            $table->string('jenjang');
            $table->string('program_studi')->nullable();
            $table->string('institusi')->nullable();
            $table->date('tanggal_lulus')->nullable();
            $table->string('keterangan')->nullable();
            $table->foreignId('biodata_id')->constrained('biodata')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikan');
    }
};
