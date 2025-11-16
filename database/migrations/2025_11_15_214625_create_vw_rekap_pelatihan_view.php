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
        DB::statement("
            CREATE VIEW vw_rekap_pelatihan AS
            SELECT 
                dp.pegawai_id,
                count(dp.status) as pelatihan,
                sum(dp.status) as verified_pelatihan
            FROM 
                diklat_pelatihan dp
            group by dp.pegawai_id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS vw_rekap_pelatihan");
    }
};
