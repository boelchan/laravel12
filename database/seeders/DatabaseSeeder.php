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
        
        $this->call([
            IndonesiaRegionSeeder::class
        ]);
        
        Permission::insert([
            ['name' => 'list-user', 'guard_name' => 'web'],
            ['name' => 'tambah-user', 'guard_name' => 'web'],
            ['name' => 'edit-user', 'guard_name' => 'web'],
            ['name' => 'hapus-user', 'guard_name' => 'web'],
            ['name' => 'list-pasien', 'guard_name' => 'web'],
            ['name' => 'tambah-pasien', 'guard_name' => 'web'],
            ['name' => 'edit-pasien', 'guard_name' => 'web'],
            ['name' => 'hapus-pasien', 'guard_name' => 'web'],
            ['name' => 'list-kunjungan', 'guard_name' => 'web'],
            ['name' => 'tambah-kunjungan', 'guard_name' => 'web'],
            ['name' => 'edit-status-kunjungan', 'guard_name' => 'web'],
            ['name' => 'edit-observasi', 'guard_name' => 'web'],
            ['name' => 'edit-pemeriksaan', 'guard_name' => 'web'],
            ['name' => 'lihat-observasi', 'guard_name' => 'web'],
            ['name' => 'lihat-hasil', 'guard_name' => 'web'],
            ['name' => 'lihat-resep', 'guard_name' => 'web'],
            ['name' => 'aktifkan-pasien', 'guard_name' => 'web'],
        ]);

        $role = Role::create(
            ['name' => 'administrator', 'guard_name' => 'web'],
        );
        $role->givePermissionTo([
            'list-user',
            'tambah-user',
            'edit-user',
            'hapus-user',
        ]);

        $user = Role::create(
            ['name' => 'dokter', 'guard_name' => 'web'],
        );
        $user->givePermissionTo([
            'list-pasien',
            'tambah-pasien',
            'edit-pasien',
            'hapus-pasien',
            'list-kunjungan',
            'tambah-kunjungan',
            'edit-status-kunjungan',
            'edit-observasi',
            'edit-pemeriksaan',
            'lihat-observasi',
            'lihat-hasil',
            'lihat-resep',
            'aktifkan-pasien',
        ]);

        $user = Role::create(
            ['name' => 'bidan', 'guard_name' => 'web'],
        );
        $user->givePermissionTo([
            'list-pasien',
            'tambah-pasien',
            'edit-pasien',
            'hapus-pasien',
            'list-kunjungan',
            'tambah-kunjungan',
            'edit-status-kunjungan',
            'edit-observasi',
            'lihat-observasi',
        ]);

        $user = Role::create(
            ['name' => 'apoteker', 'guard_name' => 'web'],
        );
        $user->givePermissionTo([
            'lihat-resep',
        ]);

        // dummy admin
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('123'),
        ]);
        $user->assignRole('administrator');
        $user->assignRole('dokter');

        $user = User::create([
            'name' => 'Bidan',
            'email' => 'bidan@app.com',
            'password' => bcrypt('123'),
        ]);
        $user->assignRole('bidan');

        Patient::create([
            'uuid' => Str::uuid(),
            'medical_record_number' => 'RM-00001',
            'full_name' => 'Mainuma',
            'gender' => '2',
            'birth_date' => '2000-01-01',
            'address' => 'Jl. Mainuma',
            'village_code' => '3529012013',
            'phone' => '08123456789',
            'email' => 'mainuma@app.com',
            'created_by' => 1,
        ]);

        Patient::create([
            'uuid' => Str::uuid(),
            'nik' => '1234567890123456',
            'medical_record_number' => 'RM-00002',
            'full_name' => 'Fatima',
            'gender' => '2',
            'birth_date' => '1992-06-01',
            'address' => 'Jl. imam bonjol',
            'village_code' => '3529012009',
            'phone' => '08123456789',
            'email' => 'mainuma@app.com',
            'created_by' => 1,
        ]);

    }
}
