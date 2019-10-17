<?php

namespace App\Http\Middleware;


use Closure;

use Auth;
use Carbon;

use App\cseo_account;



class LogLastUserActivity
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


         if(Auth::check()) {
            $expiresAt = \Carbon\Carbon::now()->addMinutes(1);
            //aff_account::put('is_logged_in' . Auth::user()->id, true, $expiresAt);
            //$res = aff_account::where('id', Auth::user()->id, true)->update(['is_logged_in' => "true"]);
           

          /* if (Auth::User()->is_logged_in != 'true')
           {
               $res = aff_account::where('id', Auth::user()->id, true)->update(['is_logged_in' => "false"]);
           }else {*/

             //aff_account::where('id', Auth::user()->id, true)->update(['is_logged_in' => "true", 'updated_at' => $expiresAt]);
             cseo_account::where('id', Auth::user()->id, true)->update(['is_logged_in' => "true", 'updated_at' => $expiresAt]);

             //$res = aff_account::where('id',Auth::user()->id)->where('updated_at', \Carbon\Carbon::now()->addMinutes(2))->get();
             //$res = aff_account::where('id', Auth::user()->id)->where('updated_at', \Carbon\Carbon::now()->addMinutes(5))->get();

             //aff_account::where('id', '!=', Auth::user()->id)->where('updated_at',"<=",\Carbon\Carbon::now()->subMinutes(2))->update(['is_logged_in' => "false"]);
             cseo_account::where('updated_at',"<=",\Carbon\Carbon::now()->subMinutes(2))->update(['is_logged_in' => "false"]);
            


           /*}*/

         }
         return $next($request);

    }
}
