<!DOCTYPE html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Day Book Report</title>
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
											<img src="https://theisb.in/wp-content/uploads/2020/06/School-Logo-2-2048x461.png" alt="ISB" title="ISB"/ style="width:30%;">
											<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:25px; color:#333333; margin-top:10px;letter-spacing:1px;"><b>Day Book Report</b></h2>
											<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:22px; color:#333333; margin-top:10px;letter-spacing:1px;">Today's Total Fees Report of - <?= $t_all; ?> INR / <?= $student_count; ?> Students</h2>
											<h3 style="font-family:Arial, Helvetica, sans-serif; font-size:22px; color:#333333; margin-top:10px;letter-spacing:1px;">Date: <?= $title; ?></h3>
										</td>
									</tr>
								</table>
							</td>
						</tr> 
					</table>
					<table cellpadding="0" cellspacing="0"  style="width:80%; background-color:#FFFFFF; border-radius:4px;margin: 0 auto;">
						<tr>
							<td style="padding:10px;" style="width:10%;">
								<div style="display:flex;border: 1px solid #dad8d8;padding: 2px 10px;background-color:#fff;align-items:center;">
									<div>
										<img src="<?php echo  base_url(); ?>assets/images/svg-icons/cash.png" alt="ISB" title="ISB" style="width:50px;">
									</div>
									<div class="align-items-center" style="margin-left:15px;">
										<div class="dl">
											<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#08aaf5; margin-top:10px;letter-spacing:1px;">Cash</h2>
											<p style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#757575; margin-top:10px;letter-spacing:1px;"><?= $cash; ?></p>
										</div>
									</div>
								</div>
							</td>
							<td style="padding:10px;" style="width:10%;">
								<div style="display:flex;align-items:center;border: 1px solid #dad8d8;padding: 2px 10px;background-color:#fff;">
									<div>
										<img src="<?php echo  base_url(); ?>assets/images/svg-icons/cheque.png" alt="ISB" title="ISB" style="width:50px;">
									</div>
									<div class="align-items-center" style="margin-left:15px;">
										<div class="dl">
											<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#08aaf5; margin-top:10px;letter-spacing:1px;">Cheque</h2>
											<p style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#757575; margin-top:10px;letter-spacing:1px;"><?= $cheque; ?></p>
										</div>
									</div>
								</div>
							</td>
							<td style="padding:10px;" style="width:10%;">
								<div style="display:flex;align-items:center;border: 1px solid #dad8d8;padding: 2px 10px;background-color:#fff;">
									<div>
										<img src="<?php echo  base_url(); ?>assets/images/svg-icons/dd.png" alt="ISB" title="ISB" style="width:50px">
									</div>
									<div class="align-items-center" style="margin-left:15px;">
										<div class="dl">
											<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#08aaf5; margin-top:10px;letter-spacing:1px;">DD</h2>
											<p style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#757575; margin-top:10px;letter-spacing:1px;"><?= $dd; ?></p>
										</div>
									</div>
								</div>
							</td>
							<td style="padding:10px;" style="width:10%;">
								<div style="display:flex;align-items:center;border: 1px solid #dad8d8;padding: 2px 10px;background-color:#fff;">
									<div>
										<img src="<?php echo  base_url(); ?>assets/images/svg-icons/upi.png" alt="ISB" title="ISB" style="width:50px;">
									</div>
									<div class="align-items-center" style="margin-left:15px;">
										<div class="dl">
											<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#08aaf5; margin-top:10px;letter-spacing:1px;">UPI</h2>
											<p style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#757575; margin-top:10px;letter-spacing:1px;"><?= $upi; ?></p>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</table>
					<table cellpadding="0" cellspacing="0"  style="width:60%; background-color:#FFFFFF; border-radius:4px;margin: 0 auto;">
						<tr>
							<td style="padding:10px;" style="width:10%; border: 1px;">
								<div style="display:flex;align-items:center;border: 1px solid #dad8d8;padding: 2px 10px;background-color:#fff;">
									<div>
										<img src="<?php echo  base_url(); ?>assets/images/svg-icons/online.png" alt="ISB" title="ISB" style="width:50px;">
									</div>
									<div class="align-items-center" style="margin-left:15px;">
										<div class="dl">
											<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#08aaf5; margin-top:10px;letter-spacing:1px;">Online</h2>
											<p style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#757575; margin-top:10px;letter-spacing:1px;"><?= $online; ?></p>
										</div>
									</div>
								</div>
							</td>
							<td style="padding:10px;" style="width:10%;">
								<div style="display:flex;align-items:center;border: 1px solid #dad8d8;padding: 2px 10px;background-color:#fff;">
									<div>
										<img src="<?php echo  base_url(); ?>assets/images/svg-icons/imps.png" alt="ISB" title="ISB" style="width:50px;">
									</div>
									<div class="align-items-center" style="margin-left:15px;">
										<div class="dl">
											<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; color:#08aaf5; margin-top:10px;letter-spacing:1px;">IMPS</h2>
											<p style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#757575; margin-top:10px;letter-spacing:1px;"><?= $IMPS; ?></p>
										</div>
									</div>
								</div>
							</td>
							<td style="padding:10px;" style="width:10%;">
								<div style="display:flex;align-items:center;border: 1px solid #dad8d8;padding: 2px 10px;background-color:#fff;">
									<div>
										<img src="<?php echo  base_url(); ?>assets/images/svg-icons/card.png" alt="ISB" title="ISB" style="width:50px;">
									</div>
									<div class="align-items-center" style="margin-left:15px;">
										<div class="dl">
											<h2 style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#08aaf5; margin-top:10px;letter-spacing:1px;">Card</h2>
											<p style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#757575; margin-top:10px;letter-spacing:1px;"><?= $card; ?></p>
										</div>
									</div>
								</div>
							</td>
						</tr>       
					</table>
					<table cellpadding="0" cellspacing="0"  style="width:80%; background-color:#FFFFFF;padding:40px 10px;margin: 0 auto;">
						<tr style="background-color: #dcbd760f;">
							<th style="border: 1px solid #eee;padding: 3px 6px;">Student Name</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Father Name</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Mother Name</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Class</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Father Mobile</th>
							<!-- <th style="border: 1px solid #eee;padding: 3px 6px;">Mother Mobile</th> -->
							<!-- <th style="border: 1px solid #eee;padding: 3px 6px;">Login Details</th> -->
							<th style="border: 1px solid #eee;padding: 3px 6px;">Academic Year</th>
							<!-- <th style="border: 1px solid #eee;padding: 3px 6px;">Date</th> -->
							<th style="border: 1px solid #eee;padding: 3px 6px;">Amount</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Mode</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Transaction Id/ Cheque/ DD</th>
							<th style="border: 1px solid #eee;padding: 3px 6px;">Accountant Name</th>
						</tr>
						<?php
							if($daybook_result)
							{
								foreach($daybook_result as $value)
								{
									$ct= '';
						            $year =   explode("-",$value->academic_year);
						            $ct ='(Due)';
						            if($year[0]==date('Y')){
						                    $ct=  '(Current Year)';
						                }
									?>
										<tr>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->student_name; ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->Father_Name; ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->Mother_Name; ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->Class; ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->Father_Mobile; ?></td>
											<!-- <td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->Mother_Mobile; ?></td> -->
											<!-- <td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= '<b>ID: </b>'.$value->email.'<br><b>Password: </b>'.$value->paa; ?></td> -->
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->academic_year.$ct; ?></td>
											<!-- <td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= date('d-m-Y', strtotime($value->deposit_date)); ?></td> -->
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->deposit_amount; ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= strtoupper($value->payment_mode); ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->payment_mode=='cheque' ? 'Cheque N0:'.$value->check_no  : strtoupper($value->dd_upi_online); ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= get_staff_full_name($value->accounted_id); ?></td>
										</tr>
									<?php
								}
							}
							if($daybook_result1)
							{
								foreach($daybook_result1 as $value)
								{
									$ct= '';
						            $year =   explode("-",$value->academic_year);
						            $ct ='(Previous)';
						            if($year[0]==date('Y')){
						                    $ct=  '(Current Year)';
						                }
									?>
										<tr>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->student_name; ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->Father_Name; ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->Mother_Name; ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->Class; ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->Father_Mobile; ?></td>
											<!-- <td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->Mother_Mobile; ?></td> -->
											<!-- <td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= '<b>ID: </b>'.$value->email.'<br><b>Password: </b>'.$value->paa; ?></td> -->
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->academic_year.$ct; ?></td>
											<!-- <td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= date('d-m-Y', strtotime($value->deposit_date)); ?></td> -->
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->deposit_amount; ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= strtoupper($value->payment_mode); ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= $value->payment_mode=='cheque' ? 'Cheque N0:'.$value->check_no  : strtoupper($value->dd_upi_online); ?></td>
											<td style="border: 1px solid #eee;padding: 3px 6px;text-align: center;"><?= get_staff_full_name($value->accounted_id); ?></td>
										</tr>
									<?php
								}
							}
							if(count($daybook_result) == 0 && count($daybook_result1) == 0)
							{
								echo '<tr class="odd"><td valign="top" colspan="12" class="dataTables_empty">No entries found</td></tr>';
							}
						?>
					</table>
				</td>
			</tr>  
		</table>
	</body>
</html>
