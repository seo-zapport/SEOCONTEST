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
                <strong>Theme Settings</strong>
            </li>
     </ol>
@endsection
@section('admin-content')
	<div class="wrapper wrapper-content clearfix">
		<div id="alert_box" class="col-lg-12 ">  @include('layouts.messages.messages') </div>
		<div class="ibox-title">
			<h5>Theme Settings List</h5>
		</div>
		<div class="tabs-container ibox-content">
        <div id="Pages-Items">
            <div class="row">
                <div class="col-md-3 pull-right m-b">
                    <!-- Search box  -->        
                    <form role="form" class="form-horizontal pull-right"  method="get" >
                        <div class="input-group">
                            <div class="input-group-btn">
                                <button id="searchnow" type="submit" class="btn btn-primary searchnow"> Search </button>
                            </div>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search for ...">
                            @if(!empty(app('request')->input('status_id')))  
                                <input type="hidden" id="status_id" name="status_id" value="{{app('request')->input('status_id')}}"> 
                            @endif
                        </div>
                    </form>
                </div> 
            </div> <!---.row-->
            <div class="row">
                <div class="col-md-3 pull-right">
                    <p class="badge badge-info"><span>{{$theme_count}}</span> Item(s)</p>
                      @if(!empty(app('request')->input('search')))  
                         Search results for <strong>"{{app('request')->input('search')}}"</strong>
                     @endif 
                </div>
            </div> <!---.row-->
            <div class="table-responsive" id="data_slider_table">
                <table class="footable toggle-arrow-tiny table table-striped table-bordered table-hover" data-show-toggle="false">
                    <thead>
                        <tr>
                          <th data-hide="all"></th>
        									<th data-breakpoints="xs sm">Merchant ID</th>
                          <th data-breakpoints="xs sm">Domain</th>
        									<th data-breakpoints="xs sm">Language</th>
                          <th data-hide="all" style="display: none;" >Title</th>
                          <th data-hide="all" style="display: none;" >Tag</th>
                          <th data-hide="all" style="display: none;" >Date</th>
                          <th data-breakpoints="xs sm">Last Updated</th>
                          <th data-breakpoints="xs sm">Maintenance Mode</th>
        									<th data-sort-ignore="true" data-breakpoints="xs sm" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($theme_group as $tg_val)
                        @php
                          $sample = json_decode( $merchats_quwey[0]->site_identity);
                          $site_title = str_replace('http://', '', $sample->site_title);
                          $title = str_replace('.com', '', $sample->site_title);
                        @endphp
        								<tr class="gradeX table-item" data-expanded="true">
                          <td data-hide="all"></td>
        									<td style="width: 150px;text-align: center;">{{ $tg_val->theme_merchant_id }}</td>
        									<td><a href="{{  url($tg_val->merchant_name)  }}" target="_blank" title="Go to Site"><strong>{{  str_replace("http://", '', $tg_val->merchant_name) }}</strong></a></td>
                          <td style="display: none;">{{ $tg_val->name }}</td>
                          <td style="display: none;">{{ $title }}</td>
                          <td style="display: none;">Tag</td>
        									<td style="display: none;">{{ date('M d, Y @ H:i', strtotime($tg_val->updated_at)) }}</td>
                          <td style="width: 150px;">{{ $tg_val->updated_at->diffForhumans() }}</td>
                          <td style="width: 150px;">@if($tg_val->maintenance_mode== '1') <span class="label label-primary">ON</span> @else <span class="label label-danger">OFF</span> @endif</td>
        									<td style="width: 100px;" class="text-center">
                            <a href="{{ url('system/theme-settings/' . $tg_val->opt_set_id . '/edit') }}" title="edit">
                              <button class="btn btn-info  dim btn-sm" type="button"><i class="fa fa-paste"></i> </button>
                            </a>
                          </td>
        								</tr>
                      @endforeach
                    </tbody>
                </table>
            </div> <!---.table-responsive-->
            <div id="paginate" name="paginate">
            </div>  
        </div> <!---#page-Items-->
		</div>
	</div>
@endsection