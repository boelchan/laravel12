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
        Schema::create('encounters', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->foreignId('patient_id')->constrained('patients');
            $table->date('visit_date');
            $table->dateTime('arrived_at')->nullable();
            $table->dateTime('inprogress_at')->nullable();
            $table->dateTime('finished_at')->nullable();    
            $table->string('chief_complaint', 250)->nullable();
            $table->string('problem_list_item', 250)->nullable();
            $table->string('diagnosis', 250)->nullable();
            $table->integer('practitioner_id')->nullable()->index();
            $table->enum('status', ['registered', 'arrived', 'inprogress', 'finished', 'cancelled'])->default('registered');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {   
        Schema::dropIfExists('encounters');
    }
};
