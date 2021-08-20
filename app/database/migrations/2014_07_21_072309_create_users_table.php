<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('username', 60)->unique();
			$table->string('display_name', 60);
			$table->string('email', 100)->unique();
			$table->string('password', 60);
			$table->string('first_name', 20);
			$table->string('last_name', 20);
			$table->string('gender', 6);
			$table->dateTime('birthday');
			$table->string('remember_token', 100);
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
		Schema::drop('users');
	}

}
