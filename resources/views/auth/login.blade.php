@extends('layouts.master')
@section('title', $site_identity->site_title.' | Login')

@section('admin-content')

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
              @if (!empty($logo)>0)
                    <h1 class="logo-name">
                        <a href="{{ URL::to('/') }}"><img src="{{ $logo->merchants_name.'/img/gallery/' .$logo->media_name }}" class="img-responsive" style="margin: 0 auto;" alt="{{ str_replace('http://', '',URL::to('/')) }}"></a>
                    </h1>       
                @else
                    <h1 class="logo-name">
                        <a href="{{ URL::to('/') }}"><img src="{{ asset('/img/front-assets/admin-logo.png') }}" class="img-responsive" style="margin: 0 auto;" alt="{{ str_replace('http://', '',URL::to('/')) }}"></a>
                    </h1>  
                @endif 

        </div>
        <h3>Welcome to {{$site_identity->site_title}}</h3>
        <p>
        </p>
     
        <form class="m-t" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email Address" >
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password" required placeholder="Password" >
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

             <!-- <a class="btn btn-link" href="{{ route('password.request') }}"><small>Forgot password?</small></a> -->
        </form>
        <p class="m-t"> <small>{{$site_identity->site_title}} &copy; 2017</small> </p>
    </div>
</div>



@endsection
