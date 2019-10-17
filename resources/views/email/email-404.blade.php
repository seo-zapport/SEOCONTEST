<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ config('app.name', 'seocontest') }} 404 Halaman</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/seo-style.css') }}">
		<style type="text/css">
			.liga-thankyou{color:#2c2c2c;font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:1.45;position:relative}
			.liga-thankyou:before{position:absolute;content:'';width:100%;height:100%;display:block;top:0;left:0;bottom:0;right:0;z-index:-1;background:url(/img/back.jpg) repeat-x;background-size:cover}
			.full-wh{display:table-cell;width:1%;height:100vh;vertical-align:middle}
			.block{display:block;margin:auto}
			.heading-3{font-size:28px}
			.liga-thankyou main{position:relative;z-index:1}
			p.heading-3{word-break:break-all;line-height:1.5;margin-bottom:25px}
		</style>
</head>
<body class="seo-liga liga-thankyou">
	<main>
		<div class="container">
			<div class="full-wh">
				<div style="word-break: break-all;">
					<div class="logo-wrap">
						<img src="{{ url('/img/front-assets/404.png') }}" class="img-responsive block">
					</div>
					<div class="col-md-8 col-md-offset-2">
						<p class="heading-3 text-center" style="color:#fff;font-style:italic;">Sepertinya kami tidak menemukan laman yang Anda cari.</p>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>
</html>