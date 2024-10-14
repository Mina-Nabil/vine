<?php

use App\Models\DashUser;
use App\Models\Inventory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("code");
            $table->foreignIdFor(Inventory::class)->constrained("inventory");
            $table->foreignIdFor(DashUser::class)->constrained('dash_users');
            $table->integer("in")->default(0);
            $table->integer("out")->default(0);
            $table->integer("balance");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_transactions');
    }
}
