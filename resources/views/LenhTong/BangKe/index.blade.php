@extends('blank') 
@section('content')
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
<style>
	body {
		padding-right: 0 !important;
	}

	tbody td span {
		cursor: pointer;
	}

	.data_hover {
		display: none;
	}

	.table-responsive table thead tr th,
	.table-responsive table tbody tr td {
		vertical-align: middle !important;
		text-align: center !important;
	}

	tbody td span {
		cursor: pointer;
	}
	.table th {
		text-transform: uppercase;
	}
	.dieuphoi {
		background: #008080;
		color: #FFFFFF
	}
	.bangke {
		background: #3C8DBC;
		color: #FFFFFF;
	}
	.chiphi {
		background: #dd9052;
		color: #FFFFFF;
	}
	.luong {
		background: #8359a3;
		color: #FFFFFF;
	}
</style>
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
		@if(request()->get('partner'))
			@include('LenhTong.BangKe.partner')
		@endif
	</div>
</section>
<script>
	function showNotify(place, msg, type, position) {
		$.notify.defaults({ className: type });
		$(place).notify(
		  msg,
		  { position: position }
		);
	} 
	$('.tailenhtong tbody td > span').on('mouseover', function() {
		let pos = $(this).prev().attr('id');
		let msg = $(this).children().html().trim();
		showNotify('#'+pos, msg, "info", "top");
	})
	$(document).on('mouseover', '#lenhtong tbody td > span', function() {
		let pos = $(this).prev().attr('id');
		let msg = $(this).children().html().trim();
		showNotify('#'+pos, msg, "info", "top");
	})
	function CLOSE() {
		$('.notifyjs-wrapper').trigger('notify-hide');
	}
</script>
<script>
	$(function () {
		$('.select2').select2(
			{
				allowClear: true
			}
		)
  	})
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
<script>
	var inValue = null;
	var firstValue = null;
	var count = 0;
	$("td").focus(function(){
		inValue = $(this).text();
		if(count == 0 ) {
			firstValue = $(this).text();
			count++;
		}
	})
	.blur(function(){
		var outValue = $(this).text();
		console.log(firstValue)
		console.log(outValue)
		
	});
	
</script>
@endsection