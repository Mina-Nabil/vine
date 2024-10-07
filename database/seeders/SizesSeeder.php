<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;

class SizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Size::create("Large", "لارج", "L");
        Size::create("Medium", "ميديوم", "M");
        Size::create("Small", "سمال", "S");
    }
}
