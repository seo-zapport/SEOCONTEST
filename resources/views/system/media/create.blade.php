@extends('layouts.master')
@section('title', $site_identity->site_title.' | Media')
@section('breadcrumb')
            <h2><i class="fa fa-picture-o"></i> Media</h2>
            <ol class="breadcrumb">
                   <li>
                       <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li >
                          <a href="/media">Media</a>
                   </li>
                   <li class="active">
                      <strong>{{-- {{ucfirst(substr(Route::currentRouteName(),6))}} --}}New Images</strong>
                  </li>
            </ol>
@endsection
@section('admin-content')
  <div class="wrapper wrapper-content clearfix">
    <div class="ibox">
      <div class="ibox-title">
        <h5>Upload Images</h5>
      </div>
      <div class="tabs-container ibox-content">
        <form action="{{url( '/system/media' )}}" class="dropzone dz-clickable" id="dropzoneFormCreate">    
                <div class="dz-default dz-message">
                    <span><strong>Images files here or click to upload. </strong></br> (Maximum Filesize is 2mb)</span>
                </div>
            {{ csrf_field() }}
        </form> 
      </div>
    </div>
  </div>
@endsection