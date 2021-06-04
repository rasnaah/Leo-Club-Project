<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dp', function (Blueprint $table) {
            //  $table->id();
            $table->bigIncrements('id');
            $table->text('dp');
            /*$table->rememberToken();*/
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
        Schema::dropIfExists('dp');
    }
}
