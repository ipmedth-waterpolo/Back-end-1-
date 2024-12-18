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
        Schema::create('oefening', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('enabled')->default(true);
            $table->string('categorie');
            $table->string('onderdeel');
            $table->json('leeftijdsgroep'); // Voor JSON-velden
            $table->integer('duur');
            $table->integer('minimum_aantal_spelers');
            $table->text('benodigdheden');
            $table->boolean('water_nodig')->default(false);
            $table->text('omschrijving');
            $table->text('variatie')->nullable();
            $table->string('source')->nullable();
            $table->json('afbeeldingen')->nullable(); // JSON-array voor afbeeldingen
            $table->json('videos')->nullable(); // JSON-array voor video's
            $table->integer('rating')->nullable();
            $table->binary('icon')->nullable(); // For storing the icon as binary data (BLOB)
            $table->timestamps(); // Created_at en updated_at
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
