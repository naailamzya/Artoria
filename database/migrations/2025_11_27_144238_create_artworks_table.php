<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artworks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->foreignId('category_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path');
            
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('views_count')->default(0);
            
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('category_id');
            $table->index('created_at');
            $table->index('likes_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artworks');
    }
};