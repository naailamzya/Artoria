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
        Schema::table('users', function (Blueprint $table) {
            // Check if columns don't exist before adding
            if (!Schema::hasColumn('users', 'brand_name')) {
                $table->string('brand_name')->nullable()->after('name');
            }
            
            if (!Schema::hasColumn('users', 'portfolio_url')) {
                $table->string('portfolio_url')->nullable()->after('brand_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop if columns exist
            if (Schema::hasColumn('users', 'brand_name')) {
                $table->dropColumn('brand_name');
            }
            
            if (Schema::hasColumn('users', 'portfolio_url')) {
                $table->dropColumn('portfolio_url');
            }
        });
    }
};