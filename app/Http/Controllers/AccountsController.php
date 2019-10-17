<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\cseo_account;
use App\cseo_statuses;
use App\cseo_options_settings;
use App\cseo_role_accesses;
use App\cseo_merchant;


use DB;
use URL;
use Validator;
use Redirect;


class AccountsController extends Controller
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

            $this->user = cseo_account::where('id',  auth()->user()->id)->first();
            
            if($this->user->status_id != '4'){
                return $next($request); 
            }else{
                return redirect('/403');
            }

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

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }

        $query = [];

        $users = new cseo_account;

        $user_count = $users::Select(DB::raw('(Select count(*) from cseo_accounts where account_id != 1 ) countAll, (Select count(*) from cseo_accounts where account_id = 2) countAdmin, (Select count(*) from cseo_accounts where account_id = 3) countDev, (Select count(*) from cseo_accounts where account_id = 4) countSupport '))->first();

        
        if(request()->has('account_type')){
             $accounttype = request('account_type');    

            $user = $users::Select(DB::raw('cseo_accounts.id, cseo_accounts.first_name, cseo_accounts.last_name, cseo_accounts.position, cseo_accounts.email,cseo_accounts.remember_token,cseo_statuses.status_name, cseo_accounts.is_logged_in, cseo_accounts.created_at'))->join('cseo_statuses', 'cseo_statuses.id', 'cseo_accounts.account_id')->where('account_id',$accounttype)->latest();

              $query['account_type'] = $accounttype; 
        
        }else{

            $user = $users::Select(DB::raw('cseo_accounts.id, cseo_accounts.first_name, cseo_accounts.last_name, cseo_accounts.position, cseo_accounts.email,cseo_accounts.remember_token,cseo_statuses.status_name, cseo_accounts.is_logged_in, cseo_accounts.created_at'))->join('cseo_statuses', 'cseo_statuses.id', 'cseo_accounts.account_id')->where('account_id','!=', '1')->latest();
            
        }

        $user = $user->paginate(10)->appends($query);

        $account_count = $user->count();

        return view('system.account.index', compact('site_identity','user_count', 'user','account_count'));    

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

         if ( count( $title ) > 0 ) {
             $site_identity = json_decode( $title->site_identity);
         }

        $account = cseo_statuses::where('level_id','1')->where('status_name' ,'!=', 'SuperAdmin')->get();

        return view('system.account.create', compact('account','site_identity'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
                       'first_name' => 'required|string|max:255',
                        'last_name' => 'required|string|max:255',
                        'email' => 'required|string|email|max:255|unique:cseo_accounts',
                        'password' => 'required|string|min:6|confirmed',
                        'account_type' => 'required|numeric',
                       ]);
    

        if ($validate->fails())
         {
              return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
              //return Redirect::to('backoffice/contact/create')->withErrors($validate)->withInput();
         }else{

                $user = new cseo_account;

                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->display_name = $request->first_name." ".$request->last_name;
                $user->email = $request->email;
                $user->account_id = $request->account_type;
                $user->status_id = $request->account_type;
                $user->cseo_media_id = '2';
                $user->password = bcrypt($request->password);

                $user->save();

                $lastinsert = $user->id;

                $role_access = new cseo_role_accesses;
                $role_access->cseo_statuses_id = $request->account_type;
                $role_access->user_id = $lastinsert;
                $role_access->cseo_media_id = '2';
                $role_access->save();

               session()->flash('message', 'Successfully Added');

               return redirect('system/account');
          }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
           $site_identity = json_decode( $title->site_identity);
        }

        $account = cseo_statuses::where('level_id','1')->where('status_name' ,'!=', 'Super Admin')->get();

        $user = cseo_account::find($id);

        return view('system.account.edit', compact('account','site_identity','user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->moveprocess=="moveSingle" || $request->moveprocess=="moveMulti"  ){
            
            
        if($request->action=="2" || $request->action=="3" || $request->action=="4"){
         
              foreach ($request->id as $ids) 
               {
                   $user = cseo_account::where('id', $ids)->update(['account_id'=> $request->action, 'status_id'=>$request->action]);
                   $role_access = cseo_role_accesses::where('user_id',$ids)->update(['cseo_statuses_id'=> $request->action]);

               }

                 if($request->action=="2"){
                         $promptmessages = 'Successfully Changes User to Administrator';
                 }elseif($request->action=="3"){
                         $promptmessages = 'Successfully Changes User to Developer'; 
                 }else{
                         $promptmessages = 'Successfully Changes Administrator to Support';     
                 }

         }else{
             
                 foreach ($request->id as $ids) 
                 {

                    $user = cseo_account::where('id', $ids)->delete();
                    $role_access = cseo_role_accesses::where('user_id',$ids)->delete();
                 }

                 $promptmessages = 'Permanently Deleted';
         } 

            return response()->json(['message' => $promptmessages]);
        
        }else{

            $user = cseo_account::find($id);
        

             if($request->password !="") { 
                    
                 $editvalid = [
                        'first_name' => 'required|string|max:255',
                        'last_name' => 'required|string|max:255',
                        'account_type' => 'required|numeric',
                        'password' => 'string|min:6'
                        ];                

             }else{

                    $editvalid = [
                           'first_name' => 'required|string|max:255',
                           'last_name' => 'required|string|max:255',
                           'account_type' => 'required|numeric',
                          
                           ];
             }


            $this->validate($request,$editvalid);

            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->account_id = $request->account_type;
            if($request->password !="") { 
                $user->password = bcrypt($request->password); 
            }   

            $user->save();

            $role_access = cseo_role_accesses::where('user_id',$id)->update(['cseo_statuses_id'=> $request->account_type]);        
            return redirect('system/account');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
