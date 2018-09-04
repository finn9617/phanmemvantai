@extends('blank') 
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('dungcu') }}</div>
	</div>
</section>
<section class="content">
	<div class="box box-primary">
		<div class="box-header">
			<form class="form-inline" id="searchdungcu">
					<div class="col-md-2">
					</div>
					<div class="col-md-2">
						<select class="col-md-12 select2 " name="loaidungcu" id="loaidungcu" data-placeholder="-- Chọn loại --" >
							<option value=""></option>
							@foreach ($toolsearch as $item)
							<option value="{{ $item->tool_category_id }}" @if(request()->get('loaidungcu') == $item->tool_category_id) selected @endif >
									{{ $item->tool_category_name }}
							</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-2">
						<select class="col-md-12 select2" name="tendungcu" id="tendungcu" data-placeholder="-- Chọn dụng cụ --" >
							<option value=""></option>
							@foreach ($toolsearchloai as $item)
							<option @if(request()->get('tendungcu') == $item->tool_id) selected @endif value="{{$item->tool_id}}" >
									{{ $item->name }}
							</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-md-2">
						<input type="text" class="form-control" value="" id="txtGhichu" style="width:100%;" placeholder="Thông tin ...  " name="txtGhichu">
					</div>
					<button class="btn btn-success"><i class="fa fa-search" style="margin-left:1%"></i> Tìm kiếm</button>
					<a href="{{ route('DungCu') }}" class="btn btn-success"><i class="fa fa-search"></i> Tất cả</a>

			</form>
		</div>
		<a href="{{ route('ThemDungCu') }}" class="btn btn-success" style="margin-left:15px;"><i class="fa fa-plus"></i> Thêm mới</a>
		<div class="box-body">
			<table id="dungcu" class="table table-bordered  dataTable table-hover" role="grid">
				<thead style="background-color: #3C8DBC; color: #FFFFFF">
					<tr role="row">
						<th style="width: 10px;" class="sorting">STT</th>
						<th class="sorting">Bộ</th>
						<th class="sorting">Tên loại</th>
						<th class="sorting" style="width:250px">Tên dụng cụ</th>
						<th class="sorting">Số lượng</th>
						<th class="sorting" >Thông tin</th>
						<th style="width: 80px; text-align: center" class="sorting">Chức năng</th>
					</tr>
				</thead>
				<style type="text/css">
					tbody:nth-child(odd) {
						background: #E9F6FC;
					}

					tr.even {
						background: #FFFFFF;
					}
				</style>
				<tbody>
					@foreach ($tool as $item)
					<tr>
						<td>{{ $loop->index + 1 }}</td>
						<td>@if($item->tool_type == 1) Bộ dụng cụ 1 @else Bộ dụng cụ 2 @endif</td>
						<td>{{ $item->tool_category_name }}</td>
						<td>{{ $item->name }}</td>
						<td>{{ $item->num }}</td>
						<td>{{ $item->infomation }}</td>
						<td>
							<a class="edit" title="Sửa" href="{{ route('SuaDungCu', $item->tool_id)}}"><i class="glyphicon glyphicon-edit"></i></a> &nbsp;&nbsp;
							<a class="delete" href="#" onclick="btnDelete({{ $item->tool_id }}); return false" title="Xóa"><i class="glyphicon glyphicon-trash"></i></a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</section>
