<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DB;
use URL;
use App\cseo_register;
use App\cseo_merchant;
use App\cseo_team;
use App\cseo_account;
use App\cseo_options_settings;
use App\cseo_pages;
use App\cseo_banner;

class AdminController extends Controller
{
    public $user;

        /**
        * Create a new controller instance.
        *
        * @return void
        */
       public function __construct()
       {
           $this->middleware('auth');
           $this->middleware('logged');
           $this->middleware(function ($request, $next) {
                $this->user = cseo_account::where('id',auth()->user()->id)->first();
    
                if($this->user->status_id != '4'){
                    return $next($request); 
                }
                    return redirect('/403');
                

            });
       }

   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $user = cseo_account::where('id', Auth::user()->id)->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();
        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }

        $team = cseo_team::latest()->get();
        $merchant_list = cseo_merchant::where('status_id', '9' )->latest()->get();

        //$lang_id = $request->lang_id;
        $lang_id = '1';


        $pagescount = cseo_pages::where('status_id', '9')->where('lang_id', $lang_id)->count();
        $merchantcount = cseo_merchant::where('status_id', '9' )->count();
        $bannercount = cseo_banner::where('lang_id', $lang_id)->count();
        $usercount = cseo_account::where('status_id', '!=', '1')->count();
        $registecount = cseo_register::count();
        
        $status_register = cseo_register::Select(DB::raw("(SELECT count(*) from cseo_registers where status_id = 6) countPending,(SELECT count(*) from cseo_registers where status_id = 7) countApproved, (SELECT count(*) from cseo_registers where status_id = 8) countDisqual, (SELECT count(*) from cseo_registers where verify_status = 9) countConfirm" ))->first();
        $merchant_rank = cseo_options_settings::join('cseo_teams', 'cseo_teams.id', 'cseo_options_settings.lang_id')->where('site_curr_status', '9' )->orderby('cseo_options_settings.created_at','DESC')->get();
        return view('system.dashboard.admin', compact('status_register','site_identity','user','team','merchant_list','merchant_rank','pagescount','merchantcount','bannercount','usercount','registecount'));
    }

    public function firstGlance(Request $request){
         
         if($request->ajax()){

            if($request->domain_id == ""){
               
                $status_register = cseo_register::Select(DB::raw("(SELECT count(*) from cseo_registers where status_id = 6) countPending,(SELECT count(*) from cseo_registers where status_id = 7) countApproved, (SELECT count(*) from cseo_registers where status_id = 8) countDisqual, (SELECT count(*) from cseo_registers where verify_status = 9) countConfirm" ))->first();

                $merchant_rank = cseo_options_settings::join('cseo_teams', 'cseo_teams.id', 'cseo_options_settings.lang_id')->where('site_curr_status', '9' )->orderby('cseo_options_settings.created_at','DESC')->get();
            }else{
               
               $status_register = cseo_register::Select(DB::raw("(SELECT count(*) from cseo_registers where status_id = 6 and merchants_id= ".$request->domain_id.") countPending,(SELECT count(*) from cseo_registers where status_id = 7 and merchants_id= ".$request->domain_id.") countApproved, (SELECT count(*) from cseo_registers where status_id = 8 and merchants_id= ".$request->domain_id.") countDisqual, (SELECT count(*) from cseo_registers where verify_status = 9 and merchants_id= ".$request->domain_id.") countConfirm" ))->first();
           
               $merchant = cseo_merchant::SELECT('cseo_merchants.merchant_name')->where('id', $request->domain_id)->where('cseo_merchants.status_id', '9' )->first();

               $merchant_rank = cseo_options_settings::join('cseo_teams', 'cseo_teams.id', 'cseo_options_settings.lang_id')->where('cseo_options_settings.merchants_id', $request->domain_id)->where('cseo_options_settings.site_curr_status', '9' )->orderby('cseo_options_settings.created_at','DESC')->get();

               $googleresult  = cseo_team::SELECT(DB::raw("cseo_teams.google, cseo_options_settings.ranking"))->join('cseo_merchants', 'cseo_merchants.team_merchant_id', 'cseo_teams.id')->join('cseo_options_settings', 'cseo_merchants.id', 'cseo_options_settings.merchants_id')->where('cseo_merchants.status_id', '9' )->where('cseo_options_settings.merchants_id', $request->domain_id)->first();    

            }

                     $data = view('system.dashboard.ajax-glance',compact('status_register', 'merchant'))->render();
                     $datagoogle = view('system.dashboard.ajax-ranking',compact('status_register','merchant_rank'))->render();
                     
                     return response()->json(['report'=>$data, 'report_google'=>$datagoogle]);
        }
        
    }

    public  function curlresultAjax(Request $request)
    {
        if($request->ajax()){

                if($request->gresult == ""){

                    $googleresult  = cseo_team::SELECT(DB::raw("cseo_teams.google, cseo_options_settings.ranking"))->join('cseo_merchants', 'cseo_merchants.team_merchant_id', 'cseo_teams.id')->join('cseo_options_settings', 'cseo_merchants.id', 'cseo_options_settings.merchants_id')->where('cseo_merchants.status_id', '9' )->first();    

                }else{

                    $googleresult  = cseo_team::SELECT(DB::raw("cseo_teams.google, cseo_options_settings.ranking"))->join('cseo_merchants', 'cseo_merchants.team_merchant_id', 'cseo_teams.id')->join('cseo_options_settings', 'cseo_merchants.id', 'cseo_options_settings.merchants_id')->where('cseo_options_settings.merchants_id', $request->gresult)->where('cseo_merchants.status_id', '9' )->first();    

                }

                $data_google = view('system.dashboard.ajax-gresult',compact('googleresult'))->render();    

                if(!empty($data_google)){
                    return response()->json(array('success' => true, 'resulta' => $data_google));
                    
                }else{

                    return response()->json(array('success' => false, 'resulta' => "connection timeout"));

                }
                

        }
    }


}
