@extends('layouts.master')

@section('title', $site_identity->site_title.' | Dashboard')

@section('breadcrumb')
    <h2><i class="fa fa-th-large"></i> Dashboard</h2>
@endsection

@section('admin-content')
    <div class="row  border-bottom white-bg dashboard-header">
        <div class="col-md-3">
            <h2>Welcome {{$user->display_name}}</h2>
            <small>At First Glance.</small>
            <ul class="list-group clear-list m-t">
                            <li class="list-group-item fist-item">
                                <span class="pull-right label label-success">
                                    {{ $pagescount }}
                                </span>
                                 <a href="{{ url('system/pages') }}" class="glancelink">Pages</a>
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right label label-primary">
                                    {{ $registecount }}
                                </span>
                                  <a href="{{ url('system/contest') }}" class="glancelink">Contestant</a>
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right label label-info">
                                    {{$bannercount}}
                                </span>
                                 <a href="{{ url('system/banner') }}" class="glancelink"> Banner</a>
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right label label-warning">
                                    {{ $merchantcount }}
                                </span>
                                 <a href="{{ url('system/merchant') }}" class="glancelink"> Merchant</a>
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right label label-danger">
                                    {{ $usercount }}
                                </span>
                                 <a href="{{ url('system/account') }}" class="glancelink"> User</a>
                            </li>
                        </ul>
        </div>
        <div class="col-md-9">
          <div class="statistic-box pull-right">
              <form id="search" class="form-inline">
                {{csrf_field()}}
                <h4>Search</h4>
                <div class="input-group">
                  <select class="form-control m-b" id="merchant" name="merchant" onchange="filterResult(this);">
                    <option value="">--- Select Merchant ---</option>
                    @foreach ($merchant_list as $merchants)  
                    <option value="{{$merchants->id }}" class="text-center">{{str_replace('http://','',$merchants->merchant_name)}}</option>
                    @endforeach
                  </select>
                </div>
              </form>
          </div>
          <div class="col-md-12 m-t">
            <div class="row">
              <div class="first-glance">
              <div class="col-lg-4">
                  <div class="widget yellow-bg">
                      <div class="row">
                          <div class="col-xs-4">
                              <i class="fa fa-clock-o fa-5x"></i>
                          </div>
                          <div class="col-xs-8 text-right">
                              <h2><a href="{{url('system/contest?status_id=6')}}" class="text-primary default-link">Pending</a></h2>
                              <h2 class="font-bold">@if(count($status_register)>0) <a href="{{url('system/contest?status_id=6')}}" class="text-primary default-link">{{ $status_register->countPending }}</a> @else 0 @endif</h2>
                              <small>Total pending</small>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="widget red-bg">
                      <div class="row">
                          <div class="col-xs-4">
                              <i class="fa fa-times fa-5x"></i>
                          </div>
                          <div class="col-xs-8 text-right">
                              <h2><a href="{{url('system/contest?status_id=8')}}" class="text-primary default-link">Disqualified</a></h2>
                              <h2 class="font-bold">@if(count($status_register)>0) <a href="{{url('system/contest?status_id=8')}}" class="text-primary default-link">{{ $status_register->countDisqual }}</a> @else 0 @endif</h2>
                              <small>Total Disqualified</small>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-lg-4">
                  <div class="widget navy-bg">
                      <div class="row">
                          <div class="col-xs-4">
                              <i class="fa fa-check fa-5x"></i>
                          </div>
                          <div class="col-xs-8 text-right">
                              <h2><a href="{{url('system/contest?status_id=7')}}" class="text-primary default-link"> Approved </a></h2>
                              <h2 class="font-bold">@if(count($status_register)>0) <a href="{{url('system/contest?status_id=7')}}" class="text-primary default-link">{{ $status_register->countApproved }}</a> @else 0 @endif</h2>
                              <small>Total Approved</small>
                          </div>
                      </div>
                  </div>
              </div>
              </div>
            </div>
          </div>
        </div>
    </div>    
    
    <div class="wrapper wrapper-content row">
           <div class="rark-report">
                <div class="col-lg-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Ranking</h5>
                        </div>
                        <div class="ibox-content">
                          <div class="scroll_content">  
                            <table class="table table-hover no-margins">
                                <thead>
                                <tr>
                                    <th>Domain</th>
                                    <th>Focus Title</th>
                                </tr>
                                </thead>
                                <tbody>
                                
                                   @if(!empty($merchant_rank))
                                        @foreach($merchant_rank as $rank)
                                         <tr> 
                                            <td><a href="{{$rank->site_url }}" target="_blank" title="Visit this Site" class="btn-link">{{str_replace('http://', '', $rank->site_url)}}/{{strtolower($rank->locale)}}</a></td>
                                            <td><button id="btn-rr" type="button" class="btn btn-w-m btn-link btn-sm" data-id="{{$rank->merchants_id}}" >{{$rank->ranking}}</button></td>
                                        </tr>
                                        @endforeach 
                                   @else
                                        <tr>
                                            <td colspan="2"><strong class="text-center">No Record Found</strong></td>                            
                                        </tr>
                                   @endif 
                                
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Google Ranking Result</h5>
                            </div>
                            <div class="ibox-content">
                              <div class="scroll_content_grank">
                                    <div class="sk-spinner sk-spinner-three-bounce s-skin-1" style="display: none; margin-top: 15%;">
                                       <div class="sk-bounce1"></div>
                                       <div class="sk-bounce2"></div>
                                       <div class="sk-bounce3"></div>
                                    </div> 
                                 <div class="google_result" disabled>       
                                    <p class="gnotice text-center" style="margin-top: 15%;">Please Click Focus Title to Show Result</p>
                                 </div>   
                              </div>  
                              <hr>
                             <span><strong>Note</strong></span>
                             <ul class="media-list">
                                <li class="media-item"><i class="fa fa-asterisk"></i>If Result Don't Show Their have Some Problem on Connection</li>   
                            </ul>
                            </div>
                    </div>
                </div>
         </div>
    </div>


@endsection