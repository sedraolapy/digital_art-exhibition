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
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('exhibitor_id')
                ->constrained('exhibitor_profiles')
                ->onDelete('cascade');
            $table->foreignId('event_occurrence_id')
                ->constrained('events_occurrences')
                ->onDelete('cascade');
            $table->unique(['user_id', 'exhibitor_id', 'event_occurrence_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('votes');
    }
};
