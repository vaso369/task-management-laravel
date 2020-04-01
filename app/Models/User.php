<?php

namespace App\Models;

class User
{

    public function getByEmailAndPassword($username, $pass)
    {
        return \DB::table("users AS u")
            ->leftJoin("users AS b", "u.idBoss", "=", "b.id")
            ->join("sectors AS s", "u.idSector", "=", "s.idSector")
            ->select("u.id", "u.first_name AS emp_first_name", "u.last_name AS emp_last_name", "u.username", "u.email AS emp_email", "u.idBoss", "u.idSector", "s.name", "u.imagePath", "u.imagePathNew", "u.idPart", "u.idBoss", "u.idSector", "b.first_name AS boss_first_name", "b.last_name AS boss_last_name", "b.email AS boss_email", "b.imagePath AS boss_imagePath", "b.imagePathNew AS boss_imagePathNew")
            ->where([
                ["u.username", "=", $username],
                ["u.pass", "=", md5($pass)],
            ])
            ->first();
    }
    public function getBoss($id)
    {
        return \DB::table("users AS u")
            ->leftJoin("users AS b", "u.idBoss", "=", "b.id")
            ->join("sectors AS s", "u.idSector", "=", "s.idSector")
            ->select("u.id", "u.first_name AS emp_first_name", "u.last_name AS emp_last_name", "u.username", "u.email AS emp_email", "u.idBoss", "u.idSector", "s.name", "u.imagePath", "u.imagePathNew", "u.idPart")
            ->where('u.id', $id)
            ->first();
    }
    public function isBoss($id)
    {
        return \DB::table("users")
            ->where('idBoss', $id)
            ->first();
    }
    public function insertUser($first_name, $lastName, $username, $pass, $email, $defaultImage)
    {
        return \DB::table('users')->insert(
            ['first_name' => $first_name, 'last_name' => $lastName, 'username' => $username, 'email' => $email, 'pass' => $pass, 'idPart' => 2, 'imagePath' => $defaultImage, 'imagePathNew' => $defaultImage, 'active' => 0, 'idBoss' => 12, 'idSector' => 5]
        );
    }
    public function updateUser($first_name, $lastName, $username, $pass, $email, $idEmployee)
    {
        return \DB::table('users')
            ->where('id', $idEmployee)
            ->update(
                ['first_name' => $first_name, 'last_name' => $lastName, 'username' => $username, 'email' => $email, 'pass' => $pass]
            );
    }
    public function insertPhoto($slika, $idEmployee)
    {
        return \DB::table('users')
            ->where('id', $idEmployee)
            ->update(
                ['imagePath' => $slika, 'imagePathNew' => $slika]
            );
    }
}
