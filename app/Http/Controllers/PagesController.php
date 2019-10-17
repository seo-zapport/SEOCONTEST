<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\cseo_pages;
use App\cseo_meta;
use App\cseo_account;
use App\cseo_media;
use App\cseo_merchant;
use App\cseo_options_settings;
use App\cseo_team;


use DB;
use URL;
use Validator;
use Redirect;

class PagesController extends Controller
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

        $page = new cseo_pages;

         $cseo_count = $page->SELECT(DB::raw("(SELECT count(*) from cseo_pages where status_id = '9' and lang_id = '1' or status_id = '12' and lang_id = '1') countAll, (SELECT count(*) from cseo_pages where status_id = '9'and lang_id = '1') countPublished , (SELECT count(*) from cseo_pages where status_id = '11'and lang_id = '1') countTrash, (SELECT count(*) from cseo_pages where status_id = '12'and lang_id = '1') countDraft"))->first(); 

         $query = [];
         $searchpages = ['cseo_pages.page_title'];    

        if(request()->has('search') && request()->has('status_id')){

            $search = request('search');    
            $statusid = request('status_id'); 
            
            $page = $page::SELECT(DB::raw("cseo_pages.id as page_id, cseo_pages.page_title,cseo_pages.status_id,cseo_pages.curr_status_id, cseo_pages.created_at, cseo_accounts.display_name,cseo_merchants.merchant_name,cseo_teams.name"))->join('cseo_accounts', 'cseo_accounts.id' , '=', 'cseo_pages.user_id')->join('cseo_merchants','cseo_merchants.id','=','cseo_pages.merchants_id')->join('cseo_teams', 'cseo_teams.id', 'cseo_pages.lang_id');

            foreach ($searchpages as $search) {
              $page->orwhere($search, 'LIKE', "%".$search."%")->where('cseo_pages.status_id',  "%".$statusid."%")->where('lang_id', '1')->orderBy('cseo_pages.created_at','desc')->orderBy('cseo_merchants.id','asc')->latest();
            }     
            
            $query['search'] = $search;
            $query['status_id'] = $statusid;


        }elseif(request()->has('status_id')){

            $query['status_id'] = request('status_id');

            $page = $page::SELECT(DB::raw("cseo_pages.id as page_id, cseo_pages.page_title,cseo_pages.status_id,cseo_pages.curr_status_id, cseo_pages.created_at, cseo_accounts.display_name,cseo_merchants.merchant_name,cseo_teams.name"))->join('cseo_accounts', 'cseo_accounts.id' , '=', 'cseo_pages.user_id')->join('cseo_merchants','cseo_merchants.id','=','cseo_pages.merchants_id')->join('cseo_teams', 'cseo_teams.id', 'cseo_pages.lang_id')->where('cseo_pages.status_id', request('status_id'))->where('lang_id', '1')->orderBy('cseo_pages.created_at','desc')->orderBy('cseo_merchants.id','asc')->latest();
        

        }elseif(request()->has('search')){   

            $search = request('search');    
            $query['search'] = $search;

            $page = $page::SELECT(DB::raw("cseo_pages.id as page_id, cseo_pages.page_title,cseo_pages.status_id,cseo_pages.curr_status_id, cseo_pages.created_at, cseo_accounts.display_name,cseo_merchants.merchant_name,cseo_teams.name"))->join('cseo_accounts', 'cseo_accounts.id' , '=', 'cseo_pages.user_id')->join('cseo_merchants','cseo_merchants.id','=','cseo_pages.merchants_id')->join('cseo_teams', 'cseo_teams.id', 'cseo_pages.lang_id');

            foreach ($searchpages as $search) {
              $page->orwhere($search, 'LIKE', "%".$search."%")->where('cseo_pages.status_id', '9')->where('lang_id', '1')->orderBy('cseo_pages.created_at','desc')->orderBy('cseo_merchants.id','asc')->latest();
            }     

        }else {

            $page = $page::SELECT(DB::raw("cseo_pages.id as page_id, cseo_pages.page_title,cseo_pages.status_id,cseo_pages.curr_status_id, cseo_pages.created_at, cseo_accounts.display_name,cseo_merchants.merchant_name,cseo_teams.name"))->join('cseo_accounts', 'cseo_accounts.id' , '=', 'cseo_pages.user_id')->join('cseo_merchants','cseo_merchants.id','=','cseo_pages.merchants_id')->join('cseo_teams', 'cseo_teams.id', 'cseo_pages.lang_id')->where('cseo_pages.status_id', '9')->where('lang_id', '1')->orwhere('cseo_pages.status_id', '12')->where('lang_id', '1')->orderBy('cseo_pages.created_at','desc')->orderBy('cseo_merchants.id','asc')->latest();
            
        }    

        $page = $page->paginate(10)->appends($query);
        $page_count = $page->count();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }        

        return view('system.pages.index', compact('cseo_count', 'page','page_count','site_identity'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        

     $lang = cseo_team::get();
     
     $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();
     
     
     if(Auth::user()->status_id != "4" ){

         $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->latest('cseo_media.created_at')->get();

     }else{

         $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->where('merchants_id',$merchant->id)->latest('cseo_media.created_at')->get();
     }

     

     $merchantlist = cseo_merchant::where('status_id', '9')->latest()->get();
     
     $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }        

        return view('system.pages.create', compact('media','site_identity','merchantlist', 'lang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $page = new cseo_pages;
        $meta = new cseo_meta;
        
        $action = $request->action;

        $merchant = cseo_merchant::where('merchant_name', $request->merchant)->first();


         $validate = Validator::make($request->all(), [
                               'page_title'=>'required',
                               ]);

        if($request->cseo_media_id==""){
               $media_id = '1'; 
        }else {
              $media_id =  $request->cseo_media_id;
        }

        if($action == "draft") { 
            $status = "12";
        }else{
            $status = "9";
        }
        
            if ($validate->fails())
             {
                  return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
                 
             }else{    
        

            $page->page_name = $request->page_name;
            $page->page_title = $request->page_title;
            $page->page_content = str_replace('../../..','http://qqseocontest.com',$request->page_content);
            $page->url_path = "/".strtolower(str_replace(' ', '-', $request->page_name));
            $page->page_type = "pages";
            $page->rev_count = "0";
            $page->cseo_media_id = $media_id;
            $page->cseo_category_id = "0";
            $page->status_id = $status;
            $page->curr_status_id = $status;
            $page->merchants_id = $merchant->id;
            $page->lang_id = $request->lang_id;
            $page->user_id = Auth::user()->id;
            $page->save();

            $pageslastinsert = $page->id;

            if($request->meta_title == "") {
             $meta_title = $request->page_title; 
            }else{
             $meta_title = $request->meta_title; 
            }

            if($request->meta_description == "") {
             $meta_desc = str_limit(str_replace(array("<p>", "</p>", "<br />"), "",html_entity_decode($request->page_content)), 150, ''); 
            }else{
             $meta_desc = $request->meta_description; 
            }

            $meta->page_id = $pageslastinsert;
            $meta->meta_title = $meta_title;
            $meta->meta_description = $meta_desc;
            $meta->save();

            if($action != "draft"){
                $meta_draft = $page::where('id', $request->temp_id)->update(['status_id' => '13', 'curr_status_id' => '12']);
            }

            return response()->json(['status'=>'success','message'=>'Successfully Added', 'last_id'=> $pageslastinsert ]);
            
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
        $page = new cseo_pages;

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $page = $page::SELECT(DB::raw('cseo_pages.id as pagesid, cseo_pages.page_title, cseo_pages.page_content, cseo_pages.page_recent_title, cseo_pages.page_recent_content, cseo_pages.updated_at, cseo_accounts.display_name'))->join('cseo_accounts', 'cseo_accounts.id', 'cseo_pages.recent_user_id')->where('cseo_pages.id', $id)->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }              

        return view('system.pages.show', compact('page', 'site_identity','merchantlist'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lang = cseo_team::get();
        $page = new cseo_pages;
        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();
        
        if(Auth::user()->status_id != "4" ){

            $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->latest('cseo_media.created_at')->get();

        }else{

            $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->where('merchants_id',$merchant->id)->latest('cseo_media.created_at')->get();
        }

         $merchantlist = cseo_merchant::where('status_id', '9')->latest()->get();

        $page = $page::SELECT(DB::raw("cseo_pages.id,cseo_pages.page_title,cseo_pages.page_content,cseo_pages.url_path,cseo_pages.rev_count,cseo_pages.cseo_media_id,cseo_pages.status_id,cseo_pages.curr_status_id,cseo_pages.created_at,cseo_metas.meta_title,cseo_metas.meta_description,cseo_metas.meta_keyword,cseo_media.media_name,cseo_merchants.merchant_name, cseo_pages.merchants_id, cseo_pages.lang_id, cseo_pages.parent_id"))->join('cseo_metas', 'cseo_metas.page_id', '=', 'cseo_pages.id')->leftJoin('cseo_media', 'cseo_pages.cseo_media_id', '=','cseo_media.id')->join('cseo_merchants', 'cseo_merchants.id', 'cseo_pages.merchants_id')->where('cseo_pages.id',$id)->where('cseo_pages.status_id', '9')->orwhere('cseo_pages.id',$id)->where('cseo_pages.status_id', '12')->first();

         $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }              

        if(count($page)>0){
            return view('system.pages.edit', compact('page', 'media','site_identity','merchantlist', 'lang'));
        }else{
            session()->flash('message', 'This record cannot be Edited');
            return Redirect('/system/pages');
        }    
            

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

           $recentpage =  cseo_pages::where('id',$id)->first();

          if($request->moveprocess == "moveSingle" || $request->moveprocess == "moveMulti" ){

           $sel_id = $request->id;
           $action = $request->action;
           $curr_action = $request->curr_status; 

           if($action=="9" || $action=="11" || $action=="12" ){
           
              foreach ($sel_id as $ids) 
              {

                   $pagefind = cseo_pages::where('id', $ids)->first(); 

                  if($request->moveprocess == "moveMulti"){
                    if($action == "9"){
                        $action_now =  $pagefind->curr_status_id;
                    }else{
                        $action_now = $action;
                    }
                  } else{
                        $action_now = $action;
                  }
  
                   $pages = cseo_pages::where('id', $ids)->update(['status_id'=> $action_now,'curr_status_id'=> $pagefind->status_id]);              
              }

               if($action=="11"){
                       $promptmessages = 'Successfully Move to Trash';
                       $lastact = "Trash";
               }else{
                       $promptmessages = 'Successfully Updated Status';
                       $lastact = "Edit Status";
               }

           }else{
               
               foreach ($sel_id as $ids) 
               {
                   $pages = cseo_pages::where('id', $ids)->delete();
                   $meta = cseo_meta::where('page_id', $ids)->delete();               

               }

                   $promptmessages = 'Permanently Deleted';
                   $lastact = "Deleted";
           } 

            return response()->json(['status'=>'success','message'=> $promptmessages,'lastact' => $lastact]);

        }else{

             if($request->action=="11"){
             
                    $pages = cseo_pages::where('id', $id)->update(['status_id'=> $action,'curr_status_id'=> $curr_action]);  

                    session()->flash('message', 'Successfully Move to Trash');
                    return response()->json(['message'=>'Successfully Move to Trash']);     

             }else{
                 
                     $page =  cseo_pages::find($id);
                     
                     $action = $request->action;

                     $merchant = cseo_merchant::where('merchant_name', $request->merchant)->first();

                     $validate = Validator::make($request->all(), [
                                            'page_title'=>'required',
                                            ]);

                     if($page->page_name != $request->page_name || $page->page_title != $request->page_title || $page->page_content != $request->page_content || $page->url_path != "/".strtolower(str_replace(' ', '-', $request->page_name)) || $page->cseo_media_id != $request->cseo_media_id  ) {
                         $rev_count = $page->rev_count+1;
                     }else{
                         $rev_count = $page->rev_count;
                     }

                         if($request->cseo_media_id==""){
                                $media_id = '1'; 
                         }else {
                               $media_id =  $request->cseo_media_id;
                         }

                           if($action == "draft") { 
                               $status = "12";
                           }else{
                               $status = "9";
                           }
                           
                        if ($validate->fails())
                         {
                              return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
                             
                         }else{    
                    
                         //$page->page_name = $request->page_name;
                         $page->page_title = $request->page_title;
                         $page->page_content = str_replace('../../..','http://qqseocontest.com',$request->page_content);
                         $page->url_path = "/".strtolower(str_replace(' ', '-', $request->page_name));
                         $page->page_type = "pages";
                         $page->rev_count = $rev_count;
                         $page->cseo_media_id = $media_id;
                         $page->cseo_category_id = "0";
                         $page->status_id = $status;
                         $page->curr_status_id = $status;
                         $page->merchants_id = $merchant->id;
                         $page->user_id = Auth::user()->id;
                         $page->page_recent_title = $recentpage->page_title;
                         $page->page_recent_content = $recentpage->page_content;
                         $page->recent_user_id = $recentpage->user_id;

                         //$page->lang_id = $request->lang_id;
                         //$page->user_id = "1";

                         $page->save();

                         $pageslastinsert = $page->id;

                         if($request->meta_title == "") {
                          $meta_title = $request->page_title; 
                         }else{
                          $meta_title = $request->meta_title; 
                         }

                         if($request->meta_description == "") {
                          $meta_desc = str_limit(str_replace(array("<p>", "</p>", "<br />"), "",html_entity_decode($request->page_content)), 150, ''); 
                         }else{
                          $meta_desc = $request->meta_description; 
                         }

                         $meta =  cseo_meta::where('page_id',  $id)->update(['meta_title' => $meta_title,'meta_description' => $meta_desc]);
                         return response()->json(['status'=>'success','message'=>'Successfully Added', 'last_id'=> $pageslastinsert ]);
                         
                         }
                    
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
        $page = cseo_pages::find($id);
        $page->delete();

        $meta_page = cseo_meta::where('page_id', $id)->delete();

        session()->flash('message', 'Successfully Deleted');
        return response()->json(['message' => 'Successfully Updated']); 
    }

    public function pageslang(Request $request){

        $page = new cseo_pages;
        $meta = new cseo_meta;
        
        $action = $request->action;
        $merchant = cseo_merchant::where('merchant_name', $request->merchant)->first();

        $validate = Validator::make($request->all(), [
                                       'page_title'=>'required',
                                       ]);
        
        $countryresult = cseo_pages::where('id', $request->pageid)->where('merchants_id', $merchant->id)->where('lang_id', $request->lang_id)->latest()->first();

        if(count($countryresult) > 0 ) {
                return response()->json(['status'=>'success','message'=>'Successfully Added', 'last_id'=> $countryresult->id ]);
        }else{

                $resultlang = cseo_pages::where('parent_id', $request->pageid)->where('merchants_id', $merchant->id)->where('lang_id', $request->lang_id)->latest()->first();

                if(count($resultlang) > 0 ) {

                    return response()->json(['status'=>'success','message'=>'Successfully Added', 'last_id'=> $resultlang->id ]);

                }else{

                if($request->cseo_media_id==""){
                       $media_id = '1'; 
                }else {
                      $media_id =  $request->cseo_media_id;
                }

                if($action == "draft") { 
                    $status = "12";
                }else{
                    $status = "9";
                }

                 if ($validate->fails())
                 {
                      return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
                     
                 }else{

                        $page->parent_id = $request->pageid;
                        $page->page_name = $request->page_name;
                        $page->page_title = $request->page_title;
                        $page->page_content = str_replace('../../..','http://qqseocontest.com',$request->page_content);
                        $page->url_path = "/".strtolower(str_replace(' ', '-', $request->page_name));
                        $page->page_type = "pages";
                        $page->rev_count = "0";
                        $page->cseo_media_id = $media_id;
                        $page->cseo_category_id = "0";
                        $page->status_id = $status;
                        $page->curr_status_id = $status;
                        $page->merchants_id = $merchant->id;
                        $page->lang_id = $request->lang_id;
                        $page->user_id = Auth::user()->id;
                        $page->save();

                        $pageslastinsert = $page->id;

                        if($request->meta_title == "") {
                         $meta_title = $request->page_title; 
                        }else{
                         $meta_title = $request->meta_title; 
                        }

                        if($request->meta_description == "") {
                         $meta_desc = str_limit(str_replace(array("<p>", "</p>", "<br />"), "",html_entity_decode($request->page_content)), 150, ''); 
                        }else{
                         $meta_desc = $request->meta_description; 
                        }

                        $meta->page_id = $pageslastinsert;
                        $meta->meta_title = $meta_title;
                        $meta->meta_description = $meta_desc;
                        $meta->save();

                         if($action != "draft"){
                             $meta_draft = $page::where('id', $request->temp_id)->update(['status_id' => '13', 'curr_status_id' => '12']);
                         }
                   return response()->json(['status'=>'success','message'=>'Successfully Added', 'last_id'=> $pageslastinsert ]);
                 }

            }
        }              
    }   

}
