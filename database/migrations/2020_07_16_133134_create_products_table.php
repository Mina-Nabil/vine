<?php

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\Tag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tags', function(Blueprint $table){
            $table->id();
            $table->string("name")->unique();
            $table->string("soundex");
        });

        Schema::create('prod_images', function (Blueprint $table){
            $table->id();
            $table->string("image_url");
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->string("arabic_name");
            $table->foreignIdFor(SubCategory::class)->constrained("sub_categories");
            $table->string("desc");
            $table->string("arabic_desc");
            $table->double("price");
            $table->double("cost")->nullable();
            $table->double("offer")->default(0); //percentage
            $table->foreignIdFor(ProductImage::class)->nullable()->constrained("prod_images"); // main image
            $table->string("material");
            $table->string("dimensions");
            $table->string("handled_topics")->nullable();
            $table->timestamps();
        });

        Schema::table("prod_images", function (Blueprint $table){
            $table->foreignIdFor(Product::class)->constrained("products");
        });

        Schema::create("prod_tag", function(Blueprint $table){
            $table->id();
            $table->foreignIdFor(Product::class)->constrained("products");
            $table->foreignIdFor(Tag::class)->constrained("tags");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prod_tag');
        Schema::dropIfExists('products');
        Schema::dropIfExists('prod_images');
        Schema::dropIfExists('tags');

    }
}
