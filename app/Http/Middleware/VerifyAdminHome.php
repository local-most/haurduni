<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifyAdminHome
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
        $user = $request->user();

        if ($user != NULL) {
            if ($user->role == role('pelanggan')) {
                Auth::guard('web')->logout();
            }
            return $next($request);
        }else{
            return $next($request);
        }

        return abort('403');
    }
}
