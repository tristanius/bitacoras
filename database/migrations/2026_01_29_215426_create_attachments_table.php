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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('name');      // Ejemplo: "foto_vuelo.jpg"
            $table->string('path');      // Ejemplo: "attachments/archivo.jpg"
            $table->string('mime_type'); 
            
            // REEMPLAZA pilot_id POR ESTOS DOS:
            $table->unsignedBigInteger('attachable_id'); // ID del registro (sea piloto o vuelo)
            $table->string('attachable_type');           // Clase del modelo (User o LogEntry)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment');
    }
};
