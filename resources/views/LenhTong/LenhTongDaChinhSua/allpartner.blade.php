@extends('blank') 
@section('content')
<link rel="stylesheet" href="{{ asset('css/allpartner.css') }}">
@php
	if(!session()->has('email')){
		echo "Chưa đăng nhập";
		exit();
  	}
	$currentUser = null;
	if(session()->has('email'))
	{
		$tmpemail = Session::get('email');
		$sess_email = end($tmpemail);
		$sess_users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $sess_email)->get();
		$currentUser_type =$sess_users[0]->user_type;
		
	}
@endphp
<section class="content-header">
	<div class="row">
		<div class="col-md-12 titleDieuXe">Bảng kê</div>
	</div>
</section>
<section class="content">
	<div class="box box-primary">
		<div class="box-header">
			<form action="/accountant" method="GET" id="searchForm">
				<meta name="csrf-token" content="VwGIhD8HVc121HLfULhHvkfQZS4tKlxtPTpKFYzC">
				<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Từ ngày</label>
							<div class="input-group date">
								<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								<input class="form-control" id="datepicker13" placeholder="Từ ngày" name="dateStart" value="" type="date" style="width:65%;">
							</div>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label">Đến ngày</label>
							<div class="input-group date">
								<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								<input class="form-control" id="datepicker13" placeholder="Đến ngày" name="dateEnd" value="" type="date" style="width:65%;">
							</div>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<select class="form-control select2" name="partner" id="partner" data-placeholder="-- Chọn chủ hàng --" style="width:80%;">
							  <option></option>
							  @foreach ($select as $item)
							  	<option>{{ $item->partner_name }}</option>
							  @endforeach
							</select>
						</div>
					</div>
					<style>
						.dropdown {
							position: relative;
							display: inline-block;
							vertical-align: middle;
						}
					</style>
					<div class="col-md-3">
						<!-- <div class="dropdown"> -->
						<div class="form-group ">
							<a href="#" class="btn btn-success" id="addsearch"><i class="glyphicon glyphicon-plus"></i></a>
							<button type="submit" class="btn btn-success" style="height: 32px"><i class="fa fa-search"></i>&nbsp;&nbsp;Tìm kiếm</button>
						</div>
					</div>
				</div>
				<div class="row row-search">
				</div>
			</form>
		</div>
		<div class="box-body">
				<div class="row" style="margin-bottom: 20px;">
					<div class="col-md-12">
						<button class="btn btn-success pull-right" style="margin-left: 30px;"><i class="fa fa-check"></i>&nbsp;&nbsp;In lệnh</button>
						<button class="btn btn-success pull-right" style="margin-right: 30px;"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Xuất Excel</button>
					</div>
				</div>
				<div class="table-responsive">
					<table id="allpartner" class="table">
						<thead>
							<tr role="row">
								<th style="min-width: 10px;" rowspan="2" class="dieuphoi">STT</th>
								<th class="cb dieuphoi" style="min-width: 43px;" rowspan="2">
									<label class="container-header">
										<!-- <input type="checkbox">  -->
										<input type="checkbox" id="checkall">
										<span class="checkmark1"></span>
									</label>
								</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Người phụ trách</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Ngày</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Số xe</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Số mọc
								</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">ML Giao hàng
								</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Loại hàng
								</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Nơi nhận
								</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Nơi giao
								</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Chủ hàng
								</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Tài xe
								</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Lơ</th>
								<th style="min-width: 150px;" rowspan="2" class="dieuphoi">Số lượng</th>
								
								{{-- ĐIỀU PHỐI --}}
								 @if($currentUser_type == 1 || $currentUser_type == 2 || $currentUser_type == 3)
								<th style="min-width: 150px;" rowspan="2" class="bangke">Người nhập
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">Tháng xuất hóa đơn khách hàng
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">SL Nhận
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">SL Nhận Phuy
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">SL Giao
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">SL Giao Phuy
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">Số KG PHUY
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">HH Thực tế
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">HH Định mức
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">Chênh lệch
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">Tiền cân
								</th>
								<th style="min-width: 300px;" colspan="2" class="bangke">
									CHI DÙM KHÁCH HÀNG
								</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">Giá</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">Gối đầu</th>
								<th style="min-width: 150px;" rowspan="2" class="bangke">Ghi chú</th>
								@endif 
								{{-- ĐIỀU PHỐI --}} 
			
								{{-- CHI PHÍ --}} 
								@if($currentUser_type == 1 || $currentUser_type == 4)
								<th style="min-width: 150px;" rowspan="2" class="chiphi">Đầu ngày</th>
								<th style="min-width: 150px;" rowspan="2" class="chiphi">Ứng</th>
								<th style="min-width: 300px;" colspan="2" class="chiphi">
									VÉ CẦU ĐƯỜNG
								</th>
								<th style="min-width: 150px;" class="chiphi">Tổng tiền</th>
								<th style="min-width: 150px;" rowspan="2" class="chiphi">Xịt bồn (Rửa xe)</th>
								<th style="min-width: 150px;" rowspan="2" class="chiphi">Vá vỏ</th>
								<th style="min-width: 150px;" rowspan="2" class="chiphi">Người duyệt</th>
								<th style="min-width: 300px;" colspan="2" class="chiphi">
									BỒI DƯỠNG, BƠM HÀNG
								</th>
								<th style="min-width: 150px;" class="chiphi">Tổng tiền</th>
								<th style="min-width: 150px;" rowspan="2" class="chiphi">Người duyệt</th>
								<th style="min-width: 300px;" colspan="2" class="chiphi">
									CHI HỘ
								</th>
								<th style="min-width: 150px;" class="chiphi">Tổng tiền</th>
								<th style="min-width: 300px;" colspan="2" class="chiphi">
									CÁC TRẠM
								</th>
								<th style="min-width: 150px;" class="chiphi">Tổng tiền</th>
								<th style="min-width: 150px;" rowspan="2" class="chiphi">Cơm Tài
								</th>
								<th style="min-width: 150px;" rowspan="2" class="chiphi">Cơm Lơ
								</th>
								<th style="min-width: 150px;" rowspan="2" class="chiphi">Đổ Dầu ngoài
								</th>
								<th style="min-width: 300px;" colspan="2" class="chiphi">
									CHI KHÁC
								</th>
								<th style="min-width: 150px;" class="chiphi">Tổng tiền</th>
								<th style="min-width: 150px;" rowspan="2" class="chiphi">TỔNG CHI
								</th>
								<th style="min-width: 150px;" rowspan="2" class="chiphi">CUỐI NGÀY
								</th>
								<th style="min-width: 300px;" rowspan="2" class="chiphi">GHI CHÚ
								</th>
								@endif {{-- CHI PHÍ --}} {{-- LƯƠNG --}} @if($currentUser_type == 1 || $currentUser_type == 5)
								<th style="min-width: 150px;" rowspan="2" class="luong">SỐ LƯỢNG QUY ĐỔI
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">MÃ NHÓM SỐ LƯỢNG
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">TÀI XẾ
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">LƠ
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">CỰ LY
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">SỐ KM
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">MÃ TÍNH LƯƠNG
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">LƯƠNG TÀI
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">LƯƠNG LƠ
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">CƠM TÀI
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">CƠM LƠ
								</th>
								<th style="min-width: 300px;" rowspan="2" class="luong">NƠI NHẬN ĐẾN NƠI GIAO
								</th>
								<th style="min-width: 150px;" rowspan="2" class="luong">NGHỈ PHÉP
								</th>
								@endif {{-- LƯƠNG --}}
								<th style="min-width: 150px;" rowspan="2" class="bangke">Chức năng</th>
							</tr>
							<tr>
								@if($currentUser_type == 1 || $currentUser_type == 2 || $currentUser_type == 3) {{-- ĐIỀU PHỐI --}}
								<th class="bangke">Diễn giải</th>
								<th class="bangke">Số tiền</th>
								@endif @if($currentUser_type == 1 || $currentUser_type == 4) {{-- LƯƠNG --}}
								<th class="chiphi">Diễn giải</th>
								<th class="chiphi">Số tiền</th>
								<th class="chiphi">Tổng tiền</th>
			
								<th class="chiphi">Diễn giải</th>
								<th class="chiphi">Số tiền</th>
								<th class="chiphi">Tổng tiền</th>
			
								<th class="chiphi">Diễn giải</th>
								<th class="chiphi">Số tiền</th>
								<th class="chiphi">Tổng tiền</th>
			
								<th class="chiphi">Diễn giải</th>
								<th class="chiphi">Số tiền</th>
								<th class="chiphi">Tổng tiền</th>
			
								<th class="chiphi">Diễn giải</th>
								<th class="chiphi">Số tiền</th>
								<th class="chiphi">Tổng tiền</th>
								@endif
							</tr>
						</thead>
						<tbody style="border: none;" class="index">
							@foreach($allpartner as $value)
							<tr pool-id='{{ $value->pool_id }}'>
								<td>{{ $loop->index + 1 }}</td>
								<td>
									<label class="container-header">
										<!-- <input type="checkbox">  -->
										<input type="checkbox" id="checkall">
										<span class="checkmark1"></span>
									</label>
								</td>
								<td>{{ $value->curator_nick_name }}</td>
								<td>{{ $value->operating_date }}</td>
								<td>{{ $value->car_num }}</td>
								<td>{{ $value->trailer_num }}</td>
								<td></td>
								<td>{{ $value->goods_name }}</td>
								<td>{{ $value->receipt_name }}</td>
								<td>{{ $value->partner_short_name }}</td>
								<td>{{ $value->delivery_name }}</td>
								<td>{{ $value->driver_nick_name }}</td>
								<td>{{ $value->assistant_nick_name }}</td>
								<td>{{ $value->num }}</td>
								<td contenteditable="true" class="nguoinhap" name="user_enter">{{ $value->user_enter }}</td>
								<td contenteditable="true" class="thangxuathd" name="month_bill">{{ $value->month_bill }}</td>
								<td contenteditable="true" class="slnhan" name="amount_received">{{ $value->amount_received }}</td>
								<td contenteditable="true" class="slnhanphuy" name="amount_received_phuy">{{ $value->amount_received_phuy }}</td>
								<td contenteditable="true" class="slgiao" name="amount_delivery">{{ $value->amount_delivery }}</td>
								<td contenteditable="true" class="slgiaophuy" name="amount_delivery_phuy">{{ $value->amount_delivery_phuy }}</td>
								<td contenteditable="true" class="sokgphuy" name="price_in_kg">{{ $value->price_in_kg }}</td>
								<td contenteditable="true" class="hhthucte" name="standard_loss">{{ $value->standard_loss }}</td>
								<td contenteditable="true" class="hhdinhmuc" name="actual_loss">{{ $value->actual_loss }}</td>
								<td contenteditable="true" class="chenhlech" name="diff">{{ $value->diff }}</td>
								<td contenteditable="true" class="tiencan" name="weight">{{ $value->weight }}</td>
								<td contenteditable="true" class="chidiengiai" name="explain_accountant">{{ $value->explain_accountant }}</td>
								<td contenteditable="true" class="chisotien" name="money_accountant">{{ $value->money_accountant }}</td>
								<td contenteditable="true" class="gia" name="price_accountant">{{ $value->price_accountant }}</td>
								<td contenteditable="true" class="goidau" name="debt">{{ $value->debt }}</td>
								<td contenteditable="true" class="ghichu" name="note_accountant">{{ $value->note_accountant }}</td>
								<td><a class="delete" href="#" onclick="btnDelete('244')" title="Lưu"><i class="glyphicon glyphicon-check"></i></a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
	</div>
