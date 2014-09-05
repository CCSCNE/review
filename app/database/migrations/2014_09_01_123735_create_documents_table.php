<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documents', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('name')->nullable();
            $table->string('saved_name')->nullable();
            $table->boolean('is_for_reviewers')->default(false);
            $table->boolean('is_for_authors')->default(false);
            //$table->morphs('container')->nullable();
            $table->string('container_type')->nullable();
            $table->integer('container_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
			$table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('documents');
	}

}
