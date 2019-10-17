<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\cseo_media;
use App\cseo_options_settings;
use App\cseo_merchant;
use App\cseo_account;

use URL;
use DB;
use Image;
use Storage;
use File;

class MediaController extends Controller
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
               
               if($this->user->status_id != '2'){
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


        $relPath = 'img/gallery/';
        if (!file_exists($relPath)) {
            mkdir($relPath, 777, true);
        }

        $media = new cseo_media;


        $searchmedia = ['cseo_media.media_name','cseo_media.title_name'];

        if(request()->has('search')){
            $search = request('search');

            $media_img = $media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id'); 

           if(Auth::user()->status_id != "4"){
               foreach ($searchmedia as $searchmedias) {
                  $media_img->orwhere($searchmedias,'like','%'.$search.'%')->where('view_stat', '0')->latest()->get();                
               } 

           }else{
               foreach ($searchmedia as $searchmedias) {
                  $media_img->orwhere($searchmedias,'like','%'.$search.'%')->where('view_stat', '0')->where('cseo_media.merchants_id', $merchant->id)->latest()->get();                
               } 
            
           }          


        }else{

            //$media_img = $media::where('view_stat','0')->latest()->get();

          if(Auth::user()->status_id != "4"){

            $media_img = $media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->latest('cseo_media.created_at')->get();
          
          }else{
           
            $media_img = $media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->where('cseo_media.merchants_id', $merchant->id)->latest('cseo_media.created_at')->get();
            
          } 


            
        }
    
       $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }

        return view('system.media.index',compact('media_img','site_identity'));
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
        
        return view('system.media.create',compact('site_identity'));
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
          $media = new cseo_media;
         
          $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        //if($request->hasFile('mediaimg')){
         
         //$media_name = $request->file('mediaimg');
         //$media_name = $request->mediaimg;
         $this->validate($request, [
                     'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                 ]); 

         $media_name = $request->file('file');

        //Give a unique and random file name of the image
         $name = pathinfo($media_name->getClientOriginalName(), PATHINFO_FILENAME);

         $mediafind = $media->where('media_name', 'like', '%'.$name.'%')->get();

         if(count($mediafind)>0){
            $count = $mediafind->count() + 1;
            $filename_org = str_replace(' ', '_',$name.'_'.$count.'.'.$media_name->getClientOriginalExtension());
         }else{
            $filename_org = str_replace(' ', '_',$media_name->getClientOriginalName());
         }

         if(request()->has('view_stat') == "0"){
                $path = '/img/gallery/';
         }else{
                $path = '/img/account/';
         }

        $filename_150x150 = pathinfo($filename_org, PATHINFO_FILENAME).'-150x150.'.$media_name->getClientOriginalExtension();
        $filename_768x576 = pathinfo($filename_org, PATHINFO_FILENAME).'-768x576.'.$media_name->getClientOriginalExtension();
        //Resize the image and save to the folder images/gallery
  

        //Store the file name of the image to database       
        $media->media_name = $filename_org;
        $media->title_name = str_replace('_', ' ',pathinfo($filename_org, PATHINFO_FILENAME));
        $media->media_thumbnail = $filename_150x150;
        $media->media_attachments = $filename_768x576;
        $media->file_size = $media_name->getClientSize();
        $media->file_type = $media_name->getMimeType();
        $media->view_stat = "0";
        $media->merchants_id = $merchant->id;           
        $media->user_id = Auth::user()->id;
        $media->status_id = "9";
        $media->save();

        //file::exists($path) or File::makeDirectory($path, 0777, true, true);
        Image::make($media_name)->resize(150, 150)->save(public_path('/img/gallery/').$filename_150x150);
        Image::make($media_name)->resize(768, 576)->save(public_path('/img/gallery/').$filename_768x576);
        
        if($media_name->getClientOriginalExtension() == "gif" ){
            $media_name->move(public_path('/img/gallery/'), $filename_org);
        }else{
            Image::make($media_name)->save(public_path('/img/gallery/').$filename_org);
            
        }

        //return $media;
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
        $media = cseo_media::find($id);;
       
        $media->title_name = $request->title_name;     
        $media->caption_text = $request->caption_name;
        $media->alt_text = $request->alt_text;
        $media->description = $request->description;

        $media->save();
      
         return response()->json(['message' => "Save"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $media = cseo_media::find($id);

        $media_name = ('img/gallery/'. $media->media_name);
        $media_thumbnail = ('img/gallery/'. $media->media_thumbnail);
        $media_attachments = ('img/gallery/'. $media->media_attachments);

        File::delete($media_name, $media_thumbnail, $media_attachments);
            
        $media->delete();

        session()->flash('message', 'Successfully Deleted');


         return response()->json(['message' => "Successfully Deleted"]);
    }
}
