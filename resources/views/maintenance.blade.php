<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=initial-width,initial-scale=1.0">
	<title>Coming Soon - {{$site_identity->site_title}}</title>
	<link rel="icon" href="http://qqseocontest.com/img/front-assets/seocontest.ico" type="image/x-icon">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="{{asset('/js/protection.js')}}"></script>
	<style type="text/css">
		@font-face{font-family:Inversionz-Unboxed;src:url({{asset('/fonts/Inversionz/Inversionz-Unboxed.ttf') }});font-weight:400}
		@font-face{font-family:Inversionz;src:url({{asset('/fonts/Inversionz/Inversionz.ttf') }});font-weight:400}
		body{
			background: #d37d40 url({{asset('/img/front-assets/bg-qqfunbetseo.jpg') }}) no-repeat;
			background-size: cover;
			color: #fff;
			font-size: 14px;
			font-family: "Inversionz-Unboxed";
			line-height: 1.42857143;
			-webkit-touch-callout:none;
	        -webkit-user-select:none;
		}
		.wrapper{
		    padding: 8px 12px;
		    position: absolute;
		    top: 35%;
		    left: 50%;
		    transform: translate(-50%, -50%);
		    text-align: center;
		}
		.coming-title{
		    font-size: 84px;
		}
		.coming-title,
		.coming-desc{
		    text-shadow: 1px 5px 5px #222;
		}
		.coming-desc{
			font-size:21px;
		}
		.coming-ul{
			position: relative;
		    text-transform: uppercase;
		}
		@media ( max-width: 768px) {
			.wrapper{
				top: 50%;
			}
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="wrapper">
				<h1 class="coming-title">Coming Soon</h1>
				<p class="coming-desc">We are still working <span class="coming-ul">something awesome</span>.</p>
			</div>
		</div>
	</div>
</body>
</html>