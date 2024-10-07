<?php

use App\Models\Area;
use App\Models\DashUser;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('payment_options', function (Blueprint $table) {
        //     $table->id();
        //     $table->string("PYOP_NAME")->unique();
        //     $table->string("PYOP_ARBC_NAME");
        //     $table->tinyInteger("PYOP_ACTV")->default(1);
        // });

        Schema::create('order_status', function (Blueprint $table) {
            $table->id();
            $table->string("STTS_NAME")->unique();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained("users");
            $table->dateTime("delivery_date")->nullable();
            $table->string("guest_name")->nullable();
            $table->string("guest_mobn")->nullable();
            $table->string("address");
            $table->foreignIdFor(Area::class)->constrained("areas");
            // $table->foreignId("ORDR_PYOP_ID")->constrained("payment_options");
            $table->double("total");
            $table->string("note")->nullable();
            $table->double("paid")->default(0);
            $table->foreignIdFor(DashUser::class, 'collected_by_id')->constrained('dash_users');
            $table->enum('status', Order::STATUSES)->default('new');
            $table->timestamps();
        });

        Schema::create('order_items', function(Blueprint $table){
            $table->id();
            $table->foreignIdFor(Order::class)->constrained("orders");
            $table->foreignIdFor(Inventory::class)->constrained("inventory");
            $table->tinyInteger("amount")->default(1);
        });

        Schema::table('inventory_transactions', function(Blueprint $table){
            $table->foreignIdFor(Order::class)->nullable()->constrained("orders");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inventory_transactions', function(Blueprint $table){
            $table->dropForeign("inventory_transactions_intr_ordr_id_foreign");
            $table->dropColumn("INTR_ORDR_ID");
        });
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_status');
        Schema::dropIfExists('payment_options');
    }
}
