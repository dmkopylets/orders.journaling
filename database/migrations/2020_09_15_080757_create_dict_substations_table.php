<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDictSubstationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dict_substations', function (Blueprint $table) {
            $table->Bigincrements('id');
            $table->integer('branch_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->string('body');
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('dict_branches')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('dict_station_types')->onDelete('cascade');
            $table->unique(['branch_id','type_id','id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dict_substations');
    }
}
