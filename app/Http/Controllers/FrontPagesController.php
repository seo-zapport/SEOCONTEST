<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Response;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

use App\cseo_menu;
use App\cseo_menu_setups;
use App\cseo_register;
use App\cseo_bank;
use App\cseo_bank_register;
use App\cseo_banner;
use App\cseo_category;
use App\cseo_pages;
use App\cseo_meta;
use App\cseo_statuses;
use App\cseo_merchant;
use App\cseo_options_settings;
use App\cseo_theme_options;
use App\cseo_media;
use App\cseo_reward;
use App\cseo_team;

use DB;
use Input;
use Redirect;
use Validator;
use Mail;
use URL;
use File;
use App\Mail\VerifyEmail;


class FrontPagesController extends Controller
{
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();
             
        $menu_navs = cseo_menu::where('cseo_menus.default_id','1')->where('cseo_menus.merchants_id', $merchant->id)->first();    

        if(count($menu_navs)>0){
            $menu_nav = cseo_menu_setups::where('menu_id', $menu_navs->id)->with('children')->orderBy('order','asc')->get();
        }else{
           $default_menu = cseo_menu::where('status_id', '14')->where('cseo_menus.merchants_id', $merchant->id)->Update(['default_id'=>'1']);
           return redirect('/');     
        }
        
        $menu_navs_footer = cseo_menu::where('cseo_menus.footer_d_id','1')->where('cseo_menus.merchants_id', $merchant->id)->first();    

        if(count($menu_navs_footer)>0){
           $menu_nav_footer = cseo_menu_setups::where('menu_id', $menu_navs_footer->id)->with('children')->orderBy('order','asc')->get();
        }else{
           $default_menu_footer = cseo_menu::where('status_id', '14')->where('cseo_menus.merchants_id', $merchant->id)->Update(['footer_d_id'=>'1']);
           return redirect('/');     
        }

        $logo_settings = cseo_theme_options::select( DB::raw( 'cseo_theme_options.identity_img as identity_img,cseo_theme_options.footer_link_opt as footer_link_opt,cseo_theme_options.footer_copyright_opt as footer_copyright_opt' ) )->where('merchants_id', $merchant->id)->first();

        if ( count($logo_settings) > 0 ) {
            $identity_img = json_decode($logo_settings->identity_img);
            $logo = $identity_img->identity_logo;
            $banner = $identity_img->identity_banner;
        }

