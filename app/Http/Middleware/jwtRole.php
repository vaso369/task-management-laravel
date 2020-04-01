<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class jwtRole
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
        $user = new User();
        $idBoss = $request->input('idBoss');
        $isBoss = $user->isBoss($idBoss);
        if ($isBoss) {
            return $next($request);
        } else {
            return response(['message' => 'You do not have a permission!']);
        }
    }
}
