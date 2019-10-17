@extends('layouts.master')
@section('title', $site_identity->site_title.' | Reward')

@section('breadcrumb')
            <h2><i class="fa fa-trophy"></i> Reward</h2>
            <ol class="breadcrumb">
                   <li>
                      <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <strong>Reward</strong>
                   </li>
            </ol>
@endsection

@section('admin-content')
   
  <div class="wrapper wrapper-content clearfix">
    <div id="alert_box" class="col-lg-12 ">  @include('layouts.messages.messages') </div>

    <div class="ibox">
      <div class="ibox-title">
        <h5>Rewards List</h5>
      </div>
      <div class="tabs-container ibox-content">
              <div id="Pages-Items">
                  <div class="row">
                      <div class="col-lg-6">
                      </div> <!---.col-lg-12-->
                      <div class="col-md-3 pull-right">
                          <!-- Search box  -->        
                          <form role="form" class="form-horizontal pull-right"  method="get" >
                              <div class="input-group">
                                  <div class="input-group-btn">
                                      <button id="searchnow" type="submit" class="btn btn-primary searchnow"> Search </button>
                                  </div>
                                  <input type="text" class="form-control" id="search" name="search" placeholder="Search for ...">
                                  
                              </div>
                          </form>
                      </div> 
                  </div> <!---.row-->
                  <div class="row">
                      <div class="col-md-5">
                          
                      </div>
                      <div class="col-md-3 pull-right">

                      </div>
                  </div> <!---.row-->
                  <br>
                  <div class="table-responsive" id="data_slider_table">
                      <table class="table table-striped table-bordered table-hover" >
                          <thead>
                              <tr>
                                  <th>Merchant</th>
                                  <th>1st Place</th>
                                  <th>2nd Place</th>
                                  <th>3rd Place</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                          @if(count($reward)>0)
                              @foreach ($reward as $rewards)
                                  <tr class="gradeX table-item">
                                      <td><a href="{{$rewards->merchant_name.'/reward'}}" target="_blank" title="View Pages"><strong>{{str_replace('http://','',$rewards->merchant_name)}}</strong></a></td>
                                      <td>{{$rewards->amount_one}}</td>
                                      <td>{{$rewards->amount_two}}</td>
                                      <td>{{$rewards->amount_three}}</td>
                                      <td><span><a href="{{'/system/reward/'.$rewards->id.'/edit'}}" title="Edit"><button class="btn btn-info  dim" type="button"><i class="fa fa-paste"></i> </button></a></span></td>
                                  </tr>
                              @endforeach
                          @else
                              <tr class='gradeX'>
                                  <td colspan='6' align="center"><strong>No Record Found</strong></td>
                              </tr>
                          @endif       
                          </tbody>
                      </table>
                  </div> <!---.table-responsive-->
                  <div id="paginate" name="paginate">
                     
                  </div>  
              </div> <!---#page-Items-->
  </div>
</div>
</div>


@endsection



