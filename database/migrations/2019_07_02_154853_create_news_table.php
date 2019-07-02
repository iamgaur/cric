<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title', 100);
			$table->text('description', 65535);
			$table->string('tags', 200);
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
		Schema::drop('news');
	}

}
