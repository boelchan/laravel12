<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateIndonesiaRegionsTable extends Migration
{
    public function up()
    {
        Schema::create('indonesia_regions', function (Blueprint $table) {
            $table->string('code')->primary();
            $table->string('name');
            $table->string('postal_code')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('status')->nullable();

            // Basic indexes
            $table->index('name');
            $table->index('postal_code');
        });

        // Add function-based indexes based on database driver
        $driver = DB::getDriverName();

        switch ($driver) {
            case 'mysql':
                // Menggunakan prefix index (code(n)) yang kompatibel dengan MySQL 5.7+, 8.0, dan MariaDB
                DB::statement('CREATE INDEX idx_region_code_province ON indonesia_regions (code(2))');
                DB::statement('CREATE INDEX idx_region_code_city ON indonesia_regions (code(5))');
                DB::statement('CREATE INDEX idx_region_code_district ON indonesia_regions (code(8))');

                // Index untuk LENGTH memerlukan MySQL 8.0.13+. Kita bungkus try-catch agar tidak error di MariaDB/MySQL lama.
                try {
                    DB::statement('CREATE INDEX idx_region_code_length ON indonesia_regions((LENGTH(code)))');
                } catch (\Throwable $e) {
                    // Lewati jika tidak didukung
                }
                break;

            case 'pgsql':
                DB::statement('CREATE INDEX idx_region_code_length ON indonesia_regions (LENGTH(code))');
                DB::statement('CREATE INDEX idx_region_code_province ON indonesia_regions (SUBSTRING(code FROM 1 FOR 2))');
                DB::statement('CREATE INDEX idx_region_code_city ON indonesia_regions (SUBSTRING(code FROM 1 FOR 5))');
                DB::statement('CREATE INDEX idx_region_code_district ON indonesia_regions (SUBSTRING(code FROM 1 FOR 8))');
                break;

            case 'sqlite':
                // SQLite doesn't support function-based indexes, so we'll skip them
                break;

            case 'sqlsrv':
                DB::statement('CREATE INDEX idx_region_code_length ON indonesia_regions (LEN(code))');
                DB::statement('CREATE INDEX idx_region_code_province ON indonesia_regions (LEFT(code, 2))');
                DB::statement('CREATE INDEX idx_region_code_city ON indonesia_regions (LEFT(code, 5))');
                DB::statement('CREATE INDEX idx_region_code_district ON indonesia_regions (LEFT(code, 8))');
                break;
        }
    }

    public function down()
    {
        Schema::dropIfExists('indonesia_regions');
    }
}
