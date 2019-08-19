<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulsTable extends Migration {

	public function __construct() {
		config(['database.connections.laravelrestbuilder_mysql'   =>  config('laravelrestbuilder.database')]);
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::connection('laravelrestbuilder_mysql')->create('moduls', function(Blueprint $table)
		{
			$table->increments('id', true);
			$table->string('name')->index();
            $table->text('detail');
			$table->softDeletes();
			$table->string('created_by')
				->nullable(false);
			$table->string('modified_by')
				->nullable();
			$table->string('deleted_by')
				->nullable();
			$table->string('created_from')
				->nullable(false);
			$table->string('modified_from')
				->nullable();
			$table->string('deleted_from')
				->nullable();
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
		Schema::connection('laravelrestbuilder_mysql')->drop('moduls');
	}

}
