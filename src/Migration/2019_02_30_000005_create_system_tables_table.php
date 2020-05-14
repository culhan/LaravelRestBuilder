<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSystemTablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{                
		Schema::create('system_tables', function(Blueprint $table)
		{
			$table->increments('id', true);
			$table->integer('project_id',false,true);
			$table->string('name')->index();                        
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
		Schema::drop('system_tables');
	}

}
