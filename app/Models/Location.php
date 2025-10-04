<?php

namespace App\Models;

use App\Services\FileManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = "locations";

    public static function boot()
    {
        parent::boot(); 
        static::deleted(function ($obj) {
            FileManager::delete($obj->image_url);
        });
    }

    ////static queries
    public static function createLocation(string $imageUrl, string $title, string $locationUrl, ?string $address = null, ?string $telephone = null): Location
    {
        $newLocation = new self();
        $newLocation->image_url = $imageUrl;
        $newLocation->title = $title;
        $newLocation->location_url = $locationUrl;
        $newLocation->address = $address;
        $newLocation->telephone = $telephone;
        $newLocation->save();
        return $newLocation;
    }

    ////model functions
    public function editInfo(string $imageUrl, string $title, string $locationUrl, ?string $address = null, ?string $telephone = null)
    {
        $this->image_url = $imageUrl;
        $this->title = $title;
        $this->location_url = $locationUrl;
        $this->address = $address;
        $this->telephone = $telephone;
        $this->save();
    }

    //scopes
    public static function scopeActive(Builder $query)
    {
        return $query->where('is_active', 1);
    }

    //Accessors
    public function getImageUrlAttribute(): string
    {
        return FileManager::get($this->attributes['image_url']);
    }
}
