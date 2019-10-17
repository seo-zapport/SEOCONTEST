<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\cseo_banner;
use App\cseo_category;
use App\cseo_media;
use App\cseo_statuses;
use App\cseo_merchant;
use App\cseo_options_settings;
use App\cseo_account;
use App\cseo_team;

use DB;
use URL;
use Image;
use Storage;
use Validator;
use Redirect;

class BannerController extends Controller
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
      
        $banner = new cseo_banner;


         $cseo_count = $banner->SELECT(DB::raw("(SELECT count(*) from cseo_banners  where lang_id ='2') countAll, (SELECT count(*) from cseo_banners where status_id = '9' and lang_id ='2') countPublished , (SELECT count(*) from cseo_banners where status_id = '11' and lang_id ='2') countTrash, (SELECT count(*) from cseo_banners where status_id = '10' and lang_id ='2') countUnpublished"))->join('cseo_categories','cseo_banners.cseo_categories_id', '=', 'cseo_categories.id')->join('cseo_media','cseo_banners.cseo_media_id','=','cseo_media.id')->first(); 

         $query = [];
         $searchbanner = ['cseo_banners.title_name','cseo_categories.category_name', 'cseo_statuses.status_name'];    

         if(request()->has('search') && request()->has('status_id')){            

          $search = request('search');    
          $statusid = request('status_id');    
          
           $banner = $banner->SELECT('cseo_banners.id as banner_id','cseo_banners.title_name','cseo_banners.created_at','cseo_categories.category_name','cseo_media.media_name','cseo_media.media_thumbnail','cseo_banners.status_id', 'cseo_banners.curr_status_id','cseo_statuses.status_name','cseo_merchants.merchant_name');

           foreach ($searchbanner as $searchbanners) {
                    $banner->orwhere($searchbanners,'like', "%".$search."%")->where('cseo_banners.status_id',$statusid)->where('cseo_banners.lang_id', '2');
             }

           $banner->join('cseo_categories','cseo_banners.cseo_categories_id', '=', 'cseo_categories.id')->join('cseo_statuses','cseo_banners.status_id', '=', 'cseo_statuses.id')->leftjoin('cseo_media','cseo_banners.cseo_media_id','=','cseo_media.id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_banners.merchants_id')->orderBy('cseo_merchants.id','desc')->latest();  

           $query['search'] = request('search'); 
           $query['status_id'] = request('status_id'); 
         

          }elseif(request()->has('status_id')){
         
            $banner = $banner->SELECT('cseo_banners.id as banner_id','cseo_banners.title_name','cseo_banners.created_at','cseo_categories.category_name','cseo_media.media_name','cseo_media.media_thumbnail','cseo_banners.status_id', 'cseo_banners.curr_status_id','cseo_statuses.status_name','cseo_merchants.merchant_name')->join('cseo_categories','cseo_banners.cseo_categories_id', '=', 'cseo_categories.id')->join('cseo_statuses','cseo_banners.status_id', '=', 'cseo_statuses.id')->leftjoin('cseo_media','cseo_banners.cseo_media_id','=','cseo_media.id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_banners.merchants_id')->where('cseo_banners.status_id',  request('status_id'))->where('cseo_banners.lang_id', '2')->orderBy('cseo_merchants.id','desc')->latest();    
            
            $query['status_id'] = request('status_id');


          }elseif(request()->has('search')){

               $search = request('search');    

               $banner = $banner->SELECT('cseo_banners.id as banner_id','cseo_banners.title_name','cseo_banners.created_at','cseo_categories.category_name','cseo_media.media_name','cseo_media.media_thumbnail','cseo_banners.status_id', 'cseo_banners.curr_status_id','cseo_statuses.status_name','cseo_merchants.merchant_name');

               foreach ($searchbanner as $searchbanners) {
                      $banner->orwhere($searchbanners,'like', "%".$search."%")->where('cseo_banners.status_id', '7')->where('cseo_banners.lang_id', '2')->orwhere($searchbanners,'like', "%".$search."%")->where('cseo_banners.status_id', '8')->where('cseo_banners.lang_id', '2');
               }
              $banner->join('cseo_categories','cseo_banners.cseo_categories_id', '=', 'cseo_categories.id')->join('cseo_statuses','cseo_banners.status_id', '=', 'cseo_statuses.id')->leftjoin('cseo_media','cseo_banners.cseo_media_id','=','cseo_media.id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_banners.merchants_id')->orderBy('cseo_merchants.id','desc')->latest();   
              $query['search'] = request('search');        
         }else{
            
            $banner = $banner->SELECT('cseo_banners.id as banner_id','cseo_banners.title_name','cseo_banners.created_at','cseo_categories.category_name','cseo_media.media_name','cseo_media.media_thumbnail','cseo_banners.status_id', 'cseo_banners.curr_status_id','cseo_statuses.status_name','cseo_merchants.merchant_name')->join('cseo_categories','cseo_banners.cseo_categories_id', '=', 'cseo_categories.id')->join('cseo_statuses','cseo_banners.status_id', '=', 'cseo_statuses.id')->leftjoin('cseo_media','cseo_banners.cseo_media_id','=','cseo_media.id')->join('cseo_merchants', 'cseo_merchants.id','=','cseo_banners.merchants_id')->where('cseo_banners.status_id', '9')->where('cseo_banners.lang_id', '2')->orwhere('cseo_banners.status_id', '10')->where('cseo_banners.lang_id', '2')->orderBy('cseo_merchants.id','desc')->latest();   

         }  

         $banner = $banner->paginate(10)->appends($query);
         $banner_count = $banner->count();

       $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }
        
         return view('system.banner.index', compact('banner','cseo_count','banner_count','site_identity'));
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $category = cseo_category::where('status_id', '9')->latest()->get(); 

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        if(Auth::user()->status_id != "4" ){

            $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->latest('cseo_media.created_at')->get();

        }else{

            $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->where('merchants_id',$merchant->id)->latest('cseo_media.created_at')->get();
        }
  
        $lang = cseo_team::get();

        $merchantlist = cseo_merchant::where('status_id', '9')->latest()->get();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

             if ( count( $title ) > 0 ) {
                 $site_identity = json_decode( $title->site_identity);
             }

        return view('system.banner.create', compact('category','media','site_identity','merchantlist','lang'));
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
                               //'title_name'=>'required|unique:cseo_banners',
                               'title_name'=>'required',
                               'cseo_media_id'=>'required',
                               'target_url'=> 'required',
                               'title_b_name'=> 'required',
                               'alt_text'=> 'required',
                               ],
                               [
                                 'cseo_media_id.required'=>'Please Select Images',
                               ]);
               
                $merchant = cseo_merchant::where('merchant_name', $request->merchant)->first();

                if ($validate->fails())
                 {
                      return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
                      //return Redirect::to('backoffice/contact/create')->withErrors($validate)->withInput();
                 }else{

                       $banner = new cseo_banner; 

                       $banner->cseo_media_id = $request->cseo_media_id;
                       $banner->title_name = $request->title_name;
                       $banner->title_banner = $request->title_b_name;
                       $banner->alt_text_banner = $request->alt_text;
                       $banner->target_url = $request->target_url;
                       $banner->cseo_categories_id = $request->cagetory;
                       $banner->description = $request->description;
                       $banner->rev_count = "0";
                       $banner->merchants_id = $merchant->id;
                       $banner->lang_id = $request->lang_id;
                       $banner->user_id = Auth::user()->id;
                       $banner->status_id = $request->status_id;
                       $banner->curr_status_id = $request->status_id;
                       
                       $banner->save();

                       $lastinsert = $banner->id;

                       session()->flash('message', 'Successfully Added');

                       return response()->json(['status'=>'success','message'=>'Successfully Added','id'=>$lastinsert]);
    
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
        
      $lang = cseo_team::get();
        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        if(Auth::user()->status_id != "4" ){

            $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->latest('cseo_media.created_at')->get();

        }else{

            $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->where('merchants_id',$merchant->id)->latest('cseo_media.created_at')->get();
        }


        $category = cseo_category::where('status_id', '9')->latest()->get();           
        
        $banner = cseo_banner::select('cseo_banners.id','cseo_banners.cseo_media_id','cseo_banners.cseo_categories_id', 'cseo_banners.title_name','cseo_banners.title_banner','cseo_banners.alt_text_banner','cseo_banners.target_url', 'cseo_banners.description','cseo_banners.status_id','cseo_banners.lang_id','cseo_media.media_name','cseo_media.media_thumbnail', 'cseo_categories.category_name','cseo_banners.rev_count','cseo_banners.updated_at','cseo_banners.created_at', 'cseo_banners.merchants_id', 'cseo_merchants.merchant_name','cseo_banners.parent_id' )->leftjoin('cseo_media','cseo_banners.cseo_media_id' , 'cseo_media.id' )->join('cseo_categories','cseo_banners.cseo_categories_id','cseo_categories.id')->join('cseo_merchants','cseo_media.merchants_id','cseo_merchants.id')->where('cseo_banners.id', $id)->where('cseo_banners.status_id', '9')->orwhere('cseo_banners.id', $id)->where('cseo_banners.status_id', '10')->first();   

        $merchantlist = cseo_merchant::where('status_id', '9')->latest()->get();

        
        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

             if ( count( $title ) > 0 ) {
                 $site_identity = json_decode( $title->site_identity);
             }
  
        if(count($banner)>0){
            return view('system.banner.edit', compact('banner','category','media','site_identity','merchantlist','lang'));  
        }else{
             session()->flash('message', 'This record cannot be Edited');
             return Redirect('/system/banner');
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
         if($request->moveprocess == "moveSingle" || $request->moveprocess == "moveMulti" ){

           $ban_id = $request->id;
           $action = $request->action;
           $curr_action = $request->curr_status;
        

           if($action=="9" || $action=="10" || $action=="11" ){
           
              foreach ($ban_id as $ids) 
              {
                  $bannerfind = cseo_banner::where('id', $ids)->first();
                  if($request->moveprocess == "moveMulti"){

                    if($action == "9"){
                        $action_now = $bannerfind->curr_status_id;
                    }else{
                        $action_now = $action;
                    }

                  } else{

                    $action_now = $action;

                  }     

                   //$banner = cseo_banner::where('id', $ids)->update(['status_id'=> $action,'curr_status_id'=> $curr_action]);           
                   $banner = cseo_banner::where('id', $ids)->update(['status_id'=> $action_now,'curr_status_id'=> $bannerfind->status_id]);           
              
              }

               if($action=="11"){
                       $promptmessages = 'Successfully Move to Trash';
                       $lastact = "Trash";
               }else{
                       $promptmessages = 'Successfully Status Updated';
                       $lastact = "Edit Status";
               }

           }else{
               
               foreach ($ban_id as $ids) 
               {
                   $banner = cseo_banner::where('id', $ids)->delete();
               }

                   $promptmessages = 'Permanently Deleted';
                   $lastact = "Deleted";
           } 

            return response()->json(['status'=>'success','message'=> $promptmessages,'lastact' => $lastact]);

        }else{

             if($request->action=="11"){
             
                    $banner = cseo_banner::where('id', $id)->update(['status_id'=> $action,'curr_status_id'=> $curr_action]);
                    session()->flash('message', 'Successfully Move to Trash');
                    return response()->json(['message'=>'Successfully Move to Trash']);     

             }else{
                 
                  $banner = cseo_banner::find($id);

                  $merchant = cseo_merchant::where('merchant_name', $request->merchant)->first();
                  
                   $validate = Validator::make($request->all(), [
                                    'title_name'=>'required',
                                    'cseo_media_id'=>'required',
                                    'target_url'=> 'required',
                                    'title_b_name'=> 'required',
                                    'alt_text'=> 'required',
                                  ],
                                  [
                                    'cseo_media_id.required'=>'Please Select Images',
                                  ]);
                   
                   if ($validate->fails())
                    {
                         return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422); 
                    }else{  

                     if($banner->title_name != $request->title_name || $banner->title_banner != $request->title_banner || $banner->alt_text_banner != $request->alt_text_banner || $banner->description != $request->description || $banner->cseo_media_id != $request->cseo_media_id || $banner->cseo_categories_id != $request->cagetory){
                         $revision = $banner->rev_count+1;   
                     }else {
                         $revision = $banner->rev_count;
                     }

                    $banner->cseo_media_id = $request->cseo_media_id;
                    $banner->title_name = $request->title_name;
                    $banner->title_banner = $request->title_b_name;
                    $banner->alt_text_banner = $request->alt_text;
                    $banner->target_url = $request->target_url;
                    $banner->cseo_categories_id = $request->cagetory;
                    $banner->description = $request->description;
                    $banner->rev_count = $revision;
                    $banner->status_id = $request->status_id;
                    $banner->curr_status_id = $request->status_id;
                    $banner->merchants_id = $merchant->id;
                    //$banner->lang_id = $request->lang_id;
                    $banner->save();

                    $lastinsert = $banner->id;

                     session()->flash('message', 'Successfully Updated');
                     return response()->json(['status'=>'success','message'=>'Successfully Updated','id'=>$lastinsert]);


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
        $banner = cseo_banner::find($id);
        $banner->delete();

        session()->flash('message', 'Successfully Deleted');
        return response()->json(['message' => 'Successfully Updated']); 
    }

    public function pageslang(Request $request){

      $banner = new cseo_banner; 
      $action = $request->action;

      $validate = Validator::make($request->all(), [
                     //'title_name'=>'required|unique:cseo_banners',
                     'title_name'=>'required',
                     'cseo_media_id'=>'required',
                     'target_url'=> 'required',
                     'title_b_name'=> 'required',
                     'alt_text'=> 'required',
                     ],
                     [
                       'cseo_media_id.required'=>'Please Select Images',
                     ]);
      
      $merchant = cseo_merchant::where('merchant_name', $request->merchant)->first();

      $countryresult = $banner::where('id', $request->pageid)->where('merchants_id',$merchant->id)->where('lang_id', $request->lang_id)->latest()->first();


      if(count($countryresult) > 0 ){
              return response()->json(['status'=>'success','id'=>$countryresult->id]);
      }else{
               $resultlang = $banner::where('parent_id', $request->pageid)->where('merchants_id', $merchant->id)->where('lang_id', $request->lang_id)->latest()->first();

                if(count($resultlang) > 0 ) {
                    return response()->json(['status'=>'success','id'=> $resultlang->id ]);
                }else{ 

                    if ($validate->fails())
                     {
                          return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
                     }else{

                if($action == "draft") { 
                    $status = "12";
                }else{
                    $status = "9";
                }
                           $banner->parent_id = $request->pageid;
                           $banner->cseo_media_id = $request->cseo_media_id;
                           $banner->title_name = $request->title_name;
                           $banner->title_banner = $request->title_b_name;
                           $banner->alt_text_banner = $request->alt_text;
                           $banner->target_url = $request->target_url;
                           $banner->cseo_categories_id = $request->cagetory;
                           $banner->description = $request->description;
                           $banner->rev_count = "0";
                           $banner->merchants_id = $merchant->id;
                           $banner->lang_id = $request->lang_id;
                           $banner->user_id = Auth::user()->id;
                           $banner->status_id = $status;
                           $banner->curr_status_id = $request->status_id;
                           
                           $banner->save();

                           $lastinsert = $banner->id;

                           session()->flash('message', 'Successfully Added');

                           return response()->json(['status'=>'success','message'=>'Successfully Added','id'=>$lastinsert]);
                    
                      }
                }
      }

    }
}
