<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $employeeID = $request->input('idEmployee');
        $bossID = $request->input('idBoss');
        $message = $request->input('message');
        $model = new Message();
        $activity = new UserActivity();
        try {
            $isInserted = $model->sendMessage($employeeID, $bossID, $message);
            $ip = request()->ip();
            $dateTime = date("Y-m-d H:i:s");
            $activity = "Message sent to boss";
            $method = request()->getMethod();
            $activity->insert($idEmployee, $ip, $dateTime, $activity, $method);
            if ($isInserted) {
                return response(['message' => 'Your message is sent!'], 201);
            }
        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
}
