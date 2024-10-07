<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = "areas";
    public $timestamps = false;

    ////static queries
    public static function createArea(string $name, string $arabicName, int $rate): Area
    {
        $newArea = new self();
        $newArea->name = $name;
        $newArea->arabic_name = $arabicName;
        $newArea->rate = $rate;
        $newArea->save();
        return $newArea;
    }

    ////model functions
    public function editInfo(string $name, string $arabicName, int $rate)
    {
        $this->name = $name;
        $this->arabic_name = $arabicName;
        $this->rate = $rate;
        $this->save();
    }

    //scopes
    public static function scopeActive(Builder $query)
    {
        return $query->where('is_active', 1);
    }
}