</section>
<script src="{{ asset('js/autonumeric.js') }}"></script>
<script>
	$(function () {$('.select2').select2({allowClear: true})});
	// tabindex
	var tabindex = $("[contenteditable]");
	$.each(tabindex, function(key, value){
		$(this).attr('tabindex', key+1);
	});
	// tabindex
	$('.slnhan, .slgiao, .sokgphuy, .hhthucte, .hhdinhmuc, .chenhlech').each(function(){
		new AutoNumeric($(this).get(0), {
			suffixText : ' KG',
			digitGroupSeparator        : '.',
			decimalCharacter           : ',',
			decimalCharacterAlternative: '.',
			decimalPlaces: '0',
			emptyInputBehavior: 'null',
			minimumValue: '1',
			
		});
	});
	$('.slnhanphuy, .slgiaophuy').each(function(){
		new AutoNumeric($(this).get(0), {
			suffixText : ' PHUY',
			digitGroupSeparator        : '.',
			decimalCharacter           : ',',
			decimalCharacterAlternative: '.',
			decimalPlaces: '0',
			emptyInputBehavior: 'null',
			minimumValue: '1',
		});
	});
	$('.tiencan, .gia').each(function(){
		new AutoNumeric($(this).get(0), {
			suffixText : ' VNĐ',
			digitGroupSeparator        : '.',
			decimalCharacter           : ',',
			decimalCharacterAlternative: '.',
			decimalPlaces: '0',
			emptyInputBehavior: 'null',
			minimumValue: '1',
		});
	});
	//đổi màu chữ và màu nền
	var allpartner = {!! json_encode($allpartner) !!};
	$("td").focus(function(){
		$(this).parent('tr').css('background','#c7e2f9');
	})
	.blur(function(){
		let val = $(this).text(),
			id = $(this).parent('tr').attr('pool-id'),
			name = $(this).attr('name'),
			input = allpartner.find(data => data.pool_id == id)[name];
			val = val.replace(" KG", "");
			val = val.replace(" PHUY", "");
			val = val.replace(" VNĐ", "");
		if(input === null) {
			input = '';
		}
		if(input != val) {
			$(this).parent('tr').css({'background':'bisque'});
			$(this).css({'color':'red'});
			if(this.className == 'slnhanphuy') {
				$(this).prev().val(123);
			}
		}else if(input == val) {
			let count = null;
			$.each($(this).siblings(), function(index, value) {
				if(this.style[0] == 'color') {count=1;return false;}
			});
			if(count == 1) {
				$(this).parent('tr').css({'background':'bisque'});
				$(this).removeAttr('style');
			}else {
				$(this).parent('tr').css({'background':'white'});
				$(this).removeAttr('style');
			}
		}
	});
	// đổi màu chữ và màu nền
	
