<?php

namespace App\Models;

class Boss
{
    public function getYourTeam($bossID)
    {
        return \DB::table("users")
            ->select("*")
            ->where('idBoss', $bossID)
            ->get();
    }

}
