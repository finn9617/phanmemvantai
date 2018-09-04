@extends('blank') 
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-md-12 titleDieuXe">DANH MỤC LOẠI DỤNG CỤ</div>
	</div>
</section>
<section class="content">
	<div class="box box-primary">
		<div class="box-header">
			<div class="row">
				<div class="col-md-12 prePage">
					<a href="{{ route('LoaiDungCu') }}">
					<span class="glyphicon glyphicon-step-backward">
						<span class="prePage">Quay lại </span>
					</span>
					</a>
				</div>
			</div>
		</div>
		<div class="box-body">
			<form>
				<h1>Thêm mới loại dụng cụ</h1>
				{{ csrf_field() }}
				<div class="row">
					<div class="form-group col-md-6">
						<label for="email">Tên dụng cụ:(*)</label><i><b><span style="color: red;font-style: italic;" class="errors"></span></b></i>
						<input type="text" class="form-control" name="txtTenloai" id="txtTenloai" placeholder="Nhập tên loại dụng cụ" value="">
					</div>
					<div class="form-group col-md-6"> 
						<label for="email">Bộ dụng cụ:</label>
						<select class="form-control" id="selBodungcu" name="selBodungcu">
							<option value="1">Bộ dụng cụ 1</option>
							<option value="2">Bộ dụng cụ 2</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label for="txtGhichu">Ghi chú:</label>
						<textarea class="form-control" rows="7" cols="10" id="txtGhichu" name="txtGhichu" placeholder="Ghi chú"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<button name="btnChange" id="btnOk" class="btn btn-success btn-md">Lưu</button>&nbsp;
					</div>
				</div>
			</form>
		</div>
	</div>
</section>
<script>
	$(document).ready(function () {
		$(document).on('click', '#btnOk', function(e){
			e.preventDefault();
			var data = new FormData();
			data.append('_token', $('input[name=_token]').val());
			data.append('tendungcu', $('input[name=txtTenloai]').val());
			data.append('bodungcu', $('#selBodungcu :selected').val());
			data.append('ghichu', $('textarea[name=txtGhichu]').val());
			$.ajax({
				type : "POST",
				url : "{{ route('PostThemLoaiDungCu') }}",
				data: data,
				processData: false,
				contentType: false,
				success : function(data)
				{
					if(data.success){
						window.location = "{{ route('LoaiDungCu') }}";
					}
					if(data.errors){
						if(data.errors.tendungcu) {
							$('.errors').text(data.errors.tendungcu)
						}else $('.errors').text('')
					}
				}
			});
		});
	});
</script>
@endsection