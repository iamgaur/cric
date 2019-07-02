<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerTeamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('player_teams', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('pid');
			$table->integer('team_type');
			$table->integer('team_id');
			$table->dateTime('time_from')->nullable();
			$table->dateTime('time_to')->nullable();
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
		Schema::drop('player_teams');
	}

}
