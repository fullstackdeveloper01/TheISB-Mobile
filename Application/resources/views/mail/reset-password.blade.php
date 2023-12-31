<!DOCTYPE html>

	<head>

		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<title>Framesport Emailer || Reset password</title>

		<link rel="preconnect" href="https://fonts.googleapis.com">

		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

		<style type="text/css">

		body {

			margin: 0;

			padding: 0;

			background-color:#EDEDED;

			font-size:13px;

			color:#444;

			font-family:'Poppins', sans-serif;

			padding-top:75px;

		}

		table, tr, td, th {

			margin: 0;

			padding: 0;

		}

		img {

			border: none;

		}

		a {

			text-decoration: none; cursor:pointer !important;	

		}

		table[class="outer-tbl"] {

			width:768px !important;

			margin:0px auto !important;
		}
		p {
			padding:0;
		}

		img[class="main-image"] {width:100% !important; }

		div[class="foot-items"]{padding:0 190px;}

		table[class="full-wid"] {width:100%;}

		a[class="hide"]{display:inline;}

		@media only screen and (max-width:767px) {

		body {padding:0; }

		a[class="hide"]{display:none !important;}

		table[class="outer-tbl"] {width:320px !important; margin-top:0 !important; margin-bottom:0 !important;}

		div[class="foot-items"]{max-width:290px}

		td[class="logo"] {padding:20px 0  !important;}

		td[class="text"] {padding:5px 0 2px 0 !important;}

		td[class="footer"] {padding:15px 0 !important;}

		td[class="botm"] {padding:0 0 15px 0 !important;}

		td[class="less-wid"]{ font-family:'Poppins', sans-serif; font-size:13px;padding:10px !important;}

		td[class="pad-top"] {padding-top:10px !important;}

		p {margin-top:10px !important;}

		p[class="rdlinht"] {line-height:15px !important;}

		p[class="cnteimg"] {margin:20px 0 0 0!important; }

		img[class="main-image"] {width:100% !important; margin:0; padding:0; }

		p[class="pre"]{padding:0 10px !important;}

		td[class="pad-l-r-b"]{padding:0 15px 30px !important;}

		td[class="pad-l-r"]{padding:0 !important;}

		td[class="content"]{padding:20px 20px !important;}

		div[class="foot-items"]{padding:0 10px;}

		}

		a{color:#006ba4!important;}

		</style>

	</head>

	<body style="margin: 0;	padding: 0; background-color:#fff; font-size:13px; color:#444; font-family:'Poppins', sans-serif;	padding-top:70px; padding-bottom:70px;">

		<table  cellspacing="0" cellpadding="0" align="center" width="768" class="outer-tbl" style="margin:0 auto;">

			<tr>

				<td class="pad-l-r-b" style="background-color: #2597d3b5;padding: 0 5px 5px;">

					<table cellpadding="0" cellspacing="0" class="full-wid">

						<tr>

						<td style="padding:3px 0; text-align:right; font-family:'Poppins', sans-serif;" align="right">

							<a href="javascript:void(0);" style="font-size:12px; color:#DDDDDD; "></a></td>

						</tr>        

					</table>

					<table cellpadding="0" cellspacing="0"  style="width:100%; background-color:#fafdff; border-radius:4px;">

						<tr>

							<td>

								<table border="0" style="margin:0; width:100%" cellpadding="0" cellspacing="0">

									<tr>

										<td class="logo" style="padding:40px 0 30px 0; text-align:center; border-bottom:1px solid #d8dfe4;">

											<img src="{{asset('images/dark-logo.png')}}" alt="dark-logo.svg">


											<h2 style="font-family:'Poppins', sans-serif; font-size:25px; color:#006ba4; margin-top:10px;letter-spacing:1px;">Welcome To Framesport</h2>

										</td>

									</tr>

									<tr>

										<td class="content" style="padding:40px 40px;">

											<p style="font-family:'Poppins', sans-serif; font-size:15px; color:#333; margin-top:10px;">Hello! </p>
											<p style="font-family:'Poppins', sans-serif; font-size:15px; color:#333; margin-top:10px;">You are receiving this email because we received a password reset request for your account.</p>

											<p style="font-family:'Poppins', sans-serif; font-size:15px; color:#333; margin-top:0">
												<a href="{{ $url }}">Reset Password</a>
											</p>
											<p style="font-family:'Poppins', sans-serif; font-size:15px; color:#333; margin-top:0">This password reset link will expire in {{ $expire }} minutes.</p>

											<p style="font-family:'Poppins', sans-serif; font-size:15px; color:#333;">If you did not request a password reset, no further action is required.</p>

											<p style="font-family:'Poppins', sans-serif; font-size:15px; color:#333; margin-top:20px; margin-bottom:0;">Best Regards</p>

											<p style="font-family:'Poppins', sans-serif; font-size:15px; color:#333; font-weight:600; margin-top:5px">Framesport Team</p>

										</td>

									</tr>

								</table>

							</td>

						</tr>        

					</table>

				</td>

			</tr>  

		</table>

	</body>

</html>