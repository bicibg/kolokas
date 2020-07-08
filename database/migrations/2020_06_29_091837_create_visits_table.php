<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string("session_id");
            $table->unsignedInteger('visited_id');
            $table->string('visited_type', 50);
            $table->string("ip");
            $table->string("agent");
            $table->foreignId('user_id')->nullable();
            $table->timestamps();

            $table->unique(['session_id', 'visited_id', 'visited_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
