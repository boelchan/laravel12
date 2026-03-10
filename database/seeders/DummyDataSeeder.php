<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Encounter;
use App\Models\VitalSign;
use App\Models\Anthropometry;
use App\Models\Hasil;
use App\Models\Resep;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $user = User::first();
        $userId = $user ? $user->id : 1;

        // 1. Create 100 Patients
        $this->command->info('Creating 100 Patients...');
        for ($i = 0; $i < 100; $i++) {
            Patient::create([
                'uuid' => Str::uuid(),
                'medical_record_number' => Patient::generateMedicalRecordNumber(),
                'nik' => $faker->unique()->numerify('################'),
                'full_name' => $faker->name,
                'birth_date' => $faker->date('Y-m-d', '2010-01-01'),
                'birth_place' => $faker->city,
                'gender' => $faker->randomElement([1, 2]),
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'is_active' => true,
                'created_by' => $userId,
            ]);
        }

        // 2. Create 200 Encounters
        $this->command->info('Creating 100 Encounters...');
        $patients = Patient::all();
        $statuses = ['registered', 'arrived', 'inprogress', 'finished', 'cancelled'];

        for ($i = 0; $i < 100; $i++) {
            $status = $faker->randomElement($statuses);
            $visitDate = Carbon::now()->addDays(rand(1, 30));
            
            $arrivedAt = in_array($status, ['arrived', 'inprogress', 'finished']) ? $visitDate->copy()->addHours(rand(1, 4)) : null;
            $inprogressAt = in_array($status, ['inprogress', 'finished']) ? ($arrivedAt ? $arrivedAt->copy()->addMinutes(rand(15, 60)) : null) : null;
            $finishedAt = ($status === 'finished') ? ($inprogressAt ? $inprogressAt->copy()->addMinutes(rand(30, 120)) : null) : null;

            $encounter = Encounter::create([
                'uuid' => Str::uuid(),
                'patient_id' => $patients->random()->id,
                'visit_date' => $visitDate->format('Y-m-d'),
                'arrived_at' => $arrivedAt,
                'inprogress_at' => $inprogressAt,
                'finished_at' => $finishedAt,
                'status' => $status,
                'no_antrian' => $faker->numberBetween(1, 100),
                'created_by' => $userId,
                'chief_complaint' => $faker->sentence,
                'diagnosis' => $status === 'finished' ? $faker->word . ' ' . $faker->word : null,
                'obat_diambil_at' => ($status === 'finished' && $faker->boolean(70)) ? ($finishedAt ? $finishedAt->copy()->addMinutes(rand(10, 60)) : null) : null,
                'catatan_farmasi' => ($status === 'finished' && $faker->boolean(30)) ? $faker->sentence : null,
            ]);

            // Add clinical data for those who arrived/checked
            if (in_array($status, ['arrived', 'inprogress', 'finished'])) {
                VitalSign::create([
                    'encounter_id' => $encounter->id,
                    'systolic' => rand(110, 140),
                    'diastolic' => rand(70, 90),
                    'heart_rate' => rand(60, 100),
                    'respiratory_rate' => rand(16, 24),
                    'body_temperature' => $faker->randomFloat(1, 36, 38),
                    'created_by' => $userId,
                ]);

                Anthropometry::create([
                    'encounter_id' => $encounter->id,
                    'body_height' => rand(150, 180),
                    'body_weight' => rand(45, 90),
                    'created_by' => $userId,
                ]);
            }

            // Fill prescription and results for finished encounters
            if ($status === 'finished') {
                // Hasil (Text)
                Hasil::create([
                    'encounter_id' => $encounter->id,
                    'tipe' => 'text',
                    'hasil' => "Anamnesi: " . $faker->paragraph . "\n\nPlanning: " . $faker->paragraph,
                    'created_by' => $userId,
                ]);

                // Hasil (Draw/Signature placeholder)
                Hasil::create([
                    'encounter_id' => $encounter->id,
                    'tipe' => 'draw',
                    'signatures' => ['data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='], // 1x1 base64 pixel
                    'created_by' => $userId,
                ]);

                // Resep (Text)
                Resep::create([
                    'encounter_id' => $encounter->id,
                    'tipe' => 'text',
                    'resep' => "R/ Paracetamol 500mg No. X\nS 3 dd 1 tab prn panas\n\nR/ Amoxicillin 500mg No. XV\nS 3 dd 1 tab habiskan",
                    'created_by' => $userId,
                ]);

                // Resep (Draw/Signature placeholder)
                Resep::create([
                    'encounter_id' => $encounter->id,
                    'tipe' => 'draw',
                    'signatures' => ['data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg=='],
                    'created_by' => $userId,
                ]);
            }
        }

        $this->command->info('Dummy data seeding completed!');
    }
}
