<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Area::create("El Rehab", "الرحاب", 40);
        Area::create("5th District", "التجمع الخامس", 40);
        Area::create("Masr El Gdeeda", "مصر الجديده", 40);
    }
}
