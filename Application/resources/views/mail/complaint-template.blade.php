<!DOCTYPE html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>The ISB Mobile App</title>
		<style type="text/css">
		body {
			margin: 0;
			padding: 0;
			background-color:#EDEDED;
			font-size:13px;
			color:#444;
			font-family:Arial, Helvetica, sans-serif;
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
			width:1300px !important;
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
		td[class="less-wid"]{ font-family:Arial, Helvetica, sans-serif; font-size:13px;padding:10px !important;}
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
		</style>
	</head>

	<body style="margin: 0;	padding: 0; background-color:#EDEDED; font-size:13px; color:#444; font-family:Arial, Helvetica, sans-serif;	padding-top:70px; padding-bottom:70px;">
		<table  cellspacing="0" cellpadding="0" align="center" width="1100" class="outer-tbl" style="margin:0 auto; border: 10px solid #e50003; background-color: #fff;">
			<tr>
				<td class="pad-l-r-b" style="border:1px solid #d0cece;">
					<table cellpadding="0" cellspacing="0"  style="width:100%; background-color:#FFFFFF; border-radius:4px;">
						<tr>
							<td colspan="7">
								<table border="0" style="margin:0; width:100%" cellpadding="0" cellspacing="0">
									<tr>
										<td class="logo" style="padding:40px 0 30px 0; text-align:center;">
											<img src="https://mobile.theisb.in/images/logo.png" alt="ISB" title="ISB"/ style="width:30%;">
											<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:25px; color:#333333; margin-top:10px;letter-spacing:1px;"><b>{{ $subject }}</b></h2>
											<h3 style="font-family:Arial, Helvetica, sans-serif; font-size:22px; color:#333333; margin-top:10px;letter-spacing:1px;">Date: <?= date('d M, Y h:i a') ?></h3>
										</td>
									</tr>
								</table>
							</td>
						</tr> 
					</table>
					
					<table cellpadding="0" cellspacing="0"  style="width:80%; background-color:#FFFFFF;padding:40px 10px;margin: 0 auto;">
						<tr style="background-color: #dcbd760f;">
							<th style="border: 1px solid #eee;padding: 3px 6px;">Student Name</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Father Name</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Mother Name</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Father Mobile</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Class</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Shift</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Message</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Status</th>
						</tr>
						<tr>
							<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $student_name; ?></td>
							<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $father_name; ?></td>
							<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $mother_name; ?></td>
							<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $student_mobile; ?></td>
							<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $student_class; ?></td>
							<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $student_shift; ?></td>
							<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $message; ?></td>
							<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= 'Pending'; ?></td>
						</tr>
					</table>
				</td>
			</tr>  
		</table>
	</body>
</html>
