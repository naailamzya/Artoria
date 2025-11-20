<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenge_winners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->onDelete('cascade');
            $table->foreignId('submission_id')->constrained('challenge_submissions')->onDelete('cascade');
            $table->integer('rank'); // Juara 1, 2, 3, dst
            $table->timestamps();

            $table->unique(['challenge_id', 'submission_id']);

            $table->index(['challenge_id', 'rank']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_winners');
    }
};