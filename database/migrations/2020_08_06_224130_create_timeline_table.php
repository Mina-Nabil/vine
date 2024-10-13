<?php

use App\Models\DashUser;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimelineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timeline', function (Blueprint $table) {
            $table->id();
            $table->foreignId('TMLN_ORDR_ID')->constrained('orders');
            $table->foreignIdFor(DashUser::class ,"TMLN_DASH_ID")->constrained('dash_users')->nullable();
            $table->string('TMLN_TEXT');
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table){
            $table->foreignId('return_id')->nullable()->constrained('orders');
            $table->foreignIdFor(DashUser::class)->nullable()->constrained('dash_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timeline');
    }
}
