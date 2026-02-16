<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->index('slug');
            $table->index('published');
            $table->index('featured');
            $table->index(['published', 'featured']);
            $table->index('created_at');
        });

        Schema::table('favourites', function (Blueprint $table) {
            $table->index('favourited_id');
        });

        Schema::table('visits', function (Blueprint $table) {
            $table->index('visited_id');
        });

        if (Schema::hasTable('category_recipe')) {
            Schema::table('category_recipe', function (Blueprint $table) {
                $table->index('recipe_id');
                $table->index('category_id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropIndex(['published']);
            $table->dropIndex(['featured']);
            $table->dropIndex(['published', 'featured']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('favourites', function (Blueprint $table) {
            $table->dropIndex(['favourited_id']);
        });

        Schema::table('visits', function (Blueprint $table) {
            $table->dropIndex(['visited_id']);
        });

        if (Schema::hasTable('category_recipe')) {
            Schema::table('category_recipe', function (Blueprint $table) {
                $table->dropIndex(['recipe_id']);
                $table->dropIndex(['category_id']);
            });
        }
    }
};
