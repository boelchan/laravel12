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
        // dummy user
        User::factory(100)->create();

        // dummy role
        Role::insert([
            ['name' => 'administrator', 'guard_name' => 'web'],
            ['name' => 'dokter', 'guard_name' => 'web'],
            ['name' => 'perawat', 'guard_name' => 'web'],
            ['name' => 'pasien', 'guard_name' => 'web'],
            ['name' => 'operator', 'guard_name' => 'web'],
        ]);

        // dummy admin
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('123'),
        ]);
        $user->assignRole('administrator');
    }
}
