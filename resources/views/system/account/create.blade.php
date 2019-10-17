@extends('layouts.master')
@section('title', $site_identity->site_title.' | '.ucfirst(substr(Route::currentRouteName(),8)).' Account')
@section('breadcrumb')
            <h2><i class="fa fa-user"></i> Account</h2>
            <ol class="breadcrumb">
                   <li>
                       <a href="@if(Auth::user()->account_id !='4' ) /system/admin @else/system/support  @endif ">Dashboard</a>
                   </li>
                <li><a href="/system/account">Accounts</a></li>
                <li class="active"><strong>{{ucfirst(substr(Route::currentRouteName(),8))}} Account</strong></li>
            </ol>
@endsection
@section('admin-content')
    <div class="row">
        <div class="wrapper wrapper-content">
            <div class="col-lg-12">
                 @section('btn-AddNew')
                 @show
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-offset-3"> 
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>{{ucfirst(substr(Route::currentRouteName(),8))}} User</h5>
                            </div>
                            <div class="ibox-content">
                                <p><span><strong>Note:</strong></span> <i>Please Fill the Form Have This in Field</i> <strong class="text-danger"> (*)</strong> </span></p>
                                <div class="hr-line-dashed"></div>
                                <form id="useraccount" role="form" class="form-horizontal" method="post" action="/system/account/@yield('editid')">
                                    {{csrf_field()}}
                                    @section('editMethod')
                                    @show 
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label for="first_name" class="col-md-4 control-label">First Name <span class="text-danger" >*</span></label>
                                        <div class="col-md-6">
                                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name')=='' ? @$user->first_name : old('first_name') }}" required autofocus>
                                            @if ($errors->has('first_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label for="last_name" class="col-md-4 control-label">Last Name <span class="text-danger" >*</span></label>

                                        <div class="col-md-6">
                                            <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name')=='' ? @$user->last_name : old('last_name') }}" required autofocus>

                                            @if ($errors->has('last_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label for="email" class="col-md-4 control-label">E-Mail Address <span class="text-danger" >*</span></label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email')=='' ? @$user->email : old('email') }}" required  @section('editDisabled')  @show>

                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('account_type') ? ' has-error' : '' }}">
                                        <label for="account_type" class="col-md-4 control-label">Account Type <span class="text-danger" >*</span></label>
                                        <div class="col-md-6">
                                            <select class="form-control m-b" name="account_type"  required autofocus>
                                                <option value="" >-Select Account Type-</option>     
                                                @foreach ($account as $accounts) 
                                                <option value="{{$accounts->id}}" {{ old('account_type', $accounts->id) == @$user->account_id ? 'selected': ''  }} >{{$accounts->status_name}}</option>
                                                @endforeach
                                            </select> 

                                            @if ($errors->has('account_type'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('account_type') }}</strong>
                                                </span>
                                            @endif
                                        </div> 
                                    </div>

                                    @if(ucfirst(substr(Route::currentRouteName(),8)) =="Create")
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="password" class="col-md-4 control-label">Password <span class="text-danger" >*</span></label>

                                            <div class="col-md-6">
                                                <input id="password" type="password" class="form-control" name="password" required>

                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password <span class="text-danger" >*</span></label>

                                            <div class="col-md-6">
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button type="submit" class="btn btn-primary">
                                                    Register
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        @section('editpass')
                                        @show
                                    @endif
                                </form>
                            </div>
                            @include('layouts.messages.errors')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection