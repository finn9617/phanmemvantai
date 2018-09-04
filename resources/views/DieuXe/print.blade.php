<!DOCTYPE html>
<html>
<head>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>




	<script
	src="https://code.jquery.com/jquery-3.3.1.js"
	integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
	crossorigin="anonymous"></script>
	<title></title>
	<style type="text/css">
	/* .container1{
		min-height: 1122px/2;
	} */
	.borderless td, .borderless th {
		border: none !important;
	}
	.page {
		size: A4;
		height: 291mm; 
		word-wrap: break-word;
	}
	@media print {
        html, body {
            width: 210mm;
            height: 291mm;      
  			margin: 0px;  

        }
		.page {
			margin: 0;
			max-width: initial;
			max-height: initial;
			page-break-after: always;
		}
	}
	/* header footer bi đẩy đi mất */
	@page {
		size: A4;
		margin: 0;
		padding:0;
		height: 291mm; 
	 }

	 .num_car{
		font-size: 110%; 
		margin-top: 15px; 
		padding-left: 30px; 
		padding-right: 20px;
		font-weight: 500;
	 }
	 .row{
		 margin-left: 0;
		 margin-right: 0;
	 }

	 
</style>
</head>
<body style="font-family: "Arial, Helvetica, sans-serif"" class="myBody">
	<?php


	if(!session()->has('email')){
		echo "Chưa đăng nhập";
		exit();
	}
	$currentUser = null;
	$currentUser_name="tr";
	if(session()->has('email'))
	{
		$tmpemail = Session::get('email');
		$email = end($tmpemail);
		$users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $email)->get();
		$currentUser =$users[0];
		$user = $users[0]->user_id;
		$currentUser_name = $users[0]->full_name;
		$nick_name = mb_strtoupper($users[0]->nick_name, 'UTF-8');
		$phone = $users[0]->phone;
		$currentUser_type =$users[0]->user_type;
		$nhom = App\Metadata::getGroupList('print_operation','print_operation_detail');
		$nhom1=$nhom[0]['value1'];
		$nhom2=$nhom[0]['value2'];
		
  }
	?>
	<form name="frmOperation" id "frmOperation" method = "get">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
	</form>
	<script type="text/javascript">
		$(document).ready(function(){
			var currentDateTime = new Date();
			var currentDate = currentDateTime.getDate();
			var currentMonth = (currentDateTime.getMonth()+1);
			var currentYear = currentDateTime.getFullYear();
			//get parameter from url
			var getUrlParameter = function getUrlParameter(sParam) {
				var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

				for (i = 0; i < sURLVariables.length; i++) {
					sParameterName = sURLVariables[i].split('=');

					if (sParameterName[0] === sParam) {
						return sParameterName[1] === undefined ? true : sParameterName[1];
					}
				}
			};
			console.log(getUrlParameter('id'));


			let tmpID = getUrlParameter('id');
			var tmpID2 = tmpID.split("-");
			console.log(tmpID2);
			var id = [];
			if(tmpID2.length > 0){
				for(let i = 0 ; i < tmpID2.length ; i++){
					if( ! isNaN(tmpID2[i])){
						if (Number(tmpID2[i]) === parseInt(Number(tmpID2[i], 10)))
							id.push(Number(tmpID2[i]));
					}
				}
			}
			if(id.length > 0){
				// var info = {};
				var info = {};
				$.each($('form').serializeArray(),function(){
					info[this.name] = this.value;
				});
				info['id'] = id;
				$.ajax('{{url("/getListPrint")}}', {
					type: 'POST',  
					data: info,
					dataType:"json",
					// headers: {"Authorization": localStorage.getItem('token')},
					async: true,
					success: function (result) {
						if(result.success)
						{
							console.log(result.success); 
							var res = result.success;//res.length > 0 departure_time
							var currentUserName = '<?php echo $currentUser_name; ?>';
							currentUserName = currentUserName.toUpperCase();
							console.log(res.length);
							if(res.length){
								if(res.length < 2){
									for(var j=0; j < res.length; j+=2){
										// d = getDatE(res[j]['operating_date']);
										var breakLine="";
										// if(j %2 ==0){
											breakLine = '<hr width="100%" style="border:1px dashed; top:40%; margin-top: 0; margin-bottom: 0;">';

										// }
										// ============================ append content ===============================
										var content = '<div class="page"><div class="container1"  style="height: 100%; padding-top:15px;" >'+
												'<div class="mycontent">'+
										'<div class="row">'+
										'<div class="col-md-6 col-xs-6" style="text-align: center;">'+
										'<span style="font-size:16px; font-weight: bold; ">CTY TNHH TM VẬN TẢI </span>	<br>'+
										'<span style="font-size:16px; font-weight: bold; ">QUỐC HUY</span> <br>'+
										'08.39610305 == 0989007669'+
										'</div>'+
										'<div class="col-md-6 col-xs-6" style="text-align: left; ">'+
										'<span style="font-size:25px; font-weight: bold; ">LỆNH LẤY HÀNG </span>'+
										'</div>'+
										'</div>'+
										'<div class="row num_car">'+
										'<div class="col-md-3 col-xs-3" style="padding-left: 0;padding-right: 0;text-align: center; text-transform: uppercase;">SỐ XE: '+res[j]['car_num']+'</div>'+
										'<div class="col-md-3 col-xs-3 size" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">ROMOOC: '+res[j]['trailer_num']+'</div>'+
										'<div class="col-md-3 col-xs-3 size" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">XỊT BỒN: '+res[j]['clear_tank_name']+'</div>'+
										'<div class="col-md-3 col-xs-3 size" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">GIỜ ĐI: '+res[j]['departure_time']+'</div>'+		
										'</div>'+
										'<div class="row"  style=" font-size: 12.5px; letter-spacing: 0.5px;  margin-top: 15px; padding-left: 30px; ">'+
										'<div class="col-md-3 col-xs-3">LOẠI HÀNG: </div>'+
										'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j]['goods_name']+'</div>'+
										'<div class="col-md-3 col-xs-3">SỐ LƯỢNG:</div>'+
										'<div class="col-md-3 col-xs-3">'+res[j]['num']+'</div>'+		
										'</div>'+
										'<div class="row"  style=" font-size: 12.5px; letter-spacing: 0.5px; padding-left: 30px; ">'+
										'<div class="col-md-3 col-xs-3">NƠI NHẬN: </div>'+
										'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j]['receipt_place_name']+'</div>'+	
										'<div class="col-md-3 col-xs-3">TÀI XẾ:</div>'+
										'<div class="col-md-3 col-xs-3">'+res[j]['driver_name']+'</div>'+			
										'</div>'+
										'<div class="row"  style=" font-size: 12.5px; letter-spacing: 0.5px; padding-left: 30px; ">'+
										'<div class="col-md-3 col-xs-3">NƠI GIAO:</div>'+
										'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j]['delivery_place_name']+'</div>'+	
										'<div class="col-md-3 col-xs-3">LƠ XE:</div>'+
										'<div class="col-md-3 col-xs-3">'+res[j]['assistant_driver_name']+'</div>'+			
										'</div>'+
										'<div class="row" style=" font-size: 110%; margin-top: 7px; margin-bottom: 7px; padding-left: 30px; padding-right: 20px;">'+
										'<div class="col-md-3 col-xs-3">CHỦ HÀNG</div>'+
										'<div class="col-md-9 col-xs-9">'+res[j]['owner_name']+'</div>'+
										'</div>'+
										'<div class="row"  style=" font-size: 12px; padding-left: 30px; ">'+
										'<div class="col-md-6 col-xs-6">'+
										'<div class="row">'+
										'<div class="col-md-7 col-xs-7" style=" text-align: center; text-decoration: underline;">'+
										'CHỨNG TỪ MANG VỀ'+
										'</div>'+
										'<div class="col-md-12 col-xs-12">'+
										'*PHIẾU CẦN KHO <br>'+
										'*PHIẾU CẦN KHO KHÁCH <br>'+
										'*BIÊN BẢN GIAO HÀNG <br>'+
										'</div>'+
										'</div>'+
										'</div>'+
										'<div class="col-md-6 col-xs-6" style="text-align: center;">'+
										'<span>NGÀY '+getDatE(res[j]['operating_date'])+' THÁNG '+getMontH(res[j]['operating_date'])+' NĂM '+getYear(res[j]['operating_date'])+'</span>'+
										'<p>NGƯỜI PHỤ TRÁCH</p>'+
										'<p>'+res[j]['curator_name']+' - '+res[j]['curator_phone']+'</p>'+
										// '<p>'+currentUserName+'</p>'+
										'</div>'+
										'</div>'+
										'<div class="row"  style=" font-size: 12px; padding-left: 30px; ">'+
										'<div class="row">'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 55px;text-decoration: underline;">'+
										'CHỨNG TỪ MANG THEO'+
										'</div>'+
										'<div class="" style="padding-left: 30px;padding-top: 5px; ">'+res[j]['document1']+
										'</div>'+
										'<div class="" style="padding-left: 30px;padding-top: 5px; ">'+res[j]['document2']+
										'</div>'+
										'</div>'+
										'<div class="row">'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 55px;"><span style="text-decoration: underline;">DỤNG CỤ MANG THEO</span>&nbsp;&nbsp;&nbsp; '+
										'</div>'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 30px;padding-top: 5px; ">'+res[j]['tools1']+
										'</div>'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 30px;padding-top: 5px; ">'+res[j]['tools2']+
										'</div>'+
										'</div>'+
										'</div>'+
										'<div class="row"  style="padding-left: 30px; margin-top: 10px;">'+
										'<span style="font-size: 15;text-decoration: underline;font-weight:bold;">CHÚ Ý:</span> <span style="font-size: 12px;">'+res[j]['note']+'</span><br>'+
										'<div style="text-align: center; font-size: 13px;">'+
										'TÀI XẾ KHÔNG ĐƯỢC TỰ Ý BẬT BƠM HOẶC MỞ VAN CỦA KHÁCH HÀNG (NƠI XE GIAO HÀNG).KỂ CẢ KHÁCH HÀNG NHỜ '+
										'CŨNG KHÔNG ĐƯỢC <br>'+
										'{{ $nhom1 }} <br>'+
										'{{ $nhom2 }}'+
										'</div>'+
										'</div><br><br>'+
										'</div>'+
										'</div>'+
										'</div>';
										$(".myBody").append(content);

									}
								}else{
									for(var j=0; j < res.length; j+=2){
										var breakLine="";
										// if(j %2 ==0){
											breakLine = '<hr width="100%" style="border:1px dashed; top:40%; margin-top: 0; margin-bottom: 0;">';

										// }
										// ============================ append content ===============================
										var content = '<div class="page"><div class="container1"  style="height: 51%; padding-top:15px;overflow: hidden;" >'+
												'<div class="mycontent">'+
										'<div class="row">'+
										'<div class="col-md-6 col-xs-6" style="text-align: center;">'+
										'<span style="font-size:16px; font-weight: bold; ">CTY TNHH TM VẬN TẢI </span>	<br>'+
										'<span style="font-size:16px; font-weight: bold; ">QUỐC HUY</span> <br>'+
										'08.39610305 == 0989007669'+
										'</div>'+
										'<div class="col-md-6 col-xs-6" style="text-align: left; ">'+
										'<span style="font-size:25px; font-weight: bold; ">LỆNH LẤY HÀNG </span>'+
										'</div>'+
										'</div>'+
										'<div class="row num_car">'+
										'<div class="col-md-3 col-xs-3" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">SỐ XE: '+res[j]['car_num']+'</div>'+
										'<div class="col-md-3 col-xs-3 size" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">ROMOOC: '+res[j]['trailer_num']+'</div>'+
										'<div class="col-md-3 col-xs-3 size" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">XỊT BỒN: '+res[j]['clear_tank_name']+'</div>'+
										'<div class="col-md-3 col-xs-3 size" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">GIỜ ĐI: '+res[j]['departure_time']+'</div>'+		
										'</div>'+
										'<div class="row"  style=" font-size: 12.5px; letter-spacing: 0.5px;  margin-top: 15px; padding-left: 30px; ">'+
										'<div class="col-md-3 col-xs-3">LOẠI HÀNG: </div>'+
										'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j]['goods_name']+'</div>'+
										'<div class="col-md-3 col-xs-3">SỐ LƯỢNG:</div>'+
										'<div class="col-md-3 col-xs-3">'+res[j]['num']+'</div>'+		
										'</div>'+
										'<div class="row"  style=" font-size: 12.5px; letter-spacing: 0.5px; padding-left: 30px; ">'+
										'<div class="col-md-3 col-xs-3">NƠI NHẬN: </div>'+
										'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j]['receipt_place_name']+'</div>'+	
										'<div class="col-md-3 col-xs-3">TÀI XẾ:</div>'+
										'<div class="col-md-3 col-xs-3">'+res[j]['driver_name']+'</div>'+			
										'</div>'+
										'<div class="row"  style=" font-size: 12.5px; letter-spacing: 0.5px; padding-left: 30px; ">'+
										'<div class="col-md-3 col-xs-3">NƠI GIAO:</div>'+
										'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j]['delivery_place_name']+'</div>'+	
										'<div class="col-md-3 col-xs-3">LƠ XE:</div>'+
										'<div class="col-md-3 col-xs-3">'+res[j]['assistant_driver_name']+'</div>'+			
										'</div>'+
										'<div class="row" style=" font-size: 110%; margin-top: 7px; margin-bottom: 7px; padding-left: 30px; padding-right: 20px;">'+
										'<div class="col-md-3 col-xs-3">CHỦ HÀNG</div>'+
										'<div class="col-md-9 col-xs-9">'+res[j]['owner_name']+'</div>'+
										'</div>'+
										'<div class="row"  style=" font-size: 12px; padding-left: 30px; ">'+
										'<div class="col-md-6 col-xs-6">'+
										'<div class="row">'+
										'<div class="col-md-7 col-xs-7" style=" text-align: center; text-decoration: underline;">'+
										'CHỨNG TỪ MANG VỀ'+
										'</div>'+
										'<div class="col-md-12 col-xs-12">'+
										'*PHIẾU CẦN KHO <br>'+
										'*PHIẾU CẦN KHO KHÁCH <br>'+
										'*BIÊN BẢN GIAO HÀNG <br>'+
										'</div>'+
										'</div>'+
										'</div>'+
										'<div class="col-md-6 col-xs-6" style="text-align: center;">'+
										'<span>NGÀY '+getDatE(res[j]['operating_date'])+' THÁNG '+getMontH(res[j]['operating_date'])+' NĂM '+getYear(res[j]['operating_date'])+'</span>'+
										'<p>NGƯỜI PHỤ TRÁCH</p>'+
										'<p>'+res[j]['curator_name']+' - '+res[j]['curator_phone']+'</p>'+
										// '<p>'+currentUserName+'</p>'+
										'</div>'+
										'</div>'+
										'<div class="row"  style=" font-size: 12px; padding-left: 30px; ">'+
										'<div class="row">'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 55px;text-decoration: underline;">'+
										'CHỨNG TỪ MANG THEO'+
										'</div>'+
										'<div class="" style="padding-left: 30px;padding-top: 5px; ">'+res[j]['document1']+
										'</div>'+
										'<div class="" style="padding-left: 30px;padding-top: 5px; ">'+res[j]['document2']+
										'</div>'+
										'</div>'+
										'<div class="row">'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 55px;"><span style="text-decoration: underline;">DỤNG CỤ MANG THEO</span>&nbsp;&nbsp;&nbsp; '+
										'</div>'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 30px;padding-top: 5px; ">'+res[j]['tools1']+
										'</div>'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 30px;padding-top: 5px; ">'+res[j]['tools2']+
										'</div>'+
										'</div>'+
										'</div>'+
										'<div class="row"  style="padding-left: 30px; margin-top: 10px;">'+
										'<span style="font-size: 15;text-decoration: underline;font-weight:bold;">CHÚ Ý:</span> <span style="font-size: 12px;">'+res[j]['note']+'</span><br>'+
										'<div style="text-align: center; font-size: 13px;">'+
										'TÀI XẾ KHÔNG ĐƯỢC TỰ Ý BẬT BƠM HOẶC MỞ VAN CỦA KHÁCH HÀNG (NƠI XE GIAO HÀNG).KỂ CẢ KHÁCH HÀNG NHỜ '+
										'CŨNG KHÔNG ĐƯỢC <br>'+
										'{{ $nhom1 }} <br>'+
										'{{ $nhom2 }}'+
										'</div>'+
										'</div><br><br>'+
										'</div>'+
										'</div>'
										+breakLine+'<div class="container1 "  style="padding-top:15px; overflow: hidden;" >'+
												'<div class="mycontent">'+
										'<div class="row">'+
										'<div class="col-md-6 col-xs-6" style="text-align: center;">'+
										'<span style="font-size:16px; font-weight: bold; ">CTY TNHH TM VẬN TẢI </span>	<br>'+
										'<span style="font-size:16px; font-weight: bold; ">QUỐC HUY</span> <br>'+
										'08.39610305 == 0989007669'+
										'</div>'+
										'<div class="col-md-6 col-xs-6" style="text-align: left; ">'+
										'<span style="font-size:25px; font-weight: bold; ">LỆNH LẤY HÀNG </span>'+
										'</div>'+
										'</div>'+
										'<div class="row num_car">'+
										'<div class="col-md-3 col-xs-3" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">SỐ XE: '+res[j+1]['car_num']+'</div>'+
										'<div class="col-md-3 col-xs-3 size" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">ROMOOC: '+res[j+1]['trailer_num']+'</div>'+
										'<div class="col-md-3 col-xs-3 size" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">XỊT BỒN: '+res[j+1]['clear_tank_name']+'</div>'+
										'<div class="col-md-3 col-xs-3 size" style="padding-left: 0;padding-right: 0;text-align: center;text-transform: uppercase;">GIỜ ĐI: '+res[j+1]['departure_time']+'</div>'+		
										'</div>'+
										'<div class="row"  style=" font-size: 12.5px; letter-spacing: 0.5px;  margin-top: 15px; padding-left: 30px; ">'+
										'<div class="col-md-3 col-xs-3">LOẠI HÀNG: </div>'+
										'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j+1]['goods_name']+'</div>'+
										'<div class="col-md-3 col-xs-3">SỐ LƯỢNG:</div>'+
										'<div class="col-md-3 col-xs-3">'+res[j+1]['num']+'</div>'+		
										'</div>'+
										'<div class="row"  style=" font-size: 12.5px; letter-spacing: 0.5px; padding-left: 30px; ">'+
										'<div class="col-md-3 col-xs-3">NƠI NHẬN: </div>'+
										'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j+1]['receipt_place_name']+'</div>'+	
										'<div class="col-md-3 col-xs-3">TÀI XẾ:</div>'+
										'<div class="col-md-3 col-xs-3">'+res[j+1]['driver_name']+'</div>'+			
										'</div>'+
										'<div class="row"  style=" font-size: 12.5px; letter-spacing: 0.5px; padding-left: 30px; ">'+
										'<div class="col-md-3 col-xs-3">NƠI GIAO:</div>'+
										'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j+1]['delivery_place_name']+'</div>'+	
										'<div class="col-md-3 col-xs-3">LƠ XE:</div>'+
										'<div class="col-md-3 col-xs-3">'+res[j+1]['assistant_driver_name']+'</div>'+			
										'</div>'+
										'<div class="row" style=" font-size: 110%; margin-top: 7px; margin-bottom: 7px; padding-left: 30px; padding-right: 20px;">'+
										'<div class="col-md-3 col-xs-3">CHỦ HÀNG</div>'+
										'<div class="col-md-9 col-xs-9">'+res[j+1]['owner_name']+'</div>'+
										'</div>'+
										'<div class="row"  style=" font-size: 12px; padding-left: 30px; ">'+
										'<div class="col-md-6 col-xs-6">'+
										'<div class="row">'+
										'<div class="col-md-7 col-xs-7" style=" text-align: center; text-decoration: underline;">'+
										'CHỨNG TỪ MANG VỀ'+
										'</div>'+
										'<div class="col-md-12 col-xs-12">'+
										'*PHIẾU CẦN KHO <br>'+
										'*PHIẾU CẦN KHO KHÁCH <br>'+
										'*BIÊN BẢN GIAO HÀNG <br>'+
										'</div>'+
										'</div>'+
										'</div>'+
										'<div class="col-md-6 col-xs-6" style="text-align: center;">'+
										'<span>NGÀY '+getDatE(res[j]['operating_date'])+' THÁNG '+getMontH(res[j]['operating_date'])+' NĂM '+getYear(res[j]['operating_date'])+'</span>'+
										'<p>NGƯỜI PHỤ TRÁCH</p>'+
										'<p>'+res[j+1]['curator_name']+' - '+res[j+1]['curator_phone']+'</p>'+
										// '<p>'+currentUserName+'</p>'+
										'</div>'+
										'</div>'+
										'<div class="row"  style=" font-size: 12px; padding-left: 30px; ">'+
										'<div class="row">'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 55px;text-decoration: underline;">'+
										'CHỨNG TỪ MANG THEO'+
										'</div>'+
										'<div class="" style="padding-left: 30px;padding-top: 5px; ">'+res[j+1]['document1']+
										'</div>'+
										'<div class="" style="padding-left: 30px;padding-top: 5px; ">'+res[j+1]['document2']+
										'</div>'+
										'</div>'+
										'<div class="row">'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 55px;"><span style="text-decoration: underline;">DỤNG CỤ MANG THEO</span>&nbsp;&nbsp;&nbsp; '+
										'</div>'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 30px;padding-top: 5px; ">'+res[j+1]['tools1']+
										'</div>'+
										'<div class="col-md-12 col-xs-12" style="padding-left: 30px;padding-top: 5px; ">'+res[j+1]['tools2']+
										'</div>'+
										'</div>'+
										'</div>'+
										'<div class="row"  style="padding-left: 30px; margin-top: 10px;">'+
										'<span style="font-size: 15;text-decoration: underline;font-weight:bold;">CHÚ Ý:</span> <span style="font-size: 12px;">'+res[j+1]['note']+'</span><br>'+
										'<div style="text-align: center; font-size: 13px;">'+
										'TÀI XẾ KHÔNG ĐƯỢC TỰ Ý BẬT BƠM HOẶC MỞ VAN CỦA KHÁCH HÀNG (NƠI XE GIAO HÀNG).KỂ CẢ KHÁCH HÀNG NHỜ '+
										'CŨNG KHÔNG ĐƯỢC <br>'+
										'{{ $nhom1 }} <br>'+
										'{{ $nhom2 }}'+
										'</div>'+
										'</div><br><br>'+
										'</div>'+
										'</div>'+
										'</div>';
										$(".myBody").append(content);

										// ============================ end - append content ==========================
									}
								}
									loadPrint();
								}

							
						}
						if(result.error)
						{
							
						}          
						// console.log(result); 
					}

				});
}

			// ./ get parameter form url 
		});
		//
		function loadPrint() {
			//window.print();
			//setTimeout(function () { window.close(); }, 100);
			 //if($('.container1').length > 0){
			/*	$('.container1').each(function () {
					console.log(this.clientHeight);
					//if(this.clientHeight > 520)
					
				}); */
			/*	for(let e = 0; e< $('.container1').length; e++ ){
					
					//console.log($('.container1')[e]);
					//console.log($('body').height());
					console.log($('.container1')[e].clientHeight );
					if($('.container1')[e].clientHeight > (1122/2)){
						//alert($('.container1')[e].clientHeight );
						$('.container1')[e].setAttribute("style","height:1125px");
						console.log($('.container1')[e]);
					
						if($('.container1')[e+1].clientHeight > (1122/2)){
							$('.container1')[e].setAttribute("style","height:1122px");
						
						}
					}
					
				}
			} */
			window.print();
			setTimeout(function () { window.close(); }, 100);



		}

		
		function getYear(d){
			Y = new Date(d);
			var Y = Y.getFullYear();
			return Y;
		}

		function getMontH(d){
			M = new Date(d);
			var M = M.getMonth();
			return M + 1;
		}

		function getDatE(d){
			D = new Date(d);
			D = D.getDate();
			return D;
		}
</script>
</body>
</html>