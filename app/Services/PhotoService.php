<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserActivity;
use App\Services\UploadService;

class PhotoService
{

    public function insert($request)
    {
        $picture = $this->upload($request);
        $idEmployee = $request->input('idEmployee');
        $model = new User();
        $activity = new UserActivity();
        try {
            $isInserted = $model->insertPhoto($picture, $idEmployee);
            $ip = request()->ip();
            $dateTime = date("Y-m-d H:i:s");
            $activity = "Picture photo uploaded";
            $method = request()->getMethod();
            $activity->insert($idEmployee, $ip, $dateTime, $activity, $method);
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
