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
        Schema::create('log_entries', function (Blueprint $table) {
            $table->id();
            // RELACIONES (El LogEntry ahora pertenece a un Logbook)
            $table->foreignId('logbook_id')->constrained()->onDelete('cascade');
            $table->foreignId('pilot_id')->constrained('users');
            $table->foreignId('aircraft_id')->constrained();
            $table->foreignId('origin_id')->constrained('airports');
            $table->foreignId('destination_id')->constrained('airports');
            $table->foreignId('instructor_id')->nullable()->constrained('users');

            // FECHA Y TIEMPOS (GUI)
            $table->date('date');
            $table->decimal('hobbs_out', 8, 2);
            $table->decimal('hobbs_in', 8, 2);
            $table->decimal('total_time', 8, 2);

            // TYPE OF PILOTING TIME (PDF)
            $table->decimal('pic_time', 8, 2)->default(0);
            $table->decimal('sic_time', 8, 2)->default(0);
            $table->decimal('solo_time', 8, 2)->default(0);
            $table->decimal('dual_time', 8, 2)->default(0);
            $table->decimal('cfi_time', 8, 2)->default(0);
            $table->decimal('simulator_time', 8, 2)->default(0);
            
            // CONDITIONS & IFR (PDF)
            $table->decimal('xc_time', 8, 2)->default(0);
            $table->decimal('night_time', 8, 2)->default(0);
            $table->decimal('instr_actual', 8, 2)->default(0);
            $table->decimal('instr_sim', 8, 2)->default(0);
            $table->integer('approaches')->default(0);
            $table->integer('holds')->default(0);
            
            // OPERACIÓN Y FIRMA
            $table->integer('landings_day')->default(1);
            $table->integer('landings_night')->default(0);
            $table->dateTime('instructor_certified_at')->nullable();
            $table->text('remarks')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_entries');
    }
};
