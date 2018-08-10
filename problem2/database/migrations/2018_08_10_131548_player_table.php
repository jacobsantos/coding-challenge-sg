<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlayerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('player', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('player_id')->unique();
			$table->string('name');
			$table->float('credits');
			$table->integer('lifetime_spins');
			$table->string('salt_value');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::dropIfExists('player');
    }
}