        $logo = cseo_media::SELECT(DB::raw('cseo_media.media_name, cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('cseo_media.id', $logo)->first();
        $banner = cseo_media::SELECT(DB::raw('cseo_media.media_name, cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('cseo_media.id', $banner)->first();
        
        $title = cseo_options_settings::SELECT('site_identity','ranking','data_sitekey','maintenance_mode','google_verify','google_analytics')->where('merchants_id', $merchant->id)->first();
        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }

        $team = cseo_team::SELECT('google')->where('id', $merchant->team_merchant_id)->first();

        $bank = cseo_bank::latest()->get();  

        $participant = cseo_register::where('merchants_id',$merchant->id)->count();
        
        $front_pages = cseo_pages::where('status_id', '15')->where('merchants_id',$merchant->id)->latest()->get();

        $reward = cseo_merchant::SELECT(DB::raw('cseo_merchants.merchant_name,cseo_rewards.placereward,cseo_rewards.amount'))->join('cseo_rewards', 'cseo_merchants.id', 'cseo_rewards.merchants_id')->where('cseo_merchants.id',$merchant->id)->get();

        $this->styleupdate($merchant->id);

  

      if (Auth::guest()){

        if($title->maintenance_mode == '1'){

            return view('maintenance', compact('site_identity'));

        }else{
            return view('maintenance', compact('site_identity'));
          //  return view('front-page', compact('menu_nav','bank','participant','menu_nav_footer','front_pages','logo_settings','logo','banner','site_identity','reward','team','title'));
        }       
        
      }else{
        //return view('maintenance', compact('site_identity'));
        //return view('front-page', compact('menu_nav','bank','participant','menu_nav_footer','front_pages','logo_settings','logo','banner','site_identity','reward','team','title'));
        if(Auth::user()->status_id !='4'){
           return redirect('system/admin');
        }else{
           return redirect('system/support'); 
        }  
     }    


    }

    public function checkEmailValid(Request $request){
        //$email = cseo_register::all()->where('email', Input::get('email') )->first();
        //$email = cseo_register::all()->where('email', $request->email )->first();
        $email = cseo_register::where('email', $request->email )->first();
        
        if ( $email ) {
            //return Response::json(Input::get('email').' is already taken');
            return response()->json(['status' => 'true','message' => 'Taken']);
        } else {
            //return Response::json(Input::get('email').' is available');
            return response()->json(['status' => '','message' => '']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $peronal_data = new cseo_register;

        $merchant = cseo_merchant::where('merchant_name', $request->merchant)->first();

        $rules = [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:cseo_registers',
            'mob_no' => 'required|string|max:255',
            // 'bbm_pin' => 'required',
            'url_permalink' => 'required|string|max:255',
            'bank_name' => 'required',
            'acct_no'  => 'required',
            'be_acct' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()){

            return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);

        }else{
            //Check weather their is a captcha

            $datasecret =  cseo_options_settings::where('merchants_id', $merchant->id)->first();

            if ( $request->g_token ) {
                $client = new Client();
                $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                    'form_params' => array(
                        'secret'    => $datasecret->data_secretkey,
                        'response'  => $request->g_token
                    ),
                ]);

              $json_result = json_decode($response->getBody()->getContents());
                    
                    if ( $json_result->success ) {
                        
                        $confirmation_code = str_random(30);
                        $peronal_data->name = $request->full_name;
                        $peronal_data->email = $request->email;
                        $peronal_data->mobile_number = $request->mob_no;
                        $peronal_data->pin_bbm = $request->bbm_pin;
                        $peronal_data->url_web_contest = $request->url_permalink;
                        $peronal_data->status_id = "6";
                        $peronal_data->curr_status_id = "6";
                        $peronal_data->verify_status = "0";
                        $peronal_data->verify_token = $confirmation_code;
                        $peronal_data->merchants_id = $merchant->id;
                        $peronal_data->save();

                        $lastinsert = $peronal_data->id;
                        
                        $bank_data = new cseo_bank_register;

                        if ( count($lastinsert) > 0) {
                            $bank_data->register_id = $lastinsert;
                            $bank_data->bank_id = $request->bank_name;
                            $bank_data->account_no = $request->acct_no;
                            $bank_data->behalfofaccount = $request->be_acct;
                            $bank_data->save();
                        }
                        //check weather the email is pass or fail
                        //$thisUser = cseo_register::findOrFail($lastinsert);
                        //$this->sendEmail($thisUser);

                        session()->flash('message', 'We send a reply via email. Please check your email inbox/spam folder.');
                        return response()->json(['message' => 'Successfully Added']);

                    }else{

                        session()->flash('error', 'The Fields are required.');
                        return response()->json(['error' => 'The Fields are required.']);

                    }
            }else{
                 session()->flash('error', 'Are you realy a human ?');
            //     //session()->flash('error', 'Check the message toker');
                //return response()->json(['error' => 'Check the message token']);
                //return redirect('/');
          }
        }

    }

    public function sendEmail($thisUser){
        Mail::to( $thisUser['email'] )->send(new VerifyEmail( $thisUser));
    }

    public function sendEmailDone($email, $verify_token){
        $user = cseo_register::where(['email'=>$email,'verify_token' => $verify_token ])->first();
        if ( $user ) {
            $update = cseo_register::where(['email'=>$email,'verify_token' => $verify_token ])->update(['verify_status'=>'1','verify_token'=> NULL]);
            if ($update) {
                return view('email.thank-page');
            }
        }else{
            return "User Not Found";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function show($id)
    public function show($value)
    {
        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $page = new cseo_pages;

        $menu_navs = cseo_menu::where('cseo_menus.default_id','1')->where('cseo_menus.merchants_id', $merchant->id)->first();    

        if(count($menu_navs)>0){
            $menu_nav = cseo_menu_setups::where('menu_id', $menu_navs->id)->with('children')->orderBy('order','asc')->get();
        }else{
           $default_menu = cseo_menu::where('status_id', '14')->where('cseo_menus.merchants_id', $merchant->id)->Update(['default_id'=>'1']);
           return redirect('/');     
        }
        
        $menu_navs_footer = cseo_menu::where('cseo_menus.footer_d_id','1')->where('cseo_menus.merchants_id', $merchant->id)->first();    

        if(count($menu_navs_footer)>0){
           $menu_nav_footer = cseo_menu_setups::where('menu_id', $menu_navs_footer->id)->with('children')->orderBy('order','asc')->get();
        }else{
           $default_menu_footer = cseo_menu::where('status_id', '14')->where('cseo_menus.merchants_id', $merchant->id)->Update(['footer_d_id'=>'1']);
           return redirect('/');     
        }
        
        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();
        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }

        //media
        $logo_settings = cseo_theme_options::select( DB::raw( 'cseo_theme_options.identity_img as identity_img,cseo_theme_options.footer_link_opt as footer_link_opt,cseo_theme_options.footer_copyright_opt as footer_copyright_opt' ) )->where('merchants_id', $merchant->id)->first();

        if ( count($logo_settings) > 0 ) {
            $identity_img = json_decode($logo_settings->identity_img);
            $logo = $identity_img->identity_logo;
        }
        $logo = cseo_media::SELECT(DB::raw('cseo_media.media_name, cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('cseo_media.id', $logo)->first();


        $bank = cseo_bank::latest()->get();  

        $reward = cseo_merchant::SELECT(DB::raw('cseo_merchants.merchant_name,cseo_rewards.placereward,cseo_rewards.amount'))->join('cseo_rewards', 'cseo_merchants.id', 'cseo_rewards.merchants_id')->where('cseo_merchants.id',$merchant->id)->get();

        $this->styleupdate($merchant->id);

        if($value == "login" || $value == "/login"){

            if (Auth::guest()){
                    return view('auth.login',compact('site_identity', 'logo'));
            }else{
                    if(Auth::user()->status_id =='1'){
                       return redirect('system/admin');
                    }else{
                       return redirect('system/support'); 
                    }
            }    

        }elseif($value == "banner" || $value == "/banner" ) {

            $banner = new cseo_banner;
            $category = new cseo_category;

            $category = $category::where('status_id', '9')->get();

            $banner = $banner::SELECT(DB::raw("cseo_banners.id as banid,cseo_banners.title_name,cseo_banners.title_banner,cseo_banners.target_url, cseo_banners.alt_text_banner, cseo_banners.cseo_media_id, cseo_banners.cseo_categories_id,cseo_media.media_name, cseo_media.media_name"))->join('cseo_media', 'cseo_media.id', '=','cseo_banners.cseo_media_id')->join('cseo_categories','cseo_categories.id','=', 'cseo_banners.cseo_categories_id')->where('cseo_banners.status_id','9')->where('cseo_banners.merchants_id', $merchant->id)->get();

            return view('banner', compact('banner','category','menu_nav','menu_nav_footer','logo','logo_settings','site_identity','reward'));


        }elseif($value =="participants" || $value == "/participants"){

            $participants = new cseo_register;

            $participants = $participants::SELECT(DB::raw('cseo_registers.name, cseo_registers.url_web_contest, cseo_registers.created_at, cseo_statuses.status_name'))->join('cseo_statuses', 'cseo_statuses.id', '=','cseo_registers.status_id')->where('cseo_registers.merchants_id', $merchant->id)->orderBy('cseo_statuses.id', 'asc')->orderBy('cseo_registers.verify_status', 'asc')->latest()->get();
            
            return view('participants', compact('participants','menu_nav','menu_nav_footer','logo','logo_settings','site_identity','reward'));
        
        }elseif($value =="reward" || $value == "/reward"){
            
            return view('rewards', compact('menu_nav','menu_nav_footer','logo','logo_settings','site_identity','reward'));
        
        }elseif($value =="verify" || $value =="/verify"){
        
             return view('email.thank-page');
        
        }elseif($value =="system" || $value =="/system" || $value =="/system/"){
            
            if(Auth::user()->status_id !='4'){
               return redirect('system/admin');
            }else{
               return redirect('system/support'); 
            }  

        }elseif($value =="403" || $value =="500"){
              
              //return view("errors.".$value, compact('site_identity'));   
            return view('errors.403', compact('site_identity'));
            
        }else{

    

             $page = $page::SELECT(DB::raw("cseo_pages.id,cseo_pages.page_title,cseo_pages.page_content,cseo_pages.url_path,cseo_pages.rev_count,cseo_pages.cseo_media_id,cseo_pages.status_id,cseo_pages.curr_status_id,cseo_pages.created_at,cseo_metas.meta_title,cseo_metas.meta_description,cseo_metas.meta_keyword,cseo_media.media_name"))->join('cseo_metas', 'cseo_metas.page_id', '=', 'cseo_pages.id')->leftJoin('cseo_media', 'cseo_pages.cseo_media_id', '=','cseo_media.id')->where('cseo_pages.page_title','like', '%'.$value.'%')->where('cseo_pages.status_id', '9')->where('cseo_pages.merchants_id', $merchant->id)->orwhere('cseo_pages.page_name','like', '%'.$value.'%')->where('cseo_pages.status_id', '9')->where('cseo_pages.merchants_id', $merchant->id)->orwhere('cseo_pages.url_path','like', '%'.$value.'%')->where('cseo_pages.status_id', '9')->where('cseo_pages.merchants_id', $merchant->id)->first();

            if(count($page)>0){ 
                return view('pages', compact('menu_nav','bank','page','menu_nav_footer','logo','logo_settings','site_identity','reward'));

             }else{

                $findpages =  cseo_menu_setups::SELECT('cseo_menu_setups.id')->join('cseo_menus', 'cseo_menus.id', 'cseo_menu_setups.menu_id')->where('link', 'like', '%'.$value.'%')->where('cseo_menus.merchants_id', $merchant->id)->first();

                if(count($findpages)>0){ 


                    $page = $page::SELECT(DB::raw("cseo_pages.id,cseo_pages.page_title,cseo_pages.page_content,cseo_pages.url_path,cseo_pages.rev_count,cseo_pages.cseo_media_id,cseo_pages.status_id,cseo_pages.curr_status_id,cseo_pages.created_at,cseo_metas.meta_title,cseo_metas.meta_description,cseo_metas.meta_keyword,cseo_media.media_name"))->join('cseo_metas', 'cseo_metas.page_id', '=', 'cseo_pages.id')->leftJoin('cseo_media', 'cseo_pages.cseo_media_id', '=','cseo_media.id')->where('cseo_pages.id', $findpages->id)->where('cseo_pages.status_id', '9')->where('cseo_pages.merchants_id', $merchant->id)->first();


                    if(count($page)>0){

                        return view('pages', compact('menu_nav','bank','page','menu_nav_footer','logo','logo_settings','site_identity','reward'));

                    }else{

                        return view('errors.404', compact('site_identity'));       
                    }


                }else{

                        return view('errors.404', compact('site_identity'));

                }

            }
                        
        }
    }

    public function styleupdate($merchant) {

        $theme_opt = new cseo_theme_options;

        $style = $theme_opt::select( DB::raw('cseo_theme_options.familyHead_opt as familyHead_opt,cseo_theme_options.fontsHead_opt as fontsHead_opt,cseo_theme_options.familyContent_opt as familyContent_opt,cseo_theme_options.fontContent_opt as fontContent_opt,cseo_theme_options.color_opt as color_opt,cseo_theme_options.menu_color_opt as menu_color_opt,cseo_theme_options.m_menu_color_opt as m_menu_color_opt,cseo_theme_options.bgAttrib_opt as bgAttrib_opt,cseo_theme_options.bgcoloritem_opt as bgcoloritem_opt,cseo_theme_options.bgimgitem_opt as bgimgitem_opt') )->where('merchants_id', $merchant)->first();


        if (count( $style ) > 0 ) {
            $bg_image = json_decode($style->bgimgitem_opt);
        }
        
        $bg_image_id = cseo_media::where('id',$bg_image->bg_image_url)->first();

        $data = view('layouts.sample',compact('style','bg_image_id'))->render();

        $fileName = 'front-customize.css'; //Save it as css file
        File::put(public_path('/css/'.$fileName),$data);

    }



}
