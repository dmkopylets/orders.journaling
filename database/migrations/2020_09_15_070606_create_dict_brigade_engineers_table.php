<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictBrigadeEngineersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_brigade_engineers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id')->unsigned();        
            $table->string('body');
            $table->string('specialization');                
            $table->string('group');
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('dict_branches')->onDelete('cascade');
            $table->unique(['branch_id','id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_brigade_engineers');
    }
}
