@extends('system.pages.create')

@section('editid', $page->id)

@section('editmedia_id', $page->cseo_media_id)

@section('editmedia_thumbnail')
	@if(is_null($page->media_name) || is_null($page->media_thumbnail))
		  <img id="preview_images" src="http://via.placeholder.com/1000x200" >
	@else
		  <img id="preview_images" src="{{$page->merchant_name.'/img/gallery/'.$page->media_thumbnail}}" style="display: block;margin:auto;">
	@endif
@endsection



@section('edittitle_name', $page->page_title)
@section('editdescription', $page->page_content)
@section('editmeta_title', $page->meta_title)
@section('editmeta_desc', preg_replace("/<.*?>/", " ", $page->meta_description))
@section('editmeta_keyword', $page->meta_keyword)
@section('parent_id', $page->parent_id)

@section('pageid', $page->id)
@section('draftid', $page->id)  

@section('permalink')
<label><strong>Permalink: </strong></label> <a href="{{str_replace(\Request::path(),"",$page->merchant_name)}}/{{ str_replace("/","",$page->url_path) }}" target="_blank" title="view">{{str_replace(\Request::path(),"",$page->merchant_name)}}/{{ str_replace("/","",$page->url_path) }}</a>
@endsection

@section('editMethod')
    {{method_field('PUT')}}
@endsection

@section('btn-AddNew')
        <a href="{{'/system/pages/create'}}" class="btn btn-sm btn-primary" style="margin-bottom: 15px;"><i class="fa fa-plus"></i> Add New</a>
@endsection

@section('status_info')
		    @if($page->status_id == "9")	
       		<span class="badge badge-primary"> Published </span> 
       	@else	
       		<span class="badge badge-warning"> Draft </span> 
       	@endif	
       	
       	<button type="button" class="btn btn-link  text-success" id="editstatus">Edit</button>
      
       	<div class="updated_status sr-only">
       	   <hr> 
            <form role="form" class="form-horizontal col-lg-12" method="post"> 
                {{csrf_field()}}         
                <div class="form-group">
                    <div class="input-group">
        
                        <select class="form-control m-b" id="bulkActionStatus" name="bulkActionStatus" required autofocus>
                            <option value="9"   @if($page->status_id == "9") selected="selected" @endif> Published </option>
                            <option value="12"  @if($page->status_id == "12") selected="selected" @endif> Draft </option>    
                        </select>
                        <div class="input-group-btn">
                            <button id="btn-bulkActionstat" type="button" class="btn btn-m btn-success btn-bulkActionstat">OK</button>
                            <button type="button" class="btn btn-link  text-success" id="canceleditstat">cancel</button> 
                        </div>
                    </div>
            </div>
        </form> 
       	</div>
@endsection

@section('revision')
	<div class="form-group">
		<span><i class="fa fa-refresh"></i> Revisions </span>
		<strong>{{ $page->rev_count }}</strong>  
    @if($page->rev_count != "0")
      <a href="{{'/system/pages/'.$page->id}}">Browse</a>
    @endif
	</div>
@endsection

@section('date_create', $page->created_at->format('M d, Y @ H:i') )

@section('movetrash')
        <button class="btn btn-w-m btn-link pull-left text-danger btn-delPages"><i class="fa fa-trash"></i> Delete </button>
@endsection

