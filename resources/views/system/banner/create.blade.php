@extends('layouts.master')

@section('title', $site_identity->site_title.' | '.ucfirst(substr(Route::currentRouteName(),7)).' Banner ')

@section('breadcrumb')
   
            <h2><i class="fa fa-picture-o"></i> Banner</h2>
            <ol class="breadcrumb">
                   <li>
                        <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <a href="/system/banner">Banner</a>
                   </li>
                    <li class="active">
                        <strong>{{ucfirst(substr(Route::currentRouteName(),7))}}</strong>
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
                <div class="col-lg-12 animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>{{ucfirst(substr(Route::currentRouteName(),7))}} Banner</h5>
                                </div>
                                <div class="ibox-content">
                                    <p><span><strong>Note:</strong></span> <i>Please Fill the Required Fields</i> <strong class="text-danger"> (*)</strong> </span></p>
                                    <div class="hr-line-dashed"></div>
                                    <form id="formbanner" role="form" class="form-horizontal">
                                        {{csrf_field()}}
                                         <input type="hidden" name="pages_parent_id" id="pages_parent_id" class="pages_parent_id" value="@yield('parent_id')">
                                        @section('editMethod')
                                        @show
                                        <div class="form-group">
                                            <div class="media-detail">
                                                <h4>Select Images</h4>
                                                <ul class="media-list">
                                                    <li class="media-item"><i class="fa fa-asterisk"></i>Banner standard size is 150x150</li>
                                                </ul>
                                            </div>
                                            
                                            <div id="img-box" class="slider-cre8-img media-img-box {{ $errors->has('cseo_media_id') ? 'has-error' : '' }}">
                                                <h1 class="img-select-text text-center @if(ucfirst(substr(Route::currentRouteName(),7)) =="Edit") sr-only @endif">150x150</h1>
                                                <input type="hidden" name="media_id" id="media_id" class="image-data" value="@yield('editmedia_id')">
                                                @if(ucfirst(substr(Route::currentRouteName(),7)) =="Create")
                                                    <img id="preview_images" src="@if(old('preview_images') =='')   @else {{ old('preview_images') }} @endif" class="img-responsive" style="margin: auto;">
                                                @else
                                                    @yield('editmedia_thumbnail')
                                                @endif
                                            </div>

                                             @if($errors->has('cseo_media_id'))
                                                    <span class="help-block">
                                                        <strong class="text-danger">{{ $errors->first('cseo_media_id') }}</strong>
                                                    </span>
                                            @endif

                                            <div class="col-lg-12 img-error sr-only"> 
                                                <div class="alert alert-warning">
                                                        Please use Standard Banner Size 150x150.
                                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                                </div>
                                            </div>  

                                            <button type="button" class="btn btn-outline btn-info" data-toggle="modal" data-target="#Media">Choose Image</button>
                                            <button type="button" class="btn btn-outline btn-danger @if(ucfirst(substr(Route::currentRouteName(),7)) =="Create") sr-only @endif" id="remove_set_img">Remove Images</button> 
                                        </div>
                                        <div class="form-group {{ $errors->has('title_name') ? 'has-error' : '' }}">
                                            <label>Title<strong class="text-danger"> *</strong></label>
                                            <input type="text" id='title_name' name='title_name' placeholder="Title" class="form-control" value="@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){{old('title_name')}}@else @yield('edittitle_name') @endif">
                                            @if($errors->has('title_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('title_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group {{ $errors->has('target_url') ? 'has-error' : '' }}">
                                            <label>Target URL<strong class="text-danger"> *</strong></label>
                                            <input type="text" id='target_url' name='target_url' placeholder="Title" class="form-control" value="@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){{old('target_url') }}@else @yield('edittarget_url')@endif">
                                            @if($errors->has('target_url'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('target_url') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('title_b_name') ? 'has-error' : '' }}">
                                            <label>Title Banner<strong class="text-danger"> *</strong></label>
                                            <input type="text" id='title_b_name' name='title_b_name' placeholder="Title Banner" class="form-control" value="@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){{old('title_b_name')}}@else @yield('edittitle_b_name')@endif">
                                            @if($errors->has('title_b_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('title_b_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group {{ $errors->has('alt_text') ? 'has-error' : '' }}">
                                            <label>Alt Text<strong class="text-danger"> *</strong></label>
                                            <input type="text" id='alt_text' name='alt_text' placeholder="Alt Text" class="form-control" value="@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){{old('alt_text')}}@else @yield('editalt_text')@endif">
                                            @if($errors->has('alt_text'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('alt_text') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea id='description' name='description' rows="5" placeholder="Description" class="form-control" >@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){{old('Description')}}@else @yield('editdescription')@endif</textarea>
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
                                        <span><i class="fa fa-key"></i></span> Status: @if(ucfirst(substr(Route::currentRouteName(),7)) =="Create")<span class="badge badge-warning"> Draft </span>  @else @yield('status_info') @endif
                                    </div>
                                    @yield('revision')
                                    <div class="form-group" id="pub-date">
                                        <span><i class="fa fa-calendar-o"></i></span> Date: <strong>@if(ucfirst(substr(Route::currentRouteName(),7)) =="Create") Immediate Publish @else @yield('date_create') @endif</strong>
                                    </div>
                                </div>
                                <div class="ibox-content ibox-heading">
                                    <div class="clearfix">
                                        <input type="hidden" id="bannerid" name="bannerid" value="@yield('bannerid')">
                                        @yield('movetrash')
                                        <button class="btn btn-w-m btn-success pull-right" type="button" id="Saves"><strong> @if(ucfirst(substr(Route::currentRouteName(),7)) =="Create") Save @else Save Changes @endif</strong></button>
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
                                        <select class="form-control m-b" id="merchantname" name="merchantname" @if( @$banner->merchants_id !='') disabled @endif  >
                                            <option value="">--- Select Merchant ---</option>
                                            @foreach ($merchantlist as $merchants)  
                                                <option value="{{$merchants->merchant_name }}" class="text-center" @if(old('merchantname', $merchants->id) == @$banner->merchants_id) selected="selected" @endif> {{str_replace("http://", "",$merchants->merchant_name)}} </option>
                                            @endforeach
                                        </select> 
                                        <div class="lngchoice">
                                        <label>Language</label>    
                                        @php
                                         if(ucfirst(substr(Route::currentRouteName(),7)) =="Create"){ $langid = '1'; }else{ $langid= @$banner->lang_id; } 
                                        @endphp
                                        <select class="form-control m-b" id="langname" name="langname" onchange="countrylang(this);" @if(ucfirst(substr(Route::currentRouteName(),7)) =="Create") disabled @endif>
                                            <option value="">--- Select Language ---</option>
                                            @foreach ($lang as $langs)  
                                                <option value="{{$langs->id }}" class="text-center" @if(old('merchantname', $langs->id) == @$langid) selected="selected" @endif> {{ $langs->name}} </option>
                                            @endforeach
                                        </select> 
                                        </div>
                                    </div>
                                </div>
                               
                            </div> <!---.box .float-e-margins-->

                            @endif

                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Category</h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="form-group">
                                        <select class="form-control m-b" id="cagetory" name="cagetory"  >
                                            <option value="1">--- Select Category ---</option>
                                            @foreach ($category as $categories)  
                                                <option value="{{$categories->id }}" class="text-center" @if(old('cagetory', $categories->id) == @$banner->cseo_categories_id) selected="selected" @endif> {{$categories->category_name }} </option>
                                            @endforeach
                                       

                                        </select> 
                                    </div>
                                </div>
                            </div> <!---.box .float-e-margins-->
                        </div> <!---.col-lg-3-->
                    </div> <!---.row-->
                </div> <!---.col-lg-12-->
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
                                                                        <img id="{{$medias->id}}" src="{{'/img/gallery/'.$medias->media_name}}" title="{{$medias->title_name}}" >
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
                                                            <img src="{{'/img/gallery/'.$medias->media_name}}">
                                                        </div>
                                                        <div class="attach-details">
                                                        <p class="attach-filename">{{ucfirst($medias->title_name)}}</p>
                                                        <p class="attach-date">{{$medias->created_at->format('M d, Y')}}</p>
                                                        <?php $bytes = $medias->file_size;           
                                                         $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
                                                         for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
                                                         $media_unit = round( $bytes, 2 ) . " " . $label[$i]; ?>
                                                        <p class="attach-size">{{ $media_unit }}</p>
                                                        <div class="attach-btn-wrap">
                                                        <a class="btn btn-link text-danger" id="delete_img" data-id="{{$medias->id}}"><i class="fa fa-trash"></i> Delete</a>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div tabindex="0" id="attachment_id_{{$medias->id}}" class="attach-form" data-attachment_id="{{$medias->id}}">
                                                            <div class="form-group">
                                                                <label>URL</label>
                                                                <input type="text" id="attach_url_{{$medias->id}}" name="attach_url" class="form-control" value="{{'/img/gallery/'.$medias->media_name}}" disabled>
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
                    <button type="button" id="selectbannerimg" class="btn btn-primary" data-method="featured_image" data-dismiss="modal">Set featured image</button>
                </div>
            </div>
        </div>
    </div>

@endsection