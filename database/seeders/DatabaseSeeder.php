<?php

namespace Database\Seeders;

use App\Models\Direktorat;
use App\Models\JenisTenaga;
use App\Models\User;
use App\Models\Role;
use App\Models\Struktural;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@rsks.com',
            'password' => bcrypt('passwordrsks123'),
        ]);

        // Create roles
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'user',
            'guard_name' => 'web',
        ]);

        // Assign role to user
        $admin = User::where('name', 'admin')->first();
        $admin->assignRole('admin');


        // jenis tenaga
        JenisTenaga::create([
            'nama' => 'Tenaga Medis',
        ]);
        JenisTenaga::create([
            'nama' => 'Non Medis',
        ]);
        JenisTenaga::create([
            'nama' => 'Tenaga Kesehatan',
        ]);

        // struktur organisasi
        Struktural::create([
            'nama' => 'Direktur Utama',
        ]);
        Struktural::create([
            'nama' => 'Direktur',
        ]);
        Struktural::create([
            'nama' => 'Manajer',
        ]);

        // direktorat
        Direktorat::create([
            'nama' => 'Direktorat Medik dan Keperawatan',
            'struktural_id' => 2, // Assuming 'Direktur' is the second structural level
        ]);
        Direktorat::create([
            'nama' => 'Direktorat SDM Pendidikan dan Pelatihan',
            'struktural_id' => 2, // Assuming 'Direktur' is the second structural level
        ]);
        Direktorat::create([
            'nama' => 'Direktorat Perencanaan Keuangan dan Layanan Operasional',
            'struktural_id' => 2, // Assuming 'Direktur' is the second structural level
        ]);



        $this->call(
            [
                FungsionalSeeder::class,
                StatusKepegawaianSeeder::class,
                UnitSeeder::class,
            ]
        );
    }
}
