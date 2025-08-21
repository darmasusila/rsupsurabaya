<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class StatusKepegawaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create status kepegawaian
        App::make(\App\Models\StatusKepegawaian::class)->insert([
            ['nama' => 'ASN PNS', 'keterangan' => null],
            ['nama' => 'ASN PPPK', 'keterangan' => null],
            ['nama' => 'CPNS', 'keterangan' => null],
            ['nama' => 'Outsourcing', 'keterangan' => null],
            ['nama' => 'Tim Manajemen', 'keterangan' => null],
        ]);
    }
}
