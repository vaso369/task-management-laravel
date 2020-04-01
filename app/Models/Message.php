<?php

namespace App\Models;

class Message
{
    public function sendMessage($employeeID, $bossID, $message)
    {
        return \DB::table('messages')->insert(
            ['idEmployee' => $employeeID, 'idBoss' => $bossID, 'message' => $message]
        );
    }

}
