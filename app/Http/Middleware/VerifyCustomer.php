<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifyCustomer
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

        if (!auth()->check()) 
        {
            return redirect('/login');
        }

        if ($user != NULL) {
            if (auth()->user()->role == role('pelanggan'))  {
                return $next($request);
            }else{
                return redirect()->route('logout.customer')->with('msg', ['type'=>'danger','text'=>'Access Denied']);
            }
        }else{
            return redirect()->route('home')->with('msg', ['type'=>'danger','text'=>'Access Denied']);
        }

        return abort('403');
    }
}
