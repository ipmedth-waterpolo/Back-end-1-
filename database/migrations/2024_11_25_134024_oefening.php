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
        Schema::create('oefeningen', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('enabled')->default(true); // Default true voor enabled
            $table->string('categorie');
            $table->string('onderdeel');
            $table->enum('leeftijdsgroep', ['15', '16', '17', '18', '19', '20']); // Enum met leeftijdsgroepen
            $table->integer('duur'); // Correct datatype
            $table->integer('minimum_aantal_spelers');
            $table->text('benodigdheden');
            $table->boolean('water_nodig')->default(false); // Default false voor water_nodig
            $table->text('omschrijving');
            $table->text('variatie')->nullable(); // Correct nullable gebruik
            $table->string('source')->nullable(); // Voor eventueel een bron
            $table->json('afbeeldingen')->nullable(); // Voor afbeeldingen als JSON-array
            $table->json('videos')->nullable(); // Voor video's als JSON-array
            $table->integer('rating')->nullable(); // Rating kan nullable zijn
            $table->timestamps(); // Automatisch created_at en updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oefening');
    }
};
