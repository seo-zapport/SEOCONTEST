<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\cseo_account;
use App\cseo_merchant;
use App\cseo_options_settings;
use App\cseo_team;
use App\cseo_pages;
use App\cseo_theme_options;
use App\cseo_meta;
use App\cseo_reward;
use App\cseo_menu;
use App\cseo_menu_setups;

use DB;
use URL;
use Validator;
use Redirect;

class MerchantController extends Controller
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

        $branding = new cseo_merchant;

        $cseo_count = $branding::SELECT(DB::raw('(select count(*) from cseo_merchants where status_id=9) countAll, (select count(*) from cseo_merchants where status_id=9) countPublished, (select count(*) from cseo_merchants where status_id=11) countTrash'))->first();

        $team = cseo_team::latest()->get();

        $query = [];
        $searchbrand = ['cseo_merchants.merchant_name'];   

        if(request()->has('search') && request()->has('status_id')){

            $search = request('search');    
            $statusid = request('status_id'); 

            $branding = $branding::SELECT(DB::raw('cseo_merchants.id,cseo_merchants.merchant_name,cseo_merchants.description,cseo_merchants.status_id,cseo_teams.name as team_name,cseo_merchants.created_at,cseo_merchants.team_merchant_id'));

              foreach ($searchbrand as $searchbrands) {

                $branding->orwhere($searchbrands, 'LIKE', "%".$search."%")->where('cseo_merchants.status_id',  "%".$statusid."%");
                
              } 

            $branding->join('cseo_teams','cseo_teams.id','=','cseo_merchants.team_merchant_id')->latest();      

            $query['search'] = $search;
            $query['status_id'] = $statusid;
        

        }elseif(request()->has('status_id')){
            
            $query['status_id'] = request('status_id');

            $branding = $branding::SELECT(DB::raw('cseo_merchants.id,cseo_merchants.merchant_name,cseo_merchants.status_id,cseo_teams.name as team_name,cseo_merchants.created_at,cseo_merchants.team_merchant_id'))->join('cseo_teams','cseo_teams.id','=','cseo_merchants.team_merchant_id')->where('status_id', request('status_id'))->latest();


        }elseif(request()->has('search')){

            $search = request('search');    
            $query['search'] = $search;
            
            $branding = $branding::SELECT(DB::raw('cseo_merchants.id,cseo_merchants.merchant_name,cseo_merchants.status_id,cseo_teams.name as team_name,cseo_merchants.created_at,cseo_merchants.team_merchant_id'));

              foreach ($searchbrand as $searchbrands) {

                $branding->orwhere($searchbrands, 'LIKE', "%".$search."%")->where('cseo_categories.status_id', '9');
                
              } 

            $branding->join('cseo_teams','cseo_teams.id','=','cseo_merchants.team_merchant_id')->latest();   

        }else{

            $branding = $branding::SELECT(DB::raw('cseo_merchants.id,cseo_merchants.merchant_name,cseo_merchants.status_id,cseo_teams.name as team_name,cseo_merchants.created_at,cseo_merchants.team_merchant_id'))->join('cseo_teams','cseo_teams.id','=','cseo_merchants.team_merchant_id')->where('status_id','9')->latest();
            
        }
    
        $branding = $branding->paginate(10)->appends($query);
        $branding_count = $branding->count();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

         if ( count( $title ) > 0 ) {
             $site_identity = json_decode( $title->site_identity);
         }

        return view('system.settings.brand.index', compact('branding','cseo_count','branding_count','team','site_identity'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           // 

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
                    'merchant_name'=>'required|unique:cseo_merchants',                   
                    ]);

            $lang = cseo_team::get();
               
            if ($validate->fails()){
                    return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
            }else{

               $merchant = new cseo_merchant;

                $merchant->merchant_name = $request->merchant_name;
                $merchant_title = $request->merchant_title;
                $merchant->status_id = "9";
                $merchant->save();

                $lastIdMerchant = $merchant->id;

                foreach ($lang as $langs) {

                $opt_setting = new cseo_options_settings;
                    $opt_setting->parent_id = Auth::user()->id;
                    $opt_setting->current_id = $lastIdMerchant;
                    $opt_setting->merchants_id = $lastIdMerchant;
                    $opt_setting->site_url = $request->merchant_name;
                    $opt_setting->site_identity = '{"site_title":"'.$merchant_title.'","site_display_assets":"false","site_tag_line":""}';
                    $opt_setting->lang_id = $langs->id;
                    $opt_setting->site_curr_status = '9';
                    $opt_setting->save();

                $reward_one = new cseo_reward;
                    $reward_one->merchants_id = $lastIdMerchant;
                    $reward_one->placereward = '1';
                    $reward_one->amount = '0.00';
                    $reward_one->lang_id = $langs->id;
                    $reward_one->save();       
                
                $reward_two = new cseo_reward;
               
                    $reward_two->merchants_id = $lastIdMerchant;
                    $reward_two->placereward = '2';
                    $reward_two->amount = '0.00';
                    $reward_two->lang_id = $langs->id;
                    $reward_two->save();
                
                $reward_three = new cseo_reward;
               
                    $reward_three->merchants_id = $lastIdMerchant;
                    $reward_three->placereward = '3';
                    $reward_three->amount = '0.00';
                    $reward_three->lang_id = $langs->id;
                    $reward_three->save();
                
                $pages = new cseo_pages;
               
                    $pages->merchants_id = $lastIdMerchant;
                    $pages->status_id = "15";
                    $pages->curr_status_id = "15";
                    $pages->page_type = "front_page";
                    $pages->rev_count = "0";
                    $pages->user_id = Auth::user()->id;
                    $pages->lang_id = $langs->id;
                    $pages->save();
               
                $meta = new cseo_meta;
                    $meta->page_id = $pages->id;
                    $meta->save();
                
               
                $theme_setting = new cseo_theme_options;
                    $theme_setting->parent_id = Auth::user()->id;
                    $theme_setting->current_id = $lastIdMerchant;
                    $theme_setting->merchants_id = $lastIdMerchant;
                    $theme_setting->identity_img = '{"identity_logo":"0","identity_icon":"0","identity_banner":"0"}';
                    $theme_setting->familyHead_opt = 'noto-sans';
                    $theme_setting->fontsHead_opt = '{"size":"22","style":"normal","weight":"600"}';
                    $theme_setting->familyContent_opt = 'san-serif';
                    $theme_setting->fontContent_opt = '{"size":"14","style":"normal","weight":"500"}';
                    $theme_setting->color_opt = '{"head":"#f1f1f1","default":"#272727"}';
                    $theme_setting->menu_color_opt = '{"wrap":"#f1f1f1","text":"#272727","hover":"#ece98a"}';
                    $theme_setting->m_menu_color_opt = '{"btn_wrap":"#f1f1f1","icon":"#272727","hover":"transparent"}';
                    $theme_setting->bgAttrib_opt = '1';
                    $theme_setting->bgcoloritem_opt = '#455545';
                    $theme_setting->bgimgitem_opt = '{"bg_image_url":"0","presets":"default","position":"left-center","repeat":"false","scroll":"false","size":"contain"}';
                    $theme_setting->footer_link_opt = '{"link_name_opt":"' .  str_replace('http://', '', $request->merchant_name) . '","link__opt":"' . $request->merchant_name . '","link_title_opt":"' .str_replace('http://', '', $request->merchant_name) . '","link_target_opt":"_target","link_rel_opt":"nofollow"}';
                    $theme_setting->banner_stat = 'false';
                    $theme_setting->banner_disp = '{"bld_id":"0","brd_id":"0","bbd_id":"0"}';
                    $theme_setting->lang_id = $langs->id;
                    $theme_setting->save();

                }
                
                $menu = new cseo_menu;
                $menu->menu_name = "default";
                $menu->description = "";
                $menu->default_id = "1";
                $menu->footer_d_id = "1";
                $menu->user_id = Auth::user()->id;
                $menu->status_id = "14";
                $menu->merchants_id = $lastIdMerchant;
                $menu->save();
                
                $menu_set = new cseo_menu_setups;
                $menu_set->menu_id = $menu->id;
                $menu_set->parent_id = "0";
                $menu_set->pages_id = "0";
                $menu_set->label = "Home";
                $menu_set->link = "/";
                $menu_set->title_attrib = "Home";
                $menu_set->tab_status = "0";
                $menu_set->tab_cat = "0";
                $menu_set->custom_menu = "0";
                $menu_set->css_class = "";
                $menu_set->link_rel = "";
                $menu_set->pop_m = "0";
                $menu_set->order = "1";
                $menu_set->description = "";
                $menu_set->save();

              
                
                session()->flash('message', 'Successfully Added');
                return response()->json(['message' => 'Successfully Added']);
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
        //
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
            if($request->moveprocess == "moveSingle" || $request->moveprocess == "moveMulti" ){

           $sel_id = $request->id;
           $action = $request->action;
        

           if($action=="9" || $action=="11"){
           
              foreach ($sel_id as $ids) 
              {
                   $merchant = cseo_merchant::where('id', $ids)->update(['status_id'=> $action]);
              }

               if($action=="9"){
                       $promptmessages = 'Successfully Deleted';
               }else{
                       $promptmessages = 'Successfully Restore';
               }

           }else{
               
               foreach ($sel_id as $ids) 
               {
                   $merchant = cseo_merchant::where('id', $ids)->delete();
               }

                   $promptmessages = 'Permanently Deleted';
           } 

           return response()->json(['message' => $promptmessages]);

        }else{


              $merchant = cseo_merchant::find($id);

               $this->validate($request,[
                          'merchant_name'=>'required',
                                             
                  ]);

               $validate = Validator::make($request->all(), [
                      'merchant_name'=>'required',                   
                      ]);
                 

                if ($validate->fails())
                 {
                      return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
                     
                 }else{
                      $merchant->merchant_name = $request->merchant_name;
                      $merchant->team_merchant_id = $request->team_id;
                      $merchant->save();

                      session()->flash('message', 'Successfully Updated');
                      return response()->json(['message' => 'Successfully Updated']);

                  }
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
        $merchant = cseo_merchant::find($id);
        $merchant->delete();

        session()->flash('message', 'Successfully Deleted');
        return response()->json(['message' => 'Successfully Deleted']);

    }
}
