@extends('layouts.master')
@section('title', $site_identity->site_title.' | '.ucfirst(substr(Route::currentRouteName(),6)).' Pages')
@section('breadcrumb') 
   
            <h2><i class="fa fa-files-o"></i> Pages</h2>
            <ol class="breadcrumb">
                   <li>
                        <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <a href="/system/pages">Pages</a>
                   </li>
                    <li class="active">
                        <strong>{{ucfirst(substr(Route::currentRouteName(),6))}}</strong>
                    </li>
            </ol>

@endsection
@section('admin-content')
            <div class="wrapper wrapper-content clearfix">
                <div class="col-lg-12 "> @include('layouts.messages.messages') 
                            @if(count($errors))
                                   <div class="alert alert-danger">
                                       <strong>Whoops!</strong> There were some problems with your input.
                                       <br/>
                                       <ul>
                                           @foreach($errors->all() as $error)
                                           <li>{{ $error }}</li>
                                           @endforeach
                                       </ul>
                                   </div>
                               @endif
                </div>
                <div  class="col-lg-12 "> @yield('btn-AddNew') </div>
  
                        <div class="col-lg-9">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>{{ucfirst(substr(Route::currentRouteName(),6))}} Pages</h5>
                                </div>
                                <div class="ibox-content">
                                    <form id="formbanner" role="form">
                                        {{csrf_field()}}
                                        @section('editMethod')
                                        @show
                                        <div class="form-group {{ $errors->has('title_name') ? 'has-error' : '' }}">
                                            <label>Title</label>
                                            <input type="text" id='title_name' name='title_name' placeholder="Title" class="form-control" value="@yield('edittitle_name')" data-id="@yield('draftid')">
                                            @if($errors->has('title_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('title_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <input type="hidden" name="pages_t_id" id="pages_t_id" class="pages_t_id" value="">
                                        <input type="hidden" name="pages_parent_id" id="pages_parent_id" class="pages_parent_id" value="@yield('parent_id')">
                                        @yield('permalink')
                                        <div class="form-group">
                                            <label>Content</label>
                                            <textarea id='page_content' name='page_content' rows="5" placeholder="Description" class="form-control" >@yield('editdescription')</textarea>
                                        </div>  
                                    </form>
                                </div>
                            </div> <!---.ibox-->

                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>SEO</h5>
                                </div>
                                <div class="ibox-content">
                                    <form id="formSeobanner" role="form">
                                        <div class="form-group {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                                            <label>Meta Title</label>
                                            <input type="text" id='meta_title' name='meta_title' placeholder="Meta Title" class="form-control" value="@yield('editmeta_title')">
                                            @if($errors->has('meta_title'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('meta_title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('meta_desc') ? 'has-error' : '' }}">
                                            <label>Meta Description</label>
                                            <input type="text" id='meta_desc' name='meta_desc' placeholder="Meta Description" class="form-control" value="@yield('editmeta_desc')">
                                            @if($errors->has('meta_desc'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('meta_desc') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                            </div> <!---.ibox-->
                        </div> <!---.col-lg-9-->

                        <div class="col-lg-3">
                        
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Publish</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="form-group" id="pub-status">
                                        <span><i class="fa fa-key"></i></span> Status: @if(ucfirst(substr(Route::currentRouteName(),6)) =="Create")<span class="badge badge-warning"> Draft </span>  @else @yield('status_info') @endif
                                    </div>
                                    @yield('revision')
                                    <div class="form-group" id="pub-date">
                                        <span><i class="fa fa-calendar-o"></i></span> Date: <strong>@if(ucfirst(substr(Route::currentRouteName(),6)) =="Create") Immediate Publish @else @yield('date_create') @endif</strong>
                                    </div>
                                </div>
                                <div class="ibox-content ibox-heading">
                                    <div class="clearfix">
                                        <input type="hidden" id="pageid" name="pageid" value="@yield('pageid')">
                                        @yield('movetrash')
                                        <button class="btn btn-w-m btn-success pull-right" type="button" id="Saves"><strong> @if(ucfirst(substr(Route::currentRouteName(),6)) =="Create") Save @else Save Changes @endif</strong></button>
                                    </div>
                                </div> <!---.box-content .ibox-heading-->
                            </div> <!---.box .float-e-margins-->
                            
                            @if(Auth::user()->status_id != '4' )

                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Category</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="form-group">
                                        <label>Merchant</label>    
                                        <select class="form-control m-b" id="merchantname" name="merchantname" @if( @$page->merchants_id !='') disabled @endif >
                                            <option value="">--- Select Merchant ---</option>
                                            @foreach ($merchantlist as $merchants)  
                                                <option value="{{$merchants->merchant_name }}" class="text-center" @if(old('merchantname', $merchants->id) == @$page->merchants_id) selected="selected" @endif> {{str_replace("http://", "",$merchants->merchant_name)}} </option>
                                            @endforeach
                                        </select> 
                                        <div class="lngchoice">
                                        <label>Language</label>
                                             @php
                                              if(ucfirst(substr(Route::currentRouteName(),6)) =="Create"){ $langid = '1'; }else{ $langid= @$page->lang_id; } 
                                             @endphp
                                        <select class="form-control m-b" id="langname" name="langname" onchange="countrylang(this);"  @if(ucfirst(substr(Route::currentRouteName(),6)) =="Create") disabled @endif>
                                            <option value="">--- Select Language ---</option>
                                            @foreach ($lang as $langs)  
                                                <option value="{{$langs->id }}" class="text-center" @if(old('merchantname', $langs->id) == @$langid) selected="selected" @endif > {{ $langs->name}} </option>
                                            @endforeach
                                        </select> 
                                        </div>
                                    </div>
                                </div>
                               
                            </div> <!---.box .float-e-margins-->

                            @endif

                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Featured Image</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="form-group">
                                           <div id="img-box" class="slider-cre8-img media-img-box {{ $errors->has('media_id') ? 'has-error' : '' }}">
                                            <h1 class="img-select-text text-center @if(ucfirst(substr(Route::currentRouteName(),6)) == "Create")  @endif"><button type="button" id="sfi" class="btn btn-link text-info" data-toggle="modal" data-target="#Media">Set Featured Images</button></h1>                                            
                                            <input type="hidden" name="media_id" id="media_id" class="image-data" value="@yield('editmedia_id')">
                                            @if(ucfirst(substr(Route::currentRouteName(),6)) =="Create")
                                                <button type="button" class="btn btn-link text-info" data-toggle="modal" data-target="#Media">
                                                    <img id="preview_images" src="@if(old('preview_images') =='')   @else {{ old('preview_images') }} @endif" class="img-responsive" style="margin: auto;">
                                                 </button>
                                            @else
                                                @yield('editmedia_thumbnail')
                                            @endif
                                        </div>
                                         @if($errors->has('media_id'))
                                                <span class="help-block">
                                                    <strong class="text-danger">{{ $errors->first('media_id') }}</strong>
                                                </span>
                                        @endif
                                        <div class="col-lg-12 img-error sr-only"> 
                                            <div class="alert alert-warning">
                                                    Please use Standard Banner Size 150x150.
                                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                            </div>
                                        </div>  
                                        <button type="button" class="btn btn-link text-danger @if(ucfirst(substr(Route::currentRouteName(),6)) =="Create") sr-only @endif" id="remove_set_img">Remove Images</button> 
                                    </div>
                                </div>
                               
                            </div> <!---.box .float-e-margins-->
                        </div> <!---.col-lg-3-->
            </div> <!---.wrapper-->

    <div class="modal modal-wide fade" id="Media" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <!--Modal Content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Featured Image</h3>
                </div>
                <div class="modal-body" >
                    <div class="container-fluid" id="attach_body">
                        <div class="row">
                            <ul class="nav nav-tabs">
                                <li><a data-toggle="tab" href="#uploads">Upload Files</a></li>
                                <li class="active"><a data-toggle="tab" href="#media_library">Media Library</a></li>
                            </ul>
                            <div class="col-md-10 media-attachment">
                                <div class="tab-content">
                                    <div id="uploads" class="tab-pane">
                                        File Uploads
                                        <div class="dropimg" >
                                        <div class="uploader-inline">
                                        <form action="{{url( '/system/media' )}}" class="dropzone dz-clickable" id="dropzoneForm">    
                                                <div class="dz-default dz-message">
                                                    <span><strong>Images files here or click to upload. </strong></br> (Maximum Filesize is 2mb)</span>
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
                                                                        <img id="{{$medias->id}}" src="{{$medias->merchant_name.'/img/gallery/'.$medias->media_thumbnail}}" title="{{$medias->title_name}}" >
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
                                                            <img src="{{$medias->merchant_name.'/img/gallery/'.$medias->media_thumbnail}}">
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
                </div>
                <div class="modal-footer">
                    <button type="button" id="InsertPhoto" class="btn btn-primary" data-id="" data-dismiss="modal" style="display: none">Insert Images</button>
                    <button type="button" id="selectbannerimg" class="btn btn-primary" data-method="featured_image" data-dismiss="modal">Set featured image</button>
                </div>
            </div>
        </div>
    </div>

@endsection