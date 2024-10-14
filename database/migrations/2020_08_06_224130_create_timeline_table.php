<?php

use App\Models\DashUser;
use App\Models\Order;
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
            $table->foreignIdFor(Order::class)->constrained('orders');
            $table->foreignIdFor(DashUser::class)->constrained('dash_users')->nullable();
            $table->string('text');
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
