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
        Schema::create('oefening_training', function (Blueprint $table) {
            $table->id();
            // Foreign key to the 'training' table
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            // Foreign key to the 'oefening' table
            $table->foreignId('oefening_id')->constrained()->onDelete('cascade');
            // Timestamps for tracking creation and updates
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'oefening_training' table
        Schema::dropIfExists('oefening_training');
    }
};
