<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenge_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->foreignId('artwork_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->boolean('is_winner')->default(false);
            $table->timestamps();
            
            $table->unique(['challenge_id', 'artwork_id']);
            
            $table->index('challenge_id');
            $table->index('user_id');
            $table->index('is_winner');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_entries');
    }
};