</script>
{{--  DANH MỤC TÌM 1,2,3  --}}
<script>
	function convertDate(dateString){
		var p = dateString.split(/\D/g)
		return [p[2],p[1],p[0]].join("-")
	}
	function SearchOld(stt, search, ContentSearch) {
		var searchF = getParameterByName(search);
		var contentSearchF = getParameterByName(ContentSearch);
		var searchOP = '.search[name='+search+'] option';
		var insearch = '.inputsearch'+stt;
		$('#addsearch').click();
		if(searchF && contentSearchF ) {
			$(searchOP).each(function() {
				if($( this).val() == searchF) {
					$( this).prop('selected', true).change();
					$(insearch).val(contentSearchF);
				}
			});
		}
	}
	function DateSet(Value,Input) {
		var today = new Date(Value);
		var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10){ dd='0'+dd; } 
		if(mm<10){ mm='0'+mm; } 
		var today = yyyy+'-'+mm+'-'+dd;
		var InputSet = 'input[name="'+Input+'"]';
		$(InputSet).val(today);
	}
	function getParameterByName(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, '\\$&');
		var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
			results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, ' '));
	}
	$(document).on('click','.remove-btn', function(){
		$(this).parents('.form-group').remove();
		$('.row-search label.danhmuc').each(function(index) {
			$(this).text('Danh mục tìm '+(index+1)+':');
		});
		$('.row-search .search-left').each(function(index){
			$(this).attr('name','search'+(index+1))
		})
		$('.row-search .search-right').each(function(index){
			$(this).attr('name','ContentSearch'+(index+1))
		})
	});
	$('#addsearch').on('click', function(){
		if($('.row-search > .form-group').length < 3 ) {
			let stt = $('.row-search > .form-group').length + 1;
			$('.row-search ').append(`
				<div class="form-group row">
					<div class="col-md-12">
						<div class="col-sm-1"></div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label danhmuc">Danh mục tìm `+stt+` :</label>
								<div class="col-md-8">
									<select class="form-control select2 search search-left" name ="search`+stt+`" stt="`+stt+`" data-placeholder="-- Chọn danh mục --">
										<option value=""></option>
										<option value="search_car">Số xe</option>
										<option value="search_goods">Loại hàng</option>
										<option value="search_receipt">Nơi nhận</option>
										<option value="search_delivery">Nơi giao</option>
										<option value="search_owner">Chủ hàng</option>
										<option value="search_num" data-s="input">Số lượng</option>
										<option value="search_driver">Tài xế</option>
										<option value="search_assistant_driver">Phụ xe (lơ)</option>
										<option value="search_departure_time" data-s="input">Giờ đi</option>
										<option value="search_clear">Xịt bồn</option>
										<option value="search_trailer">RoMooc</option>
										<option value="search_document1" data-s="input">Chứng từ 1</option>
										<option value="search_document2" data-s="input">Chứng từ 2</option>
										<option value="search_tool1">Dụng cụ 1</option>
										<option value="search_tool2">Dụng cụ 2</option>
										<option value="search_note"data-s="input">Ghi chú</option>
										<option value="search_curator">Người phụ trách</option>
										<option value="search_ordershow" data-s="input">Vị trí</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label">Nội dung tìm :</label>
								<div class="col-md-8">
									<input type="text" class="form-control inputsearch`+stt+` search-right" name="ContentSearch`+stt+`">
								</div>
							</div>
						</div>
					<div class="col-md-1"><a href="#" class="btn btn-danger remove-btn"><i class="glyphicon glyphicon-remove"></i></a></div>
					</div>
				</div>
			`);
			$('.select2').select2({allowClear: true});
		}
	});
	if( window.location.href.indexOf('search?') >= 0){
		var dateStart = getParameterByName('dateStart');
		var dateEnd = getParameterByName('dateEnd');
		var status = getParameterByName('status');
		var search1 = getParameterByName('search1');
		var ContentSearch1 = getParameterByName('ContentSearch1');
		var search2 = getParameterByName('search2');
		var ContentSearch2 = getParameterByName('ContentSearch2');
		var search3 = getParameterByName('search3');
		var ContentSearch3 = getParameterByName('ContentSearch3');
		if(dateEnd) {DateSet(dateEnd,'dateEnd')}
		if(dateStart) {DateSet(dateStart,'dateStart')}
		if(status){
			$('.select2[name=status] option').each(function(){
				if($( this).val() == status) {
					$( this).attr('selected', 'selected')
				}
			});
		}
		if((search1 && ContentSearch1) && (search2 && ContentSearch2) && (search3 && ContentSearch3) ) {
			SearchOld('1','search1','ContentSearch1');
			SearchOld('2','search2','ContentSearch2');
			SearchOld('3','search3','ContentSearch3');
		}
		if((search1 && ContentSearch1) && !(search2 && ContentSearch2) && !(search3 && ContentSearch3) ) {
			SearchOld('1','search1','ContentSearch1');
		}
		if((search1 && ContentSearch1) && !(search2 && ContentSearch2) && (search3 && ContentSearch3) ) {
			SearchOld('1','search1','ContentSearch1');
			SearchOld('2','search2','ContentSearch2');
			SearchOld('3','search3','ContentSearch3');
		}
		if((search1 && ContentSearch1) && (search2 && ContentSearch2) && !(search3 && ContentSearch3) ) {
			SearchOld('1','search1','ContentSearch1');
			SearchOld('2','search2','ContentSearch2');
		}
		if(!(search1 && ContentSearch1) && !(search2 && ContentSearch2) && (search3 && ContentSearch3) ) {
			SearchOld('1','search1','ContentSearch1');
			SearchOld('2','search2','ContentSearch2');
			SearchOld('3','search3','ContentSearch3');
		}
		if(!(search1 && ContentSearch1) && (search2 && ContentSearch2) && !(search3 && ContentSearch3) ) {
			SearchOld('1','search1','ContentSearch1');
			SearchOld('2','search2','ContentSearch2');
			SearchOld('3','search3','ContentSearch3');
		}
  }
  
  function setDate(value){
    var date = new Date();
    date.setDate(date.getDate() + value);
    DateSet(date,'dateStart');
    DateSet(date,'dateEnd');
    $("#searchForm").submit();
  }

  function btnReload(){
    window.location = "{{ route('operating') }}";
  }
  $(document).on('keyup', function(e) {
	if(e.keyCode === 13)  {
		if($('.select2').val() || $('input[name="dateStart"]') || $('input[name="dateEnd"]')){
			$('#searchForm').submit();
		}
	}
});
</script>
@endsection