<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create units
        \App\Models\Unit::create([
            'nama' => 'Pelayanan Medik',
            'keterangan' => 'Unit yang menangani pelayanan medis',
            'direktorat_id' => 1, // Assuming this is the ID for 'Direktorat Medik dan Keperawatan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);

        \App\Models\Unit::create([
            'nama' => 'Pelayanan Keperawatan',
            'keterangan' => 'Unit yang menangani pelayanan keperawatan',
            'direktorat_id' => 1, // Assuming this is the ID for 'Direktorat Medik dan Keperawatan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);

        \App\Models\Unit::create([
            'nama' => 'Pelayanan Penunjang',
            'keterangan' => 'Unit yang menangani pelayanan penunjang',
            'direktorat_id' => 1, // Assuming this is the ID for 'Direktorat Medik dan Keperawatan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);

        \App\Models\Unit::create([
            'nama' => 'Organisasi dan SDM',
            'keterangan' => 'Unit yang menangani organisasi dan sumber daya manusia',
            'direktorat_id' => 2, // Assuming this is the ID for 'Direktorat SDM, Pendidikan, dan Pelatihan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);

        \App\Models\Unit::create([
            'nama' => 'Pendidikan dan Pelatihan',
            'keterangan' => 'Unit yang menangani pendidikan dan pelatihan',
            'direktorat_id' => 2, // Assuming this is the ID for 'Direktorat SDM, Pendidikan, dan Pelatihan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);

        \App\Models\Unit::create([
            'nama' => 'Penelitian',
            'keterangan' => 'Unit yang menangani penelitian dan pengembangan',
            'direktorat_id' => 2, // Assuming this is the ID for 'Direktorat SDM, Pendidikan, dan Pelatihan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);

        \App\Models\Unit::create([
            'nama' => 'Urusan Umum',
            'keterangan' => 'Unit yang menangani urusan umum dan administrasi',
            'direktorat_id' => 2, // Assuming this is the ID for 'Direktorat SDM, Pendidikan, dan Pelatihan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);

        \App\Models\Unit::create([
            'nama' => 'Perencanaan dan Perbendaharaan',
            'keterangan' => 'Unit yang menangani perencanaan dan pengelolaan keuangan',
            'direktorat_id' => 3, // Assuming this is the ID for 'Direktorat SDM, Pendidikan, dan Pelatihan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);

        \App\Models\Unit::create([
            'nama' => 'Akuntansi dan Inventaris Aset',
            'keterangan' => 'Unit yang menangani akuntansi dan pengelolaan inventaris aset',
            'direktorat_id' => 3, // Assuming this is the ID for 'Direktorat SDM, Pendidikan, dan Pelatihan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);

        \App\Models\Unit::create([
            'nama' => 'Teknologi Informasi',
            'keterangan' => 'Unit yang menangani pengelolaan teknologi informasi',
            'direktorat_id' => 3, // Assuming this is the ID for 'Direktorat SDM, Pendidikan, dan Pelatihan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);

        \App\Models\Unit::create([
            'nama' => 'Operasional',
            'keterangan' => 'Unit yang menangani operasional',
            'direktorat_id' => 3, // Assuming this is the ID for 'Direktorat SDM, Pendidikan, dan Pelatihan'
            'struktural_id' => 3, // Assuming this is the ID for 'Manajer'
        ]);
    }
}
