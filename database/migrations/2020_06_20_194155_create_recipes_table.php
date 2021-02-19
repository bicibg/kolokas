<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');
            $table->text('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('ingredients');
            $table->text('instructions');
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('prep_time')->default(0)->nullable();   //minutes
            $table->unsignedBigInteger('cook_time')->default(0)->nullable();   //minutes
            $table->text('servings')->nullable();       //how many servings
            $table->boolean('published')->default(false);
            $table->boolean('featured')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
