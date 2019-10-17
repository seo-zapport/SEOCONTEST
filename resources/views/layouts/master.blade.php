<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<title> @yield('title')</title>	
    <link rel="icon" href="http://qqseocontest.com/img/front-assets/seocontest.ico" type="image/x-icon">
    
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('/css/custom.css')}}" rel="stylesheet">
    
    @if ( Request::is('system/theme-settings') || Request::is('system/theme-settings/*') )
    	<link href="{{asset('/css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">
    	<link href="{{asset('/css/plugins/colorpicker/bootstrap-colorpicker.min.css')}}" rel="stylesheet">
    	<link href="{{asset('/css/plugins/chosen/bootstrap-chosen.css')}}" rel="stylesheet">
    	<link href="{{asset('/css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">
    	<link href="{{asset('/css/plugins/switchery/switchery.css')}}" rel="stylesheet">
    	<link href="{{asset('/css/plugins/daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    	<link href="{{asset('/css/plugins/chosen/bootstrap-chosen.css')}}" rel="stylesheet">
    @endif

	@if(Request::is('system/profile/*') || Request::is('system/pages/*') || Request::is('system/media') || Request::is('system/media/*') || Request::is('system/banner/*'))
	    <link href="{{asset('/css/plugins/dropzone/dropzone.css')}}" rel="stylesheet">
	
	@elseif ( Request::is('system/winner') || Request::is('system/winner/*') )

		<link href="{{asset('/css/plugins/chosen/chosen.css')}}" rel="stylesheet">
		<link href="{{asset('/css/plugins/select2/select2.min.css')}}" rel="stylesheet">

	@endif

	@if(Request::is('system/*'))
	    <link href="{{asset('/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
	    <link href="{{asset('/css/plugins/footable/footable.core.css')}}" rel="stylesheet">
	@endif

   
    <link href="{{asset('/css/seo-style.css')}}" rel="stylesheet">
    <link href="{{asset('/css/style.css')}}" rel="stylesheet">
  
    @php
    	$bg_color = '';
	    if ( Request::is( 'login' ) ) {
	    	$bg_color = 'gray-bg';
	    }
    @endphp
    @if (Auth::guest())
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
   
    @endif
</head>

<body id="wrapper" class="seo-admin {{ $bg_color }} ">

	@if (Auth::guest())
	    @yield('admin-content')
	@else
		@include('layouts.sidebar')
		<div id="page-wrapper" class="gray-bg dashbard-1">
			<div class="row border-bottom">
				<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
					<div class="navbar-header">
					    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

					</div>
				    <ul class="nav navbar-top-links navbar-right">
				        <li>
				            <span class="m-r-sm text-muted welcome-message">Welcome to SEO Contest.</span>
				        </li>

				        <li>
				           <a href="{{ route('logout') }}"
	                             onclick="event.preventDefault();
	                                      document.getElementById('logout-form').submit();">
	                            <i class="fa fa-sign-out"></i> Log out
	                         </a>

	                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                             {{ csrf_field() }}
	                         </form>
				        </li>
				    </ul>
				</nav>
			</div>

			@if(Request::url() != URL::to('/').'/403' && Request::url() != URL::to('/').'/system/admin' && Request::url() != URL::to('/').'/system/support')
			@include('layouts.breadcrumb')
			@endif
			
			@yield('accessdenied')
			
			@yield('admin-content')
		</div>
		@include('layouts.functions')	    
	@endif



</body>
</html>