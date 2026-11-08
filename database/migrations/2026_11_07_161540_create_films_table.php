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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('genre')->default('Drama');
            $table->integer('duration')->comment('Duration in minutes');
            $table->decimal('rating', 3, 1)->default(4.5);
            $table->string('age_rating', 10)->default('13+');
            $table->string('director')->nullable();
            $table->string('cast')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('poster_color', 50)->default('#1F1F1F');
            $table->string('poster_path')->nullable();
            $table->string('poster_url')->nullable();
            $table->string('banner_url')->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('status', 30)->default('now_showing'); // 'now_showing', 'coming_soon'
            $table->boolean('is_featured')->default(false);
            $table->date('release_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
