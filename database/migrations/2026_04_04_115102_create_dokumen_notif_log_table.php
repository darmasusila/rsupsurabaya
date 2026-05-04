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
        Schema::create('dokumen_notif_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokumen_kepegawaian_id')->constrained('dokumen_kepegawaian')->onDelete('cascade');
            $table->dateTime('notified_at');
            $table->string('notification_type'); // Jenis notifikasi: reminder, expired, dll.
            $table->text('message')->nullable();
            $table->string('recipient'); // Penerima notifikasi, bisa berupa email atau user ID
            $table->string('status')->default('sent'); // Status notifikasi: sent, failed, dll.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_notif_log');
    }
};
