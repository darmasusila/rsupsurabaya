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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('nama_dokumen');
            $table->string('deskripsi')->nullable();
            $table->string('slug')->unique();
            $table->string('url');
            $table->string('nama_pengupload')->nullable();
            $table->string('path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('original_file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->integer('counter')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
