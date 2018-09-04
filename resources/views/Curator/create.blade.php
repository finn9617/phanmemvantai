@extends('blank')
@section('content')
    <section class="content-header">
      <div class="row">
        <div class="col-md-12 titleDieuXe">THÊM MỚI NGƯỜI PHỤ TRÁCH</div>
      </div>
              <!-- back page -->
      <div class="row">
        <div class="col-md-12 prePage">
          <a href="{{ route('AddCurator') }}">
            <span class="glyphicon glyphicon-step-backward">
              <span class="prePage">Quay lại </span>
            </span>
          </a>
        </div>
      </div>
    </section>
    <section class="content thongbao">
		<style>
				.thongbao [class*="er-"] {
					color: red;
					font-style: italic;
				}
		</style>
		<form id="user" name="user">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="row">
					<div class="col-md-3">
						<div class="box box-primary">
							<div class="box-body box-profile">
								<img class="profile-user-img img-responsive img-circle" src="../../img/user.png" alt="User profile picture">
								<h3 class="profile-username text-center"></h3>
								<p class="text-muted text-center"></p>
								<ul class="list-group list-group-unbordered">
									<li class="list-group-item" style="border:none">
									<b>Số điện thoại: </b> <a class="pull-right"></a>
									</li>
								</ul>
							</div>
						</div>
						<div class="box box-primary">
							<div class="box-header with-border">
								<h3 class="box-title"><b>THÔNG TIN</b></h3>
							</div>
							<div class="box-body">
								<strong><i class="fa fa-book margin-r-5"></i> Địa chỉ</strong>
								<p class="text-muted"></p>
								<hr>
								<strong><i class="fa fa-file-text-o margin-r-5"></i> Ghi chú</strong>
								<p></p>
							</div>
						</div>
					</div>
					<div class="col-md-9">
						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#thongtinnguoidung" data-toggle="tab">Thông tin người phụ trách</a></l>
							</ul>
							<div class="tab-content">
								<div><h4><b>Thông tin người phụ trách</b></h4></div>
								<div class="form-group">
									<label for="selDanhxung" class="control-label">Danh xưng (*):</label><label style="color: red; font-size: 13px"><i class="er-selDanhxung"> </i></label><br>
									<select class="form-control" id="selDanhxung" name="selDanhxung">
										<option value="1">Anh</option>
										<option value="0">Chị</option>
									</select>
								</div>
								<div class="form-group">
									<label for="txtHoten" class="control-label">Tên đầy đủ (*):</label><label style="color: red; font-size: 13px"><i class="er-txtHoten"> </i></label><br>
									<input type="text" class="form-control" id="txtHoten" name="txtHoten" placeholder="Nhập tên đầy đủ" >
								</div>
								<div class="form-group">
									<label for="txtTendixe" class="control-label">Tên người phụ trách (*):</label><label style="color: red; font-size: 13px"><i class="er-txtTendixe"> </i></label><br>
									<input type="text" class="form-control" id="txtTendixe" name="txtTendixe" placeholder="Nhập tên người phụ trách">
								</div>
								
								<div class="row">
									<div class="form-group col-md-4 ">
										<label for="diachi" class="control-label">Ngày sinh:</label><label style="color: red; font-size: 13px"><i class="er-datenam"> </i></label><br>
										<div class="input-group date">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input class="form-control" placeholder="Nhập Ngày sinh" name="dateNam" value="" type="date">
										</div>
									</div>
									<div class="form-group col-md-8">
										<label for="diachi" class="control-label">CMND :</label><label style="color: red; font-size: 13px"><i class="er-txtCNND"> </i></label><br>
										<input type="text" class="form-control" id="txtCNND" maxlength="20" name="txtCNND" placeholder="Nhập chứng minh nhân dân">
									</div>
								</div>
									<div class="form-group">
										<label for="sdt" class="control-label">Số điện thoại :</label> <label style="color: red; font-size: 13px"><i class="er-txtSDT"> </i></label><br>
										<input type="text" class="form-control" id="txtSDT" name="txtSDT" placeholder="Nhập số điện thoại người phụ trách">
									</div>
									<div class="form-group">
										<label for="diachi" class="control-label">Địa chỉ :</label>
										<textarea class="form-control" rows="3" placeholder="Nhập địa chỉ người phụ trách" id="txtDiachi" name="txtDiachi"></textarea>
									</div>
									<div class="form-group">
										<label for="note" >Ghi chú :</label>
										<textarea class="form-control" rows="3" placeholder="Nhập ghi chú" id ="txtGhichu" name="txtGhichu"></textarea>
									</div>
									<div class="row">
										<div class="col-md-12">
										<div class="form-group">
											<label style="font-family: Arial;">Trạng thái</label>
											<select class="form-control" id="selStatus" name="selStatus">
											<option value="0" selected>Đang làm</option>
											<option value="1" >Đã nghỉ làm</option>
											</select>
										</div>
										</div>
									</div>
									<div class="form-group">
										<label for="diachi" class="control-label">Ảnh đại diện: </label><label style="color: red; font-size: 13px"><i class="er-avatar"> </i></label>
										<br><img src="" class="imagePreview mb-2" style="padding: 10px; border-radius: 20px;"><br>
										<input type="file" id="avatar" name="avatar">
									</div>
									<hr>
									<div><h4><b>Thông tin đăng nhập</b><label style="color: red; font-size: 13px"><i class="er-infologin"> </i></label>
										</h4></div> 
									<div class="form-group">
										<label for="email" class="control-label">Email :</label><label style="color: red; font-size: 13px"><i class="er-txtEmail"> </i></label> 
										<input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Nhập Email">
									</div>
									<div class="form-group">
										<label for="username" class="control-label">Tên đăng nhập:</label> <label style="color: red; font-size: 13px"><i class="er-txtUsername"> </i></label>
										<input type="text" class="form-control" id="txtUsername" name="txtUsername" placeholder="Nhập tên đăng nhập" >
									</div>
									<div class="form-group">
										<label for="txtPassword" class="control-label">Mật khẩu:</label> <label style="color: red; font-size: 13px"><i class="er-txtPassword"> </i></label>
										<input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Nhập mật khẩu" >
									</div>
									<div class="form-group">
										<label for="password_confirmation" class="control-label">Nhập lại mật khẩu:</label> <label style="color: red; font-size: 13px"><i class="er-password_confirmation"> </i></label>
										<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu">
									</div>
									<div class="form-group">
										<label for=""></label>
										<button type="button" id="CreateAssistant" class="btn btn-success btn-md postbutton" >Lưu</button>
									</div> 
								</div>
							</div>
						</div>
					</div>
		</form>
	</section>
	<script>
		function validateEmail(email) {
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}
		$(document).ready(function(){
				$('#CreateAssistant').click(function(e){
					e.preventDefault();
					add();
				});
				var previewImage = function(input, block){
					var fileTypes = ['jpg', 'jpeg', 'png','svg','gif'];
					var extension = input.files[0].name.split('.').pop().toLowerCase();  
					var isSuccess = fileTypes.indexOf(extension) > -1;
					if(isSuccess){
						var reader = new FileReader();
						reader.onload = function (e) {
							block.attr('src', e.target.result);
						};
						reader.readAsDataURL(input.files[0]);
					}else{
						alert('Tệp tin không đúng định dạng');
					}
				};
				$(document).on('change', '#avatar', function(){
					previewImage(this, $('.imagePreview'));
				});
		});
		var check = 0;
		function add(){
			var data = new FormData();
			data.append('hoten', $("input[name='txtHoten']").val());
			data.append('tendixe', $("input[name='txtTendixe']").val());
			data.append('ghichu', $("textarea[name='txtGhichu']").val());
			data.append('diachi', $("textarea[name='txtDiachi']").val());
			data.append('trangthai', $('#selStats :selected').val());
			data.append('check',check);
			
			data.append('password_confirmation', $("input[name='password_confirmation']").val());
			var img = $("input[name='avatar']")[0].files[0];
			if(img){
				data.append('avatar', img);
			}
			if($('#selDanhxung :selected').val()){
				data.append('danhxung', $('#selDanhxung :selected').val());
			}
			//if($("input[name='txtEmail']").val().length > 0){
				//if (validateEmail($("input[name='txtEmail']").val())) {
			//		data.append('email',$("input[name='txtEmail']").val());
		//			$('.er-txtEmail').text('')
		//		}else {
		//			$('.er-txtEmail').text('Email không hợp lệ')
		//		}
		//	}else $('.er-txtEmail').text('')
			if($("input[name='txtEmail']").val()){
				data.append('email',$("input[name='txtEmail']").val());
			}else $('.er-txtEmail').text('')
			if($("input[name='txtCNND']").val()) {
				data.append('cmnd', $("input[name='txtCNND']").val());
			}
			if($("input[name='txtUsername']").val()){
				data.append('tendangnhap', $("input[name='txtUsername']").val());
			}
			if($("input[name='txtSDT']").val()){
				data.append('sdt', $("input[name='txtSDT']").val());
			}
			if($("input[name='dateNam']").val()){
				data.append('dateNam', $("input[name='dateNam']").val());
			}
			if($("input[name='txtPassword']").val()){
				data.append('password', $("input[name='txtPassword']").val());
			}
			$.ajax({
				url:"{{ route('AddCuratorPost') }}",
				type: 'POST',
				headers: {
					'X-CSRF-TOKEN': $("input[name='_token']").val()
				},
				data: data,
				enctype:'multipart/form-data',
				processData: false,
				contentType: false,
				success: function(data){
					if(data.success){
						window.location = "{{ route('AddCurator') }}"
					}
					if (data.loi){
						swal({
							title: "Lỗi !!!",
							text: "Tên người phụ trách này bị trùng với người đã nghỉ, bạn vẫn muốn thêm??",
							icon: "warning",
							buttons: {
								confirm: 'Có',
								cancel: 'Hủy'
							},
							dangerMode: true,
						}).then((willCreate) => {
							if(willCreate){
								window.check=1;
								add();
								window.check=0;
							}
						});						
					}
					if(data.errors){
						swal({
							title: "Lỗi !!!",
							text: "Có lỗi xảy ra vui lòng kiểm tra lại thông tin",
							icon: "warning",
							button: "OK",
							timer: 1500
						})
						if(data.errors.hoten) {
							$('.er-txtHoten').text(''+data.errors.hoten)
						}else $('.er-txtHoten').text('')
						if(data.errors.tendixe) {
							$('.er-txtTendixe').text(''+data.errors.tendixe)
						}else $('.er-txtTendixe').text('')
						if(data.errors.danhxung) {
							$('.er-selDanhxung').text('Vui lòng chọn danh xưng')
						}else $('.er-selDanhxung').text('')
						if(data.errors.password) {
							$('.er-txtPassword').text(''+data.errors.password)
						}else $('.er-txtPassword').text('')
						if(data.errors.avatar) {
							$('.er-avatar').text(''+data.errors.avatar)
						}else $('.er-avatar').text('')
						if(data.errors.cmnd) {
							$('.er-txtCNND').text(''+data.errors.cmnd)
						}else $('.er-txtCNND').text('')
						if(data.errors.tendangnhap) {
							$('.er-txtUsername').text(''+data.errors.tendangnhap)
						}else $('.er-txtUsername').text('')
						if(data.errors.sdt) {
							$('.er-txtSDT').text(''+data.errors.sdt)
						}else $('.er-txtSDT').text('')
						if(data.errors.infologin) {
							$('.er-infologin').text(''+data.errors.infologin)
						}else $('.er-infologin').text('')
						if(data.errors.password_confirmation) {
							$('.er-password_confirmation').text(''+data.errors.password_confirmation)
						}else $('.er-password_confirmation').text('')
						if(data.errors.email) {
							$('.er-txtEmail').text(''+data.errors.email)
						}else $('.er-txtEmail').text(' ')
					}
				}
			});
		}
			
	</script>
@endsection