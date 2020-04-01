<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $employeeID = $request->input('idEmployee');
        $bossID = $request->input('idBoss');
        $message = $request->input('message');
        $model = new Message();
        try {
            $isInserted = $model->sendMessage($employeeID, $bossID, $message);
            if ($isInserted) {
                return response(['message' => 'Your message is sent!'], 201);
            }
        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
}
