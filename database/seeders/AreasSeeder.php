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
        Area::createArea("El Rehab", "الرحاب", 40);
        Area::createArea("5th District", "التجمع الخامس", 40);
        Area::createArea("Masr El Gdeeda", "مصر الجديده", 40);
    }
}
