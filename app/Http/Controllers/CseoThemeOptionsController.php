<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Response;

use DB;
use URL;
use Image;
use Storage;
use File;
use Validator;
use Redirect;

use App\cseo_account;
use App\cseo_pages;
use App\cseo_media;
use App\cseo_options_settings;
use App\cseo_theme_options;
use App\cseo_merchant;
use App\cseo_team;
use App\cseo_banner;

class CseoThemeOptionsController extends Controller 
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

           $this->user = cseo_account::where('id', auth()->user()->id)->first();
       
               if($this->user->status_id == '4'){
                   return redirect('/403');
               }else{
                   return $next($request); 
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

        $relPath = 'css/front-customize.css';
        if (!file_exists($relPath)) {
            mkdir($relPath, 777, true);
        }

      $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $theme_settings = new cseo_theme_options;
             
        $theme_group = cseo_merchant::select( DB::raw('cseo_merchants.id as theme_merchant_id,cseo_merchants.merchant_name as merchant_name,cseo_merchants.id as merchants_id,cseo_theme_options.merchants_id as merchant_theme_opt,cseo_theme_options.updated_at as updated_at, cseo_options_settings.maintenance_mode,cseo_options_settings.id as opt_set_id, cseo_teams.name') )->leftjoin('cseo_theme_options', 'cseo_merchants.id', '=', 'cseo_theme_options.merchants_id')->join('cseo_options_settings', 'cseo_options_settings.merchants_id', 'cseo_merchants.id')->join('cseo_teams', 'cseo_teams.id', 'cseo_options_settings.lang_id')->where('cseo_options_settings.lang_id','1')->where('cseo_theme_options.lang_id','1')->where('cseo_options_settings.site_curr_status', '9')->orderby('cseo_theme_options.created_at', 'desc')->get();

        $theme_count = $theme_group->count(); 

        if(Auth::user()->status_id != "4" ){
            $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->latest('cseo_media.created_at')->get();
        }else{
            $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->where('merchants_id',$merchant->id)->latest('cseo_media.created_at')->get();
        }

        $logo_settings = cseo_theme_options::select( DB::raw( 'cseo_theme_options.identity_img as identity_img,cseo_theme_options.footer_link_opt as footer_link_opt,cseo_theme_options.footer_copyright_opt as footer_copyright_opt' ) )->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();
        $merchats_quwey = cseo_options_settings::where('merchants_id', $theme_group[0]->merchant_theme_opt)->get();

        if ( count( $title ) > 0 ) {
            $site_identity = json_decode( $title->site_identity);
        }
      return view('system.appearance.theme-settings.theme-settings', compact('site_identity','media','theme_group','merchats_quwey', 'theme_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){

        $lang = cseo_team::get();

        $merchant = cseo_merchant::where('merchant_name', URL::to('/'))->first();

        $title = cseo_options_settings::SELECT('site_identity')->where('merchants_id', $merchant->id)->first();

        if ( count( $title ) > 0 ) {
           $site_identity = json_decode( $title->site_identity);
        }

        $theme_group = cseo_theme_options::select( DB::raw('cseo_theme_options.id as id,
            cseo_theme_options.merchants_id as merchant_id,
            cseo_theme_options.identity_img as identity_img,
            cseo_theme_options.familyHead_opt as familyHead_opt,
            cseo_theme_options.fontsHead_opt as fontsHead_opt,
            cseo_theme_options.familyContent_opt as familyContent_opt,
            cseo_theme_options.fontContent_opt as fontContent_opt,
            cseo_theme_options.color_opt as color_opt,
            cseo_theme_options.menu_color_opt as menu_color_opt,
            cseo_theme_options.m_menu_color_opt as m_menu_color_opt,
            cseo_theme_options.bgAttrib_opt as bgAttrib_opt,
            cseo_theme_options.bgcoloritem_opt as bgcoloritem_opt,
            cseo_theme_options.bgimgitem_opt as bgimgitem_opt,
            cseo_theme_options.footer_link_opt as footer_link_opt,
            cseo_theme_options.footer_copyright_opt as footer_copyright_opt,
            cseo_theme_options.currstatus_opt as currstatus_opt,
            cseo_theme_options.status_opt as status_opt,
            cseo_theme_options.head_misc as head_misc,
            cseo_theme_options.foot_misc as foot_misc,
            cseo_theme_options.banner_stat as banner_stat,
            cseo_theme_options.banner_disp as ban_dis,
            b.merchants_id as merchants_id,
            b.page_title as page_title,
            b.page_content as page_content,
            c.site_identity as site_identity,
            c.site_url as merchant_name,
            c.ranking as ranking,
            c.data_sitekey as data_sitekey,
            c.data_secretkey as data_secretkey, 
            c.maintenance_mode as main_m, 
            c.google_analytics as google_analytics, 
            c.google_verify as google_verify,
            c.site_notif as site_notif,
            c.contest_prog_date as cpd,
            c.lang_id as lang_id'))
         ->join('cseo_pages as b','b.merchants_id', '=' ,'cseo_theme_options.merchants_id' )
         ->join('cseo_options_settings as c', function ($join){
                  $join->on('b.merchants_id','=', 'c.merchants_id')->on('b.lang_id','=', 'c.lang_id')->on('cseo_theme_options.lang_id','=', 'c.lang_id');
          })
         ->where('c.id', $id)->where('b.status_id', '15')->orderby('cseo_theme_options.created_at', 'desc')->first(); 

        if(Auth::user()->status_id != "4" ){
            $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->latest('cseo_media.created_at')->get();
        }else{
            $media = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('view_stat','0')->where('merchants_id',$merchant->id)->latest('cseo_media.created_at')->get();
        }
     
        if ( count( $theme_group ) > 0 ) {
            $identity_img = json_decode($theme_group->identity_img);
            $bgimg = json_decode($theme_group->bgimgitem_opt);
        }
     
        $merchants = cseo_merchant::latest()->get();
        if ( count( $identity_img ) > 0) {
            if ($identity_img->identity_logo > 2) {
                $logo = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('cseo_media.id', $identity_img->identity_logo)->first();
            }else{
                $logo = '0';
            }
            if ($identity_img->identity_icon > 2) {
                $icon = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('cseo_media.id', $identity_img->identity_icon)->first();
            }else{
                $icon = '0';
            }

            if ($identity_img->identity_banner > 2) {
                $banner = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('cseo_media.id', $identity_img->identity_banner)->first();
            }else{
                $banner = '0';
            }
        }

        if ( count( $bgimg ) > 0 ) {
            if ($bgimg->bg_image_url > 2) {
                $bgimg = cseo_media::SELECT(DB::raw('cseo_media.id,cseo_media.title_name,cseo_media.media_thumbnail,cseo_media.media_name,cseo_media.created_at,cseo_media.file_size,cseo_media.caption_text,cseo_media.alt_text,cseo_media.description,cseo_merchants.merchant_name'))->join('cseo_merchants', 'cseo_merchants.id', 'cseo_media.merchants_id')->where('cseo_media.id', $bgimg->bg_image_url)->first();
            }else{
                $bgimg = '0';
            }
        }


        $banner_dis = cseo_banner::SELECT(DB::raw('cseo_banners.id as bdid, cseo_banners.title_name, cseo_banners.title_banner, cseo_banners.lang_id, cseo_banners.cseo_media_id, cseo_media.media_name,
          cseo_categories.category_name'))->join('cseo_media', 'cseo_banners.cseo_media_id', 'cseo_media.id')->join('cseo_categories', 'cseo_banners.cseo_categories_id','cseo_categories.id')->where('cseo_banners.status_id','9')->where('cseo_banners.lang_id', "$theme_group->lang_id")->get();
            
           // dd($banner_dis);

        return view( 'system.appearance.theme-settings.edit', compact('theme_group','logo','icon','banner','bgimg','merchants','site_identity','media','lang', 'misce','banner_dis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){

        $relPath = asset('css/front-customize.css');
        if (!file_exists($relPath)) {
            mkdir($relPath, 777, true);
        }
        
        //Collect all the data request
        
        //$site_url = $request->site_id;
         $familyHead_opt = $request->familyHead_opt;
         $familyContent_opt = $request->familyContent_opt;

        //site_identity
        $site_identity = '{"site_title":"' . $request->site_title . '","site_display_assets":"' . $request->site_display_assets . '","site_tag_line":"' .  $request->site_tag_line . '"}';

        //image
        $identity_img = '{"identity_logo":"' . $request->media_logo . '","identity_icon":"' . $request->media_icon . '","identity_banner":"' . $request->media_banner . '"}';

        //heading-fonts
        $fontsHead_opt = '{"size":"' . $request->font_size_heading . '","style":"' . $request->font_style_heading . '","weight":"' . $request->font_weight_heading . '"}';

        //content-fonts
        $fontContent_opt = '{"size":"' . $request->font_size_content . '","style":"' . $request->font_style_content . '","weight":"' . $request->font_weight_content . '"}';

        //color
        $color_opt = '{"head":"' . $request->colorElementHeading . '","default":"' . $request->colorElementDefaultColor . '"}';

        //menu color
        $menu_color_opt = '{"wrap":"' . $request->colorElementMenuColorWrap . '","text":"' . $request->colorElementMenuColorText . '","hover":"' . $request->colorElementMenuColorHover . '"}';

        //mobile menu color
        $m_menu_color_opt = '{"btn_wrap":"' . $request->colorElementMenuColorMobileBtn . '","icon":"' . $request->colorElementMenuColorMobileBtnIcon . '","hover":"' . $request->colorElementMenuColorMobileBtnHover . '"}';

        //background-image
        $bgimgitem_opt = '{"bg_image_url":"' . $request->bgimageitem_opt . '","presets":"' . $request->site_fp_presets . '","position":"' . $request->site_fp_position . '","repeat":"' . $request->site_fp_repeat . '","scroll":"' . $request->site_fp_scroll . '","size":"' . $request->site_fp_size . '"}';

        //date contest progress
        $date_prog = '{"lor":"'.$request->lor.'", "wa":"'.$request->wa.'"}';
        
        //MISC.
        //$misc = '{"head_m":"'.$request->head_misc.'","foot_m":"'.$request->foot_misc.'"}';

        //footer
        $footer_link_opt = '{"link_name_opt":"' . $request->site_url . '","link__opt":"' . $request->site_url . '","link_title_opt":"' . $request->site_url . '","link_target_opt":"' . $request->site_fp_ft_target . '","link_rel_opt":"' . $request->site_fp_ft_rel . '"}';

        //Check the Rules
        $rules = ['site_url' => 'required', 'google_ranking'=> 'required', 'google_gkey'=> 'required' , 'google_skey'=> 'required'];

        //Banner 
        $banner_display = '{"bld_id":"'.$request->banleft.'","brd_id":"'.$request->banright.'","bbd_id":"'.$request->banbottom.'"}';

        $banner_opt = $request->bandisopt;

        //Check messages
        $customMessages = ['required' => 'This :attribute is required' ];

        $validate = Validator::make($request->all(), $rules, $customMessages);

        if ( $validate->passes() ) {
            
            if ( count($id) > 0 ) {
    
                    $theme_opt = cseo_theme_options::where('merchants_id', $request->merchant_id)->where('lang_id', $request->lang_id)->first();
                    
                    $theme_opt_up = cseo_theme_options::find($theme_opt->id);
                    $theme_opt_up->identity_img = $identity_img;
                    //$theme_opt_up->familyHead_opt = $familyHead_opt;
                    $theme_opt_up->fontsHead_opt = $fontsHead_opt;
                    //$theme_opt_up->familyContent_opt = $familyContent_opt;
                    $theme_opt_up->fontContent_opt = $fontContent_opt;
                    $theme_opt_up->color_opt = $color_opt;
                    $theme_opt_up->menu_color_opt = $menu_color_opt;
                    $theme_opt_up->m_menu_color_opt = $m_menu_color_opt;
                    $theme_opt_up->bgAttrib_opt = $request->bgAttrib_opt;
                    $theme_opt_up->bgcoloritem_opt = $request->bgcoloritem_opt;
                    $theme_opt_up->bgimgitem_opt = $bgimgitem_opt;
                    $theme_opt_up->head_misc = $request->head_misc;
                    $theme_opt_up->foot_misc = $request->foot_misc;
                    $theme_opt_up->status_opt = 'revise';
                    $theme_opt_up->banner_disp = $banner_display;
                    $theme_opt_up->banner_stat = $banner_opt;
    				        $theme_opt_up->footer_link_opt = $footer_link_opt;
                    $theme_opt_up->footer_copyright_opt = html_entity_decode($request->site_fp_ft_copyright);
                    $theme_opt_up->updated_at = date('Y-m-d H:i:s');
      				      $theme_opt_up->save();
   				
                $pages_opt = new cseo_pages;
                $rev_count = $id . '-revision-v1';
                $pages_opt::where('merchants_id', $request->merchant_id)->where('status_id', '15')->where('lang_id', $request->lang_id)->update([
                    'page_name' => $request->site_fp_title,
                    'page_title' => $request->site_fp_title,
                    'page_content' => $request->site_fp_editor,
                    'url_path' => "/".strtolower(str_replace(' ', '-', $request->site_url)),
                    'page_type' => 'front-page',
                    'rev_count' => '0',
                    'cseo_media_id' => '0',
                    'curr_status_id' => '15',
                    'user_id' => Auth::user()->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $options_opt = new cseo_options_settings;
                $options_opt::where( 'merchants_id', $request->merchant_id)->update([
                    'google_analytics' => $request->google_ga,
                    'google_verify' => $request->google_gv,
                    'data_sitekey' => $request->google_gkey,
                    'data_secretkey' => $request->google_skey,
                    'maintenance_mode' => $request->maintenance_mode,
                    'site_status' => 'updated'

                ]);

                $options_opt_title = new cseo_options_settings;
                $options_opt_title::where( 'merchants_id', $request->merchant_id)->where('lang_id', $request->lang_id)->update([
                    'site_identity' => $site_identity,
                    'ranking' => $request->google_ranking,
                    'site_notif' => $request->site_notif,
                    'contest_prog_date' => $date_prog
                ]);
            }
           
            $getid = cseo_options_settings::where( 'merchants_id', $request->merchant_id)->where('lang_id', $request->lang_id)->first();
            $redirect = url('/system/theme-settings/' . $getid->id . '/edit' );

            return response()->json([
                'status'    => 'success',
                'message'   => 'Update the record',
                'type'      => 'publish',
                'redirect'  => $redirect
            ]);

        }else{
            return response()->json([
                'status'    => 'Error',
                'message'   => 'Please check the required field',
                'type'      => '',
                'error' => $validate->getMessageBag()->toArray(),
                'redirect'  => ''
            ]);
           // return Redirect::back()->withErrors($validate)->withInput()->setStatusCode(422);    

         }
     }

     public function pageslang(Request $request){

        $opt_setting = new cseo_options_settings;           
        $theme_setting = new cseo_theme_options;
        $pages = new cseo_pages;

        $merchantfind = cseo_merchant::where('id', $request->merchant)->first();
        $merchant = $opt_setting::where('merchants_id', $request->merchant)->first();



        $countrylang = $opt_setting::where('merchants_id', $request->merchant)->where('lang_id', $request->lang_id)->first();

        if(count($countrylang) > 0) {

            return response()->json(['status'=>'success','message'=>'Successfully Added', 'last_id'=> $countrylang->id ]);

        }else{

              $opt_setting->parent_id = Auth::user()->id;
              $opt_setting->current_id = $request->merchant;
              $opt_setting->merchants_id = $request->merchant;
              $opt_setting->site_url = $merchantfind->merchant_name;
              $opt_setting->site_identity = '{"site_title":"'.$request->merchant_title.'","site_display_assets":"false","site_tag_line":""}';
              //$opt_setting->ranking_id =  $merchant->ranking_id;
              $opt_setting->ranking =  $merchant->ranking;
              $opt_setting->google_analytics = $merchant->google_analytics;
              $opt_setting->google_verify = $merchant->google_verify;
              $opt_setting->data_sitekey = $merchant->data_sitekey;
              $opt_setting->data_secretkey = $merchant->data_secretkey;
              $opt_setting->maintenance_mode = "0";  
              $opt_setting->lang_id = $request->lang_id;
              $opt_setting->save();

              $pages->merchants_id = $request->merchant;
              $pages->status_id = "15";
              $pages->curr_status_id = "15";
              $pages->page_type = "front_page";
              $pages->rev_count = "0";
              $pages->cseo_media_id = "0";
              $pages->cseo_category_id = "0";
              $pages->user_id = Auth::user()->id;
              $pages->lang_id = $request->lang_id;
              $pages->save();

              return response()->json(['status'=>'success','message'=>'Successfully Added', 'last_id'=> $opt_setting->id ]);

        }

                
     }   

}
