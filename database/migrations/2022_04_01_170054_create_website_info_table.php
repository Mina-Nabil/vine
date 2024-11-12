<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_info', function (Blueprint $table) {
            $table->id();
            $table->string("WBST_LOGO")->nullable();
            $table->string("WBST_MAIL")->nullable();
     
     
            $table->string("WBST_PHON")->nullable();
            $table->string("WBST_INST")->nullable();
            $table->string("WBST_FB")->nullable();
            
            $table->text("WBST_LAND")->nullable();
            
            $table->text("WBST_FOOT_LRG")->nullable();
            $table->text("WBST_FOOT_TTL")->nullable();
            $table->text("WBST_FOOT_SUB")->nullable();
            
            $table->text("WBST_FOOT_IMG1")->nullable();
            $table->text("WBST_FOOT_IMG2")->nullable();
            $table->text("WBST_FOOT_IMG3")->nullable();
            
            $table->text("WBST_ABUT")->nullable();
            $table->text("WBST_DPOL")->nullable();
            $table->text("WBST_PPOL")->nullable();
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_info');
    }
}
