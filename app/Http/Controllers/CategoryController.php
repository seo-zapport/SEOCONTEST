<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\cseo_category;
use App\cseo_banner;
use App\cseo_options_settings;
use App\cseo_merchant;

use DB;
use URL;
use View;
use Validator;
use Redirect;


class CategoryController extends Controller
{
     /**
         * Create a new controller instance.
         *
         * @return void
         */
        public function __construct()
        {
           $this->middleware('auth');
           $this->middleware('logged');
        }

    /**
      * Display a listing of the resource.
      *
      * @return \Illuminate\Http\Response
      */
    public function index()
    {
           
            $category = new cseo_category;

            $cseo_count =  $category::select(DB::raw("(select count(*) from cseo_categories where status_id='9' or status_id='11') countAll,(select count(*) from cseo_categories where status_id = '9') countPublished , (select count(*) from cseo_categories where status_id = '11') countTrash"))->first();    

            $query = [];
            $searchcategory = ['cseo_categories.category_name', 'cseo_categories.description'];   

           
            if(request()->has('search') && request()->has('status_id')){

                $search = request('search');    
                $statusid = request('status_id'); 

                $category = $category->Select(DB::raw("cseo_categories.id,cseo_categories.category_name,cseo_categories.parent_id,cseo_categories.description,cseo_categories.updated_at,cseo_categories.created_at,cseo_categories.status_id,(select count(cseo_banners.cseo_categories_id) from cseo_banners where cseo_banners.cseo_categories_id = cseo_categories.id and cseo_banners.status_id = 9) as counted") );

                  foreach ($searchcategory as $searchcategories) {

                    $category->orwhere($searchcategories, 'LIKE', "%".$search."%")->where('cseo_categories.status_id',  "%".$statusid."%")->latest();
                    
                  }    

                $query['search'] = $search;
                $query['status_id'] = $statusid;
            

            }elseif(request()->has('status_id')){
                
                $query['status_id'] = request('status_id');

                $category = $category->Select(DB::raw("cseo_categories.id,cseo_categories.category_name,cseo_categories.parent_id,cseo_categories.description,cseo_categories.updated_at,cseo_categories.created_at,cseo_categories.status_id,(select count(cseo_banners.cseo_categories_id) from cseo_banners where cseo_banners.cseo_categories_id = cseo_categories.id and cseo_banners.status_id = 9) as counted"))->where('status_id', request('status_id'))->latest();


            }elseif(request()->has('search')){

                $search = request('search');    
                $query['search'] = $search;
                
                $category = $category->Select(DB::raw("cseo_categories.id,cseo_categories.category_name,cseo_categories.parent_id,cseo_categories.description,cseo_categories.updated_at,cseo_categories.created_at,cseo_categories.status_id,(select count(cseo_banners.cseo_categories_id) from cseo_banners where cseo_banners.cseo_categories_id = cseo_categories.id and cseo_banners.status_id = 9) as counted") );

                  foreach ($searchcategory as $searchcategories) {

                    $category->orwhere($searchcategories, 'LIKE', "%".$search."%")->where('cseo_categories.status_id', '9')->latest();
                    
                  }    

            }else{

                $category = $category->Select(DB::raw("cseo_categories.id,cseo_categories.category_name,cseo_categories.parent_id,cseo_categories.description,cseo_categories.updated_at,cseo_categories.created_at,cseo_categories.status_id,(select count(cseo_banners.cseo_categories_id) from cseo_banners where cseo_banners.cseo_categories_id = cseo_categories.id and cseo_banners.status_id = 9) as counted") )->where('cseo_categories.status_id', '9')->orwhere('cseo_categories.status_id', '12')->latest();
            }

        $category = $category->paginate(10)->appends($query);
        $category_count = $category->count();

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();
        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

            if ( count( $title ) > 0 ) {
                $site_identity = json_decode( $title->site_identity);
            }        

        return view('system.banner.category.index', compact('category','cseo_count','category_count','site_identity'));
            
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
        $category = new cseo_category;

        $validate = Validator::make($request->all(), [
                    'category_name'=>'required|unique:cseo_categories',                   
                    ]);
               
              if ($validate->fails())
               {
                    return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
    
               }else{
                $category->category_name = $request->category_name;
                $category->description = $request->description;
                $category->parent_id = "0";
                $category->url_path = "/".$request->category_name;
                $category->status_id = "9";
                $category->save();

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
     

         if($action=="9" || $action=="7"){
         
            foreach ($sel_id as $ids) 
            {
                 $category = cseo_category::where('id', $ids)->update(['status_id'=> $action]);
            }

             if($action=="9"){
                     $promptmessages = 'Successfully Deleted';
             }else{
                     $promptmessages = 'Successfully Restore';
             }

         }else{
             
             foreach ($sel_id as $ids) 
             {
                 $category = cseo_category::where('id', $ids)->delete();
             }

                 $promptmessages = 'Permanently Deleted';
         } 

         return response()->json(['message' => $promptmessages]);

      }else{


            $category = cseo_category::find($id);

             $this->validate($request,[
                        'category_name'=>'required',
                                           
                ]);

             $validate = Validator::make($request->all(), [
                    'category_name'=>'required',                   
                    ]);
               

              if ($validate->fails())
               {
                    return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    
                   
               }else{

                    $category->category_name = $request->category_name;
                    $category->description = $request->description;
                    //$category->user_id = Auth::user()->id;
                    $category->save();

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
     
     $category = cseo_category::find($id);
     $category->delete();

     session()->flash('message', 'Successfully Deleted');
      return response()->json(['message' => 'Successfully Deleted']);

    }
}
