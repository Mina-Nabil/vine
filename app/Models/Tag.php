<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tags";
    public $timestamps = false;


    protected $fillable = [
        'name',
        'soundex'
    ];


    /////static functions
    public static function newTag($name)
    {
        $soundex = soundex($name);
        return self::firstOrCreate([
            "name"      =>  $name
        ], [
            'soundex'   =>  $soundex
        ]);
    }
}
