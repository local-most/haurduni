<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class VerifyAdmin
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
            return redirect('/administrator');
        }

        if ($user != NULL) {
            if (auth()->user()->role == role('admin') || auth()->user()->role == role('pimpinan'))  {
               return $next($request);
            }else{
                return redirect()->route('login')->with('msg', ['type'=>'danger','text'=>'Access Denied']);
            }
            
        }else{
            return redirect()->route('login')->with('msg', ['type'=>'danger','text'=>'Access Denied']);
        }

        return abort('403');
    }
}
