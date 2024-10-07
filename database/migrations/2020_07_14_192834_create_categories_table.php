<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->string("arabic_name");


        });

        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->constrained("categories");
            $table->string("name");
            $table->string("arabic_name");
            $table->string("image")->nullable();
            $table->string("desc")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
        Schema::dropIfExists('categories');
    }
}
