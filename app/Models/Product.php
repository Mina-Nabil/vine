<?php

namespace App\Models;

use App\Services\FileManager;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    public $timestamps = true;

    protected $appends = [
        "main_image_url", "final_price"
    ];

    //CRUD queries
    public static function create(string $name, string $arbcName, string $desc, string $arbcDesc, int $category, float $price, ?float $cost, $offer): Product
    {
        $product = new Product();
        $product->name = $name;
        $product->arabic_name = $arbcName;
        $product->desc = $desc;
        $product->arabic_desc = $arbcDesc;
        $product->sub_category_id = $category;
        $product->price = $price;
        $product->cost = $cost;
        $product->offer = $offer ?? 0;
        $product->save();
        return $product;
    }

    public function modify(string $name, string $arbcName, string $desc, string $arbcDesc, int $category, float $price, ?float $cost, $offer): bool
    {

        $this->name = $name;
        $this->arabic_name = $arbcName;
        $this->desc = $desc;
        $this->arabic_desc = $arbcDesc;
        $this->sub_category_id = $category;
        $this->price = $price;
        $this->cost = $cost;
        $this->offer = $offer ?? 0;
        return $this->save();
    }

    public static function searchQuery(string $search_text) : Builder {
        return self::select('products.*')
            ->join('prod_tag', 'prod_tag.product_id', 'prod_tag.tag_id')
            ->join('tags', 'tag', '=', 'tags.id')
            ->join('sub_categories', 'products.sub_category_id', '=', 'sub_categories.id')
            ->orWhere('tags.name', 'LIKE', "%{$search_text}%")
            ->orWhere('sub_categories.name', 'LIKE', "%{$search_text}%")
            ->orWhere('products.name', 'LIKE', "%{$search_text}%");
    }

    //function 
    public function addImage($image): ProductImage
    {
        $newImage = new ProductImage();
        $path = FileManager::save($image, "products");
        $newImage->image_url = $path;
        $newImage->product_id = $this->id;

        $newImage->save();
        return $newImage;
    }

    public function setMainImage($imageID)
    {
        $this->product_image_id = $imageID;
        $this->save();
    }

    //accessors
    public function getMainImageUrlAttribute(): ?string
    {
        $this->loadMissing('mainImage', 'images');
        if (is_null($this->mainImage)) {
            return ($this->images->isNotEmpty()) ? $this->images->random()->image_url : 1;
        } else {
            return $this->mainImage->image_url ?? 2;
        }
        return 3;
    }

    public function getMainImageIdAttribute(): ?int
    {
        return $this->product_image_id;
    }

    public function getFinalPriceAttribute(): ?float
    {
        return ((100 - $this->offer) / 100) * $this->price;
    }

    public function getCategoryNameAttribute(): ?string
    {
        $this->loadMissing('subcategory');
        return $this->subcategory->name;
    }

    //relations
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function mainImage()
    {
        return $this->belongsTo(ProductImage::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
    public function stock()
    {
        return $this->hasMany(Inventory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, "prod_tag", "PDTG_PROD_ID", "PDTG_TAGS_ID");
    }


    //scopes and queries
    // public static function newArrivals($dateInterval)
    // {
    //     return self::with('subcategory')
    //         ->join("inventory", "INVT_PROD_ID", "=", "products.id")
    //         ->select("products.*")->selectRaw("SUM(INVT_CUNT) as stock")
    //         ->groupBy("products.id")
    //         ->where("products.created_at", ">", (new DateTime())->sub(new DateInterval($dateInterval)))
    //         ->get();
    // }

    public function scopeOfSubcategory($query, $subcategoryID)
    {
        return $query->where("sub_category_id", $subcategoryID);
    }

    public function scopeOnSale($query){
        return $query->where('products.offer', '>', 0);
    }

    public function scopeNewArrivals($query, $dateInterval){
        return $query->where("products.created_at", ">", (new DateTime())->sub(new DateInterval($dateInterval)));
    }

    private function hasJoin(\Illuminate\Database\Query\Builder $Builder, $table)
    {
        if ($Builder->joins)
            foreach ($Builder->joins as $JoinClause) {
                if ($JoinClause->table == $table) {
                    return true;
                }
            }
        return false;
    }
}
