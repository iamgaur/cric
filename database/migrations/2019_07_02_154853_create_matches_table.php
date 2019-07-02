<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMatchesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('matches', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('series_id')->unsigned();
			$table->string('match_title', 200);
			$table->string('result', 50);
			$table->dateTime('match_date')->nullable();
			$table->string('player_of_match', 50);
			$table->string('location', 50);
			$table->string('stadium', 50);
			$table->string('match_type', 100);
			$table->timestamp('posted')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('slug', 100);
			$table->string('meta_title', 200);
			$table->text('meta_description');
			$table->string('meta_keywords', 200);
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
		Schema::drop('matches');
	}

}
