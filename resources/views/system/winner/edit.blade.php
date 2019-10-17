@extends('system.winner.create')

@section('winnerid', $winrecord->wins_id)
@section('editname', $winrecord->name)
@section('editurl_win', $winrecord->url_win)
@section('editpop', $winrecord->pop)
@section('editplace', $winrecord->win_place)

@section('winrecordid', $winrecord->id)

@section('editMethod')
    {{method_field('PUT')}}
@endsection

@section('btn-AddNew')
        <a href="{{'/system/winner/create'}}" class="btn btn-sm btn-primary" style="margin-bottom: 15px;"><i class="fa fa-plus"></i> Add New</a>
@endsection

@section('status_info')
		@if($winrecord->status_id == "9")	
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
                        <option value="9"   @if($winrecord->status_id == "9") selected="selected" @endif> Published </option>
                        <option value="10"  @if($winrecord->status_id == "10") selected="selected" @endif> Unpublished </option>    
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
	{{-- <div class="form-group">
		<span><i class="fa fa-refresh"></i> Revisions </span>
		<strong>{{ $winrecord->rev_count }}</strong>  
	</div> --}}
@endsection

@section('date_create', $winrecord->created_at->format('M d, Y @ H:i') )

@section('movetrash')
        <button class="btn btn-w-m btn-link pull-left text-danger btn-movetrashwin"><i class="fa fa-trash"></i> Delete </button>
@endsection

