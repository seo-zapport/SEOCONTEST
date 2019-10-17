@extends('layouts.master')
@section('title', $site_identity->site_title.' |  Theme Settings')
@section('breadcrumb')   
   <h2><i class="fa fa-paint-brush"></i> Theme Settings</h2>
     <ol class="breadcrumb">
            <li>
                 <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
            </li>
            <li><a href="{{url('system/theme-settings')}}">Appearance</a></li>
            <li class="active">
               <a href="{{ url('/system/theme-settings') }}">Theme Settings</a>
            </li>
            <li><strong>Edit</strong></li>
     </ol>
@endsection
@section('admin-content')
    <div class="wrapper wrapper-content clearfix">

      @php
      if ( count( $theme_group ) > 0 ) {
        $identity_img = json_decode($theme_group->identity_img);
        $fontsHead_opt = json_decode($theme_group->fontsHead_opt);
        $fontContent_opt = json_decode($theme_group->fontContent_opt);
        $color_opt = json_decode($theme_group->color_opt);
        $menu_color_opt = json_decode($theme_group->menu_color_opt);
        $m_menu_color_opt = json_decode($theme_group->m_menu_color_opt);
        $bgimgitem_opt = json_decode($theme_group->bgimgitem_opt);
        $footer_link_opt = json_decode($theme_group->footer_link_opt);
        $site_identity_opt = json_decode($theme_group->site_identity);
        $datereg = json_decode($theme_group->cpd);
   
      }
      
      if ($logo == "0"){
        $logo_id = "0";
        $logo_name = "http://via.placeholder.com/250x60";
      }else{
        $logo_id = $logo->id;
        //$logo_name = asset('/img/gallery/' . $logo->media_name);
        $logo_name =  $logo->merchant_name.'/img/gallery/' .$logo->media_name;
      }
      
      if ($icon == "0"){
        $icon_id = "0";
        $icon_name = "http://via.placeholder.com/250x60";
      }else{
        $icon_id = $icon->id;
        //$icon_name = asset('/img/gallery/' . $icon->media_name);
       $icon_name = $icon->merchant_name.'/img/gallery/' . $icon->media_name;
      }

      if ($banner == "0"){
        $banner_id = "0";
        $banner_name = "http://via.placeholder.com/2000x430";
      }else{
        $banner_id = $banner->id;
        //$banner_name = asset('/img/gallery/' . $banner->media_name);
        $banner_name = $banner->merchant_name.'/img/gallery/' . $banner->media_name;
      }

      if ($bgimg == "0"){
        $bgimg_id = "0";
        $bgimg_name = "http://via.placeholder.com/250x60";
      }else{
        $bgimg_id = $bgimg->id;
        //$bgimg_name = asset('/img/gallery/' . $bgimg->media_name);
        $bgimg_name =  $bgimg->merchant_name.'/img/gallery/' . $bgimg->media_name;
      }

      $btn_style = "none";
      if ( $identity_img->identity_logo !== "0"  ){
        $btn_style = "block";
      }
      @endphp
      
      <div id="theme_settings_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="col-md-9">
          <div class="ibox">
            <div class="ibox-title">
              <h5>Update Theme Settings - <span class="text-navy">{{ str_replace('http://', '', $theme_group->merchant_name) }}</span></h5>
              <div class="ibox-tools">
                  <label>Maintenance Mode</label>
                  <input type="checkbox" id="main_m" @if($theme_group->main_m == '1') checked @endif class="js-switch" style="display: none;" >
              </div>
            </div>
            <div class="ibox-content">
              <div class="theme-settings">
                <div class="tabs-container">
                  <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#site-identity" aria-expanded="false">Site Identity</a></li>
                        <li><a data-toggle="tab" href="#site-webmaster" >Google Webmaster Tools</a></li>
                        <li><a data-toggle="tab" href="#site-elements" aria-expanded="true">Theme Elements</a></li>
                        <li><a data-toggle="tab" href="#site-front" aria-expanded="false">Front Page</a></li>
                        <li><a data-toggle="tab" href="#site-notice" aria-expanded="false">Notification</a></li>
                        <li><a data-toggle="tab" href="#site-misc" aria-expanded="false">Custom Misc.</a></li>
                        <li><a data-toggle="tab" href="#site-footer" aria-expanded="false">Footer</a></li>
                    </ul>
                    <div class="tab-content">
                      <div id="site-identity" class="tab-pane active">
                         <div class="tt-body panel-body">
                          <div class="form-group sr-only">
                            <label class="control-label col-sm-2 sr-only" for="site_merchant_id">&nbsp;</label>
                            <div class="col-sm-10 sr-only">
                              <input type="hidden" class="form-control" name="site_url" id="site_url" value="{{ str_replace('http://', '', $theme_group->merchant_name) }}" disabled>
                            </div>
                              <input type="hidden" class="form-control" name="site_merchant_id" id="site_merchant_id" value="{{ $theme_group->merchant_id }}">
                          </div>
                           <div class="from-group m-b clearfix">
                             <label class="control-label col-sm-2" for="site_title">Site title :</label>
                             <div class="col-sm-10">
                                <input type="text" name="site_title" id="site_title" class="form-control" placeholder="Site Title" value="{{ $site_identity_opt->site_title }}">
                             </div>
                           </div>
                           <div class="from-group m-b clearfix">
                             <label class="control-label col-sm-2" for="site_tag_line">Tagline :</label>
                             <div class="col-sm-10">
                                <input type="text" name="site_tag_line" id="site_tag_line" class="form-control" placeholder="Tagline" value="{{ $site_identity_opt->site_tag_line }}">
                             </div>
                           </div>
                           <div class="from-group m-b clearfix">
                             <label class="control-label col-sm-2" for="site_display_assets">&nbsp;</label>
                             <div class="checkbox checkbox-success col-sm-10">
                                <input type="checkbox" id="site_display_assets" name="site_display_assets" {{ ( @$site_identity_opt->site_display_assets === 'true' ) ? 'checked' : '' }}>
                                <label for="site_display_assets">Display Site Title and Tagline</label>
                            </div>
                           </div>
                           <div class="hr-line-dashed"></div>
                           <div class="form-group clearfix">
                             <label class="control-label col-sm-2" for="Logo">Site Logo :</label>
                             <div class="col-sm-4">
                               <div class="profile-block">
                                 <div class="panel profile-img-prev">
                                   <input type="hidden" name="media_logo" id="media_logo" class="image-data" value="{{ $logo_id }}">
                                   <img id="preview_logo" alt="image" class="image img-thumbnail img-responsive" src="{{ $logo_name }}">
                                   <div class="middle">
                                       <div class="browse"><a class="browsePogi"  data-toggle="modal" data-target="#Media" data-option="logo"><i class="fa fa-file-image-o"></i></a></div>
                                   </div>
                                 </div>
                               </div>
                               <div id="btnWrapRemove" class="m-l">
                                  <button class="btn btn-danger" id="sampleBtn" style="display:{{ $btn_style  }}">Remove Image</button>
                               </div>
                             </div>
                           </div>
                           <div class="hr-line-dashed"></div>
                           <div class="form-group clearfix">
                             <label class="control-label col-sm-2" for="Icon">Site Icon :</label>
                             <div class="col-sm-10">
                               <p><i>The Site Icon is used as a browser and app icon for your site. Icons must be square, and at least 512 pixels wide and tall.</i></p>
                               <div class="profile-block col-sm-4">
                                 <div class="panel profile-img-prev">
                                   <input type="hidden" name="media_icon" id="media_icon" class="image-data" value="{{ $icon_id }}">
                                   <img id="preview_icon" alt="image" class="image img-thumbnail img-responsive" src="{{ $icon_name }}">
                                   <div class="middle">
                                       <div class="browse"><a class="browsePogi" data-toggle="modal" data-target="#Media" data-option="icon"><i class="fa fa-file-image-o"></i></a></div>
                                   </div>
                                 </div>
                               </div>
                             </div>
                           </div> 
                           <div class="hr-line-dashed"></div>
                           <div class="form-group clearfix">
                             <label class="control-label col-sm-2" for="Banner">Site Banner :</label>
                             <div class="col-sm-10">
                               <p><i>The Site Banner is used as a browser and app icon for your site. Icons must be square, and at least 2000x430 pixels wide and tall.</i></p>
                               <div class="profile-block">
                                 <div class="panel profile-img-prev">
                                   <input type="hidden" name="media_banner" id="media_banner" class="" value="{{ $banner_id }}">
                                   <img id="preview_banner" alt="image" class="image img-thumbnail img-responsive" src="{{ $banner_name }}">
                                   <div class="middle">
                                       <div class="browse"><a class="browsePogi" data-toggle="modal" data-target="#Media" data-option="banner"><i class="fa fa-file-image-o"></i></a></div>
                                   </div>
                                 </div>
                               </div>
                             </div>
                           </div> 
                         </div>
                       </div> <!--tab-site-identity-->
                      
                       <div id="site-webmaster" class="tab-pane">
                             <div class="tt-body panel-body">
                       
                               <div class="from-group m-b clearfix">
                                 <label class="control-label col-sm-2" for="site_ga">Google Analytics :</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="site_ga" id="site_ga" class="form-control" placeholder="" value="{{ $theme_group->google_analytics }}">
                                 </div>
                               </div>
                               <div class="from-group m-b clearfix">
                                 <label class="control-label col-sm-2" for="site_gv">Google Site Verification :</label>
                                 <div class="col-sm-10">
                                    <input type="text" name="site_gv" id="site_gv" class="form-control" placeholder="" value="{{ $theme_group->google_verify }}">
                                 </div>
                               </div>
                               <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-md-12">Google re-CAPTCHA</label></div>
                               <div class="form-group">
                                 <label class="col-md-2">Data Site Key <span class="text-danger">(*)</span></label>
                                 <div class="col-md-10">
                                   <input type="text" name="site_g_key" class="form-control" placeholder="Enter Data Site Key here" value="{{ $theme_group->data_sitekey }}">
                                 </div>
                               </div>
                                <div class="form-group">
                                 <label class="col-md-2">Data Secret Key <span class="text-danger">(*)</span></label>
                                 <div class="col-md-10">
                                   <input type="text" name="site_s_key" class="form-control" placeholder="Enter Secret Key here" value="{{ $theme_group->data_secretkey }}">
                                 </div>
                               </div>
                               <div class="hr-line-dashed"></div>
                               <div class="form-group">
                                 <label class="col-md-2">Google Ranking <span class="text-danger">(*)</span></label>
                                 <div class="col-md-10">
                                   <input type="text" name="site_act_title" class="form-control" placeholder="Enter article title here" value="{{ $theme_group->ranking }}">
                                 </div>
                               </div> 
                             </div>
                           </div> <!--tab-site-webmaster-->

                      <div id="site-elements" class="tab-pane">
                        <div class="tt-body panel-body">
                          <div class="form-group">
                              <div class="col-sm-12"><h3 class="text-navy">Heading Fonts</h3></div>
                              <div class="col-md-3">
                                <label for="font_family_heading">Font Family</label>
                                <select id="font_family_heading" data-placeholder="Choose a font family..." multiple class="form-control chosen-select">
                                  <option value="arial" {{ ( $theme_group->familyHead_opt ) == "arial"? 'selected':''}}>Arial</option>
                                  <option value="helvetica" {{ ( $theme_group->familyHead_opt ) == "helvetica"? 'selected':''}}>Helvitica</option>
                                  <option value="san-serif" {{ ( $theme_group->familyHead_opt ) == "san-serif"? 'selected':''}}>San serif</option>
                                  <option value="noto-sans" {{ ( $theme_group->familyHead_opt ) == "noto-sans"? 'selected':''}}>Noto sans</option>
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label for="font_size_heading">Font size</label>
                                <div class="input-group">
                                  <input type="number" class="form-control" name="font_size_heading" id="font_size_heading" value="{{$fontsHead_opt->size}}">
                                  <span class="input-group-addon">px</span>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label for="font_style_heading">Font style</label>
                                <select class="form-control" id="font_style_heading">
                                  <option value="normal" {{old('style',$fontsHead_opt->style) == "normal"? 'selected':''}}>Normal</option>
                                  <option value="italic" {{old('style',$fontsHead_opt->style) == "italic"? 'selected':''}}>Italic</option>
                                  <option value="oblique" {{old('style',$fontsHead_opt->style) == "oblique"? 'selected':''}}>Oblique</option>
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label for="font_weight_heading">Font weight</label>
                                <select class="form-control" id="font_weight_heading">
                                  <option value="400" {{old('weight',$fontsHead_opt->weight) == "400"? 'selected':''}}>400</option>
                                  <option value="500" {{old('weight',$fontsHead_opt->weight) == "500"? 'selected':''}}>500</option>
                                  <option value="600" {{old('weight',$fontsHead_opt->weight) == "600"? 'selected':''}}>600</option>
                                  <option value="700" {{old('weight',$fontsHead_opt->weight) == "700"? 'selected':''}}>700</option>
                                </select>
                              </div>
                          </div> <!--Heading-fonts-->
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                              <div class="col-sm-12">
                                <h3 class="text-navy">Content Fonts</h3>
                              </div>
                              <div class="col-md-3">
                                <label for="font_family_content">Font Family</label>
                                <select id="font_family_content" data-placeholder="Choose a font family..." multiple class="form-control chosen-select">
                                  <option value="arial" {{ ( $theme_group->familyContent_opt ) == "arial"? 'selected':''}}>Arial</option>
                                  <option value="helvetica" {{ ( $theme_group->familyContent_opt ) == "helvetica"? 'selected':''}}>Helvitica</option>
                                  <option value="san-serif" {{ ( $theme_group->familyContent_opt ) == "san-serif"? 'selected':''}}>San serif</option>
                                  <option value="noto-sans" {{ ( $theme_group->familyContent_opt ) == "noto-sans"? 'selected':''}}>Noto sans</option>
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label for="font_size_content">Font size</label>
                                <div class="input-group">
                                  <input type="number" class="form-control" name="font_size_content" id="font_size_content" value="{{$fontContent_opt->size}}">
                                  <span class="input-group-addon">px</span>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label for="font_style_content">Font style</label>
                                <select class="form-control" id="font_style_content">
                                  <option value="normal" {{old('style',$fontContent_opt->style) == "normal"? 'selected':''}}>Normal</option>
                                  <option value="italic" {{old('style',$fontContent_opt->style) == "italic"? 'selected':''}}>Italic</option>
                                  <option value="oblique" {{old('style',$fontContent_opt->style) == "oblique"? 'selected':''}}>Oblique</option>
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label for="font_weight_content">Font weight</label>
                                <select class="form-control" id="font_weight_content">
                                  <option value="400" {{old('weight',$fontContent_opt->weight) == "400"? 'selected':''}}>400</option>
                                  <option value="500" {{old('weight',$fontContent_opt->weight) == "500"? 'selected':''}}>500</option>
                                  <option value="600" {{old('weight',$fontContent_opt->weight) == "600"? 'selected':''}}>600</option>
                                  <option value="700" {{old('weight',$fontContent_opt->weight) == "700"? 'selected':''}}>700</option>
                                </select>
                              </div>
                          </div> <!--content-fonts-->
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <div class="col-md-6 m-b">
                              <h3 class="text-navy" for="colorElementHeading">Heading Color</h3>
                              <div id="colorElementHeading" class="input-group colorpicker-component">
                                <input type="text" value="{{$color_opt->head}}" name="colorElementHeading" class="form-control"/>
                                <span class="input-group-addon"><i></i></span>
                              </div>
                            </div>
                            <div class="col-md-6 m-b">
                              <h3 class="text-navy" for="colorElementDefaultColor">Default Color</h3>
                              <div id="colorElementDefaultColor" class="input-group colorpicker-component">
                                <input type="text" value="{{$color_opt->default}}" name="colorElementDefaultColor" class="form-control"/>
                                <span class="input-group-addon"><i></i></span>
                              </div>
                            </div>
                          </div> <!--colors-->
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <div class="col-sm-12 mb">
                              <h3 class="text-navy" for="site_title">Menu Color</h3>
                            </div>
                            <div class="col-md-4">
                              <label for="colorElementMenuColorWrap">Wrap Color</label>
                              <div id="colorElementMenuColorWrap" class="input-group colorpicker-component">
                                <input type="text" value="{{$menu_color_opt->wrap}}" name="colorElementMenuColorWrap" class="form-control"/>
                                <span class="input-group-addon"><i></i></span>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label for="colorElementMenuColorText">Text Color</label>
                              <div id="colorElementMenuColorText" class="input-group colorpicker-component">
                                <input type="text" value="{{$menu_color_opt->text}}" name="colorElementMenuColorText" class="form-control"/>
                                <span class="input-group-addon"><i></i></span>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label for="colorElementMenuColorHover">Hover Color</label>
                              <div id="colorElementMenuColorHover" class="input-group colorpicker-component">
                                <input type="text" value="{{$menu_color_opt->hover}}" name="colorElementMenuColorHover" class="form-control"/>
                                <span class="input-group-addon"><i></i></span>
                              </div>
                            </div>
                          </div>
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <div class="col-sm-12 mb">
                              <h3 class="text-navy" for="site_title">Menu Mobile Color</h3>
                            </div>
                            <div class="col-sm-4 mb">
                              <label for="colorElementMenuColorMobileBtn">Button Color</label>
                              <div id="colorElementMenuColorMobileBtn" class="input-group colorpicker-component">
                                <input type="text" value="{{$m_menu_color_opt->btn_wrap}}" name="colorElementMenuColorMobileBtn" class="form-control"/>
                                <span class="input-group-addon"><i></i></span>
                              </div>
                            </div>
                            <div class="col-sm-4 mb">
                              <label for="colorElementMenuColorMobileBtnIcon">Button icon</label>
                              <div id="colorElementMenuColorMobileBtnIcon" class="input-group colorpicker-component">
                                <input type="text" value="{{$m_menu_color_opt->icon}}" name="colorElementMenuColorMobileBtnIcon" class="form-control"/>
                                <span class="input-group-addon"><i></i></span>
                              </div>
                            </div>
                            <div class="col-sm-4 mb">
                              <label for="colorElementMenuColorMobileBtnHover">Button Hover</label>
                              <div id="colorElementMenuColorMobileBtnHover" class="input-group colorpicker-component">
                                <input type="text" value="{{$m_menu_color_opt->hover}}" name="colorElementMenuColorMobileBtnHover" class="form-control"/>
                                <span class="input-group-addon"><i></i></span>
                              </div>
                            </div>
                          </div>
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <h3 class="text-navy">Background Attributes</h3>
                            </div>                              
                            <div class="tabs-container col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="tab-item {{ old('bgAttrib_opt',$theme_group->bgAttrib_opt) == '1' ? 'active':'' }}"><a data-toggle="tab" href="#bg-color" data-bg_attr="color" aria-expanded="false"><i class="fa fa-eyedropper"></i>Color</a></li>
                                    <li class="tab-item {{ old('bgAttrib_opt',$theme_group->bgAttrib_opt) == '2' ? 'active':'' }}"><a data-toggle="tab" href="#bg-img" data-bg_attr="image" aria-expanded="true"><i class="fa fa-picture-o"></i>Image</a></li>
                                </ul>
                                <div class="tab-content" id="tab_settings">
                                    <input type="hidden" id="bgAttrib_opt" name="bgAttrib_opt" value="{{ old('bgAttrib_opt',$theme_group->bgAttrib_opt)== '1' ? 'color':'image' }}">
                                    <div id="bg-color" class="tab-pane {{ old('bgAttrib_opt',$theme_group->bgAttrib_opt)== '1' ? 'active':'' }}">
                                      <div class="p-md">
                                        <div class="form-group">
                                          <div id="colorElementBGColor" class="input-group colorpicker-component">
                                            <input type="text" value="{{ $theme_group->bgcoloritem_opt }}" name="colorElementBGColor" class="form-control"/>
                                            <span class="input-group-addon"><i></i></span>
                                          </div>
                                        </div>
                                      </div>
                                    </div> <!--color-tab-->
                                    <div id="bg-img" class="tab-pane {{ old('bgAttrib_opt',$theme_group->bgAttrib_opt)== '2' ? 'active':'' }}">
                                        <div class="p-md">
                                            <div class="form-group no-margins clearfix">
                                               <label class="control-label col-sm-2">Background Image:</label>
                                               <div class="col-sm-4">
                                                 <div class="profile-block">
                                                   <div class="panel profile-img-prev">
                                                     <input type="hidden" name="media_bg_img" id="media_bg_img" class="image-data" value="{{ $bgimg_id }}">
                                                     <img id="preview_bg_img" alt="image" class="image img-responsive img-thumbnail" src="{{ $bgimg_name }}">
                                                     <div class="middle">
                                                       <div class="browse"><a class="browsePogi"  data-toggle="modal" data-target="#Media" data-option="bg_image"><i class="fa fa-file-image-o"></i></a></div>
                                                     </div>
                                                   </div>
                                                 </div>
                                               </div>
                                            </div>
                                            <div class="hr-line-dashed"></div>
                                            <div class="form-group no-margins" id="site_fp_elem__presets">
                                              <label for="site_presets" class="control-label col-sm-2">Presets</label>
                                              <div class="col-sm-10">
                                                <select class="form-control" id="site_fp_presets">
                                                  <option value="default" {{ ( $bgimgitem_opt->presets ) == 'default' ? 'selected':'' }}>Default</option>
                                                  <option value="fill-screen" {{ ( $bgimgitem_opt->presets ) == 'fill-screen' ? 'selected':'' }}>Fill screen</option>
                                                  <option value="fit-to-screen" {{ ( $bgimgitem_opt->presets ) == 'fit-to-screen' ? 'selected':'' }}>Fit to screen</option>
                                                  <option value="repeat" {{ ( $bgimgitem_opt->presets ) == 'repeat' ? 'selected':'' }}>Repeat</option>
                                                  <option value="custom" {{ ( $bgimgitem_opt->presets ) == 'custom' ? 'selected':'' }}>Custom</option>
                                                </select>
                                              </div>
                                              <div class="hr-line-dashed col-md-12"></div>
                                            </div> <!--Image-Presets-->
                                            <div class="form-group no-margins" id="site_fp_elem__position">
                                                <label for="site_presets" class="control-label col-sm-2">Image Position</label>
                                                <div class="col-sm-10">
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioTopLeft" value="left-top" name="radioInline" {{ ( $bgimgitem_opt->position ) == 'left-top' ? 'checked':'' }}>
                                                      <label for="imgPostRadioTopLeft">Left Top</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioCenterTop" value="center-top" name="radioInline" {{ ( $bgimgitem_opt->position ) == 'center-top' ? 'checked':'' }}>
                                                      <label for="imgPostRadioCenterTop">Center Top</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioRightTop" value="right-top" name="radioInline" {{ ( $bgimgitem_opt->position ) == 'right-top' ? 'checked':'' }}>
                                                      <label for="imgPostRadioRightTop">Right Top</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioLeftCenter" value="left-center" name="radioInline" {{ ( $bgimgitem_opt->position ) == 'left-center' ? 'checked':'' }}>
                                                      <label for="imgPostRadioLeftCenter">Left Center</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioCenterCenter" value="center-center" name="radioInline" {{ ( $bgimgitem_opt->position ) == 'center-center' ? 'checked':'' }}>
                                                      <label for="imgPostRadioCenterCenter">Center Center</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioRightCenter" value="right-center" name="radioInline" {{ ( $bgimgitem_opt->position ) == 'right-center' ? 'checked':'' }}>
                                                      <label for="imgPostRadioRightCenter">Right Center</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioCenterBottom" value="left-bottom" name="radioInline" {{ ( $bgimgitem_opt->position ) == 'left-bottom' ? 'checked':'' }}>
                                                      <label for="imgPostRadioCenterBottom">Left Bottom</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioTopBottom" value="center-bottom" name="radioInline" {{ ( $bgimgitem_opt->position ) == 'center-bottom' ? 'checked':'' }}>
                                                      <label for="imgPostRadioTopBottom">Center Bottom</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioRightBottom" value="right-bottom" name="radioInline" {{ ( $bgimgitem_opt->position ) == 'right-bottom' ? 'checked':'' }}>
                                                      <label for="imgPostRadioRightBottom">Right Bottom</label>
                                                  </div>
                                                </div>
                                                <div class="hr-line-dashed col-md-12"></div>
                                            </div> <!--Image-Position-->
                                            <div class="form-group no-margins" id="site_fp_elem__repeat">
                                              <label for="site_fp_repeat" class="control-label col-sm-2">BG Img Repeat</label>
                                              <div class="col-sm-10">
                                                <div class="checkbox checkbox-primary">
                                                  <input id="site_fp_repeat" name="site_fp_repeat" type="checkbox" {{ ( $bgimgitem_opt->repeat ) == 'true' ? 'checked':'' }}>
                                                  <label for="site_fp_repeat">Do you want to repeat the image?</label>
                                                </div>
                                              </div>
                                              <div class="hr-line-dashed col-md-12"></div>
                                            </div> <!--Image-Repeat-->
                                            <div class="form-group no-margins" id="site_fp_elem__scroll">
                                              <label for="site_fp_scroll" class="control-label col-sm-2">Scroll with Page</label>
                                              <div class="col-sm-10">
                                                <div class="checkbox checkbox-primary">
                                                  <input id="site_fp_scroll" name="site_fp_scroll" type="checkbox" {{ ( $bgimgitem_opt->scroll ) == 'true' ? 'checked':'' }}>
                                                  <label for="site_fp_scroll">Enable Scroll Page?</label>
                                                </div>
                                              </div>
                                              <div class="hr-line-dashed col-md-12"></div>
                                            </div> <!--Scroll-Page-->
                                            <div class="form-group no-margins" id="site_fp_elem__size">
                                              <label for="site_fp_size" class="control-label col-sm-2">Image size</label>
                                              <div class="col-sm-10">
                                                <select class="form-control" id="site_fp_size">
                                                  <option value="original" {{ ( $bgimgitem_opt->size ) == 'original' ? 'selected':'' }}>Original</option>
                                                  <option value="contain" {{ ( $bgimgitem_opt->size ) == 'contain' ? 'selected':'' }}>Fit to screen</option>
                                                  <option value="cover" {{ ( $bgimgitem_opt->size ) == 'cover' ? 'selected':'' }}>Fill screen</option>
                                                </select>
                                              </div>
                                            </div> <!--Image-Size-->
                                        </div>
                                    </div> <!--img-tab-->
                                </div>
                            </div>
                          </div> <!--BG-Attr-->
                        </div>
                      </div> <!--tab-site-elements-->

                      <div id="site-front" class="tab-pane ">
                        <div class="tt-body panel-body">
                          <div class="form-group">
                            <div class="col-md-12">
                              <input type="text" name="site_fp_title" class="form-control" placeholder="Enter title here" value="{{ $theme_group->page_title }}">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <textarea class="form-control col-sm-12" name="site_fp_editor">{{ $theme_group->page_content }}</textarea>
                            </div>
                          </div>
                        </div>
                      </div> <!--tab-site-front-->
                  
                      <div id="site-notice" class="tab-pane ">
                        <div class="tt-body panel-body">
                          <div class="form-group">
                            <label for="site_notif" class="control-label col-sm-2">Notification: </label>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-rss"></i></span>
                                <input type="text" id="site_notif" name="site_notif" class="form-control" placeholder="Notification" value="{{ $theme_group->site_notif }}">
                              </div>
                            </div>
                          </div>
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <label for="Time Line" class="control-label col-sm-2">Time line: </label>
                            <div class="col-sm-10">
                                  <label for="Limit" class="col-sm-12">Limit of Registration : </label>
                                  <input type="text" name="daterange" class="form-control"  value="{{ old('daterange')=='' ? @$datereg->lor : '01/01/2018 12:00 AM - 01/01/2018 12:00 PM' }}" />        
                          <div class="hr-line-dashed"></div>
                                  <label for="Winner" class="col-sm-12">Announcement of Winner : </label>
                                  <input type="text" name="daterangeend" class="form-control"  value="{{ old('daterangeend')=='' ? @$datereg->wa : '01/01/2018 12:00 AM - 01/01/2018 12:00 PM' }}" />
                            </div>
                            </div>
                          </div>  
                      </div> <!--tab-site-notice-->

                      <div id="site-misc" class="tab-pane ">

                        <div class="tt-body panel-body">
                          <div class="form-group">
                            <label for="site_notif" class="control-label col-sm-2">Header Script: </label>
                            <div class="col-sm-10">     
                                <textarea id="header_misc" name="header_misc" rows="10" placeholder="" class="form-control">{!! htmlspecialchars($theme_group->head_misc) !!}</textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="site_notif" class="control-label col-sm-2">Footer Script: </label>
                            <div class="col-sm-10">
                                <textarea id="footer_misc" name="footer_misc" rows="10" placeholder="" class="form-control"> {!! htmlspecialchars($theme_group->foot_misc) !!}</textarea>
                            </div>
                          </div>

                          <div class="hr-line-dashed"></div>
                        </div>
                      </div> <!--tab-site-notice-->

                      <div id="site-footer" class="tab-pane ">
                        <div class="tt-body panel-body">
                          <div class="form-group">
                            <label for="site_fp_ft_copyright" class="control-label col-sm-2">Copyright Text: </label>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">&copy;</span>
                                <input type="text" id="site_fp_ft_copyright" name="site_fp_ft_copyright" class="form-control" placeholder="Copyright" value="{{ $theme_group->footer_copyright_opt }}">
                              </div>
                            </div>
                          </div>
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <label for="site_fp_ft_target" class="control-label col-sm-2">Domain Target: </label>
                            <div class="col-sm-10">
                              <select class="form-control" name="site_fp_ft_target">
                                <option value="_blank" {{ ( $footer_link_opt->link_target_opt ) == '_blank' ? 'selected': '' }}>_blank</option>
                                <option value="_self" {{ ( $footer_link_opt->link_target_opt ) == '_self' ? 'selected': '' }}>_self</option>
                              </select>
                            </div>
                          </div>
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <label for="site_fp_ft_rel" class="control-label col-sm-2">Domain Rel: </label>
                            <div class="col-sm-10">
                              <select class="form-control" name="site_fp_ft_rel">
                                <option value="nofollow" {{ ( $footer_link_opt->link_rel_opt ) == 'nofollow' ? 'selected': '' }}>NO Follow</option>
                                <option value="" {{ ( $footer_link_opt->link_rel_opt ) == '' ? 'selected': '' }}>Do Follow</option>
                              </select>
                            </div>
                          </div>
                          <div class="hr-line-dashed"></div>
                        </div>
                      </div> <!--tab-site-footer-->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div> <!--col-9-->
        <div class="col-md-3">
          <div class="ibox">
            <div class="ibox-title">
              <h5>Update</h5>
            </div>
            <div class="ibox-content">
              <div class="form-group clearfix">
                <div class="lngchoice">
                <label>Language</label>    
                <select class="form-control m-b" id="langname" name="langname" onchange="countrylang(this);" >
                    <option value="">--- Select Language ---</option>
                    @foreach ($lang as $langs)  
                        <option value="{{$langs->id }}" class="text-center" @if(old('merchantname', $langs->id) == @$theme_group->lang_id) selected="selected" @endif> {{ $langs->name}} </option>
                    @endforeach
                </select> 
                </div>
                <input type="hidden" id="pageid" class="pageid" value="{{ $theme_group->id }}" >
                <button class="btn btn-primary pull-right" id="theme_settings_btn_update" data-theme_id="{{ $theme_group->id }}" role="button">Update</button>
              </div>
            </div>
          </div>
        </div> <!--col-3-->
      </div>
      <div class="modal modal-wide fade" tabindex="-1" role="dialog"  aria-hidden="true" id="Media">
        <div class="modal-dialog">
          Modal Content
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h3 class="modal-title">Featured Image</h3>
            </div>
            <div class="modal-body">
              <div class="container-fluid row" id="attach_body">
                  <ul class="nav nav-tabs">
                      <li><a data-toggle="tab" href="#uploads">Upload Files</a></li>
                      <li class="active"><a data-toggle="tab" href="#media_library">Media Library</a></li>
                  </ul>
                  <div class="col-md-10 media-attachment">
                    <div class="tab-content">
                      <div id="uploads" class="tab-pane">
                        File Uploads
                        <div class="dropimg">
                          <div class="uploader-inline">
                            <form action="{{url( '/system/media' )}}" class="dropzone dz-clickable" id="dropzoneForm"> 
                              <div class="dz-default dz-message">
                                <span><strong>Images files here or click to upload. </strong></br> (Maximum Filesize is 3mb)</span>
                              </div>
                              {{ csrf_field() }}
                            </form>
                          </div>
                        </div>
                      </div>
                      <div id="media_library" class="tab-pane active" data-media_method="details">
                          <ul class="attachment-list">
                              @foreach ($media as $medias)
                                  @if( !is_null( $medias->media_name ) )

                                      <li class="attachment-group-list">
                                          <a class="show_details_image" data-id="{{$medias->id}}">
                                              <div class="attachment-prev landscape">
                                                
                                                  <div class="thumbnails lightBoxGallery selected-{{$medias->id}}">
                                                        <div class="selected check-select-{{$medias->id}}" ><i class="fa fa-check-square"></i> </div>   
                                                      <div class="centered">
                                                          <img id="{{$medias->id}}" src="{{$medias->merchant_name.'/img/gallery/'.$medias->media_name}}" title="{{$medias->title_name}}" >
                                                      </div>
                                                  </div>
                                              </div>
                                          </a>
                                      </li>
                                  @endif
                              @endforeach
                          </ul>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2 media-sidebar">
                      <div class="slider_details">
                        @foreach ($media as $medias)
                            <div id="details_attach" class="details_attach details_{{$medias->id}} animated fadeIn" style="display:none;">
                              <input type="hidden" id="edit_id" value="{{$medias->id}}">
                              <h4 class="attach-title">ATTACHMENT DETAILS</h4>
                              <div class="attachment-info">
                                  <div class="thumbnails">
                                      <img src="{{$medias->merchant_name.'/img/gallery/'.$medias->media_name}}">
                                  </div>
                                  <div class="attach-details">
                                  <p class="attach-filename">{{ucfirst($medias->title_name)}}</p>
                                  <p class="attach-date">{{$medias->created_at->format('M d, Y')}}</p>
                                  
                                  <?php $bytes = $medias->file_size;
                                   $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
                                   for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
                                   $media_unit = round( $bytes, 2 ) . " " . $label[$i];
                                 ?>

                                  <p class="attach-size">{{ $media_unit }}</p>
                                  <div class="attach-btn-wrap">
                                  <a class="btn btn-link text-danger" id="delete_img" data-id="{{$medias->id}}"><i class="fa fa-trash"></i> Delete</a>
                                  </div>
                                  </div>
                              </div>

                              <div tabindex="0" id="attachment_id_{{$medias->id}}" class="attach-form" data-attachment_id="{{$medias->id}}">
                                      <div class="form-group">
                                          <label>URL</label>
                                          <input type="text" id="attach_url_{{$medias->id}}" name="attach_url" class="form-control" value="{{$medias->merchant_name.'/img/gallery/'.$medias->media_name}}" disabled>
                                      </div>
                                      <div class="form-group">
                                          <label>Title</label>
                                          <input type="text" id="attach_title_{{$medias->id}}" name="attach_title" class="form-control" value="{{$medias->title_name}}">
                                      </div>
                                      <div class="form-group">
                                          <label>Caption</label>
                                          <textarea class="form-control" id="attach_caption_{{$medias->id}}" name="attach_caption">{{$medias->caption_text}}</textarea>
                                      </div>
                                      <div class="form-group">
                                          <label>Alt Text</label>
                                          <input type="text" id="attach_alt_text_{{$medias->id}}" name="attach_alt_text" class="form-control" value="{{$medias->alt_text}}">
                                      </div>
                                      <div class="form-group">
                                          <label>Description</label>
                                          <textarea class="form-control" id="attach_desc_{{$medias->id}}" name="attach_desc">{{$medias->description}}</textarea>
                                      </div>
                              </div>
                            </div>
                            @endforeach
                      </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="selectbannerimg" class="btn btn-primary" data-method="featured_image" data-dismiss="modal">Set featured image</button>
            </div>
          </div>
        </div>
      </div>
    </div> <!--.wrapper-->
@endsection