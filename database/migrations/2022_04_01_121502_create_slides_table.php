<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string("SLID_IMGE"); //slide image
            $table->integer("SLID_ORDR")->default(0);
            $table->string("SLID_TITL")->nullable(); //title
            $table->string("SLID_SBTL")->nullable(); //subtitle
            $table->string("SLID_BTN_TEXT")->nullable(); //button text
            $table->string("SLID_BTN_URL")->nullable(); //button url
            $table->integer("SLID_ACTV")->default(0); //only last slides
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slides');
    }
}
