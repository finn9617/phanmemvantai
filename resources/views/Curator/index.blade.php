@extends('blank') 
@section('content') 
<?php
  //Check login
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
  /*Check Auth on view 
	- use lib CheckAuthController::checkAuth($routeName,$method,$currentUser_type)
	- $routeName : Tên route 
	- $method : Tên method của route 
	- $currentUser_type : User hiện đang đăng nhập
  */
?>
	<section class="content-header">
		<div class="row">
			<div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('curator') }}</div>
		</div>
		<!-- ./ title -->
	</section>
	<section class="content">
		<div class="box box-primary">
			<div class="box-body boxPadding">
				<div class="box-header">
					<form class="form-inline text-center" id="searchForm">
						<div class="row well well-lg">
							<div class="form-group col-md-2"></div>
							<div class="form-group col-md-2">
								<!-- <div class="col-md-3"> -->
									<!-- <select class="form-control select2 " name="tendaydu" data-placeholder="-- Chọn tên đầy đủ --" style="width: 200px;">
										<option value=""></option>
										@foreach ($search_tdd as $item)
										<option value="{{ $item->full_name }}" @if(request()->get('tendaydu') == $item->full_name) selected @endif >
												{{ $item->full_name }}
										</option>
										@endforeach
									</select> -->
									<input type="text" class="form-control col-md-3" name="tendaydu" id="tendaydu" placeholder="Nhập tên đầy đủ">
								<!-- </div> -->
							</div>
							<div class="form-group col-md-2">
								<!-- <div class="col-md-3"> -->
									<!-- <select class="form-control select2" name="tendixe" data-placeholder="-- Chọn tên đi xe --" style="width: 200px">
										<option value=""></option>
										@foreach ($search_tdx as $item)
										<option value="{{ $item->nick_name }}" @if(request()->get('tendixe') == $item->nick_name) selected @endif >
												{{ $item->nick_name }}
										</option>
										@endforeach
									</select> -->
									<input type="text" class="form-control col-md-3" name="tendixe" id="tendixe" placeholder="Nhập tên viết tắt">
								<!-- </div> -->
							</div>
							<div class="form-group col-md-2">
								<!-- <div class="col-md-3"> -->
									<input type="text" class="form-control col-md-3" name="txtPhoneNumber" id="txtPhoneNumber" placeholder="Số điện thoại">
								<!-- </div> -->
							</div>
							<div class="form-group col-md-2">
								<!-- <div class="col-md-3"> -->
									<input type="text" class="form-control col-md-3" name="txtIdentityCardNumber" id="txtIdentityCardNumber" placeholder="Số chứng minh">
								<!-- </div> -->
							</div>
						</div>
						<div class="row">
							<div class="col-md-1">
								<div class="form-group">
									<a href="{{ route('AddCuratorGet') }}" class="btn btn-success"><i class="fa fa-plus"></i> Thêm mới</a>
								</div>
							</div>
							<div class="col-md-11" style="text-align: right;">
								<div class="form-group">
									<button class="btn btn-success"><i class="fa fa-search"></i> Tìm kiếm</button>
									<a href="{{ route('AddCurator') }}" class="btn btn-success"><i class="fa fa-search"></i> Tất cả</a>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table id="assistant" class="table dataTable" style="width: 100%">
							<thead style="background-color: #3C8DBC; color: #FFFFFF">
								<tr role="row">
									<th class="sorting" style="width: 10px;">STT</th>
									<th class="sorting">Tên đầy đủ</th>
									<th class="sorting">Tên viết tắt</th>
									<th class="sorting">Năm sinh</th>
									<th class="sorting">Số điện thoại</th>
									<th class="sorting">CMND</th>
									<th class="sorting">Địa chỉ</th>
									<!-- <th class="sorting">Thông tin tài xế</th> -->
									<th class="sorting">Trạng thái</th>
									<th style="width: 80px">Chức năng</th>
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
								@foreach ($assistant as $item)
								<tr>
									<td>{{ $loop->index + 1 }}</td>
									<td>{{ $item->full_name }}</td>
									<td>{{ $item->nick_name }}</td>
									<?php $birthday=date_create($item->birthday)?>
                            		<td>{{date_format($birthday,'d-m-Y')}}</td>
									<!-- <td>{{ $item->birthday }}</td> -->
									<td>{{ $item->phone }}</td>
									<td>{{ $item->identity_id }}</td>
									<td>{{ $item->address }}</td>
									<!-- <td>{{ $item->note }}</td> -->
									<td @if($item->work_status == 1) style="background: red" @endif >
										@if($item->work_status == 0)
											Đang làm 
										@else
											Đã nghĩ làm 
										@endif
									</td>
									<td>
										<a class="edit" title="Sửa" href="{{ route('EditCuratorGet', $item->user_id) }}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
										<a class="delete" href="#" type="button" onclick="btnDelete({{ $item->user_id }})" title="Xóa"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script>
		$(document).keypress(function(e) {
			if(e.which == 13) {
				if(!$('#tendaydu').val() && !$('#tendixe').val()){
					location.reload();
				}
				else{
					search();
				}
			}
		});
		function btnDelete(id){
			swal({
				title: "Xóa phụ xe",
				text: "Bạn có chắc chắn muốn xóa phụ xe này không ?",
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
						url : "{{ route('DeleteCurator') }}",
						data: {
							'_token': "{{ csrf_token() }}",
							'id': id,
						},
						success : function(data)
						{
							swal({
								title: "Đã xóa xong",
								icon: "success",
								button: "OK",
								timer: 1500
							}).then(function(){
								window.location = "{{ route('AddCurator') }}";
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
		  $(function () {
			//Initialize Select2 Elements
			$('.select2').select2(
			{
				// placeholder: "Assign to:",
				allowClear: true
			  }
			  )
		  
		  })
			 $(function () {
				$('#assistant').DataTable({
				  'searching'   : false,
				  "bStateSave": true,
				})
			  })

		function search(){
			$('#searchForm').submit();
		}

		$(document).ready(function(){
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
			$('#tendaydu').val(getUrlParameter('tendaydu'));
			$('#tendixe').val(getUrlParameter('tendixe'));
			$('#txtPhoneNumber').val(getUrlParameter('txtPhoneNumber'));
			$('#txtIdentityCardNumber').val(getUrlParameter('txtIdentityCardNumber'));
		});
		  
	</script>
@endsection