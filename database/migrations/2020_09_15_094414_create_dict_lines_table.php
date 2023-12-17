<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_lines', function (Blueprint $table) {
            $table->Bigincrements('id');
            $table->integer('branch_id')->unsigned();
            $table->integer('substation_id')->unsigned();
            $table->integer('line_id')->unsigned();            
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('dict_branches')->onDelete('cascade');
            $table->foreign('substation_id')->references('id')->on('dict_substations')->onDelete('cascade');
            $table->unique(['branch_id','substation_id','id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_lines');
    }
}
