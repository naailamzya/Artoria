<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curator_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            $table->string('title');
            $table->text('description');
            $table->text('rules')->nullable();
            $table->text('prizes')->nullable();
            $table->string('banner_image')->nullable();
            
            $table->date('start_date');
            $table->date('end_date');
            
            $table->enum('status', ['draft', 'active', 'ended'])
                  ->default('draft');
            
            $table->timestamps();
            
            $table->index('curator_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};