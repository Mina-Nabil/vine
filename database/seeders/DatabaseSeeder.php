<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Driver;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(UsersSeeder::class);
        $this->call(AreasSeeder::class);
        if (!App::isProduction()) {
            User::createUser("Mina Nabil", 'mina@hot.com', 1, 1, "012230110", "Jayd D82, 42", "test");
            Category::newCategory("Banners", "بانر");
            SubCategory::createNew(
                "Timeline",
                "الخط الزمني",
                1,
                null,
                "test"
            );
            Product::create(
                "Bible timeline",
                "الخط الزمني للكتاب",
                "Shar7 wafy baseet",
                "شرح وافي بسيط",
                1,
                1200,
                "خشب زان",
                "5 * 5",
                "العهد القديم و تاريخ الكتاب",
                200
            );
            Product::create(
                "Church timeline",
                "الخط الزمني للكنيسه",
                "Shar7 wafy baseet lel knisa",
                "شرح وافي بسيط قوي",
                1,
                500,
                "ورق ملون",
                "5 * 5",
                "العهد القديم و تاريخ الكتاب",
            );

            Category::newCategory("Material", "تحضير");
            SubCategory::createNew(
                "Secondary School",
                "تحضير لثانوي",
                2,
                null,
                "test"
            );

            Product::create(
                "Tagasod el kelma",
                "تجسد الكلمه",
                "Shar7 wafy baseet lel knisa",
                "شرح وافي بسيط قوي",
                2,
                40,
                "ورق ملون",
                "5 * 5",
                "العهد القديم و تاريخ الكتاب",
            );

            Inventory::insertEntry(
                [
                    ['modelID'  => 1, 'count' => 50],
                    ['modelID'  => 2, 'count' => 13],
                    ['modelID'  => 3, 'count' => 1000],
                ]
            );
            $newDriver = new Driver();
            $newDriver->name = "Bareed";
            $newDriver->save();
        }
    }
}
