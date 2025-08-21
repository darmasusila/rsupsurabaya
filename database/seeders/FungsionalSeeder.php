<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class FungsionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        App::make(\App\Models\Fungsional::class)->insert([
            ['nama' => 'Administrator Kesehatan', 'is_str' => true],
            ['nama' => 'Analis Anggaran', 'is_str' => true],
            ['nama' => 'Analis Hukum', 'is_str' => true],
            ['nama' => 'Analis Pengelolaan Keuangan APBN', 'is_str' => true],
            ['nama' => 'Analis Sumber Daya Manusia Aparatur', 'is_str' => true],
            ['nama' => 'Apoteker', 'is_str' => true],
            ['nama' => 'Asisten Penata Anestesi', 'is_str' => true],
            ['nama' => 'Auditor', 'is_str' => true],
            ['nama' => 'Bidan', 'is_str' => true],
            ['nama' => 'Dokter', 'is_str' => true],
            ['nama' => 'Dokter Gigi', 'is_str' => true],
            ['nama' => 'Entomolog', 'is_str' => true],
            ['nama' => 'Epidemiolog Kesehatan', 'is_str' => true],
            ['nama' => 'Fisioterapis', 'is_str' => true],
            ['nama' => 'Nutrisionis', 'is_str' => true],
            ['nama' => 'Pekerja Sosial', 'is_str' => false],
            ['nama' => 'Pembimbing Kesehatan Kerja', 'is_str' => false],
            ['nama' => 'Penata Anestesi', 'is_str' => true],
            ['nama' => 'Perawat', 'is_str' => true],
            ['nama' => 'Perekam Medis', 'is_str' => true],
            ['nama' => 'Perencana', 'is_str' => false],
            ['nama' => 'Pranata Hubungan Masyarakat', 'is_str' => false],
            ['nama' => 'Pranata Keuangan APBN', 'is_str' => false],
            ['nama' => 'Pranata Komputer', 'is_str' => false],
            ['nama' => 'Pranata Laboratorium Kesehatan', 'is_str' => true],
            ['nama' => 'Pranata Sumber Daya Manusia Aparatur', 'is_str' => false],
            ['nama' => 'Psikolog Klinis', 'is_str' => true],
            ['nama' => 'Radiografer', 'is_str' => true],
            ['nama' => 'Refraksionis Optisien', 'is_str' => true],
            ['nama' => 'Sanitarian', 'is_str' => true],
            ['nama' => 'Teknisi Elektro Medis', 'is_str' => true],
            ['nama' => 'Teknisi Gigi', 'is_str' => true],
            ['nama' => 'Tenaga Promosi Kesehatan dan Ilmu Perilaku', 'is_str' => true],
            ['nama' => 'Terapis Gigi dan Mulut', 'is_str' => true],
        ]);
    }
}
