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
        $cities = json_decode(file_get_contents(resource_path('json/governorates.json')));
        foreach ($cities as $city) {
            Area::createArea($city->governorate_name_en, $city->governorate_name_ar, 40);
        }
    }
}
