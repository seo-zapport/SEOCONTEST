@extends('layouts.master')
@section('title', $site_identity->site_title.' | General Settings')

@section('breadcrumb')
	<h2><i class="fa fa-bars"></i> General Settings</h2>
	<ol class="breadcrumb">
	       <li>
	          <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
	       </li>
	      <li><a href="{{ url('/system/settings-general') }}">Settings</a></li>
	      <li>
	      	<strong>General Settings</strong>
	      </li>
	</ol>
@endsection
@section('admin-content')
	<div class="wrapper wrapper-content row">
		<form class="form-horizontal" >
			{{ csrf_field() }}
			@php
				if( old('site_title', @$site_identity->site_title) === @$site_identity->site_title )
				{ $val_title = @$site_identity->site_title; }
				else{ $val_title = old('site_title'); }
				
				if( old('site_tag_line', @$site_identity->site_tag_line) === @$site_identity->site_tag_line )
				{ $val_tags = @$site_identity->site_tag_line; }
				else{ $val_tags = old('site_tag_line'); }
			@endphp
			<div class="col-md-9">
				<div class="ibox">
					<div class="ibox-title">
						<h5>General Settings</h5>
					</div>
					<div class="ibox-content">
						<div id="box-alert"></div>
						<div id="errors-title-wrap" class="form-group {{ $errors->has('site_title') ? 'has-error' : '' }}">
							<label class="control-label col-sm-2" for="site_title">Site Title:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="site_title" id="site_title" value="{{ $val_title }}" placeholder="Enter Site Title">
								<span id="site_title_error" class="text-danger"></span>
							</div>
						</div>
						<div class="form-group {{ $errors->has('site_tag_line') ? 'has-error' : '' }}">
							<label class="control-label col-sm-2" for="site_tag_line">Tag line:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="site_tag_line" id="site_tag_line" value="{{ $val_tags }}" placeholder="Enter Tag line">
							</div>
						</div>
                        <div class="form-group clearfix">
                        	<label class="control-label col-sm-2" for="site_display_assets">&nbsp;</label>
							<div class="col-sm-10 checkbox">
								<label><input type="checkbox" name="site_display_assets" {{ ( @$site_identity->site_display_assets === 'true' ) ? 'checked' : '' }} >Display Site Title and Tagline</label>
							</div>
                        </div><!--Enable-->
						<div class="form-group {{ $errors->has('site_url') ? 'has-error' : '' }}">
							<label class="control-label col-sm-2" for="site_url">Site Address (URL):</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="site_url" id="site_url" value="{{ URL::to('/') }}" disabled>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-10 pull-right">
								@php
									if ( count( @$site_identity )  > 0 ) {
										$btn_name = 'btn_update';
										$btn_value = 'Update';
									}else{
										$btn_name = 'btn_save';
										$btn_value = 'Publish';
									}
								@endphp
								<input role="button" id="btn_general_action" type="button" name="{{ $btn_name }}" value="{{ $btn_value }}" class="btn btn-success pull-right">
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection