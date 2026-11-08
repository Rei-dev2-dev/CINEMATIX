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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained('films')->cascadeOnDelete();
            $table->string('studio_name'); // e.g. "Studio 1", "Studio 2"
            $table->string('studio_type')->default('Reguler'); // e.g. "Reguler", "Premiere"
            $table->date('show_date');
            $table->string('show_time'); // e.g. "13.00", "16.15", "19.30"
            $table->decimal('price', 12, 2)->default(45000.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
