@extends('blank')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!-- <h1>
      Advanced Form Elements
      <small>Preview</small>
    </h1> -->
    <!-- title -->
    <div class="row">
      <div class="col-md-12 titleDieuXe"><?php if(isset($id)) echo "CẬP NHẬT THÔNG TIN NGƯỜI DÙNG"; else echo "THÊM THÔNG TIN NGƯỜI DÙNG"; ?></div>
    </div>
    <!-- ./ title -->
    <!-- back page -->
    <div class="row">
      <div class="col-md-12 prePage">
        <a href="/user" class="">
          <span class="glyphicon glyphicon-step-backward">
            <span class="prePage">DANH SÁCH NGƯỜI DÙNG</span>
          </span>
        </a>
      </div>
    </div>
    <!-- ./ back page -->
    <!-- tips -->

  </section>

  <!-- Main content -->
  <section class="content" id="mContent">
    <div class="row">
      <div class="col-md-3">
       <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" src="../../img/user.png" alt="User profile picture" id="imgAvatar">

          <h3 class="profile-username text-center"></h3>

          <p class="text-muted text-center"></p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Phòng ban</b> <a class="pull-right" id = "profile_office"></a>
            </li>
            <li class="list-group-item">
              <b>Số điện thoại:</b> <a class="pull-right" id = "profile_phone"></a>
            </li>
          </ul>

        </div>
        <!-- /.box-body -->
      </div>
      <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><b>THÔNG TIN</b></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <strong><i class="fa fa-book margin-r-5"></i> Địa chỉ</strong>
        <p class="text-muted" id = "profile_address"> 
        </p>
        <hr>   
        <strong><i class="fa fa-file-text-o margin-r-5"></i> Ghi chú</strong>
        <p id = "profile_note"> 
        </p>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-9">
      <form>
      {{csrf_field()}}
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#" data-toggle="tab">Thông tin người dùng</a>
          </li>
        </ul>
      <div class="tab-content">
        <div><h4><b>Thông tin đăng nhập</b></h4></div>
          <div class="form-group">
            <label for="username" class="control-label">Tên đăng nhập (*):</label><?php if(!isset($id)) echo "<span style='color: red;' id = 'msg_username'></span>"; ?>
            <input type="text" class="form-control"  <?php if(isset($id)) echo "disabled"; ?> id="txtUsername" name="txtUsername" placeholder="Nhập tên đăng nhập">
          </div>
          <div class="form-group">
            <label for="email" class="control-label">Email :</label>
            <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Nhập email">
          </div>
          <div class="form-group">
            <label for="password" class="control-label">Mật khẩu (*):</label><span style="color: red;" id = "msg_password"></span>
            <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Nhập mật khẩu">
          </div>
          <div class="form-group">
            <label for="password" class="control-label">Xác nhận mật khẩu (*):</label><span style="color: red;" id = "msg_confpassword"></span>
            <input type="password" class="form-control" id="txtConfpassword" name="txtConfpassword" placeholder="Nhập xác nhận mật khẩu">
          </div>
          <hr>
          <div><h4><b>Thông tin người dùng</b></h4></div>
          <div class="form-group">
            <label class="control-label">Danh xưng :</label>
            <select class="form-control" id="txtGender" name="txtGender">
            <option value="1">Anh</option>
            <option value="0">Chị</option>
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">Họ tên :</label><span style="color: red;" id = "msg_fullname"></span>
            <input type="text" class="form-control" id="txtFullname" name="txtFullname" placeholder="Nhập họ tên">
          </div>
          <div class="form-group">
            <label class="control-label">Tên thường gọi :</label><span style="color: red;" id = "msg_nickname"></span>
            <input type="text" class="form-control" id="txtNickname" name="txtNickname" placeholder="Nhập tên thường gọi">
          </div>
          <div class="form-group">
            <label class="control-label">Chức vụ :</label>
            <select class="form-control" id="txtOffice" name="txtOffice">
            <option id="1" value="1">Admin</option>
            <option id="10" value="10">Nhân viên văn phòng</option>
            <option id="11" value="11">Người liên lạc</option>
            <option id="12" value="12">Tài xế</option>
            <option id="13" value="13">Lơ xe</option>
            <option id="14" value="14">Chủ hàng</option>
            <option id="15" value="15">Người phụ trách</option>
            <option id="16" value="16">Điều phối 1</option>
            <option id="17" value="17">Điều phối 2</option>
            <option id="18" value="18">Văn phòng bãi xe</option>
            </select>
          </div>
          <div class="form-group">
            <label class="control-label">CMND :</label>
            <input type="text" class="form-control" id="txtIdentity" name="txtIdentity" placeholder="Nhập chứng minh nhân dân">
          </div>
          <div class="form-group">
            <label class="control-label">Địa chỉ :</label>
            <textarea class="form-control" rows="3" placeholder="Nhập địa chỉ người dùng" id="txtAddress" name="txtAddress"></textarea>
          </div>      
          <div class="form-group">
            <label class="control-label">Số điện thoại :</label>
            <input type="text" class="form-control" id="txtPhone" name="txtPhone" placeholder="Nhập số điện thoại người dùng">
          </div>
          <div class="form-group">
            <label for="note">Ghi chú :</label>
            <textarea class="form-control" rows="3" placeholder="Nhập ghi chú" id="txtNote" name="txtNote"></textarea>
          </div>
          <div class="form-group">
            <label>Trạng thái :</label>
            <select class="form-control" id="txtWorkStatus" name="txtWorkStatus">
            <option value="0">Đang làm</option>
            <option value="1">Đã nghỉ</option>
            </select>
          </div>                                        
        </div>
      </div>         
      <div class="box-footer">
        <div class="form-group">
          <button type="button" id = "save" class="btn btn-success btn-md postbutton">Lưu</button>
          &nbsp; 
        </div>
      </div>
    </form>
    </div>
</div>
</section>
<!-- /.content -->
<?php 
if(isset($id)){
  echo " <script type = 'text/javascript'> var getID = ". $id .";</script>";
  echo "<script src = '/js/edituser.js'></script>";
}
else{
  echo "<script src = '/js/insertuser.js'></script>";
}
?>
@endsection