@extends('blank') 
@section('content')
<section class="content-header">
	<div class="row">
		<div class="col-md-12 titleDieuXe">DANH MỤC DỤNG CỤ</div>
	</div>
</section>
<section class="content">
	<div class="box box-primary">
		<div class="box-header">
			<div class="row">
				<div class="col-md-12 prePage">
					<a href="{{ route('DungCu') }}">
					<span class="glyphicon glyphicon-step-backward">
						<span class="prePage">Quay lại </span>
					</span>
					</a>
				</div>
			</div>
		</div>
		<div class="box-body">
			<form>
				<h1>Thông tin dụng cụ</h1>
				{{ csrf_field() }}

				<div class="row">
					<div class="form-group col-md-6">
						<label for="email">Loại dụng cụ(*) :</label>
						<select class="form-control" id="selLoaidungcu" name="selLoaidungcu">
							{{-- thao tam thoi update fomr dung cu de anh hung test --}}
								@foreach ($tool_category as $item)
									<option value={{ $item->tool_category_id }} tooltype={{ $item->tool_type }}>{{ $item->name }}</option>
								@endforeach
						</select>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label for="email">Tên dụng cụ(*) :</label><i><b><span style="color: red;font-style: italic;" class="errors-tendungcu"></span></b></i>
						<input type="text" class="form-control" name="txtTendungcu" id="txtTendungcu" placeholder="Nhập tên dụng cụ">
					</div>
					<div class="form-group col-md-6 soluonghid">
						<label for="email">Số lượng :</label><b><i><span style="color: red;font-style: italic;" class="errors-soluong"></span></b></i>
						<input type="number" class="form-control" name="numSl" id="numSl" placeholder="Nhập số lượng">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label for="comment">Thông số :</label>
						<textarea class="form-control" rows="5" cols="10" id="txtThongso" name="txtThongso" placeholder="Nhập thông số dụng cụ"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12">
						<label for="comment">Thông tin :</label>
						<textarea class="form-control" rows="5" cols="10" id="txtThongtin" name="txtThongtin" placeholder="Nhập thông thông tin dụng cụ"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-12"> <label for="email"></label>
						<button type="submit" name="btnChange" id="btnOk" class="btn btn-success btn-md">Lưu</button>
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
			data.append('tenloaidungcu', $('#selLoaidungcu :selected').val());
			data.append('tendungcu', $('input[name=txtTendungcu]').val());
			data.append('soluong',  ($('input[name=numSl]').val()=='') ? 1 : $('input[name=numSl]').val()  );
			data.append('thongso', $('textarea[name=txtThongso]').val());
			data.append('thongtin', $('textarea[name=txtThongtin]').val());
			data.append('vitri', $('#txtViTri').val());
			$.ajax({
				type : "POST",
				url : "{{ route('PostThemDungCu') }}",
				data: data,
				processData: false,
				contentType: false,
				success : function(data)
				{
					if(data.success){
						window.location = "{{ route('DungCu') }}";
					}
					if(data.errors){
						if(data.errors.tendungcu) {
							$('.errors-tendungcu').text(' *'+data.errors.tendungcu)
						}else $('.errors-tendungcu').text('')
						if(data.errors.soluong) {
							$('.errors-soluong').text(' *'+data.errors.soluong)
						}else $('.errors-soluong').text('')
					}
				}
			});
		});
		$('.soluonghid').hide();
		$('#selLoaidungcu').on('change', function() {
			if($(this).find('option:selected').attr('tooltype')==1){
				$('.soluonghid').fadeOut('slow');
			}else $('.soluonghid').fadeIn('slow');
		})
	});

</script>
@endsection