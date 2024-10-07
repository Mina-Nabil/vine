<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("categories")->insert([
            "CATG_NAME" => "Men",
            "CATG_ARBC_NAME" => "رجالي",
        ]);

        DB::table("categories")->insert([
            "CATG_NAME" => "Women",
            "CATG_ARBC_NAME" => "حريمي",
        ]);
    }
}
