<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Input;
use App\Http\Controllers\Response;
use Illuminate\Database\Eloquent\Model;


use DB;
use URL;
use Validator;
use Redirect;

use App\cseo_account;
use App\cseo_options_settings;
use App\cseo_merchant;

class cseo_general_settings extends Controller
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
            
            if($this->user->status_id == '4'){
                return $next($request); 
            }else{
                return redirect('/403');
            }

        });
    }

    //index
	public function index(){

		$settings = new cseo_options_settings;
		
		//$settings_group = $settings::orderby('id', 'desc')->first();
		/*$settings_group = cseo_options_settings::SELECT(DB::raw('cseo_options_settings.parent_id as parent_id,cseo_options_settings.site_url as site_url,cseo_options_settings.site_identity as site_identity,cseo_options_settings.site_status as site_status,cseo_accounts.email as email'))->join('cseo_accounts','cseo_options_settings.parent_id','=','cseo_accounts.id')->orderby('cseo_options_settings.parent_id', 'desc')->first();*/

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();
        
		//$settings_group = $settings::orderby('id', 'desc')->first();
		$settings_group = $settings::where('merchants_id', $merchants->id)->first();

		if ( count( $settings_group ) > 0 ) {
			$site_identity_array = $settings_group->site_identity;
			$site_identity = json_decode( $site_identity_array );
			return view('system.settings.general', compact('site_identity') );
		}else{
			return view('system.settings.general' );
		}	
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

    	$parent_id = '1';
    	$site_title = $request->site_title;
    	$site_tag_line = $request->site_tag_line;
    	$site_display_assets = $request->site_display_assets;
    	$site_url = $request->site_url;
    	
    	$site_identity = array( 'site_title' => $site_title, 'site_display_assets' => $site_display_assets, 'site_tag_line' => $site_tag_line );
    	$site_identity =  json_encode( $site_identity );

    	//$site_identity = $site_title;
		$settings = new cseo_options_settings;

		//New Rules
		$rules = [ 'site_title' => 'required|min:5' ];

		//Customize errors message
        $customMessages = ['required' => 'This :attribute is required' ];

		//validate
		$validate = Validator::make($request->all(), $rules, $customMessages);

		if ( $validate->passes() ) {

			$settings->parent_id = $parent_id;
			$settings->current_id = '0';
			$settings->site_url = $site_url;
			$settings->site_identity = $site_identity;
			$settings->site_status = 'Newly Record';
			$settings->save();

			$lastinsert = $settings->id;

			//session()->flash('message', 'Successfully Added');
			return response()->json([
				'status' 	=> 'success',
				'message' 	=> 'Added New record',
				'type'		=> 'publish'
			]);
		}else{
			//return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);
			return response()->json([
				'status' 	=> 'error',
				'message' 	=> 'Please check the required field',
				'type'		=> '',
				'error' => $validate->getMessageBag()->toArray()
			]);
		}		
	}

   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

    	$site_title = $request->site_title;
    	$site_tag_line = $request->site_tag_line;
    	$site_display_assets = $request->site_display_assets;
    	$site_url = $request->site_url;
    	
    	$site_identity = array( 'site_title' => $site_title, 'site_display_assets' => $site_display_assets, 'site_tag_line' => $site_tag_line );
    	$site_identity =  json_encode( $site_identity );

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();
    
		//New Rules
		$rules = [ 'site_title' => 'required|min:5' ];

		//Customize errors message
        $customMessages = ['required' => 'This :attribute is required' ];

		//validate
		$validate = Validator::make($request->all(), $rules, $customMessages);

		if ( $validate->passes() ) {

    

	    	$update_settings = cseo_options_settings::where('merchants_id', $merchant->id)->update([
	    		'current_id' => '1',
	    		'site_identity' => $site_identity,
	    		'site_status' => 'Update',
	    	]);

			//session()->flash('message', 'Successfully Added');
			return response()->json([
				'status' 	=> 'success',
				'message' 	=> 'Added New record',
				'type'		=> 'update',
			]);
		}else{
			//return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);
			return response()->json([
				'status' 	=> 'error',
				'message' 	=> 'Please check the required field',
				'type'		=> '',
				'error' => $validate->getMessageBag()->toArray()
			]);
		}
    }

}

