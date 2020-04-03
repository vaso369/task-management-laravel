<?php

namespace App\Http\Controllers;

use App\Models\Boss;
use App\Models\UserActivity;
use Illuminate\Http\Request;

//BossController
class BossController extends Controller
{
    public function getYourTeam(Request $request)
    {
        $idBoss = $request->input('idBoss');

        $model = new Boss();

        try {
            $team = $model->getYourTeam($idBoss);
            return response($team, 200);

        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
    public function getUserActivities(Request $request)
    {
        $idEmployee = $request->input('idEmployee');
        $model = new UserActivity();
        try {
            $activities = $model->getActivity($idEmployee);
            return response($activities, 200);

        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
}
