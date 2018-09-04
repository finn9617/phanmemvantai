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
	@media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
	}
	@page {
		size: A4;
		margin: 0;
		padding:0;
		
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
		$currentUser_type =$users[0]->user_type;
    
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
			console.log(id);
			if(id.length > 0){
				// var info = {};
				var info = {};
				$.each($('form').serializeArray(),function(){
					info[this.name] = this.value;
				});
				info['id'] = id;
				$.ajax('{{url("/getListPrintPool")}}', {
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
							if(res.length){
								for(var j=0; j < res.length; j++){
									var breakLine="";
									if(j %2 !=0){
										breakLine = '-------------------------------------------------------------------------------------------------------------------------------------------------------------------';
									}
									// ============================ append content ===============================
									var content = '<div class="container1"  style="height:50%; padding-top:15px;" >'+breakLine+
											'<div class="mycontent">'+
									'<div class="row">'+
									'<div class="col-md-6 col-xs-6" style="text-align: center; padding-top:20px;">'+
									'<span style="font-size:16px; font-weight: bold; ">CTY TNHH TM VẬN TẢI </span>	<br>'+
									'<span style="font-size:16px; font-weight: bold; ">QUỐC HUY</span> <br>'+
									'08.39610305 == 0989007669'+
									'</div>'+
									'<div class="col-md-6 col-xs-6" style="text-align: left; ">'+
									'<br>'+
									'<span style="font-size:25px; font-weight: bold; ">LỆNH LẤY HÀNG </span>'+
									'</div>'+
									'</div>'+
									'<div class="row" style=" font-size: 20px; margin-top: 15px; padding-left: 30px; padding-right: 20px;">'+
									'<div class="col-md-4 col-xs-4" style="text-align: center;">SỐ XE: '+res[j]['car_num']+'</div>'+
									'<div class="col-md-4 col-xs-4">RƠ-MÓC: '+res[j]['trailer_num']+'</div>'+
									'<div class="col-md-4 col-xs-4" style="text-align: center;">'+res[j]['departure_time']+'</div>'+		
									'</div>'+
									'<div class="row"  style=" font-size: 12px;  margin-top: 15px; padding-left: 30px; ">'+
									'<div class="col-md-3 col-xs-3">LOẠI HÀNG: </div>'+
									'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j]['goods_name']+'</div>'+
									'<div class="col-md-3 col-xs-3">SỐ LƯỢNG:</div>'+
									'<div class="col-md-3 col-xs-3">'+res[j]['num']+'</div>'+		
									'</div>'+
									'<div class="row"  style=" font-size: 12px; padding-left: 30px; ">'+
									'<div class="col-md-3 col-xs-3">NƠI NHẬN: </div>'+
									'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j]['receipt_place_name']+'</div>'+	
									'<div class="col-md-3 col-xs-3">TÀI XẾ:</div>'+
									'<div class="col-md-3 col-xs-3">'+res[j]['driver_name']+'</div>'+			
									'</div>'+
									'<div class="row"  style=" font-size: 12px; padding-left: 30px; ">'+
									'<div class="col-md-3 col-xs-3">NƠI GIAO:</div>'+
									'<div class="col-md-3 col-xs-3" style="text-align: center;">'+res[j]['delivery_place_name']+'</div>'+	
									'<div class="col-md-3 col-xs-3">LƠ XE:</div>'+
									'<div class="col-md-3 col-xs-3">'+res[j]['assistant_driver_name']+'</div>'+			
									'</div>'+
									'<div class="row" style=" font-size: 20px; margin-top: 7px; margin-bottom: 7px; padding-left: 30px; padding-right: 20px;">'+
									'<div class="col-md-3 col-xs-3">CHỦ HÀNG</div>'+
									'<div class="col-md-9 col-xs-9">'+res[j]['owner_name']+'</div>'+
									'</div>'+
									'<div class="row"  style=" font-size: 12px; padding-left: 30px; ">'+
									'<div class="col-md-6 col-xs-6">'+
									'<div class="row">'+
									'<div class="col-md-12 col-xs-12" style=" text-align: center; text-decoration: underline;">'+
									'CHỨNG TỪ MANG VỀ'+
									'</div>'+
									'<div class="col-md-12 col-xs-12">'+
									'*PHIẾU CẦN KHO <br>'+
									'*PHIẾU CẦN KHO KHÁCH <br>'+
									'*BIÊN BẢN GIAO HÀNG <br>'+
									'</div>'+
									'</div>'+
									'<div class="row">'+
									'<div class="col-md-12 col-xs-12" style=" text-align: center; text-decoration: underline;">'+
									'CHỨNG TỪ MANG THEO'+
									'</div>'+
									'<div class="col-md-12 col-xs-12">'+res[j]['document1']+
									'  <br>'+res[j]['document2']+
									'<br>'+
									'</div>'+
									'</div>'+
									'<div class="row">'+
									'<div class="col-md-12 col-xs-12" style=" text-align: center; text-decoration: underline;">'+
									'DỤNG CỤ MANG THEO'+
									'</div>'+
									'<div class="col-md-12 col-xs-12">'+res[j]['tools1']+
									'<br>'+res[j]['tools2']+
									'<br>'+
									'</div>'+
									'</div>'+
									'</div>'+
									'<div class="col-md-6 col-xs-6" style="text-align: center;">'+
									'<p>NGÀY '+currentDate+' THÁNG '+currentMonth+' NĂM '+currentYear+'</p>'+
									'<p>NGƯỜI LẬP</p>'+
									'<br><br><br>'+
									'<p>'+currentUserName+'</p>'+
									'</div>'+
									'</div>'+
									'<div class="row"  style="  padding-left: 30px; margin-top: 10px;">'+
									'<span style="font-size: 15">CHÚ Ý:</span> <span style="font-size: 11px;">'+res[j]['note']+'</span><br>'+
									'<div style="text-align: center; font-size: 11px;">'+
									'TÀI XẾ KHÔNG ĐƯỢC TỰ Ý BẬT BƠM HOẶC MỞ VAN CỦA KHÁCH HÀNG (NƠI XE GIAO HÀNG).KỂ CẢ KHÁCH HÀNG NHỜ'+
									'CŨNG KHÔNG ĐƯỢC <br>'+
									'*NHÓM 1 : HÙNG : TRƯỞNG NHÓM - THẢO 0963540022 - HÙNG 0909454368 <br>'+
									'*NHÓM 2 : THÚY : TRƯỞNG NHÓM - TRÂM 0932146268 - THƯƠNG 0906963563'+
									'</div>'+
									'</div>'+
									'</div>'+
									'</div>';
									$(".myBody").append(content);

									// ============================ end - append content ==========================
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
</script>
</body>
</html>