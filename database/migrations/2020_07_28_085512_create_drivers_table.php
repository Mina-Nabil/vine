<?php

use App\Models\Driver;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->string("mobn")->unique();
            $table->tinyInteger("is_active")->default(1);
        });

        Schema::table("orders", function (Blueprint $table){
            $table->foreignIdFor(Driver::class)->nullable()->constrained("drivers");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("orders", function (Blueprint $table){
            $table->dropForeign("orders_driver_id_foreign");
            $table->dropColumn("driver_id");
        });
        Schema::dropIfExists('drivers');
    }
}
