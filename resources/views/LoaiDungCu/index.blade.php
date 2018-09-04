@extends('blank') 
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('loaidungcu') }}</div>
	</div>
</section>
<section class="content">
	<div class="box box-primary">
		<div class="box-header">
			<form class="form-inline text-center" id="searchloaidungcu">
				<div class="form-group" style="margin-right: 20px;">
					<select class="form-control select2 " name="bodungcu"  data-placeholder="-- Chọn bộ dụng cụ --" style="width: 200px;">
							<option value=""></option>
							@foreach ($search_bodungcu as $item)
								<option value="{{ $item->tool_type }}" @if(request()->get('bodungcu') == $item->tool_type) selected @endif >
									Bộ dụng cụ {{ $item->tool_type }}
								</option>
							@endforeach
					</select>
				</div>
				<div class="form-group" style="margin-right: 20px;">
					<select class="form-control select2" name="loaidungcu" id="loaidungcuselect" data-placeholder="-- Chọn loại dụng cụ --" style="width: 200px">
							<option value=""></option>
							@foreach ($search_loaidungcu as $item)
								<option @if(request()->get('loaidungcu') == $item->name) selected @endif >
									{{ $item->name }}
								</option>
							@endforeach
					</select>
				</div>
				<div class="form-group">
					<button class="btn btn-success"><i class="fa fa-search"></i> Tìm kiếm</button>
					<a href="{{ route('LoaiDungCu') }}" class="btn btn-success"><i class="fa fa-search"></i> Tất cả</a>
				</div>

			</form>
			<a href="{{ route('ThemLoaiDungCu') }}" class="btn btn-success"><i class="fa fa-plus"></i> Thêm mới</a>
		</div>
		<div class="box-body">
			<table id="loaidungcu" class="table table-bordered  dataTable table-hover" role="grid">
				<thead style="background-color: #3C8DBC; color: #FFFFFF">
					<tr role="row">
						<th style="width: 10px;" class="sorting">STT</th>
						<th class="sorting">Bộ dụng cụ</th>
						<th class="sorting">Loại dụng cụ</th>
						<th class="sorting">Ghi chú</th>
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
					@foreach ($loaidc as $item)
					<tr>
						<td>{{ $loop->index + 1 }}</td>
						<td>@if($item->tool_type == 1) Bộ dụng cụ 1 @else Bộ dụng cụ 2 @endif</td>
						<td>{{ $item->name }}</td>
						<td>{{ $item->note }}</td>
						<td>
							<a class="edit" title="Sửa" href="{{ route('SuaLoaiDungCu', $item->tool_category_id)}}"><i class="glyphicon glyphicon-edit"></i></a> &nbsp;&nbsp;
							<a class="delete" href="#" onclick="btnDelete({{ $item->tool_category_id }}); return false" title="Xóa"><i class="glyphicon glyphicon-trash"></i></a>
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
					$('#searchloaidungcu').submit();
				}
			}
		 });
	})
	$(function () {
		$('#loaidungcu').DataTable( {
			"bLengthChange": false,
			'searching'   : false,
			"bInfo": false,
			"bStateSave": true,
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
			url:"/loaidungcu/searchloai",
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
							$("#loaidungcuselect option[value!='']").each(function() {
								$(this).remove();
								});
							addOptionSelectBox('#loaidungcuselect',data.search,'name','name');
						}else {
							$("#loaidungcuselect option[value!='']").each(function() {
								$(this).remove();
								});
							var dataselect = arrFilter($(".select2:first option:selected").val(),data.search,'tool_type');
							addOptionSelectBox('#loaidungcuselect',dataselect,'name','name');
						}
					})
					if($('.select2:first :selected').val() != '') {
						$("#loaidungcuselect option[value!='']").each(function() {
							$(this).remove();
						});
						var dataselect = arrFilter($(".select2:first option:selected").val(),data.search,'tool_type');
						addOptionSelectBox('#loaidungcuselect',dataselect,'name','name');
						if($('#loaidungcu tbody tr').length > 1) {
							$('#loaidungcuselect').select2().val(null).trigger("change");
							$('#loaidungcuselect').select2({
								allowClear: true
							});
							//$('#loaidungcuselect').select2("clear");
						}else {
							var textslect =$('#loaidungcu tr td:nth(2)').text()
							$.each($('#loaidungcuselect option'), function( index, value ) {
								if($(this).val() == textslect) {
									$(this).attr('selected','selected')
								}
							});
						}
					}
				}
			}
		});
	});
	function btnDelete($id){
		swal({
			title: "Bạn có muốn xóa loại dụng cụ này?",
			text: "Loại dụng cụ đã xóa sẽ không thể phục hồi!",
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
					url : "{{ route('DeleteLoaiDungCu') }}",
					data: {
						'_token': "{{ csrf_token() }}",
						'id': $id,
					},
					success : function(data)
					{
						if(data.success){
							swal({
								title: "Đã xóa xong",
								icon: "success",
								button: "OK",
								timer: 1500
							}).then(function(){
								window.location = "{{ route('LoaiDungCu') }}";
							});
						}
						if(data.errors){
							swal({
								title: "Loại dụng cụ này đang được sử dụng.",
								icon: "warning",
								button: "OK"
							})
						}
						
					}

				});
			}
		});
	}
</script>
@endsection