<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
            if($status->status_name == "Admin"){
                  return $next($request);   
            }
        } 
        return redirect('/403');
    
    }
}
