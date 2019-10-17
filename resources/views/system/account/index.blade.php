@extends('layouts.master')
@section('title', $site_identity->site_title.' | Account')

@section('breadcrumb')
            <h2><i class="fa fa-user"></i> Account</h2>
            <ol class="breadcrumb">
                   <li>
                       <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                   <li class="active">
                       <strong>Account</strong>
                   </li>
            </ol>
@endsection
@section('admin-content')
              <div class="wrapper wrapper-content clearfix">
                <div id="alert_box" class="col-lg-12 ">  @include('layouts.messages.messages') </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <a href="{{ url( '/system/account/create' ) }}" class="btn btn-sm btn-primary" style="margin-bottom: 15px;"><i class="fa fa-plus"></i> Add New</a>
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Accounts List</h5>
                                </div>
                                <div class="ibox-content">
                                    <div id="Country-Items">
                                        

                                      <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                                <div class="status">
                                                    <ul class="nav">
                                                        <li @if (app('request')->input('account_type')=='') class="active" @endif><a href="{{ url( '/system/account' ) }}">All (@if(!empty($user_count)){{$user_count->countAll}}@else{{0}}@endif)</a></li>
                                                        <li @if (app('request')->input('account_type')=='2') class="active" @endif><a href="{{ url( '/system/account?account_type=2' ) }}">Administrator (@if(!empty($user_count)){{$user_count->countAdmin}}@else{{0}}@endif)</a></li>
                                                        <li @if (app('request')->input('account_type')=='3') class="active" @endif><a href="{{ url( '/system/account?account_type=3' ) }}">Developer (@if(!empty($user_count)){{$user_count->countDev}}@else{{0}}@endif)</a></li>
                                                        <li @if (app('request')->input('account_type')=='4') class="active" @endif><a href="{{ url( '/system/account?account_type=4' ) }}">Support (@if(!empty($user_count)){{$user_count->countSupport}}@else{{0}}@endif)</a></li>
                                                    </ul>
                                                </div>
                                            </div> <!---.col-lg-12-->

                                            <div class="col-md-3 pull-right">
                                                <!-- Search box  col-md-offset-4  -->        
                                                <form role="form" class="form-horizontal pull-right"  method="get"  >
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button id="searchnow" type="submit" class="btn btn-primary searchnow"> Search </button>
                                                        </div>
                                                        <input type="text" class="form-control" id="search" name="search" placeholder="Search for ...">
                                                        @if(!empty(app('request')->input('account_type')))
                                                            <input type="hidden" id="account_type" name="account_type" value="{{app('request')->input('account_type')}}"> 
                                                        @endif
                                                    </div>
                                                </form>
                                            </div> 

                                        </div> <!---.row-->

                                        <div class="row">
                                            <div class="col-md-5 row">
                                                <form role="form" class="col-md-6" method="post"> 
                                                    {{csrf_field()}}         
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <select class="form-control m-b" id="RoleAction" name="RoleAction" required autofocus>
                                                                <option value=""> -Change Role to- </option>
                                                            </select> 
                                                            <div class="input-group-btn">
                                                                <button id="btn-RoleAction" type="button" class="btn btn-m btn-success btn-RoleAction">Apply</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-md-3 pull-right">
                                                <p class="badge badge-info"><span>{{ $account_count }}</span> Item(s)</p>
                                                  @if(!empty(app('request')->input('search')))  
                                                     Search results for <strong>"{{app('request')->input('search')}}"<strong>
                                                 @endif 
                                            </div>
                                        </div> <!---.row-->
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover fixed" >
                                                <thead>
                                                  <tr>
                                                      <th class="text-center">
                                                        <div class="checkbox checkbox-primary">
                                                            <input type="checkbox" class="styled styled-primary" id="selectAll" name="selectAll">
                                                            <label></label>
                                                        </div>
                                                      </th>
                                                      <th>Name</th>
                                                      <th>Email</th>
                                                      <th>Account Type</th>
                                                      <th>Accessible</th>
                                                      <th>Status</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  @if(count($user)>0)
                                                     @foreach ($user as $users)
                                                        <tr class="gradeX table-item ">
                                                            <td style="width: 50px;" class="text-center">
                                                              <div class="checkbox checkbox-primary rows">
                                                                  <input type="checkbox" class="styled styled-primary check" id="accountarr" name="accountarr[]" value="{{$users->id}}" >
                                                                  <label></label>
                                                              </div>
                                                            </td>
                                                            <td class="title col-title">
                                                              <strong>
                                                                <a href="{{'/system/account/'.$users->id.'/edit'}}" class="modalEdit text-primary" >{{ucfirst($users->first_name)}} {{ucfirst($users->last_name)}} </a>@if($users->created_at >= \Carbon\Carbon::now()->subHour(24))<span class="badge badge-primary">New</span>@endif
                                                              </strong>   
                                                            </td>
                                                            <td class="column-email">{{$users->email}}</td>
                                                            <td class="column-author">{{$users->status_name}}</td>
                                                     
                                                            <td class="column-status">@if($users->remember_token == "")                         
                                                                    <span class="text-warning"><strong>Unactive</strong></span> 
                                                                @else                                             
                                                                    <span class="text-success"><strong>Active</strong></span> 
                                                                @endif
                                                            </td>
                                                            <td class="column-status">
                                                              @if($users->is_logged_in == "true" )                         
                                                                <span class="text-info"><strong>Online</strong></span> 
                                                              @else                                             
                                                                <span class="text-warning"><strong>Offline</strong></span> 
                                                              @endif
                                                            </td>

                                                        </tr>
                                                      
                                                     @endforeach
                                                  @else
                                                    <tr class='gradeX'>
                                                      <td colspan='7' align="center"><strong>No Record Found</strong></td>
                                                    </tr>
                                                  @endif
                                                </tbody>
                                            </table>
                                        </div> <!---.table-responsive-->
                                    </div> <!---#Country-Items-->

                                </div> <!---.ibox-content-->
                            </div> <!---.ibox-->
                        </div>
                    </div> <!---.row-->

            </div> <!---.wrapper-->


@endsection



                        