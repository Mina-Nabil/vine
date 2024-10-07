<?php

namespace App\Models;

use App\Services\FileManager;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{

    use HasFactory;

    protected $table = "sub_categories";
    public $timestamps = false;
    protected $with = ["category"];
    protected $appends = ['full_name'];
    //Accessors
    public function getImageUrlAttribute()
    {
        return FileManager::get($this->SBCT_IMGE);
    }

    public function getFullNameAttribute()
    {
        return $this->category->name . " : " . $this->name;
    }


    //CRUD
    public static function createNew($name, $arbcName, $category_id, $photo, $desc = null): SubCategory
    {

        $subcategory = new self();
        $subcategory->name = $name;
        $subcategory->arabic_name = $arbcName;
        $subcategory->desc = $desc;
        $subcategory->category_id = $category_id;

        $path = FileManager::save($photo, "subcategories");
        $subcategory->image = $path;

        try {
            $subcategory->save();
            return $subcategory;
        } catch (Exception $e) {
            FileManager::delete($path);
            throw $e;
        }
    }

    public function editInfo($name, $arbcName, $category, $photo = null, $desc = null): int
    {
        $this->name = $name;
        $this->arabic_name = $arbcName;
        $this->category_id = $category;
        $this->desc = $desc;

        if ($photo != null) {
            $oldPath = $this->image;
            $path = FileManager::save($photo, "subcategories");
            if ($path != null)
                $this->image = $path;
        }
        try {
            $ret = $this->save();
            if (isset($oldPath) && $path != null)
                FileManager::delete($oldPath);
            return $ret;
        } catch (Exception $e) {
            FileManager::delete($path);
            report($e);
            return false;
        }
    }

    //scope
    public function scopeOfCategory($query, $categoryID)
    {
        return $query->where('category_id', $categoryID);
    }

    //relations
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
