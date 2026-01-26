<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
        ]);

        User::factory(100)->create();

        Role::create([
            'name' => 'administrator',
        ]);

        Role::create([
            'name' => 'dokter',
        ]);

        Role::create([
            'name' => 'perawat',
        ]);

        Role::create([
            'name' => 'pasien',
        ]);
        Role::create([
            'name' => 'operator',
        ]);
    }
}
