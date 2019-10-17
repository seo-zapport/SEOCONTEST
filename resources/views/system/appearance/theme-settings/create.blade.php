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
            <li><strong>Add new</strong></li>
     </ol>
@endsection
@section('admin-content')
    <div class="wrapper wrapper-content clearfix">
      <div id="theme_settings_form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="col-md-9">
          <div class="ibox">
            <div class="ibox-title">
              <h5>Create Theme Settings</h5>
            </div>
            <div class="ibox-content">
              <div class="form-group">
                <label class="control-label col-sm-2" for="site_url">Site URL:</label>
                <div class="col-sm-10">
                  <!-- <input type="text" class="form-control" name="site_url" id="site_url" value="" placeholder="Enter Site URL"> -->
                  <select class="form-control" id="site_url">
                    @foreach ( $merchants as $merchants_value )
                      <option value="{{ str_replace('http://', '', $merchants_value->merchant_name) }}" data-merchant="{{$merchants_value->merchant_id}}">{{ str_replace('http://', '', $merchants_value->merchant_name) }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group ">
                <label class="control-label col-sm-2" for="site_merchant_id">Merchant ID:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="site_merchant_id" id="site_merchant_id" value="" placeholder="Enter Merchant ID">
                </div>
              </div>
              <div class="hr-line-dashed"></div>
              <div class="theme-settings">
                <div class="tabs-container">
                  <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#site-identity" aria-expanded="false">Site Identity</a></li>
                        <li><a data-toggle="tab" href="#site-elements" aria-expanded="true">Theme Elements</a></li>
                        <li><a data-toggle="tab" href="#site-front" aria-expanded="false">Front Page</a></li>
                        <li><a data-toggle="tab" href="#site-footer" aria-expanded="false">Footer</a></li>
                    </ul>
                    <div class="tab-content">
                      <div id="site-identity" class="tab-pane active">
                         <div class="tt-body panel-body">
                           <div class="form-group clearfix">
                             <label class="control-label col-sm-2" for="email">Site Logo :</label>
                             <div class="col-sm-4">
                               <div class="profile-block">
                                 <div class="panel profile-photo profile-img-prev">
                                   <input type="hidden" name="media_logo" id="media_logo" class="image-data" value="">
                                   <img id="preview_logo" alt="image" class="image img-circle" src="http://via.placeholder.com/350x150">
                                   <div class="middle">
                                       <div class="browse"><a class="browsePogi"  data-toggle="modal" data-target="#Media" data-option="logo"><i class="fa fa-file-image-o"></i></a></div>
                                   </div>
                                 </div>
                               </div>
                             </div>
                           </div>
                           <div class="hr-line-dashed"></div>
                           <div class="form-group clearfix">
                             <label class="control-label col-sm-2" for="email">Site Icon :</label>
                             <div class="col-sm-10">
                               <p><i>The Site Icon is used as a browser and app icon for your site. Icons must be square, and at least 512 pixels wide and tall.</i></p>
                               <div class="profile-block col-sm-4">
                                 <div class="panel profile-photo profile-img-prev">
                                   <input type="hidden" name="media_icon" id="media_icon" class="image-data" value="">
                                   <img id="preview_icon" alt="image" class="image img-circle" src="http://via.placeholder.com/350x150">
                                   <div class="middle">
                                       <div class="browse"><a class="browsePogi" data-toggle="modal" data-target="#Media" data-option="icon"><i class="fa fa-file-image-o"></i></a></div>
                                   </div>
                                 </div>
                               </div>
                             </div>
                           </div> 
                         </div>
                       </div> <!--tab-site-identity-->
                      <div id="site-elements" class="tab-pane">
                        <div class="tt-body panel-body">
                          <div class="form-group">
                              <div class="col-sm-12"><h3 class="text-navy">Heading Fonts</h3></div>
                              <div class="col-md-3">
                                <label for="font_family_heading">Font Family</label>
                                <select id="font_family_heading" data-placeholder="Choose a font family..." multiple class="form-control chosen-select">
                                  <option value="Arial">Arial</option>
                                  <option value="Helvitica">Helvitica</option>
                                  <option value="san-serif">San serif</option>
                                  <option value="noto-sans">Noto sans</option>
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label for="font_size_heading">Font size</label>
                                <div class="input-group">
                                  <input type="number" class="form-control" name="font_size_heading" id="font_size_heading" value="">
                                  <span class="input-group-addon">px</span>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label for="font_style_heading">Font style</label>
                                <select class="form-control" id="font_style_heading">
                                  <option value="normal">Normal</option>
                                  <option value="italic">Italic</option>
                                  <option value="oblique">Oblique</option>
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label for="font_weight_heading">Font weight</label>
                                <select class="form-control" id="font_weight_heading">
                                  <option value="400">400</option>
                                  <option value="500">500</option>
                                  <option value="600" selected>600</option>
                                  <option value="700">700</option>
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
                                  <option value="Arial">Arial</option>
                                  <option value="Helvitica">Helvitica</option>
                                  <option value="san-serif">San serif</option>
                                  <option value="noto-sans">Noto sans</option>
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label for="font_size_content">Font size</label>
                                <div class="input-group">
                                  <input type="number" class="form-control" name="font_size_content" id="font_size_content" value="14">
                                  <span class="input-group-addon">px</span>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label for="font_style_content">Font style</label>
                                <select class="form-control" id="font_style_content">
                                  <option value="normal">Normal</option>
                                  <option value="italic">Italic</option>
                                  <option value="oblique">Oblique</option>
                                </select>
                              </div>
                              <div class="col-md-3">
                                <label for="font_weight_content">Font weight</label>
                                <select class="form-control" id="font_weight_content">
                                  <option value="400">400</option>
                                  <option value="500" selected>500</option>
                                  <option value="600">600</option>
                                  <option value="700">700</option>
                                </select>
                              </div>
                          </div> <!--content-fonts-->
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <div class="col-md-6">
                              <h3 class="text-navy" for="site_title">Heading Color</h3>
                              <div id="colorElementHeading" class="input-group colorpicker-component">
                                <input type="text" value="#00AABB" name="colorElementHeading" class="form-control"/>
                                <span class="input-group-addon"><i></i></span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <h3 class="text-navy" for="site_title">Default Color</h3>
                              <div id="colorElementDefaultColor" class="input-group colorpicker-component">
                                <input type="text" value="#00AABB" name="colorElementDefaultColor" class="form-control"/>
                                <span class="input-group-addon"><i></i></span>
                              </div>
                            </div>
                          </div> <!--colors-->
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <h3 class="text-navy">Background Attributes</h3>
                            </div>                              
                            <div class="tabs-container col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active tab-item"><a data-toggle="tab" href="#bg-color" data-bg_attr="color" aria-expanded="false"><i class="fa fa-eyedropper"></i>Color</a></li>
                                    <li class="tab-item"><a data-toggle="tab" href="#bg-img" data-bg_attr="image" aria-expanded="true"><i class="fa fa-picture-o"></i>Image</a></li>
                                </ul>
                                <div class="tab-content" id="tab_settings">
                                    <input type="hidden" id="bgAttrib_opt" name="bgAttrib_opt" value="color">
                                    <div id="bg-color" class="tab-pane active">
                                      <div class="p-md">
                                        <div class="form-group">
                                          <div id="colorElementBGColor" class="input-group colorpicker-component">
                                            <input type="text" value="#00AABB" name="colorElementBGColor" class="form-control"/>
                                            <span class="input-group-addon"><i></i></span>
                                          </div>
                                        </div>
                                      </div>
                                    </div> <!--color-tab-->
                                    <div id="bg-img" class="tab-pane">
                                        <div class="p-md">
                                            <div class="form-group no-margins" id="site_fp_elem__presets">
                                              <label for="site_presets" class="control-label col-sm-2">Presets</label>
                                              <div class="col-sm-10">
                                                <select class="form-control" id="site_fp_presets">
                                                  <option value="default">Default</option>
                                                  <option value="fill-screen">Fill screen</option>
                                                  <option value="fit-to-screen">Fit to screen</option>
                                                  <option value="repeat">Repeat</option>
                                                  <option value="custom">Custom</option>
                                                </select>
                                              </div>
                                              <div class="hr-line-dashed col-md-12"></div>
                                            </div> <!--Image-Presets-->
                                            <div class="form-group no-margins" id="site_fp_elem__position">
                                                <label for="site_presets" class="control-label col-sm-2">Image Position</label>
                                                <div class="col-sm-10">
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioTopLeft" value="left-top" name="radioInline">
                                                      <label for="imgPostRadioTopLeft">Left Top</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioCenterTop-" value="center-top" name="radioInline">
                                                      <label for="imgPostRadioCenterTop">Center Top</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioRightTop" value="right-top" name="radioInline">
                                                      <label for="imgPostRadioRightTop">Right Top</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioLeftCenter" value="left-center" name="radioInline">
                                                      <label for="imgPostRadioLeftCenter">Left Center</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioCenterCenter" value="center-center" name="radioInline">
                                                      <label for="imgPostRadioCenterCenter">Center Center</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioRightCenter" value="right-center" name="radioInline">
                                                      <label for="imgPostRadioRightCenter">Right Center</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioCenterBottom" value="left-bottom" name="radioInline">
                                                      <label for="imgPostRadioCenterBottom">Left Bottom</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioTopBottom" value="center-bottom" name="radioInline">
                                                      <label for="imgPostRadioTopBottom">Center Bottom</label>
                                                  </div>
                                                  <div class="radio radio-primary radio-inline">
                                                      <input type="radio" id="imgPostRadioRightBottom" value="right-bottom" name="radioInline">
                                                      <label for="imgPostRadioRightBottom">Right Bottom</label>
                                                  </div>
                                                </div>
                                                <div class="hr-line-dashed col-md-12"></div>
                                            </div> <!--Image-Position-->
                                            <div class="form-group no-margins" id="site_fp_elem__repeat">
                                              <label for="site_fp_repeat" class="control-label col-sm-2">BG Img Repeat</label>
                                              <div class="col-sm-10">
                                                <div class="checkbox checkbox-primary">
                                                  <input id="site_fp_repeat" name="site_fp_repeat" type="checkbox">
                                                  <label for="site_fp_repeat">
                                                      Do you want to repeat the image?
                                                  </label>
                                                </div>
                                              </div>
                                              <div class="hr-line-dashed col-md-12"></div>
                                            </div> <!--Image-Repeat-->
                                            <div class="form-group no-margins" id="site_fp_elem__scroll">
                                              <label for="site_fp_scroll" class="control-label col-sm-2">Scroll with Page</label>
                                              <div class="col-sm-10">
                                                <div class="checkbox checkbox-primary">
                                                  <input id="site_fp_scroll" name="site_fp_scroll" type="checkbox">
                                                  <label for="site_fp_scroll">
                                                      Enable Scroll Page?
                                                  </label>
                                                </div>
                                              </div>
                                              <div class="hr-line-dashed col-md-12"></div>
                                            </div> <!--Scroll-Page-->
                                            <div class="form-group no-margins" id="site_fp_elem__size">
                                              <label for="site_fp_size" class="control-label col-sm-2">Image size</label>
                                              <div class="col-sm-10">
                                                <select class="form-control" id="site_fp_size">
                                                  <option value="original">Original</option>
                                                  <option value="contain">Fit to screen</option>
                                                  <option value="cover">Fill screen</option>
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
                              <input type="text" name="site_fp_title" class="form-control" placeholder="Enter title here">
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-12">
                              <textarea class="form-control col-sm-12" name="site_fp_editor"></textarea>
                            </div>
                          </div>
                          <div class="hr-line-dashed"></div>
                        </div>
                      </div> <!--tab-site-front-->
                      <div id="site-footer" class="tab-pane ">
                        <div class="tt-body panel-body">
                          <div class="form-group">
                            <label for="site_fp_ft_copyright" class="control-label col-sm-2">Copyright Text: </label>
                            <div class="col-sm-10">
                              <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">&copy;</span>
                                <input type="text" id="site_fp_ft_copyright" name="site_fp_ft_copyright" class="form-control" placeholder="Copyright">
                              </div>
                            </div>
                          </div>
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <label for="site_fp_ft_target" class="control-label col-sm-2">Domain Target: </label>
                            <div class="col-sm-10">
                              <select class="form-control" name="site_fp_ft_target">
                                <option value="_blank">_blank</option>
                                <option value="_self">_self</option>
                              </select>
                            </div>
                          </div>
                          <div class="hr-line-dashed"></div>
                          <div class="form-group">
                            <label for="site_fp_ft_rel" class="control-label col-sm-2">Domain Rel: </label>
                            <div class="col-sm-10">
                              <select class="form-control" name="site_fp_ft_rel">
                                <option value="nofollow">NO Follow</option>
                                <option value="">Do Follow</option>
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
              <h5>Publish</h5>
            </div>
            <div class="ibox-content">
              <div class="form-group clearfix">
                <button class="btn btn-primary pull-right" id="theme_settings_btn" role="button">Publish</button>
              </div>
            </div>
          </div>
        </div> <!--col-3-->
      </div>
      <div class="modal modal-wide fade" tabindex="-1" role="dialog"  aria-hidden="true" id="Media">
        <div class="modal-dialog">
          <!--Modal Content-->
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
                            <form action="{{url( '/system/theme-settings' )}}" class="dropzone dz-clickable" id="dropzoneProfile"> 
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
                                                          <img id="{{$medias->id}}" src="{{asset('/img/gallery/'.$medias->media_name)}}" title="{{$medias->title_name}}" >
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
                                      <img src="{{asset('/img/gallery/'.$medias->media_name)}}">
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
                                          <input type="text" id="attach_url_{{$medias->id}}" name="attach_url" class="form-control" value="{{asset('/img/gallery/'.$medias->media_name)}}" disabled>
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