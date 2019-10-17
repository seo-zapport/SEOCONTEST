<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SuperAdminMiddleware
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
        foreach (Auth::user()->status as $status) {
            if($status->status_name == "SuperAdmin" || $status->status_name == "Developer"){
                  return $next($request);   
            }
        } 
        return redirect('/403');
    
    }
}
