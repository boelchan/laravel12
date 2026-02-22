<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
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
        Permission::insert([
            ['name' => 'user.index', 'guard_name' => 'web'],
            ['name' => 'user.create', 'guard_name' => 'web'],
            ['name' => 'user.edit', 'guard_name' => 'web'],
            ['name' => 'user.destroy', 'guard_name' => 'web'],
        ]);
        Role::first()->givePermissionTo(Permission::all());

        // dummy admin
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('123'),
        ]);
        $user->assignRole('administrator');

        Patient::create([
            'uuid' => Str::uuid(),
            'medical_record_number'=> 'RM-00001',
            'full_name' => 'Mainuma',
            'gender'=> '2',
            'birth_date'=> '2000-01-01',
            'address'=> 'Jl. Mainuma',
            'phone'=> '08123456789',
            'email'=> 'mainuma@app.com',
            'created_by'=> 1,
        ]);

        Patient::create([
            'uuid' => Str::uuid(),
            'nik' => '1234567890123456',
            'medical_record_number'=> 'RM-00002',
            'full_name' => 'Fatima',
            'gender'=> '2',
            'birth_date'=> '1992-06-01',
            'address'=> 'Jl. imam bonjol',
            'phone'=> '08123456789',
            'email'=> 'mainuma@app.com',
            'created_by'=> 1,
        ]);

        $this->call([
            IndonesiaRegionSeeder::class
        ]);
    }
}
