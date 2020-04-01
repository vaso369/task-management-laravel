<?php

namespace App\Http\Controllers;

use App\Models\Boss;
use Illuminate\Http\Request;

//Radi
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
}
