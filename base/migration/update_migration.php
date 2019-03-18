<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class {{migration_name}} extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('{{table}}', function (Blueprint $table) {
            // start list droped column
            // end list droped column
        });

        Schema::table('{{table}}', function (Blueprint $table) {
            // start list new column
            // end list new column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
