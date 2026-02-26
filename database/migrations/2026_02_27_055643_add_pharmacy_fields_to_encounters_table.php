<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('encounters', function (Blueprint $table) {
            $table->dateTime('obat_diambil_at')->nullable()->after('finished_at');
            $table->text('catatan_farmasi')->nullable()->after('obat_diambil_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('encounters', function (Blueprint $table) {
            $table->dropColumn(['obat_diambil_at', 'catatan_farmasi']);
        });
    }
};
