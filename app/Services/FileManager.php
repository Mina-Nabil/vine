<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileManager
{
    /**
     * @param string $file .. base folder to retrieve 
     * @return string url of saved file 
     */
    public static function get($file)
    {
        return ($file != null) ?
            (str_starts_with($file, "http") ? $file : Storage::url($file))
            : null;
    }

    /**
     * @param string $file .. request file to save 
     * @param string $file .. base folder to save into 
     * @return string saved file path
     */
    public static function save($file, $folder)
    {
        return Storage::put($folder, $file);
    }

    /**
     * @param string $filePath .. file path to delete
     * @return boolean if file is deleted or no 
     */
    public static function delete($filePath)
    {
        return Storage::delete($filePath);
    }
}
