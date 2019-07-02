<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMatchTeamsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('match_teams', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('slug')->nullable();
			$table->integer('match_id');
			$table->integer('first_team');
			$table->integer('second_team');
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
		Schema::drop('match_teams');
	}

}
