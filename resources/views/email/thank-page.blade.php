<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ config('app.name', 'seocontest') }} Terima Kasih</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/seo-style.css') }}">
		<style type="text/css">
			.liga-thankyou{
				color: #2c2c2c;
				font-family: Helvetica,Arial,sans-serif;
				font-size: 14px;
				line-height: 1.45;
				position: relative;
			}
			.liga-thankyou:before{
				position: absolute;
				content: '';
				width: 100%;
				height: 100%;
				display: block;
				top: 0;
				left: 0;
				bottom: 0;
				right: 0;
				z-index: -1;
				background:url('/img/thank-page/thankyoupage.jpg')repeat-x;
				background-size: cover;
			}
			.full-wh{
				display: table-cell;
				width: 1%;
				height: 100vh;
				vertical-align: middle;
			}

			.block{
				display: block;
				margin: auto;
			}
			.heading-3{
				font-size: 28px;
			}
			.logo-wrap{
				padding-bottom: 3.5em;
				text-align: center;
				vertical-align: middle;
			}
			.logo{
				display: inline-block;
				margin: auto;
			}
			.liga-thankyou main{
				position: relative;
				z-index: 1;
			}
			.panel-liga-terima {
				background-color: #ffffffa3;
				border-color: #020202de;
				box-shadow: 2px 5px 6px #02020291;
			}
			.panel-liga-terima > .panel-liga-heading,
			.panel-liga-terima > .panel-footer{
				background:url('/img/front-assets/bank-strip.png') 48% 50% repeat-x;
				background-position:center;
				background-size:cover;
			}
			.panel-liga-terima > .panel-liga-heading > .heading-3{
				color: #fff;
				margin: 0;
				padding: 10px 0;
			}
			.panel-liga-terima > .panel-body{
				padding-top: 25px;
				padding-bottom: 35px;
			}
			.panel-liga-terima > .panel-footer{
				background-color: #ffffffa3;
			}
			.liga-span{
				display: block;
			}
			p.heading-3{
			    word-break: break-all;
			    line-height: 1.5;
			    margin-bottom: 25px;
			}
		</style>
</head>
<body class="seo-liga liga-thankyou">
	<main>
		<div class="container">
			<div class="full-wh">
				<div style="word-break: break-all;">
					<div class="logo-wrap">
						<a href="{{ url('/') }}" class="logo">
							<img src="{{ url('/img/front-assets/logo.png') }}" class="img-responsive block">
						</a>
					</div>
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default panel-liga-terima">
							<div class="panel-heading panel-liga-heading">
								<h3 class="heading-3 text-center">Terima Kasih</h3>
							</div>
							<div class="panel-body text-center">
								<p class="heading-3">Terima kasih telah ikut berpartisipasi <span class="liga-span">kontes qqklikseo.com</span></p>
								<p><img src="{{ url('/img/thank-page/soccer.png') }}" class="img-responsive block"></p>
							</div>
							<div class="panel-footer">
								&nbsp;
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>
</html>