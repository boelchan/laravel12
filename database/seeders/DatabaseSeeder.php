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
            ['name' => 'user-list', 'guard_name' => 'web'],
            ['name' => 'user-tambah', 'guard_name' => 'web'],
            ['name' => 'user-edit', 'guard_name' => 'web'],
            ['name' => 'user-hapus', 'guard_name' => 'web'],
            ['name' => 'pasien-list', 'guard_name' => 'web'],
            ['name' => 'pasien-tambah', 'guard_name' => 'web'],
            ['name' => 'pasien-edit', 'guard_name' => 'web'],
            ['name' => 'pasien-hapus', 'guard_name' => 'web'],
            ['name' => 'pasien-aktifkan', 'guard_name' => 'web'],
            ['name' => 'pasien-riwayat-pemeriksaan', 'guard_name' => 'web'],
            ['name' => 'kunjungan-list', 'guard_name' => 'web'],
            ['name' => 'kunjungan-tambah', 'guard_name' => 'web'],
            ['name' => 'kunjungan-edit-status', 'guard_name' => 'web'],
            ['name' => 'kunjungan-edit-observasi', 'guard_name' => 'web'],
            ['name' => 'kunjungan-edit-pemeriksaan', 'guard_name' => 'web'],
            ['name' => 'apotek-list', 'guard_name' => 'web'],
            ['name' => 'laporan-kunjungan', 'guard_name' => 'web'],
            ['name' => 'laporan-pasien', 'guard_name' => 'web'],
        ]);

        $role = Role::create(
            ['name' => 'administrator', 'guard_name' => 'web'],
        );
        $role->givePermissionTo([
            'user-list',
            'user-tambah',
            'user-edit',
            'user-hapus',
        ]);

        $user = Role::create(
            ['name' => 'dokter', 'guard_name' => 'web'],
        );
        $user->givePermissionTo([
            'pasien-list',
            'pasien-tambah',
            'pasien-edit',
            'pasien-hapus',
            'pasien-aktifkan',
            'pasien-riwayat-pemeriksaan',
            'kunjungan-list',
            'kunjungan-tambah',
            'kunjungan-edit-status',
            'kunjungan-edit-observasi',
            'kunjungan-edit-pemeriksaan',
            'apotek-list',
            'laporan-kunjungan',
            'laporan-pasien',
        ]);

        $user = Role::create(
            ['name' => 'bidan', 'guard_name' => 'web'],
        );
        $user->givePermissionTo([
            'pasien-list',
            'pasien-tambah',
            'pasien-edit',
            'pasien-hapus',
            'pasien-aktifkan',
            'kunjungan-list',
            'kunjungan-tambah',
            'kunjungan-edit-status',
            'kunjungan-edit-observasi',
        ]);

        $user = Role::create(
            ['name' => 'apoteker', 'guard_name' => 'web'],
        );
        $user->givePermissionTo([
            'apotek-list',
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

    }
}
