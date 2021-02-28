<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('medias', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('app_id')->nullable();
			$table->string('name')->nullable();
			$table->string('fs_driver')->nullable();
			$table->string('media_id')->nullable();
			$table->string('path')->nullable();
			$table->string('media_hash')->nullable();
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
		Schema::drop('medias');
	}

}
