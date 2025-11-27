<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'member', 'curator'])
                  ->default('member')
                  ->after('password');
            
            $table->enum('status', ['active', 'pending', 'suspended'])
                  ->default('active')
                  ->after('role');
            
            $table->string('display_name')->nullable()->after('name');
            $table->string('profile_picture')->nullable()->after('display_name');
            $table->text('bio')->nullable()->after('profile_picture');
            
            $table->string('instagram_link')->nullable()->after('bio');
            $table->string('github_link')->nullable()->after('instagram_link');
            
            $table->index('role');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'status',
                'display_name',
                'profile_picture',
                'bio',
                'instagram_link',
                'github_link',
            ]);
        });
    }
};