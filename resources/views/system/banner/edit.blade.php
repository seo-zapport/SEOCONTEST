@extends('system.banner.create')

@section('editid', $banner->id)

@section('editmedia_id', $banner->cseo_media_id)

@section('editmedia_thumbnail')

	@if(is_null($banner->media_name))
		  <img id="preview_images" src="http://via.placeholder.com/1000x200" >
	@else
      <img id="preview_images" src="{{'/img/gallery/'.$banner->media_name}}" style="display: block;margin:auto;">
	@endif

@endsection

@section('slider_cat_id', $banner->slider_categories_id)

@section('editselect_cat_id')
	@foreach ($category as $categories)	
 		 @if(old('cagetory', $categories->id) == $banner->slider_categories_id) selected="selected" @endif 
 	@endforeach	 
@endsection

@section('edittitle_name', $banner->title_name)
@section('edittarget_url', $banner->target_url)
@section('edittitle_b_name', $banner->title_banner)
@section('editalt_text', $banner->alt_text_banner)
@section('editdescription', $banner->description)
@section('parent_id', $banner->parent_id)

@section('bannerid', $banner->id)

@section('editMethod')
    {{method_field('PUT')}}
@endsection

@section('btn-AddNew')
        <a href="{{'/system/banner/create'}}" class="btn btn-sm btn-primary" style="margin-bottom: 15px;"><i class="fa fa-plus"></i> Add New</a>
@endsection

@section('status_info')
		@if($banner->status_id == "9")	
       		<span class="badge badge-primary"> Published </span> 
       	@else	
       		<span class="badge badge-warning"> Unpublished </span> 
       	@endif	
       	
       	<button type="button" class="btn btn-link  text-success" id="editstatus">Edit</button>
      
       	<div class="updated_status sr-only">
       	   <hr> 
            <form role="form" class="form-horizontal col-lg-12" method="post"> 
                {{csrf_field()}}         
                <div class="form-group">
    
                <div class="input-group">
    
                    <select class="form-control m-b" id="bulkActionStatus" name="bulkActionStatus" required autofocus>
                        <option value="9"   @if($banner->status_id == "9") selected="selected" @endif> Published </option>
                        <option value="10"  @if($banner->status_id == "10") selected="selected" @endif> Unpublished </option>    
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
		<strong>{{ $banner->rev_count }}</strong>  
	</div>
@endsection

@section('date_create', $banner->created_at->format('M d, Y @ H:i') )

@section('movetrash')
        <button class="btn btn-w-m btn-link pull-left text-danger btn-movetrashban"><i class="fa fa-trash"></i> Delete </button>
@endsection

