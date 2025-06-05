<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('dash_users')->insert([
            "name" => "mina",
            "full_name" => "Mina Nabil",
            "password" => bcrypt('mina@vine'),
        ]);
    }
}
