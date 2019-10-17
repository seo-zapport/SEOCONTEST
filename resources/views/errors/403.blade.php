@extends('layouts.master')

@section('title',  $site_identity->site_title.' | Access denied')

@section('accessdenied')
     <div class="middle-box text-center animated fadeInDown">
        <h2>Access Denied</h2>
        <h3 class="font-bold">You do not have permision for this Pages</h3>

        <div class="error-desc">
            For Authorized Personnel Only.<br/>
			<br/>	
            You can go back to Dashboard page: <br/><a href="{{ url('/system') }}@if(Auth::user()->account_id !='4' )/admin @else/support @endif" class="btn btn-primary m-t">Go Back</a>
        </div>
    </div>

@endsection
