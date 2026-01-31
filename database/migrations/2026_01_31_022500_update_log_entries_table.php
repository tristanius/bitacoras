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
       Schema::table('log_entries', function (Blueprint $table) {
            $table->dropColumn('logbook_id'); // Ya no agrupamos por carpetas
            $table->boolean('validated')->default(false); // El "OK" del instructor
            $table->unsignedBigInteger('instructor_id')->nullable()->change(); // Opcional
            $table->boolean('is_active')->default(true); // Para no borrar, solo invalidar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
