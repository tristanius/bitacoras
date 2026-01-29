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
        Schema::create('aircraft_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Ej: Monomotor, Bimotor, Helicóptero
            $table->text('description')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft_categories');
    }
};
