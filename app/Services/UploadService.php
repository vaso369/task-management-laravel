<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadService
{

    public static function uploadd(UploadedFile $file)
    {
        $fileName = time() . "_" . $file->getClientOriginalName();

        $file->move(\public_path() . "/user_pictures", $fileName);

        return $fileName;
    }
}
