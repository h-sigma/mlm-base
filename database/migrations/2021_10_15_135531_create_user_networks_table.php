<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_networks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('parent')->constrained('users');
            $table->foreignId('left_child')->constrained('users');
            $table->foreignId('right_child')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_networks');
    }
}
