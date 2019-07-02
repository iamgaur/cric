<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('players', function(Blueprint $table)
		{
			$table->integer('pid', true);
			$table->string('player_name', 100);
			$table->string('p_slug', 100);
			$table->string('c_slug', 100);
			$table->text('player_bio', 65535);
			$table->timestamp('player_born')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('player_nickname', 100);
			$table->string('player_playing_role', 50);
			$table->string('player_playing_batting', 50);
			$table->string('player_playing_bowling', 50);
			$table->string('player_fielding_position', 100);
			$table->string('meta_title', 200);
			$table->text('meta_description');
			$table->string('meta_keywords', 200);
			$table->timestamps();
			$table->primary(['p_slug','c_slug']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('players');
	}

}
