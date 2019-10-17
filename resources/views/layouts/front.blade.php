<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="{{ ( Auth::check() ) ? 'seo-edit' : '' }}">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('front-title')</title>
		<link rel="icon" href="http://qqseocontest.com/img/front-assets/seocontest.ico" type="image/x-icon">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/seo-front.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/plugins/timeTo/timeTo.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/front-customize.css') }}">
	</head>
	<body class="seo-template front-page" id="bg-image" itemscope="itemscope" itemtype="http://schema.org/WebPage">
		@include('layouts.front-page.header-menu')
		<main role="main" class="box-wrap" @if (! Request::is('/'))style="padding:50px 0;"@endif>
			@yield('front-content')
		</main>
		@include('layouts.front-page.footer')		
	</body>
</html>