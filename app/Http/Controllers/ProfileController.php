<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\cseo_account;
use App\cseo_role_accesses;
use App\cseo_statuses;
use App\cseo_media;
use App\cseo_options_settings;
use App\cseo_merchant;

use URL;
use Image;
use Storage;
use File;

class ProfileController extends Controller
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
       $relPath = 'img/accounts/';
       if (!file_exists($relPath)) {
           mkdir($relPath, 777, true);
       }
       
       $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

       $profile = cseo_account::SELECT('cseo_accounts.id as acct_id','cseo_accounts.account_id','cseo_accounts.first_name','cseo_accounts.last_name','cseo_accounts.email','cseo_accounts.mobile_no','cseo_accounts.skype_id','cseo_accounts.position','cseo_statuses.id','cseo_statuses.status_name','cseo_accounts.cseo_media_id','cseo_media.media_name')->join('cseo_statuses','cseo_statuses.id','=','cseo_accounts.account_id')->leftjoin('cseo_media','cseo_media.id','=','cseo_accounts.cseo_media_id')->where('cseo_accounts.id',\Auth::user()->id)->first();

       $media = cseo_media::where('view_stat', '1')->where('status_id','7')->where('user_id', \Auth::user()->id)->latest()->get(); 
       
       $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();
       if ( count( $title ) > 0 ) {
           $site_identity = json_decode( $title->site_identity);
       }

       return view('system.profile.index', compact('profile', 'media','site_identity'));
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
       $media = new cseo_media;
        
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


         $filename_150x150 = pathinfo($filename_org, PATHINFO_FILENAME).'-150x150.'.$media_name->getClientOriginalExtension();
         $filename_768x576 = pathinfo($filename_org, PATHINFO_FILENAME).'-768x576.'.$media_name->getClientOriginalExtension();
        //Resize the image and save to the folder images/uploads/products
         
         Image::make($media_name)->save('img/accounts/'.$filename_org);
         Image::make($media_name)->resize(150, 150)->save('img/accounts/'.$filename_150x150);
         Image::make($media_name)->resize(768, 576)->save('img/accounts/'.$filename_768x576);
        


        //Store the file name of the image to database
       
        $media->media_name = $filename_org;
        $media->title_name = str_replace('_', ' ',pathinfo($filename_org, PATHINFO_FILENAME));
        $media->media_thumbnail = $filename_150x150;
        $media->media_attachments = $filename_768x576;
        $media->file_size = $media_name->getClientSize();
        $media->file_type = $media_name->getMimeType();
        $media->view_stat = "1";


        $media->user_id = \Auth::user()->id;
        $media->status_id = "7";
        $media->save();
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
            $profile = cseo_account::find($id);

             if($request->action=="Info")
            {

             $this->validate($request,[
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'display_name' => 'required|string|max:255',
                                       
                ]);

                $profile->first_name = $request->first_name;
                $profile->last_name = $request->last_name;
                $profile->display_name = $request->display_name;
                $profile->mobile_no = $request->mobile_no;
                $profile->cseo_media_id = $request->media_id;
                $profile->position = $request->position;
                $profile->skype_id = $request->skype_id;


                $role = cseo_role_accesses::where('user_id', $id)->update(['cseo_media_id'=>$request->media_id]);


            }else if($request->action=="Change Password"){
                
                 $this->validate($request,[
                     'password' => 'required|string|min:6|confirmed',                                       
                ]);

                $profile->password = bcrypt($request->password);

            }


            $profile->save();


            return response()->json(['message' => 'Successfully Added']); 
        
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
