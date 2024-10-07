<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table("payment_options")->insert([
        //     'id'    =>  1,
        //     "PYOP_NAME" => "Cash On Delivery",
        //     "PYOP_ARBC_NAME" => "كاش"
        // ]);


        // DB::table("payment_options")->insert([
        //     "PYOP_NAME" => "Credit Card",
        //     "PYOP_ARBC_NAME" => "بطاقه ائتمان"
        // ]);

        // DB::table("payment_options")->insert([
        //     "PYOP_NAME" => "Credit Card On Delivery",
        //     "PYOP_ARBC_NAME" => "بطاقه ائتمان عند التوصيل"
        // ]);
    }
}
