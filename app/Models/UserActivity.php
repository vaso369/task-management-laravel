<?php
namespace App\Models;

class UserActivity
{

    public function insert($idUser, $ip, $dateTime, $activity, $method)
    {
        return \DB::table('activity')->insert(["idUser" => $idUser, "activity" => $activity, "date" => $dateTime, "ip_adress" => $ip, "method" => $method]);
    }

    public function getActivity($id)
    {
        return \DB::table('activity AS a')->join("users AS u", "a.idUser", "=", "u.id")->select("a.id AS activity_id", "u.id", "u.first_name", "u.last_name", "a.ip_adress", "a.date", "a.activity", "a.method")->where("a.idUser", "=", $id)->get();
    }

    public function deleteActivity($id)
    {
        return \DB::table('activity')->where("id", "=", $id)->delete();
    }

}
