<?php

namespace App\Models;

use App\Services\FileManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = "prod_images";
    public $timestamps = false;
    protected $appends = ["image_url"];

    public static function boot(){
        parent::boot();
        static::deleting(function ($obj) {
            $obj->loadMissing("product");
            if($obj->id == $obj->product->main_image_id ){
                $obj->product->setMainImage(null);
            }
            FileManager::delete($obj->image_url);
        });
    }

    public function getFullImageUrlAttribute(){
        return FileManager::get($this->image_url);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
