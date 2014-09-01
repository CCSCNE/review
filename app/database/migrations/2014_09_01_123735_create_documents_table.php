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
            $table->string('name');
            $table->string('saved_name');
            $table->boolean('camera_ready')->default(false);
            $table->boolean('author_can_read')->default(false);
            $table->boolean('reviewer_can_read')->default(false);
            $table->boolean('all_can_read')->default(false);
            $table->morphs('container');
            $table->integer('user_id')->unsigned();
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
