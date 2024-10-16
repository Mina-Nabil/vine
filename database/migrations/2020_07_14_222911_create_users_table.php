<?php

use App\Models\Area;
use App\Models\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('areas', function (Blueprint $table){
            $table->id();
            $table->string("name")->unique();
            $table->string("arabic_name");
            $table->double("rate")->default(20);
            $table->boolean("is_active")->default(true);
        });

        Schema::create('genders', function (Blueprint $table){
            $table->id();
            $table->string("name")->unique();
            $table->string("arabic_name");
        });

        DB::table('genders')->insert([
            "name" => "Male",
            "arabic_name" => "ذكر"
        ]);

        DB::table('genders')->insert([
            "name" => "Female",
            "arabic_name" => "انثي"
        ]);

        DB::table('genders')->insert([
            "name" => "Prefer not to say",
            "arabic_name" => "لا افضل الاختيار"
        ]);

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email")->nullable();
            $table->string("address")->nullable();
            $table->foreignIdFor(Area::class)->nullable()->constrained("areas");
            $table->foreignIdFor(Gender::class)->default(1)->constrained("genders");
            $table->string("mobile")->nullable();
            $table->string("password")->nullable();
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('genders');
        Schema::dropIfExists('areas');
    }
}
