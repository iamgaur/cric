<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('series', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 200);
			$table->dateTime('series_start_date')->nullable();
			$table->dateTime('series_end_date')->nullable();
			$table->timestamp('posted')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('slug', 100)->unique('slug');
			$table->integer('status');
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
		Schema::drop('series');
	}

}
