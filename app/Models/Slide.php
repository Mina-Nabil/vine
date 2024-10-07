<?php

namespace App\Models;

use App\Services\FileManager;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    public $timestamps = false;

    public static function boot()
    {
        parent::boot(); 
        static::deleted(function ($obj) {
            FileManager::delete($obj->SLID_IMGE);
        });
    }

    //CRUD
    public static function create($image, $title, $subtitle, $buttonText, $buttonUrl): self
    {
        $imagePath = FileManager::save($image, "slides");

        $newSlide = new self();

        $newSlide->SLID_IMGE = $imagePath;
        $newSlide->SLID_TITL = $title;
        $newSlide->SLID_SBTL = $subtitle;
        $newSlide->SLID_BTN_TEXT = $buttonText;
        $newSlide->SLID_BTN_URL = $buttonUrl;
        $newSlide->SLID_ACTV = 1;

        try {
            $newSlide->save();
            return $newSlide;
        } catch (Exception $e) {
            FileManager::delete($imagePath);
            throw $e;
        }
    }

    public function setActivation($bool): bool
    {
        $this->SLID_ACTV = $bool ? 1 : 0;
        return $this->save();
    }

    //Queries
    public static function scopeSite($query){
        return $query->limit(4)->active()->orderBy("id", "desc");
    }
    public static function scopeActive($query){
        return $query->where("SLID_ACTV", 1);
    }


    //Accessors
    public function getImageUrlAttribute(): string
    {
        return FileManager::get($this->SLID_IMGE);
    }

    //relations
}
