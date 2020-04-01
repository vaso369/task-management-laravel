<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use \Firebase\JWT\JWT;

class UserController extends Controller
{
    private $userJson;
    private $model;
    public function __construct()
    {
        $this->model = new User();
    }
    public function register(RegisterRequest $request)
    {

        if (isset($errors)) {
            return response(['error' => $errors], 404);
        }

        $first_name = $request->input("firstName");
        $lastName = $request->input("lastName");
        $username = $request->input("username");
        $pass = md5($request->input("pass"));
        $email = $request->input("email");
        $uloga = 2;
        $defaultImage = "assets/avatar-placeholder.png";

        try {
            $isInserted = $this->model->insertUser($first_name, $lastName, $username, $pass, $email, $defaultImage);
            if ($isInserted) {
                return response(['message' => 'Successfuly registration!'], 201);
            }
        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
    public function login(LoginRequest $request)
    {
        if (isset($errors)) {
            return response(['error' => $errors], 404);
        }

        $username = $request->input("username");
        $pass = $request->input("pass");
        try {

            $user = $this->model->getByEmailAndPassword($username, $pass);
            $isBoss = $this->model->isBoss($user->id);

            if ($isBoss) {
                $boss = $this->model->getBoss($user->id);
                $this->JWTtoken($boss);
                return response($this->userJson, 201);
            } elseif ($user) {
                $this->JWTtoken($user);
                return response($this->userJson, 201);
            } else {
                return response(['message' => 'You are not registered!'], 401);
            }
        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }

    }
    public function JWTtoken($user)
    {
        $secret_key = "YOUR_SECRET_KEY";
        $issuer_claim = "THE_ISSUER";
        $audience_claim = "THE_AUDIENCE";
        $issuedat_claim = time();
        $notbefore_claim = $issuedat_claim;
        $expire_claim = $issuedat_claim + 1200;
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
        );

        $jwt = JWT::encode($token, $secret_key);
        $userJson = json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "expireAt" => $expire_claim,
                "user" => $user,
            ));
        $this->userJson = $userJson;

    }
    public function editProfile(RegisterRequest $request)
    {
        if (isset($errors)) {
            return response(['error' => $errors], 404);
        }
        $idEmployee = $request->input("idEmployee");
        $first_name = $request->input("firstName");
        $lastName = $request->input("lastName");
        $username = $request->input("username");
        $pass = md5($request->input("pass"));
        $email = $request->input("email");
        $uloga = 2;
        $defaultImage = "assets/avatar-placeholder.png";

        try {
            $isUpdated = $this->model->updateUser($first_name, $lastName, $username, $pass, $email, $idEmployee);
            if ($isUpdated) {
                return response(['message' => 'Your profile is updated!'], 204);
            }
        } catch (\PDOException $ex) {
            return response(['message' => $ex->getMessage()], 500);
        }
    }
   
}
