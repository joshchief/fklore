<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('event', function($table)
		{
			$table->increments('id');
			$table->string('ip', 40)->unique();
			$table->string('email', 100)->unique();
			$table->string('event', 100);
			$table->integer('sub_event');
			$table->integer('event_choice');
			$table->string('subscriber_key', 100)->unique();
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
		Schema::drop('event');
	}

}
