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
        Schema::table('hasils', function (Blueprint $table) {
            $table->dropColumn(['signature_1', 'signature_2']);
            $table->json('signatures')->nullable()->after('hasil');
        });

        Schema::table('reseps', function (Blueprint $table) {
            $table->dropColumn(['signature_1', 'signature_2']);
            $table->json('signatures')->nullable()->after('resep');
        });
    }

    public function down(): void
    {
        Schema::table('hasils', function (Blueprint $table) {
            $table->dropColumn('signatures');
            $table->longText('signature_1')->nullable()->after('hasil');
            $table->longText('signature_2')->nullable()->after('signature_1');
        });

        Schema::table('reseps', function (Blueprint $table) {
            $table->dropColumn('signatures');
            $table->longText('signature_1')->nullable()->after('resep');
            $table->longText('signature_2')->nullable()->after('signature_1');
        });
    }
};