<script>
	$(function () {
		$('.select2').select2(
			{
				allowClear: true
				}
			)
		$(document).on('keyup', function(e) {
			if(e.keyCode === 13)  {
				if($('.select2').val()){
					$('#searchdungcu').submit();
				}
			}
		});
	})
	$(function () {
		$('#dungcu').DataTable( {
			// "bLengthChange": false,
			'searching'   : false,
			"bStateSave": true, // presumably saves state for reloads
			// "bInfo": false,
		});
	})
	// function lọc mảng con
	// duyệt mảng cha lọc ra mảng con theo điều kiện
	//value = id loOẠI cần lấy ra 1
	// arr : mảng tất cả các xe
	// filterCol : trường trong mảng xe cần so sánh
	// 
	function arrFilter(value, arr, filterCol){
		var chilArrayFilter =[];
		if(arr.length == 0)
		return undefined;
		if(arr.length == 1){
		if(arr[0][filterCol] == value){
			chilArrayFilter.push(arr[0]);
		}else{
			return undefined;
		}
		}
		if(arr.length > 1){
		for(var cArrFilter = 0 ; cArrFilter < arr.length; cArrFilter++){
			if(arr[cArrFilter][filterCol] == value){
			chilArrayFilter.push(arr[cArrFilter]);
			}
		}
		}
		if(chilArrayFilter.length == 0)
		return undefined;
		else
		return chilArrayFilter;
		
	}
	// function add option to selectBox
  /*
    select: where add option (.class or id of selectbox)
    options : array[{'value':'Value of option' , 'text': 'text display'}]
    */
    function addOptionSelectBox(select, options, colValue, colText){
		$.each(options, function (i, item) {
			// var lol = ''+colValue;
			// console.log(item[lol]);
			$(select).append($('<option>', { 
			value: item[colValue],
			text :  item[colText]
			}));
		});
	}
	$(document).ready(function(){
		var data = new FormData();
		data.append('search', 'search');
		$.ajax({
			url:"{{ route('SearchDC') }}",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': "{{ csrf_token() }}"
			},
			data: data,
			processData: false,
			contentType: false,
			success: function(data){
				if(data.success){
					$('.select2:first').on('change', function() {
						if($(this).val()==''){
							$("#tendungcu option[value!='']").each(function() {
								$(this).remove();
							});
							addOptionSelectBox('#tendungcu',data.search,'tool_id','name');
						}else {
							$("#tendungcu option[value!='']").each(function() {
								$(this).remove();
							});
							var dataselect = arrFilter($(".select2:first option:selected").val(),data.search,'tool_category_id');
							addOptionSelectBox('#tendungcu',dataselect,'tool_id','name');
						}
					})
					if($('.select2:first :selected').val() != '') {
						$("#tendungcu option[value!='']").each(function() {
							$(this).remove();
						});
						var dataselect = arrFilter($(".select2:first option:selected").val(),data.search,'tool_category_id');
						addOptionSelectBox('#tendungcu',dataselect,'tool_id','name');
						if($('#dungcu tbody tr').length > 1) {
							$('#tendungcu').select2().val(null).trigger("change");
							$('#tendungcu').select2({
								allowClear: true
							});
						}else {
							var textslect =$('#dungcu tr td:nth(3)').text()
							$.each($('#tendungcu option'), function() {
								if($(this).val() == textslect) {
									$(this).attr('selected','selected')
								}
							});
						}
					}
				}
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
				$('#loaidungcu').val(getUrlParameter('loaidungcu'));
				$('#tendungcu').val(getUrlParameter('tendungcu'));
				$('#txtGhichu').val(getUrlParameter('txtGhichu'));
			}
		});
	});
	
	function btnDelete($id){
		swal({
			title: "Bạn có muốn xóa dụng cụ này?",
			text: "Dụng cụ đã xóa sẽ không thể phục hồi!",
			icon: "warning",
			buttons: {
				confirm: 'Có',
				cancel: 'Hủy'
			},
			dangerMode: true,
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					type : "POST",
					url : "{{ route('DeleteDungCu') }}",
					data: {
						'_token': "{{ csrf_token() }}",
						'id': $id,
					},
					success : function(data)
					{
						swal({
							title: "Đã xóa xong",
							icon: "success",
							button: "OK",
							timer: 1500
						}).then(function(){
							window.location = "{{ route('DungCu') }}";
						});;
						
					},
					error : function(jqXHR, textStatus, errorThrown)
					{
						alert('Có lỗi xảy ra trong quá trình xóa');
					}
				});
			}
		});
	}

	
</script>
@endsection