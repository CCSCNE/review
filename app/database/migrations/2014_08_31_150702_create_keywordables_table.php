<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('keywordables', function(Blueprint $table)
		{
            $table->integer('keyword_id')->unsigned();
            $table->foreign('keyword_id')->references('id')->on('keyword');
            $table->morphs('keywordable');
            $table->primary(array('keyword_id', 'keywordable_id', 'keywordable_type'));
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
		Schema::drop('keywordables');
	}

}
