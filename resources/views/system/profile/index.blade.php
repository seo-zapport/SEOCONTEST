@extends('layouts.master')
@section('title', $site_identity->site_title.' | Profile')
@section('breadcrumb')
   
            <h2><i class="fa fa-user"></i> Profile</h2>
            <ol class="breadcrumb">
                   <li>
                       <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <strong>Profile</strong>
                   </li>
            </ol>

@endsection

@section('admin-content')


<div class="container-fluid">
    <div class="row">
        <div class="wrapper wrapper-content clearfix profile-wrapper">        
            <div class="col-md-2 text-center">
                <div class="profile-block">
                    <div class="panel profile-photo profile-img-prev">
                        <input type="hidden" name="media_id" id="media_id" class="image-data" value="{{$profile->cseo_media_id}}"> 
                        <img id="preview_images" alt="image" class="image img-circle" src="@if(!empty($profile->media_name)) /img/accounts/{{$profile->media_name}} @else /img/accounts/profile-default.png @endif">
                        <div class="middle">
                            <div class="browse"><a  data-toggle="modal" data-target="#Media"><i class="fa fa-file-image-o"></i></a></div>
                        </div>
                    </div>
                    <div class="profile-info-wrap">
                        <h1 class="profile-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
                        <p class="font-bold">{{ $profile->status_name }}</p>
                    </div>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="profile-contacts">
                    <h5>Contacts</h5>
                    <ul class="list-group clear-list m-t">
                        <li class="list-group-item fist-item post-count">
                            <i class="fa fa-envelope-o fa-lg"></i> <a href="mailto:{{ $profile->email }}">{{ $profile->email }}</a>
                        </li>
                       @if(!empty($profile->skype_id))
                        <li class="list-group-item fist-item post-count">
                            <i class="fa fa-skype fa-lg"></i> <a href="mailto:{{ $profile->skype_id }}">{{ $profile->skype_id }}</a>
                        </li>
                       @endif
                       @if(!empty($profile->mobile_no))
                        <li class="list-group-item page-count">
                            <i class="fa fa-mobile fa-lg"></i> {{ $profile->mobile_no }}
                        </li>
                       @endif 
                    </ul>
                </div>
            </div>
            <div class="col-md-7">
                <h2>Profile</h2>
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#tab-1" >Info</a></li>
                        <li class=""><a data-toggle="tab" href="#tab-2" >Change Password</a></li>
                    </ul>
                    <div class="tab-content">
                        <input type="hidden" id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" id="action" name="action" value="Info">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <form role="form" class="form-horizontal">
                                    <h3>Personal Info</h3>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label for="first_name" class="col-md-2 control-label">First Name</label>
                                        <div class="col-md-10">
                                            <input name="first_name" type="text" class="form-control" id="first_name"  value="{{ old('first_name')=='' ? Auth::user()->first_name : old('first_name') }}" required autofocus>
                                            @if ($errors->has('first_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label for="last_name" class="col-md-2 control-label">Last Name</label>

                                        <div class="col-md-10">
                                            <input id="last_name" type="text" class="form-control"  name="last_name" value="{{ old('last_name')=='' ? Auth::user()->last_name : old('last_name') }}" required autofocus>

                                            @if ($errors->has('last_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('display_name') ? ' has-error' : '' }}">
                                        <label for="display_name" class="col-md-2 control-label">Display Name</label>

                                        <div class="col-md-10">
                                            <input id="display_name" type="text" class="form-control" name="display_name" value="{{ old('display_name')=='' ? Auth::user()->display_name : old('display_name') }}" required autofocus>

                                            @if ($errors->has('display_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('display_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('position') ? ' has-error' : '' }}">
                                        <label for="position" class="col-md-2 control-label">Position</label>

                                        <div class="col-md-10">
                                            <input id="position" type="text" class="form-control" name="position" value="{{ old('position')=='' ? Auth::user()->position : old('position') }}" required autofocus>

                                            @if ($errors->has('position'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('position') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <h3>Contact Info</h3>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-2 control-label">E-Mail Address</label>

                                        <div class="col-md-10">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email')=='' ? Auth::user()->email : old('email') }}" disabled>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('skype_id') ? ' has-error' : '' }}">
                                        <label for="skype_id" class="col-md-2 control-label">Skype Id</label>

                                        <div class="col-md-10">
                                            <input id="skype_id" type="text" class="form-control" name="skype_id" value="{{ old('skype_id')=='' ? Auth::user()->skype_id : old('skype_id') }}" required autofocus>

                                            @if ($errors->has('skype_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('skype_id') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                                        <label for="mobile_no" class="col-md-2 control-label">Mobile No.</label>

                                        <div class="col-md-10">
                                            <input id="mobile_no" type="text" class="form-control"  name="mobile_no" onkeypress="return isNumberKey(event)" value="{{ old('mobile_no')=='' ? Auth::user()->mobile_no : old('mobile_no') }}" required>

                                            @if ($errors->has('mobile_no'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('mobile_no') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="button" id="BtnSaveProfile" class="btn btn-block btn-primary">
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <form role="form" class="form-horizontal">
                                    {{csrf_field()}}
                                    <h3>Change Password</h3>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                       <label for="password" class="col-md-2 control-label">Password</label>

                                       <div class="col-md-10">
                                           <input id="password" type="password" class="form-control" name="password" required>

                                           @if ($errors->has('password'))
                                               <span class="help-block">
                                                   <strong>{{ $errors->first('password') }}</strong>
                                               </span>
                                           @endif
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="password-confirm" class="col-md-2 control-label">Confirm Password</label>
                                       <div class="col-md-10">
                                           <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                       </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <button type="button" id="BtnSavePassword" class="btn btn-block btn-primary">
                                                Change Password
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                                    <form action="{{url( '/system/profile' )}}" class="dropzone dz-clickable" id="dropzoneProfile">    
                                       
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
                                                                    <img id="{{$medias->id}}" src="{{asset('/img/accounts/'.$medias->media_name)}}" title="{{$medias->title_name}}" >
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
                                                        <img src="{{asset('/img/accounts/'.$medias->media_name)}}">
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
                                                            <input type="text" id="attach_url_{{$medias->id}}" name="attach_url" class="form-control" value="{{asset('/img/accounts/'.$medias->media_name)}}" disabled>
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