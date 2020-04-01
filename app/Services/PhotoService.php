<?php

namespace App\Services;

use App\Models\User;
use App\Services\UploadService;

class PhotoService
{

    public function insert($request)
    {
        $picture = $this->upload($request);
        $idEmployee = $request->input('idEmployee');
        $model = new User();
        try {
            $isInserted = $model->insertPhoto($picture, $idEmployee);
            if ($isInserted) {

                return response($picture, 200);
            }

        } catch (\Exception $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }

    private function upload($request)
    {
        $pictureFile = $request->file("file");
        $picture = UploadService::uploadd($pictureFile);
        return $picture;
    }
}
