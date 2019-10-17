@extends('system.account.create')

@section('editid', $user->id)

@section('editDisabled')
	@if(is_null($user->email))
		 
	@else
		 disabled
	@endif

@endsection

@section('first_name', $user->first_name);
@section('last_name', $user->last_name);
@section('email', $user->email);
@section('account_type', $user->status_id);

@section('editpass')
	                   <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Password</label><button type="button" class="btn btn-w-m btn-white newpass">New Password</button>

                            <div class="col-md-6" id="Editpassword" style="display: none;">
                                <input id="password" type="password" class="form-control" name="password" >
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
@endsection


@section('btn-AddNew')
	               <a href="{{'/system/account/create'}}" class="btn btn-w-m btn-primary pull-left"><i class="fa fa-plus"></i> Add New</a>      
@endsection

@section('editMethod')
    {{method_field('PUT')}}
@endsection
