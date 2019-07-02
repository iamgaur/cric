<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMatchSquadTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('match_squad', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('match_id');
			$table->string('slug');
			$table->integer('first_team');
			$table->integer('second_team');
			$table->text('first_players_json', 65535)->nullable();
			$table->text('second_players_json', 65535)->nullable();
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
		Schema::drop('match_squad');
	}

}
