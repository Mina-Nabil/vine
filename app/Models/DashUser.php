<?php

namespace App\Models;

use App\Services\FileManager;
use Exception;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class DashUser extends Authenticatable
{
    use Notifiable;
    protected $table = "dash_users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'full_name',
        'password',
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    public static function create($name, $full_name, $pass, $image = null)
    {

        $imagePath = null;
        if ($image != null) {
            $imagePath = FileManager::save($image, "dash_users");
        }
        $newDash = new self;
        $newDash->name = $name;
        $newDash->full_name = $full_name;
        $newDash->password = bcrypt($pass);
        $newDash->image = $imagePath;

        try {
            $newDash->save();
            return $newDash;
        } catch (Exception $e) {
            if ($imagePath != null)
                FileManager::delete($imagePath);
            report($e);
            return false;
        }
    }

    public function modify($name, $full_name, $pass = null, $image = null)
    {
        $imagePath = null;
        $oldPath = null;
        if ($image != null) {
            $oldPath = $this->image;
            $imagePath = FileManager::save($image, "dash_users");
        }

        $this->name = $name;
        $this->full_name = $full_name;
        if ($pass != null) {
            $this->password = bcrypt($pass);
        }

        if ($imagePath != null)
            $this->image = $imagePath;

        try {
            $ret = $this->save();
            if ($oldPath != null)
                FileManager::delete($oldPath);
            return $ret;
        } catch (Exception $e) {
            if ($imagePath != null)
                FileManager::delete($imagePath);
            report($e);
            return false;
        }
    }

    public function getImageUrlAttribute()
    {
        return $this->image != null ? Storage::url($this->image) : null;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

}
