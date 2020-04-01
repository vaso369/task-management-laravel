<?php

namespace App\Http\Middleware;

use Closure;
use \Firebase\JWT\JWT;

class jwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('Authorization') !== null) {

            $secret_key = "YOUR_SECRET_KEY";
            $jwt = null;

            $authHeader = $request->header('Authorization');
            $arr = explode(" ", $authHeader);

            $jwt = $arr[1];

            if ($jwt) {

                try {

                    $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

                    // Access is granted.

                    return $next($request);

                } catch (\Exception $e) {
                    return response(["message" => "Access denied.",
                        "error" => $e->getMessage()]);

                }

            }

        } else {
            return response(["message" => "Access denied."]);

        }

    }
}
