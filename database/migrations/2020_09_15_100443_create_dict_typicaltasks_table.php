<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictTypicaltasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_typicaltasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('works_specs_id')->unsigned();
            $table->text('body');
            $table->timestamps();
            $table->foreign('works_specs_id')->references('id')->on('dict_works_specs')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_typicaltasks');
    }
}
