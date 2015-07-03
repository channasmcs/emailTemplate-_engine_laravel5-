<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailtemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('emailtemplate', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('variables',255);
            $table->string('subject', 255);
            $table->longText('description');
            $table->timestamp('created_at');
            $table->enum('status', array('1', '0'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
