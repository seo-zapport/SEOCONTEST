@extends('layouts.master')
@section('title', $site_identity->site_title.' | Media')
@section('breadcrumb')
            <h2><i class="fa fa-picture-o"></i> Media</h2>
            <ol class="breadcrumb">
                   <li>
                      <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <strong>Media</strong>
                   </li>
            </ol>
@endsection

@section('admin-content')
<div class="wrapper wrapper-content clearfix">
    <div class="row">
        <div class="col-md-3">
            <div class="ibox float-e-margins" style="margin-top: 10px;">
                <div class="ibox-content">
                    <div class="file-manager">
                        <h5>Search</h5>
                        <form role="form" class="form-horizontal"  method="get" >
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search media Items">
                        </form> 
                        <div class="hr-line-dashed"></div>
                        <h5>Upload Images</h5>
                        <button id="addnew" class="btn btn-sm btn-primary btn-block"> Add New</button>
                        <div class="dropimg" style="display: none;">
                            <div class="uploader-inline">
                                <form action="{{url( '/system/media' )}}" class="dropzone dz-clickable" id="dropzoneForm">    
                                    <button id="dropclose" class="close dashicons dashicons-no" type="button"><i class="fa fa-times-circle"></i><span class="screen-reader-text">Close uploader</span></button>
                                    <div class="dz-default dz-message">
                                        <span><strong>Drag and drop images here or click to upload. </strong></br> (Maximum Filesize is 2Mb)</span>
                                    </div>
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>  <!--.dropimg-->
                        <div class="media-detail">
                            <h5>Notes</h5>
                            <ul class="media-list">
                                <li class="media-item"><i class="fa fa-asterisk"></i>File Size Must Be 2Mb</li>
                                <li class="media-item"><i class="fa fa-asterisk"></i>Must Be An Image File</li>
                               
                            </ul>
                        </div>
                    </div> <!--.file-manager-->
                </div>
            </div>
        </div>
        <div class="col-md-9 animated fadeInRight">
            <div id="media_library" class="tab-pane active" data-media_method="details">
                <ul class="attachment-list">
                    @if(count($media_img)>0)
                        @foreach ($media_img as $medias)
                            <li class="attachment-group-list media-list">
                                <a href="#" title="{{$medias->title_name}}" data-hover="tooltip" data-placement="top"  data-toggle="modal" id="modal-edit" data-target="#modal-medias-{{$medias->id}}" data-id="{{$medias->id}}">
                                    <div class="attachment-prev landscape">
                                        <div class="thumbnails lightBoxGallery">
                                            <div class="centered">
                                                <img id="{{$medias->id}}" src="{{ $medias->merchant_name.'/img/gallery/'.$medias->media_thumbnail}}" title="{{$medias->title_name}}">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    @else
                        <h2 class="text-center p-lg">No Record Found</h2> 
                        <div class="text-center"><a href="{{ url( '/system/media' ) }}" class="btn btn-w-m btn-warning">Show Images</a></div>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<div id="modal-images">
     @if(count($media_img)>0)
            @foreach ($media_img as $medias)
                <div class="modal modal-wide fade" id="modal-medias-{{$medias->id}}" tabindex="-1" role="dialog"  aria-hidden="true">
                    <input type="hidden" id="edit_id">
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
                                        <div class="col-md-10 media-attachment">
                                            <div class="attachment-media-view">
                                                <div class="thumbnail-image"><img class="details-image" src="{{$medias->merchant_name.'/img/gallery/'.$medias->media_name}}" ></div>
                                            </div> 
                                        </div>
                                        <div class="col-md-2 media-sidebar">
                                            <div class="details-info">
                                                <h4 class="attach-title">ATTACHMENT DETAILS</h4>
                                                <div class="attachment-info">
                                                    <div class="attach-details">
                                                    <p class="attach-filename">{{ucfirst($medias->title_name)}}</p>
                                                    <p class="attach-date">{{$medias->created_at->format('M d, Y')}}</p>
                                                    @php
                                                        $bytes = $medias->file_size;
                                                        $label = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
                                                        for( $i = 0; $bytes >= 1024 && $i < ( count( $label ) -1 ); $bytes /= 1024, $i++ );
                                                        $media_unit = round( $bytes, 2 ) . " " . $label[$i];
                                                    @endphp
                                                    <p class="attach-size">{{ $media_unit }}</p>
                                                    <div class="attach-btn-wrap">
                                                    <a class="btn btn-link text-danger" id="delete_img" name="delete_img_{{$medias->id}}" data-id="{{$medias->id}}"><i class="fa fa-trash"></i> Delete</a>
                                                </div>
                                                    </div>
                                                </div>
                                                <div tabindex="0" id="attachment_id_{{$medias->id}}" class="attach-form" data-attachment_id="{{$medias->id}}">
                                                    <div class="form-group">
                                                        <label>URL</label>
                                                        <input type="text" id="attach_url_{{$medias->id}}" name="attach_url" class="form-control" value="{{ $medias->merchant_name.'/img/gallery/'.$medias->media_name}}" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Title</label>
                                                        <input type="text" id="attach_title_{{$medias->id}}" name="attach_title" class="form-control" value="{{$medias->title_name}}" data-id="{{$medias->id}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Caption</label>
                                                        <textarea class="form-control" id="attach_caption_{{$medias->id}}" name="attach_caption" data-id="{{$medias->id}}">{{$medias->caption_text}}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Alt Text</label>
                                                        <input type="text" id="attach_alt_text_{{$medias->id}}" name="attach_alt_text" class="form-control" value="{{$medias->alt_text}}" data-id="{{$medias->id}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Description</label>
                                                        <textarea class="form-control" id="attach_desc_{{$medias->id}}" name="attach_desc" data-id="{{$medias->id}}">{{$medias->description}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer"></div>
                        </div>
                    </div>
                </div>
            @endforeach
     @endif
</div>
@endsection



                        