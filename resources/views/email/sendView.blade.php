<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Verifikasi Email</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;">
			<tr><td style="font-size: 0; line-height: 0;" height="15">&nbsp;</td></tr>
		</table>
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse:collapse;font-family:Helvetica,Arial,sans-serif;font-size:14px;box-shadow:2px 5px 6px #02020291;border-radius:10px;">
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding:20px 24px 25px;background:url({{ url('/img/front-assets/bank-strip.png') }}) 48% 50% repeat-x;background-size:cover;color:#fff;min-height:50px;border-top-right-radius:9px;border-top-left-radius:9px;border-spacing:0;table-layout:auto;">
						<tr>
							<td align="middle">
								<a href="{{ url('/') }}" target="_blank" style="text-emphasis:none">
									<img src="{{ url('/img/front-assets/logo.png') }}" width="222" height="75" style="display:block;margin: auto;text-decoration:none;border:none;">
								</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding:20px 24px 25px;color:#fff;background:#2a2a2a;font-family:Helvetica,Arial,sans-serif;font-size:14px;">
						<tr>
							<td align="center" valign="middle">
								<h1 style="word-break:normal;line-height:30px;font-size:28px;font-weight:700;margin:0;">Verifikasi Email</h1>
								<p style="margin:0;padding-bottom:15px;"><img src="{{ url('/img/front-assets/mail.png') }}" style="display:block;margin:auto;text-decoration:none;border:none;"></p>
								<p style="line-height:1.5em;margin:0;padding-bottom:10px;font-family:Helvetica,Arial,sans-serif;font-size:14px;">Terima kasih sudah bergabung menjadi peserta kontes qqklikseo.com</p>
								<p style="line-height:1.5em;margin:0;padding-bottom:10px;font-family:Helvetica,Arial,sans-serif;font-size:14px;">Kami hanya perlu mengkonfirmasi kepada peserta kontes sudah mendapatkan email yang benar.</p>
								<p style="line-height:1.5em;margin:0;padding-bottom:25px;font-family:Helvetica,Arial,sans-serif;font-size:14px;">Anda hanya perlu mengklik link di bawah ini untuk mengkonfirmasi peserta kontes qqklikseo.com</p>
								<table border="0" cellspacing="0" cellpadding="0" width="200" style="width:200px;border-spacing:0;border-collapse:separate;table-layout:auto;padding-bottom:20px">
									<tr style="padding:0;">
										<td style="word-wrap:normal;display:block;white-space:nowrap;word-break:break-word;border-collapse:collapse!important;border-radius:5px;padding:8px 20px;border-color:#a00;border-style:solid;border-width:1px;" bgcolor="#aa0000">
											<a href="{{ route('sendEmailDone',["email" => $user->email, "verify_token" => $user->verify_token] ) }}" style="text-decoration:none;display:block;text-align:center;text-transform:uppercase;font-size:18px;color:#fff;">Verifikasi Email</a>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td>
					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding:20px 24px 25px;background:url({{ url('/img/front-assets/bank-strip.png') }}) 48% 50% repeat-x;background-size:cover;color:#fff;min-height:50px;border-bottom-right-radius:9px;border-bottom-left-radius:9px;border-spacing:0;table-layout:auto;">
						<tr><td style="font-size:0;line-height: 0;" height="5">&nbsp;</td></tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>