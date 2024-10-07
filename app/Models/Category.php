<?php

namespace App\Models;

use App\Services\FileManager;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";
    protected $fillable = [
        'name', 'arabic_name'
    ];
    public $timestamps = false;

    ////static functions
    public static function newCategory($name, $arabic_name)
    {
        $category = new self();
        $category->name = $name;
        $category->CATG_ARBC_NAME = $arabic_name;
        try{
            $category->save();
        } catch (Exception $e){
            report($e);
            return false;
        }
    }

    ////model functions
    public function editInfo($name, $arabic_name)
    {
        $this->name = $name;
        $this->CATG_ARBC_NAME = $arabic_name;
        try{
            $this->save();
        } catch (Exception $e){
            report($e);
            return false;
        }
    }

    ////relations
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }
}
