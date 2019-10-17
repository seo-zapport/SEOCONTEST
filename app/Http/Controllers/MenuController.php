<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\cseo_category;
use App\cseo_pages;
use App\cseo_menu_setups;
use App\cseo_menu;
use App\cseo_options_settings;
use App\cseo_merchant;
use App\cseo_account;
use App\cseo_team;

use DB;
use URL;
use Input;


class MenuController extends Controller
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
              
              if($this->user->status_id == '1' || $this->user->status_id == '4'){
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
        
        //$lang_id = $request->lang_id;
        $lang_id = "1";

        $page = cseo_pages::where('status_id', '9')->where('lang_id', $lang_id)->where('cseo_pages.merchants_id', $merchant->id)->latest()->get();
        $menuAll = cseo_menu::where('status_id','9')->where('cseo_menus.merchants_id', $merchant->id)->latest()->get();
        $menu = cseo_menu::where('status_id','9')->where('cseo_menus.merchants_id', $merchant->id)->latest()->first();
        
        if(count($menu)>0){
            $default = cseo_menu::Select(DB::raw("(select id from cseo_menus where default_id = '1') def_id,(select id from cseo_menus where footer_d_id = '1') ft_def_id"))->where('id', $menu->id)->first();
            $menu_setup = cseo_menu_setups::where('menu_id', $menu->id)->with('children')->orderBy('order','asc')->get();
        }

        if(request()->has('search')){
           $search = request('search');    
           $menulist = cseo_menu::select('cseo_menus.id','cseo_menus.menu_name','cseo_menus.created_at','cseo_merchants.merchant_name','cseo_accounts.display_name', 'cseo_menus.default_id', 'cseo_menus.footer_d_id')->join('cseo_merchants', 'cseo_merchants.id', 'cseo_menus.merchants_id')->join('cseo_accounts', 'cseo_accounts.id', 'cseo_menus.user_id')->where('cseo_menus.status_id','9')->where('cseo_menus.menu_name','like', "%".$search."%")->latest('cseo_menus.created_at')->appends('search',$search);
        }else {
            $menulist = cseo_menu::select('cseo_menus.id','cseo_menus.menu_name','cseo_menus.created_at','cseo_merchants.merchant_name','cseo_accounts.display_name', 'cseo_menus.default_id', 'cseo_menus.footer_d_id')->join('cseo_merchants', 'cseo_merchants.id', 'cseo_menus.merchants_id')->join('cseo_accounts', 'cseo_accounts.id', 'cseo_menus.user_id')->where('cseo_menus.status_id','9')->latest('cseo_menus.created_at')->paginate(10);
        }
        
        return view('system.appearance.menu.index', compact('menuAll','menu','category','menulist', 'menu_setup','page','default','site_identity'));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
            //$lang_id = $request->lang_id;
            $lang_id = '1';
            $lang = cseo_team::get();  
            $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();
            $merchantlist = cseo_merchant::latest()->get();

            $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();
             if ( count( $title ) > 0 ) {
                 $site_identity = json_decode( $title->site_identity);
             }        
                  
             if(Auth::user()->status_id == '4'){
                $menuAll = cseo_menu::where('status_id','9')->where('merchants_id', $merchant->id)->where('lang_id', '1')->latest()->get();
                $page = cseo_pages::where('status_id', '9')->where('merchants_id', $merchant->id)->where('lang_id', '1')->latest()->get();
                $menu = cseo_menu::where('status_id','9')->where('merchants_id', $merchant->id)->where('lang_id', '1')->latest()->first();
             }else{

                $page = cseo_pages::SELECT(DB::raw('cseo_pages.id, cseo_pages.page_title, cseo_merchants.merchant_name, cseo_pages.created_at'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_pages.merchants_id')->where('cseo_pages.status_id', '9')->where('cseo_pages.lang_id', '1')->latest()->get();  
                
                $menuAll = cseo_menu::where('status_id','9')->latest()->get();
                $menu = cseo_menu::where('status_id','9')->latest()->first();
             }

           if(count($menu)>0){
              $default = cseo_menu::Select(DB::raw("(select id from cseo_menus where default_id = '1') def_id,(select id from cseo_menus where footer_d_id = '1') ft_def_id"))->where('id', $menu->id)->first();    
              $menu_setup = cseo_menu_setups::where('menu_id', $menu->id)->with('children')->orderBy('order','asc')->get();
           }
    
            if(request()->has('search')){
               $search = request('search');    
               $menulist = cseo_menu::select('cseo_menus.id','cseo_menus.menu_name','cseo_menus.created_at','cseo_merchants.merchant_name','cseo_accounts.display_name')->join('cseo_merchants', 'cseo_merchants.id', 'cseo_menus.merchants_id')->join('cseo_accounts', 'cseo_accounts.id', 'cseo_menus.user_id')->where('cseo_menus.status_id','9')->where('cseo_menus.menu_name','like', "%".$search."%")->latest('cseo_menus.created_at')->appends('search',$search);
            }else {
                $menulist = cseo_menu::select('cseo_menus.id','cseo_menus.menu_name','cseo_menus.created_at','cseo_merchants.merchant_name','cseo_accounts.display_name')->join('cseo_merchants', 'cseo_merchants.id', 'cseo_menus.merchants_id')->join('cseo_accounts', 'cseo_accounts.id', 'cseo_menus.user_id')->where('cseo_menus.status_id','9')->latest('cseo_menus.created_at')->paginate(10);
            }
           
           return view('system.appearance.menu.create', compact('menuAll','menu','category','menulist','page','default','site_identity','merchantlist','lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
         $lang = cseo_team::get();
         $action = $request->action;
         $merchant = cseo_merchant::where('merchant_name', $request->merchant)->first();

         if($action == "AddMenu")
         {
              $label = $request->label; 
              $idlabel = $request->label_id; 

              if($request->url == "category"){
                  $linkquery = new cseo_category;
                  $cat_stat = 1;
              }else{
                  //$linkquery  = new cseo_page;
                  $cat_stat = 0;
              }

               $i = 0;
                  foreach ($idlabel as $idlabels) {
                      //foreach ($label as $labels ) {
                          //$page = cseo_pages::where('page_name', $labels)->orwhere('page_title', $labels)->latest()->first(); 
                          $page = cseo_pages::where('id', $idlabels)->latest()->first(); 
                          $menuorder = cseo_menu_setups::orderBy('order', 'desc')->first();
                          
                          if(count($menuorder)<1){
                              $order = 1;
                          }else{
                              $order = $menuorder->order+1;    
                          }

                          $menu_setup = new cseo_menu_setups;

                          $menu_setup->menu_id = $request->menu_id;
                          //$menu_setup->label = $labels;
                          $menu_setup->label = $page->page_title;
                          $menu_setup->title_attrib = $page->page_title;
                          //$menu_setup->link = "/".strtolower(str_replace(' ', '-', $labels));
                          $menu_setup->link = "/".strtolower(str_replace(' ', '-', $page->page_title));
                          $menu_setup->parent_id = 0;
                          $menu_setup->pages_id = $page->id;
                          $menu_setup->tab_cat = $cat_stat; 
                          $menu_setup->lang_id = $page->lang_id; 

                          $menu_setup->order = $order; 
                          $menu_setup->save();
                          $last_id = $menu_setup->menu_id;

                      ++$i;
                      }
                  /*}*/

         }elseif($action == "AddCustomMenu") {
          
                          $menuorder = cseo_menu_setups::orderBy('order', 'desc')->first();;
                          
                          if(count($menuorder)<1){
                              $order = 1;
                          }else{
                              $order = $menuorder->order+1;    
                          }

                          $menu_setup = new cseo_menu_setups;
                          $menu_setup->menu_id = $request->menu_id;
                          $menu_setup->link = $request->link;
                          $menu_setup->label = $request->label;
                          $menu_setup->title_attrib = $request->label;
                          //$menu_setup->tab_cat = 0;
                          $menu_setup->custom_menu = $request->stat;
                          $menu_setup->lang_id = $request->lang_id;
                          $menu_setup->parent_id = 0;
                          $menu_setup->order = $order; 
                          
                          $menu_setup->save();

                          $last_id = $menu_setup->menu_id;
       
         }elseif ($action == "UpdateBrand") {
              
                $primary = cseo_menu::where('id' , $request->prim_id )->update(['merchants_id' => $merchant->id]);
                
               //$merchantprimary = cseo_menu::where('merchants_id', $merchant->id)->where('id' ,'<>', $request->prim_id )->update(['merchants_id' => '0']);

                return response()->json(['status'=>'success','message'=>'Successfully Added' ]);        

         }else{

                  $menu = new cseo_menu;

                  $menu->menu_name = $request->menu_name;
                  $menu->merchants_id = $merchant->id;
                  $menu->default_id = 0;
                  $menu->footer_d_id = 0;
                  $menu->user_id = Auth::user()->id;
                  $menu->status_id = "9";

                  $menu->save();

                  $last_id = $menu->id;

                 //$menuorder = cseo_menu_setups::where('menu_id', $last_id)->orderBy('order', 'desc')->first();;
                 
                 //if(count($menuorder)<1){
                     $order = 1;
                 //}else{
                   //  $order = $menuorder->order+1;    
                 //}
                 
                 foreach ($lang as $langs) {

                  $menu_setup = new cseo_menu_setups;

                  $menu_setup->menu_id = $last_id;
                  $menu_setup->link = '/';
                  $menu_setup->label = 'Home';
                  $menu_setup->title_attrib = 'Home';
                  $menu_setup->custom_menu = 1;
                  $menu_setup->tab_cat = 0;
                  $menu_setup->parent_id = 0;
                  $menu_setup->lang_id = $langs->id;
                  $menu_setup->order = $order; 
                  
                  $menu_setup->save();    

                  $menu_setup_b = new cseo_menu_setups;

                  $menu_setup_b->menu_id = $last_id;
                  $menu_setup_b->link = '/banner';
                  $menu_setup_b->label = 'Banner';
                  $menu_setup_b->title_attrib = 'Banner';
                  $menu_setup_b->custom_menu = 1;
                  $menu_setup_b->tab_cat = 0;
                  $menu_setup_b->parent_id = 0;
                  $menu_setup_b->lang_id = $langs->id;
                  $menu_setup_b->order = $order+1; 
                  
                  $menu_setup_b->save(); 

                  $menu_setup_p = new cseo_menu_setups;

                  $menu_setup_p->menu_id = $last_id;
                  $menu_setup_p->link = '/participants';
                  $menu_setup_p->label = 'Participants';
                  $menu_setup_p->title_attrib = 'Participants';
                  $menu_setup_p->custom_menu = 1;
                  $menu_setup_p->tab_cat = 0;
                  $menu_setup_p->parent_id = 0;
                  $menu_setup_p->lang_id = $langs->id;
                  $menu_setup_p->order = $order+2; 
                  
                  $menu_setup_p->save(); 

                  $menu_setup_r = new cseo_menu_setups;

                  $menu_setup_r->menu_id = $last_id;
                  $menu_setup_r->link = '/reward';
                  $menu_setup_r->label = 'Reward';
                  $menu_setup_r->title_attrib = 'Reward';
                  $menu_setup_r->custom_menu = 1;
                  $menu_setup_r->tab_cat = 0;
                  $menu_setup_r->parent_id = 0;
                  $menu_setup_r->lang_id = $langs->id;
                  $menu_setup_r->order = $order+3; 
                  $menu_setup_r->pop_m = 0; 
                  
                  $menu_setup_r->save(); 

                  $menu_setup_rank = new cseo_menu_setups;

                  $menu_setup_rank->menu_id = $last_id;
                  $menu_setup_rank->link = '/#seoWrap';
                  $menu_setup_rank->label = 'Ranking';
                  $menu_setup_rank->title_attrib = 'Ranking';
                  $menu_setup_rank->custom_menu = 1;
                  $menu_setup_rank->tab_cat = 0;
                  $menu_setup_rank->parent_id = 0;
                  $menu_setup_rank->lang_id = $langs->id;
                  $menu_setup_rank->order = $order+4; 
                  $menu_setup_rank->pop_m = 0; 
                  
                  $menu_setup_rank->save();
                 }
         }

         $countrylang  = cseo_menu_setups::where('menu_id', $last_id)->where('lang_id', $request->lang_id)->with('children')->orderBy('order','asc')->get();
         $data_result = view('system.appearance.menu.ajax-menulist',compact('countrylang'))->render();
         $data_modal = view('system.appearance.menu.ajax-modal',compact('countrylang'))->render();

         if($action ==  "AddMenu" || $action ==  "AddCustomMenu" || $action ==  "UpdateBrand"){

            return response()->json(array('success' => true, 'menulist' => $data_result, 'modal' => $data_modal ));
       
         }else{
           
            return response()->json(['status'=>'success','message'=>'Successfully Added', 'id'=> $last_id ]);
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
      
      //$lang_id = $request->lang_id;
      $lang_id = '1';
      $lang = cseo_team::get();
      $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

      $merchantlist = cseo_merchant::latest()->get();

      $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();
       if ( count( $title ) > 0 ) {
           $site_identity = json_decode( $title->site_identity);
       }  
       
       if(Auth::user()->status_id == '4'){
          $menuAll = cseo_menu::where('status_id','9')->where('merchants_id', $merchant->id)->where('lang_id', $lang_id)->latest()->get();
          $page = cseo_pages::where('status_id', '9')->where('merchants_id', $merchant->id)->where('lang_id', $lang_id)->latest()->get();
          $menu = cseo_menu::where('status_id','9')->where('merchants_id', $merchant->id)->where('lang_id', $lang_id)->latest()->first();
       }else{

          $page = cseo_pages::SELECT(DB::raw('cseo_pages.id, cseo_pages.page_title, cseo_merchants.merchant_name, cseo_pages.created_at'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_pages.merchants_id')->where('cseo_pages.status_id', '9')->where('cseo_pages.lang_id', '1')->latest()->get();  
          
          $menuAll = cseo_menu::where('status_id','9')->latest()->get();
          $menu = cseo_menu::where('id',$id)->where('status_id','9')->latest()->first();
       }

        $default = cseo_menu::Select(DB::raw("(select id from cseo_menus where default_id = '1') def_id,(select id from cseo_menus where footer_d_id = '1') ft_def_id"))->first();

        if(count($menu)>0){
            $menu_setup = cseo_menu_setups::where('menu_id', $menu->id)->where('lang_id', $lang_id)->with('children')->orderBy('order','asc')->get();
        }

        $langdef = $menu_setup;
        
        if(request()->has('search')){
           $search = request('search');    
           $menulist = cseo_menu::select('cseo_menus.id','cseo_menus.menu_name','cseo_menus.created_at','cseo_merchants.merchant_name','cseo_accounts.display_name')->join('cseo_merchants', 'cseo_merchants.id', 'cseo_menus.merchants_id')->join('cseo_accounts', 'cseo_accounts.id', 'cseo_menus.user_id')->where('cseo_menus.status_id','9')->where('cseo_menus.menu_name','like', "%".$search."%")->latest('cseo_menus.created_at')->appends('search',$search);
        }else {
            $menulist = cseo_menu::select('cseo_menus.id','cseo_menus.menu_name','cseo_menus.created_at','cseo_merchants.merchant_name','cseo_accounts.display_name')->join('cseo_merchants', 'cseo_merchants.id', 'cseo_menus.merchants_id')->join('cseo_accounts', 'cseo_accounts.id', 'cseo_menus.user_id')->where('cseo_menus.status_id','9')->latest('cseo_menus.created_at')->paginate(10);
        }
         return view('system.appearance.menu.edit', compact('category','menu_setup','menu', 'menuAll','menulist','page','default','site_identity','merchantlist','lang','langdef'));
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
         $action = $request->action;
         $merchant = cseo_merchant::where('merchant_name', $request->merchant)->first();

         if($action == "Updatemenu"){

             $menu = cseo_menu::find($id);

             $menu->menu_name = $request->menu_name;
             $menu->default_id = $request->default_id;
             $menu->footer_d_id = $request->footer_d_id;
             $menu->merchants_id = $merchant->id;
             $menu->user_id = Auth::user()->id;
             $menu->status_id = "9";

             $menu->save();

             $last_id = $menu->id;
             
             if($request->default_id=='1'){
                 $primary_did = cseo_menu::where('merchants_id', $merchant->id)->where('default_id', $request->default_id)->where('id' ,'<>', $last_id )->update(['default_id' => '0']); 
             }
             if($request->footer_d_id=='1'){
                 $primary_fid = cseo_menu::where('merchants_id', $merchant->id)->where('footer_d_id', $request->footer_d_id)->where('id' ,'<>', $last_id )->update(['footer_d_id' => '0']); 
             }    

             return response()->json(['status'=>'success','message'=>'Successfully Added', 'id'=> $last_id ]);
        
        }elseif($action == "updatedefault"){
             
            if($request->default_id=='1'){

              $update_pd = cseo_menu::where('merchants_id', $merchant->id)->where('id', $request->primary_menu_id)->update(['default_id' => '1']);
              $primary_did = cseo_menu::where('merchants_id', $merchant->id)->where('default_id', $request->default_id)->where('id' ,'<>', $request->primary_menu_id)->update(['default_id' => '0']); 

            }
            if($request->footer_d_id=='1'){

              $update_fd = cseo_menu::where('merchants_id', $merchant->id)->where('id', $request->footer_menu_id)->update(['footer_d_id' => '1']);
              $primary_did = cseo_menu::where('merchants_id', $merchant->id)->where('footer_d_id', $request->footer_d_id)->where('id' ,'<>', $request->footer_menu_id )->update(['footer_d_id' => '0']); 
            }    

             return response()->json(['status'=>'success','message'=>'Successfully Updated' ]);

        }else{

             $menu_setup = cseo_menu_setups::find($id);

             $menu_setup->label = $request->label;
             $menu_setup->link = $request->link;
             $menu_setup->title_attrib = $request->title_attrib;
             $menu_setup->tab_status = $request->tab_status;
             $menu_setup->pop_m = $request->pop_mod;
             $menu_setup->css_class = $request->css_class;
             $menu_setup->link_rel = $request->link_rel;
             $menu_setup->description = $request->description;

             $menu_setup->save();
             
             $last_id = $menu_setup->menu_id;

            //return response()->json(['status'=>'success','message'=>'Successfully Added' ]);

             $countrylang  = cseo_menu_setups::where('menu_id', $last_id)->where('lang_id', $request->lang_id)->with('children')->orderBy('order','asc')->get();
             $data_result = view('system.appearance.menu.ajax-menulist',compact('countrylang'))->render();
             $data_modal = view('system.appearance.menu.ajax-modal',compact('countrylang'))->render();

             return response()->json(array('success' => true, 'menulist' => $data_result, 'modal' => $data_modal ));
        }
   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
       $action = $request->action;

        if($action == "Deletemenu"){

            $menu = cseo_menu::find($id);
            $menu->delete();  

            $menu_setup = cseo_menu_setups::where('menu_id',$id)->delete();

            return response()->json(['message' => "Successfully"]);
          
        }else{

            $menu_setup = cseo_menu_setups::find($id);
            $menu_setup->delete();
            return redirect(redirect()->getUrlGenerator()->previous());
        }

    }

    public function Nestable(Request $request)
    {
        $order = 0;
        $parent_id = 0;
        $id = [];

        foreach ($request->list as $list) 
        {
            $order++;    
            $id[] = $list['id'];

            $menu_setup = cseo_menu_setups::where('id', $list['id'])->update(['order'=> $order,'parent_id'=>  $parent_id ]);
          
            if (array_key_exists("children", $list)) {
            
                foreach($list['children'] as $clist){

                    $menu_setup = cseo_menu_setups::where('id',$clist['id'])->update(['order'=> $order, 'parent_id'=> $list['id']]);
                        
                }
            }
        }

        return response()->json(['message' => "Successfully"]);
    }

    public function pageslang(Request $request)
    {

          $countrylang  = cseo_menu_setups::where('menu_id', $request->pageid)->where('lang_id', $request->lang_id)->with('children')->orderBy('order','asc')->get();
          $pagelist = cseo_pages::SELECT(DB::raw('cseo_pages.id, cseo_pages.page_title, cseo_merchants.merchant_name, cseo_pages.created_at'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_pages.merchants_id')->where('cseo_pages.status_id', '9')->where('lang_id', $request->lang_id)->latest()->get();
            
          if(count($countrylang)>0){

            $data_result = view('system.appearance.menu.ajax-menulist',compact('countrylang'))->render();
            $data_modal = view('system.appearance.menu.ajax-modal',compact('countrylang'))->render();
            $data_pagelist = view('system.appearance.menu.ajax-pagelist',compact('pagelist'))->render();

            return response()->json(array('success' => true, 'menulist' => $data_result, 'pagelist' => $data_pagelist, 'modal' => $data_modal ));

          }else{

            $order = '1';
            $menu_setup = new cseo_menu_setups;

            $menu_setup->menu_id =  $request->pageid;
            $menu_setup->link = '/';
            $menu_setup->label = 'Home';
            $menu_setup->title_attrib = 'Home';
            $menu_setup->custom_menu = 1;
            $menu_setup->tab_cat = 0;
            $menu_setup->parent_id = 0;
            $menu_setup->lang_id = $request->lang_id;
            $menu_setup->order = $order; 
            
            $menu_setup->save();    

            $menu_setup_b = new cseo_menu_setups;

            $menu_setup_b->menu_id =  $request->pageid;
            $menu_setup_b->link = '/banner';
            $menu_setup_b->label = 'Banner';
            $menu_setup_b->title_attrib = 'Banner';
            $menu_setup_b->custom_menu = 1;
            $menu_setup_b->tab_cat = 0;
            $menu_setup_b->parent_id = 0;
            $menu_setup_b->lang_id = $request->lang_id;
            $menu_setup_b->order = $order+1; 
            
            $menu_setup_b->save(); 

            $menu_setup_p = new cseo_menu_setups;

            $menu_setup_p->menu_id =  $request->pageid;
            $menu_setup_p->link = '/participants';
            $menu_setup_p->label = 'Participants';
            $menu_setup_p->title_attrib = 'Participants';
            $menu_setup_p->custom_menu = 1;
            $menu_setup_p->tab_cat = 0;
            $menu_setup_p->parent_id = 0;
            $menu_setup_p->lang_id = $request->lang_id;
            $menu_setup_p->order = $order+2; 
            
            $menu_setup_p->save(); 

            $menu_setup_r = new cseo_menu_setups;

            $menu_setup_r->menu_id =  $request->pageid;
            $menu_setup_r->link = '/reward';
            $menu_setup_r->label = 'Reward';
            $menu_setup_r->title_attrib = 'Reward';
            $menu_setup_r->custom_menu = 1;
            $menu_setup_r->tab_cat = 0;
            $menu_setup_r->parent_id = 0;
            $menu_setup_r->lang_id = $request->lang_id;
            $menu_setup_r->order = $order+3; 
            $menu_setup_r->pop_m = 0; 
            
            $menu_setup_r->save(); 

            $menu_setup_rank = new cseo_menu_setups;

            $menu_setup_rank->menu_id =  $request->pageid;
            $menu_setup_rank->link = $request->merchant.'/#seoWrap';
            $menu_setup_rank->label = 'Ranking';
            $menu_setup_rank->title_attrib = 'Ranking';
            $menu_setup_rank->custom_menu = 1;
            $menu_setup_rank->tab_cat = 0;
            $menu_setup_rank->parent_id = 0;
            $menu_setup_rank->lang_id = $request->lang_id;
            $menu_setup_rank->order = $order+4; 
            $menu_setup_rank->pop_m = 0; 
            
            $menu_setup_rank->save();

          }
    }

}
