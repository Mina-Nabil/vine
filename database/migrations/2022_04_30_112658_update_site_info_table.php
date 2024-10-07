<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSiteInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('website_info', function (Blueprint $table){
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
        Schema::table('website_info', function (Blueprint $table){
            $table->dropColumn("WBST_DPOL");
            $table->dropColumn("WBST_PPOL");
        });
    }
}
