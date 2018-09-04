@extends('blank')
@section('content')
<!-- Content Header (Page header) -->
<script src="{{ asset('libs/select2-tab-fix/src/select2-tab-fix.min.js') }}"></script>
<section class="content-header">
    <!-- <h1>
      Advanced Form Elements
      <small>Preview</small>
    </h1> -->
<!--     <ol class="breadcrumb">
      <li>
        <a href="#">
          <i class="fa fa-dashboard"></i> Home</a>
        </li>
        <li>
          <a href="#">Forms</a>
        </li>
        <li class="active">Advanced Elements</li>
      </ol> -->
      <!-- title -->
      <div class="row">
        <div class="col-md-12 titleDieuXe">THÊM THÔNG TIN ĐIỀU XE</div>
      </div>
      <!-- ./ title -->
      <!-- back page -->
      <div class="row">
        <div class="col-md-12 prePage">
          <a href="/operating" class="">
            <span class="glyphicon glyphicon-step-backward">
              <span class="prePage">DANH SÁCH ĐIỀU XE </span>
            </span>
          </a>
        </div>
      </div>
      <!-- ./ back page -->
      <!-- tips -->
      
    </section>

    <!-- Main content -->
    <section class="content" id="mContent">
      <div id="tips" style="font-weight: bold; color: red; font-size: 10pt;">
        Tips: - Bạn có thể click vào các tiêu đề để xuất các thông báo tương ứng, khi muốn tắt các thông báo này, bạn hãy click vào chính nó.
        <br>&nbsp &nbsp &nbsp &nbsp &nbsp - Sau khi nhập các thông tin chủ hàng, loại hàng, nơi nhận và nơi giao bạn có thể click tổ hợp phím ALT + A để nhận các gợi ý. Lưu ý: Những gợi ý này chỉ mang tính chất tham khảo, bạn cần kiểm tra và kiểm soát tất cả dữ liệu.
      </div>
      <div class="box box-warning">
      <!-- <div class="box-header with-border">
        <h3 class="box-title">Select2</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse">
            <i class="fa fa-minus"></i>
          </button>
          <button type="button" class="btn btn-box-tool" data-widget="remove">
            <i class="fa fa-remove"></i>
          </button>
        </div>
      </div> -->
      <!-- /.box-header -->
      <div class="box-body boxPadding">
        <form name="frmOperation" id "frmOperation" method = "get">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <!-- row 1 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-family: Arial;">Mã gộp chuyến</label>
                <input type="text" class="form-control" name ="txtMaGopChuyen" id="txtMaGopChuyen" placeholder="-- Mã gộp chuyến --" >
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-family: Arial;">Ngày điều xe</label>
                <input type="date" class="form-control" name = "txtNgayDieuXe" id="txtNgayDieuXe" placeholder="Enter email">
              </div>
            </div>
          </div>
          <!-- /.row 1 -->
          <!-- row 2 -->
          <div class="row">

            <div class="col-md-6">
              <div class="form-group">
                <label id="lblChuHang" style="font-family: Arial;">Chủ hàng(*)</label><i style="color: red" id="msgErrorCH"></i>
                <select class="form-control select2" name = "selChuHang" id = "selChuHang" style="width: 100%; " data-placeholder="-- Chọn chủ hàng --">
                  <option value=""></option>
                  <!-- Append options here -->
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="handCursor" id="clickToShowNDChuHang" style="margin-top: 30px;">
                <b>Hiển thị nội dung trước / sau chủ hàng</b>
              </div>
              <div class="row" id="showNDChuHang">
                <!-- append nọi dung nơi giao here -->
              </div>
            </div>
          </div>
          <!-- /.row 2 -->
          <!-- row 3 -->
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label id="lblGoodsType" style="font-family: Arial;">Loại hàng</label>   <i style="color: red" id="msgErrorGT"></i>
                <select class="form-control select2" name = "selGoodsType" id = "selGoodsType" style="width: 100%; " data-placeholder="-- Chọn loại hàng --">
                  <option value="0" selected="">Hàng bồn</option>
                  <option value="1" ="">Hàng phi</option>
                  <!-- append options here -->
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label id="lblLoaiHang" style="font-family: Arial;">Tên hàng(*)</label>   <i style="color: red" id="msgErrorLH"></i>
                <select class="form-control select2" name = "selLoaiHang" id = "selLoaiHang" style="width: 100%; " data-placeholder="-- Chọn hàng hóa --">
                  <option value=""></option>
                  <!-- append options here -->
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-family: Arial;">Số lượng</label>
                <input type="text" class="form-control" name = "txtSoLuongHangHoa" id="txtSoLuongHangHoa" placeholder="-- Số lượng --">
              </div>
            </div>
          </div>
          <!-- /.row 3 -->
          <!-- row 4 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label id="lblNoiNhan" style="font-family: Arial;">Nơi nhận</label>
                <select class="form-control select2" name = "selNoiNhan" id = "selNoiNhan" style="width: 100%; " data-placeholder="-- Chọn loại hàng --">
                  <!-- append options here -->
                  <option value=""></option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="handCursor" id="clickToShowNDTruocNoiNhan" style="margin-top: 30px;">
                <b>Hiển thị nội dung trước / sau nơi nhận</b>
              </div>
              <div class="row" id="showNDTruocNoiNhan">
                <!-- append nọi dung trước nơi nhận here -->
              </div>
            </div>
          </div>
          <!-- /.row 4 -->
          <!-- row 5 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label id="lblNoiGiao" style="font-family: Arial;">Nơi giao</label>
                <select class="form-control select2" name = "selNoiGiao" id = "selNoiGiao" style="width: 100%; " data-placeholder="-- Chọn loại hàng --">
                  <option value=""></option>
                  <!-- Append options here -->
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="handCursor" id="clickToShowNDNoiGiao" style="margin-top: 30px;">
                <b>Hiển thị nội dung trước / sau nơi giao</b>
              </div>
              <div class="row" id="showNDNoiGiao">
                <!-- append nọi dung nơi giao here -->
              </div>
            </div>
          </div>
          <!-- /.row 5 -->
          <!-- row 6 -->
          <div class="row">
           <div class="col-md-6">
            <div class="form-group">
              <label style="font-family: Arial;">Chứng từ mang theo 1</label>
              <input type="text" class="form-control" name = "txtCTMT1" id="txtCTMT1" placeholder="Chứng từ mang theo số 1" >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label style="font-family: Arial;">Chứng từ mang theo 2</label>
              <input type="text" class="form-control" name="txtCTMT2" id="txtCTMT2" placeholder="Chứng từ mang theo số 2">
            </div>
          </div>
        </div>
        <!-- ./row 6 -->
        <!-- row 8 -->
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label>Ghi chú</label>
              <textarea class="form-control" name ="txtGhiChu" id = "txtGhiChu" rows="3" placeholder="Nhập ghi chú ..."></textarea>
            </div>
          </div>
        </div>
        <!-- ./ row 8 -->
        <!-- row 6 -->
        <div class="row rowPadding">
          <div class="col-md-2">
            <div class="form-group">
              <label id="lblNhomDungCu" style="font-family: Arial;">Nhóm dụng cụ</label>
              <select name="selNhomDungCu" id="selNhomDungCu" class="form-control " style="width: 100%; " data-placeholder="-- Chọn nhóm dụng cụ --">
                <option value = "1">DỤNG CỤ 1</option>
                <option value ="2">DỤNG CỤ 2</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label id="lblLoaiDungCu" style="font-family: Arial;">Loại dụng cụ</label>
              <select name="selLoaiDungCu" id="selLoaiDungCu" class="form-control select2" style="width: 100%; " data-placeholder="-- Chọn loại dụng cụ --">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label id="lblTenDungCu" style="font-family: Arial;">Tên dụng cụ</label>
              <select name="selDungCu" id="selDungCu" class="form-control select2" style="width: 100%; " data-placeholder="-- Chọn dụng cụ--">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label style="font-family: Arial;">Số lượng</label>
              <input type="number" name="txtSoLuongDungCu" id="txtSoLuongDungCu" min="0" class="form-control" id="exampleInputEmail11" placeholder="Số lượng">
            </div>
          </div>
          <div class="col-md-1">
            <div class="form-group">
              <div style="margin-bottom: 25px;"></div>
              <button type="button" class="btn btn-success" style="width: 150px;" id="btnAddTool">Thêm dụng cụ</button>
            </div>
          </div>
        </div>
        <!-- /.row 6 -->
        <!-- row 7 -->
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-striped" id="tblTool">
              <!-- <tbody> -->
                <tr id="tr_th" style="background: #3C8DBC; color: #ffffff; font-family: Arial, Helvetica, sans-serif; ">
                  <th class="th" style="text-align: center;">
                    STT
                  </th>

                  <th class="th" style="text-align: center;">
                    Tên dụng cụ
                  </th>
                  <th class="th" style="text-align: center;">
                    Loại dụng cụ
                  </th>

                  <th class="th" style="text-align: center;">
                    Bộ dụng cụ
                  </th>

                  <th class="th" style="text-align: center;">
                    Số lượng
                  </th>
                  <th class="th" style="width:110px; text-align: center;">
                    Xóa
                  </th>
                </tr>
                <!-- append tr here -->
                <!-- </tbody> -->
              </table>
              <div id="showErrorTable"></div>
            </div>
          </div>
          <!-- ./ row 7 -->

          <!-- row 9 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-family: Arial;">Loại xe</label>
                <select class="form-control select2" name ="selLoaiXe" id="selLoaiXe" style="width: 100%; " data-placeholder="-- Chọn loại xe--">
                  <option value=""></option>
                  <!-- Append options here -->
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label id="lblXe" style="font-family: Arial;">Số Xe</label><i style="color: red; padding-left: 15px;" class="msgError" id="msgError_selXe"></i>
                <select class="form-control select2" name ="selXe" id="selXe" style="width: 100%; " data-placeholder="-- Chọn xe--" >
                  <option value=""></option>
                  <!-- Append option here -->
                </select>
              </div>
            </div>


          </div>
          <!-- ./ row 9 -->
          <!-- row 10 -->
           <!--  <div class="row">
             <div class="col-md-6">
              <div class="form-group">
                <label id="lblXe" style="font-family: Arial;">Xe</label>
                <select class="form-control select2" name ="selXe" id="selXe" style="width: 100%; " data-placeholder="-- Chọn xe--" >
                  <option value=""></option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label style="font-family: Arial;">Chứng từ mang theo 2</label>
                <input type="text" class="form-control" name="txtCTMT2" id="txtCTMT2" placeholder="Chứng từ mang theo số 2">
              </div>
            </div>

          </div> -->
          <!-- ./ row 10 -->
          <!-- row 11 -->
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label id="lblLoaiRomooc" style="font-family: Arial;">Loại Romooc</label>
                <select class="form-control select2" name ="selLoaiRomooc" id="selLoaiRomooc" disabled  style="width: 100%; " data-placeholder="-- Loại Romooc --">
                  <option value=""></option>
                  <!-- <option value="1">20 TẤN</option>
                  <option value="2">30 TẤN</option>
                  <option value="3">40 TẤN</option> -->
                  <!-- append options here -->
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label id="lblRomooc" style="font-family: Arial;">Số Romooc</label><i style="color: red; padding-left: 15px;" class="msgError" id="msgError_selRomooc"></i>
                <select class="form-control select2" name ="selRomooc" id="selRomooc" disabled style="width: 100%; " data-placeholder="-- Chọn Romooc --">
                  <option value=""></option>
                  <!-- append options here -->
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label id="lblNguoiPhuTrach" style="font-family: Arial;">Người phụ trách</label>
                <select class="form-control select2" name = "selNguoiPhuTrach" id ="selNguoiPhuTrach" style="width: 100%; " data-placeholder="-- Chọn người phụ trách --">
                  <option value=""></option>
                  <!-- <option>Mr Phụ trách 1</option>
                  <option>Ms Phụ trách 2</option>
                  <option>Mr Phụ trách 3</option> -->
                </select>
              </div>
            </div>
          </div>
          <!-- ./ row 11 -->
          <!-- row 12 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label id="lblTaiXe" style="font-family: Arial;">Tài xế</label><i style="color: red; padding-left: 15px;" class="msgError" id="msgError_selTaiXe"></i>
                <select class="form-control select2" name ="selTaiXe" id="selTaiXe" style="width: 100%; " data-placeholder="-- Chọn tài xế --">
                  <option value=""></option>
                  <!-- Append option here -->
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="handCursor" id="clickToShowDriverDescription" style="margin-top: 30px;">
                <b>Hiển thị nội dung trước / sau tài xế</b>
              </div>
              <div class="row" id="showDriverDescription">
                <!-- append driver infomation here -->
              </div>
            </div>
          </div>
          <!-- ./ row 12 -->
          <!-- row 13 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label id="lblPhuXe" style="font-family: Arial;">Phụ xe</label><i style="color: red; padding-left: 15px;" class="msgError" id="msgError_selPhuXe"></i>
                <select class="form-control select2" name ="selPhuXe" id="selPhuXe" style="width: 100%; " data-placeholder="-- Chọn phụ xe--">
                  <option value=""></option>
                  <!-- Append options here -->
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="handCursor" id="clickToShowAssistantDriverDescription" style="margin-top: 30px;">
                <b>Hiển thị nội dung trước / sau phụ xe</b>
              </div>
              <div class="row" id="showAssistantDriverDescription">
                <!-- append driver infomation here -->
              </div>

            </div>
          </div>
          <!-- ./ row 13 -->
          <!-- row 14 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label id="lblXitBon" style="font-family: Arial;">Xịt bồn</label>
                <select class="form-control select2" name="selXitBon" id ="selXitBon" style="width: 100%; " data-placeholder="-- Chọn kiểu xịt bồn --">
                  <option value=""></option>
                  <!-- Append options here -->
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-family: Arial;">Giờ đi</label>
                <input type="text" name ="txtGioDi" id="txtGioDi" class="form-control"  placeholder="giờ đi">
              </div>
            </div>
          </div>
          <!-- ./ row 14 -->
          <!-- row 15 -->
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-family: Arial;">Thứ tự hiển thị</label>
                <input type="text" name ="txtTTHT"  class="form-control" id="txtTTHT" value="00" placeholder="-- Thứ tự --">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label style="font-family: Arial;">Tình trạng</label>
                <select class="form-control " name ="selTinhTrang" id ="selTinhTrang" style="width: 100%; "  >
                  <!-- <option value=""></option> -->
                  <option value="1"  >Chưa hoàn thành</option>
                  <option value= "2">Hoàn thành</option>
                </select>
              </div>
            </div>
          </div>
          <!-- ./row 15 -->
          <!-- row 16 -->
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label>
                  <div class="icheckbox_flat-green checked" aria-checked="false" aria-disabled="false" style="position: relative;">
                    <input type="checkbox" class="flat-red"  name="chkFreeRule" id="chkFreeRule" style="position: absolute; opacity: 0;">
                    <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                  </div>
                  Cho phép chọn lại
                </label>
                <span style="color: red">(Lưu ý: Khi chọn chế độ này, đồng nghĩa với việc bạn phải tự kiểm soát ràng buộc về dữ liệu của các lệnh
                điều xe chưa hoàn thành!)</span>
              </div>
            </div>
          </div>
          <!-- ./ row 16 -->
          <!-- row 17 -->
          <div class="row">
            <div class="form-group">
              <div class="col-md-12" style="text-align: center">
                <button type="button" class="btn btn-primary" id="btnOK">Xác nhận</button>
                <button type="button" class="btn btn-default" id="btnCancle">Hủy</button>
              </div>
            </div>
          </div>
          <!-- ./ row 17 -->
        </form>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">

      </div>
    </div>
    <!-- /.box -->




  </section>
  <!-- /.content -->
  <!-- ==================================================================  JAVASCRIPT ====================================================== -->
  <?php
// if(isset($res)) echo json_encode($res);
  ?>
  <script>
    // var tmpStr  ='<?php //if(isset($res)) echo str_replace('\r\n', '\\\n',  json_encode($res)); else echo (json_encode([])) ?>';
    // var resData = JSON.parse(tmpStr);
    var url_string =window.location.href;
    
    var resData;
    var operating ;
    $(document).ready(function () {
      // alert('dđ');

      $.ajax('{{url("/operating/create1")}}', {
        type: 'GET',  
        data: {},
        dataType:"json",
        async: false,
        success: function (result) {
          if(result.success)
          {
           resData = result.success;
           console.log('okeeeeee');
           
           // swal("Thành công", "ok!", "success");
         }else{
          swal("Lỗi", "Không tìm thấy lệnh điều xe!", "error");
        } 
      }

    });
    })
  </script>
  <!-- Page script -->

  <!-- select2 -->
  <script>
    $(function () {
  //Initialize Select2 Elements
  $('.select2').select2(
  {
      // placeholder: "Assign to:",
      allowClear: true
    }
    )

})
</script>
<!-- notify js -->
<script>
/*
  place: where display message
  msg: message
  type: type of message box - info , warn, error
  position: top, left, right, bottom
  */
  function showNotify(place, msg, type, position) {
    $.notify.defaults({ className: type });
    $(place).notify(
      msg,
       // autoHideDelay: 20000,
       { position: position, autoHideDelay: 10000 }
       );
  }

</script>
<!-- icheck -->
<script>
  $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
  })
</script>

<!-- =========================================================================== PAGE SCRIPT ================================================ -->
<script>
  $(document).ready(function () {
  // ======================================================== GUI ======================================================================================
  // Set Date field is next date
  // ---------
  var dateVal = new Date();
  var today = dateVal.getDate();
  dateVal.setDate(today+1);
  document.getElementById("txtNgayDieuXe").valueAsDate = dateVal;
  // ---------
  //click show nd chủ hàng
  var driverDescription = "<div id = 'contentCHDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước CH</label><input type='text' class='form-control' id='txtNDTruocChuHang' placeholder='ND trước chủ hàng'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau CH</label><input type='text' class='form-control' id='txtNDSauChuHang' placeholder='ND sau chủ hàng'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeCHDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
  $("#clickToShowNDChuHang").click(function () {
    $("#showNDChuHang").append(driverDescription).hide().show('slow');
    $(this).hide();
  });
  // click to remove CH description
  $(document).on('click', '#closeCHDescription', function () {
    // txtNDTruocTaiXe = "";
    // txtNDSauTaiXe = "";
    $('#contentCHDescription').remove();
    $('#clickToShowNDChuHang').show();
  });
  //click to show driver description -- clickToShowNDChuHang
  $("#clickToShowDriverDescription").click(function () {
    var driverDescription = "<div id = 'contentDriverDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước TX</label><input type='text' class='form-control' id='txtNDTruocTaiXe' placeholder='ND trước tài xế'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau TX</label><input type='text' class='form-control' id='txtNDSauTaiXe' placeholder='ND sau tài xế'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeDriverDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
    $("#showDriverDescription").append(driverDescription).hide().show('slow');
    $(this).hide();
  });

  // click to remove drive description
  $(document).on('click', '#closeDriverDescription', function () {
    txtNDTruocTaiXe = "";
    txtNDSauTaiXe = "";
    $('#contentDriverDescription').remove();
    $('#clickToShowDriverDescription').show();
  });

  //click to show Assistant Driver Description
  $("#clickToShowAssistantDriverDescription").click(function () {
    var assistantDriverDescription = "<div id = 'contentAssistantDriverDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước PX</label><input type='text' class='form-control' id='txtNDTruocPhuXe' placeholder='ND trước phụ xe'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau PX</label><input type='text' class='form-control' id='txtNDSauPhuXe' placeholder='ND sau phụ xe'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeAssistantDriverDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
    $("#showAssistantDriverDescription").append(assistantDriverDescription).hide().show('slow');
    $(this).hide();
  });

  // click to remove Assistant Driver Description
  $(document).on('click', '#closeAssistantDriverDescription', function () {
    txtNDTruocPhuXe= "";
    txtNDSauPhuXe = "";
    $('#contentAssistantDriverDescription').remove();
    $('#clickToShowAssistantDriverDescription').show();
  });

  //click to show nội dung nơi nhận
  $("#clickToShowNDTruocNoiNhan").click(function () {
    var ndTruocNoiNhan = "<div id = 'ndTruocNoiNhan'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước nơi nhận</label><input type='text' class='form-control' id='txtNDTruocNoiNhan' placeholder='ND trước nơi nhận'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau nơi nhận</label><input type='text' class='form-control' id='txtNDSauNoiNhan' placeholder='ND sau nơi nhận'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeNDNoiNhan'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
    $("#showNDTruocNoiNhan").append(ndTruocNoiNhan).hide().show('slow');
    $(this).hide();
  });

  // click to remove nội dung nơi nhận
  $(document).on('click', '#closeNDNoiNhan', function () {
    txtNDTruocNoiNhan ="";
    txtNDSauNoiNhan ="";
    $('#ndTruocNoiNhan').remove();
    $('#clickToShowNDTruocNoiNhan').show();
  });

  //click to show nội dung nơi giao
  $("#clickToShowNDNoiGiao").click(function () {
    var ndNoiGiao = "<div id = 'ndNoiGiao'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước nơi giao</label><input type='text' class='form-control' id='txtNDTruocNoiGiao' placeholder='ND trước nơi giao'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau nơi giao</label><input type='text' class='form-control' id='txtNDSauNoiGiao' placeholder='ND sau nơi giao'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeNDNoiGiao'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
    $("#showNDNoiGiao").append(ndNoiGiao).hide().show('slow');
    $(this).hide();
  });

  // click to remove nội dung nơi giao
  $(document).on('click', '#closeNDNoiGiao', function () {
    txtNDTruocNoiGiao ="";
    txtNDSauNoiGiao="";
    $('#ndNoiGiao').remove();
    $('#clickToShowNDNoiGiao').show();
  });


  //remove row of table tool by click
  $('.tblTool tr').each(function () {
    var cellText = $(this).html();
    console.log(cellText);
  });

  // Click button addTool to add row table
  // var stt = 0;
  //set default tool
  var defaultToolID= 46;
  var defaultToolCell = 'toolCell_'+defaultToolID+'_'+defaultToolID;
  var defaultTool  =   arrSearch(defaultToolID , resData['tools'], 'tool_id');
  
  
  console.log(defaultTool);
  if(defaultTool && defaultTool['num'] > 0){
    var defaultToolName = defaultTool['name'];
    defaultTool['num'] = defaultTool['num']-1;
    var defaultToolTypeCell = 'toolTypeCell_'+defaultToolID+'_'+defaultTool['tool_category_id'];
    var defaultToolTypeName = defaultTool['category_name'];
    var defaultToolGroupName = 'DỤNG CỤ 2';
    var defaultToolGroupCell = 'toolGroupCell_'+defaultToolID+'_'+defaultTool['tool_type'];
    var defaultNotyID = "defaultNoty_"+defaultToolID;
    var defaultRow = '<tr style="background-color: #b0daff;" class="trTool" id="row_'+defaultToolID+'"><td rowspan="1" style="vertical-align: inherit;" id="td_1_4">' + '1' + '</td><td  id = "'+defaultToolCell+'"><div class="notifyjs-wrapper notifyjs-hidable" id="noty_'+defaultToolID+'" ></div> <span class = "toolNameCell" id = '+defaultNotyID+' >' + defaultToolName + '</span></td><td rowspan="1" style="vertical-align: inherit;" id="'+defaultToolTypeCell+'">' + defaultToolTypeName + '</td><td id = "'+defaultToolGroupCell+'"> ' + defaultToolGroupName + '</td><td id = "toolQuantityCell_'+defaultToolID+'">' + '1' + '</td><td style="vertical-align: inherit;"><div class=" iconRemoveRowTable"><span class="glyphicon glyphicon-remove-sign"></span></div></td></tr>';
    $('#tblTool').append(defaultRow);
  }
  //else
  // alert('faled');
  var stt = $('#tblTool tr').length -1;
  // alert(stt);
  $('#btnAddTool').click(function () {
    let toolGroup = $('#selNhomDungCu').val();
    let toolType = $('#selLoaiDungCu').val();
    let tool = $('#selDungCu').val();
    let toolQuantity = $('#txtSoLuongDungCu').val();
    let checkToolQuantity = true;
    // alert(toolQuantity);

    // display notify when fail
    if (!toolGroup) {
      showNotify("#selNhomDungCu", "Chưa chọn nhóm dụng cụ", "error", "top");
    }
    if (!toolType) {
      showNotify("#selLoaiDungCu", "Chưa chọn loại dụng cụ", "error", "top");
    }
    if (!tool) {
      showNotify("#selDungCu", "Chưa chọn tên dụng cụ", "error", "top");
    }
    if (!toolQuantity || toolQuantity < 1) {
      checkToolQuantity = false;
      showNotify("#txtSoLuongDungCu", "Số lượng không được nhỏ hơn 1", "error", "top");
    }else{
      if(!freeRule){
    // check quantity of tool
    var srchTool  =   arrSearch(tool , resData['tools'], 'tool_id');
    var tmpQuantity = srchTool['num'];
    if(toolQuantity > tmpQuantity){
      checkToolQuantity = false;
      showNotify("#txtSoLuongDungCu", "Số lượng không hợp lệ", "error", "top");
    }else{
          //update quantity Tool
          srchTool['num'] = srchTool['num'] - toolQuantity;
        }
      }else{

        var srchTool  =   arrSearch(tool , resData['toolsFull'], 'tool_id');
        if(srchTool['tool_type'] == 1 ){
          let tmpDataTable = getDataTable();
          var searchInDataTable = arrSearch(tool , tmpDataTable, 'tool_id');
        //  console.log(searchInDataTable);
        if(toolQuantity > 1 || searchInDataTable){
          checkToolQuantity = false;
          // searchInDataTable= undefined;
          showNotify("#txtSoLuongDungCu", "Số lượng không hợp lệ", "error", "top");
        }
        else
          srchTool['num'] = srchTool['num'] - toolQuantity;
      }
      if(srchTool['tool_type'] == 2){
       if(toolQuantity > srchTool['num']){
        checkToolQuantity = false;
        showNotify("#txtSoLuongDungCu", "Số lượng không hợp lệ", "error", "top");
      }
      else
        srchTool['num'] = srchTool['num'] - toolQuantity;
    }


      }//case freerule

    }
    // add row to tblTool
    var toolTypeName = $('#selLoaiDungCu').select2('data')[0].text;
    var toolName = $('#selDungCu').select2('data')[0].text;
    var toolGroupName = $('#selNhomDungCu').children("option").filter(":selected").text();
    if (toolGroup && tool && toolType && toolQuantity && checkToolQuantity) {
      //remove error message div if it exist
      if ($(".msgErrorTableTool").length > 0){
        $('.msgErrorTableTool').remove();
      } 
      let rowID = tool;
      let toolTypeCell = 'toolTypeCell_'+rowID+'_'+toolType;
      let toolGroupCell = 'toolGroupCell_'+rowID+'_'+toolGroup;
      let toolCell = 'toolCell_'+rowID+'_'+tool;
      let toolQuantityCell = '#toolQuantityCell_'+tool;
      var notyID = "noty1_"+tool;
      if($('#'+toolCell).length == 0){
        stt++;
        let rowHTML = '<tr style="background-color: #b0daff;" class="trTool" id="row_'+rowID+'"><td rowspan="1" style="vertical-align: inherit;" id="td_1_4">' + stt + '</td><td  id = "'+toolCell+'"> <div class="notifyjs-wrapper notifyjs-hidable" id="noty_'+tool+'" ></div><span class = "toolNameCell" id ='+notyID+'>'  + toolName + '</span></td><td rowspan="1" style="vertical-align: inherit;" id="'+toolTypeCell+'">' + toolTypeName + '</td><td id = "'+toolGroupCell+'"> ' + toolGroupName + '</td><td id = "toolQuantityCell_'+tool+'">' + toolQuantity + '</td><td style="vertical-align: inherit;"><div class=" iconRemoveRowTable"><span class="glyphicon glyphicon-remove-sign"></span></div></td></tr>';
        $('#tblTool').append(rowHTML);
      }else{
        let tmpToolQuantity = $(toolQuantityCell).html();
        $(toolQuantityCell).html(parseInt(tmpToolQuantity)+ parseInt(toolQuantity));
      }
    }else{
      checkToolQuantity= true;
    }
  });
  //  ./ click button addToll to add row table

  // update quantity and  remove row table
  $('#tblTool').on('click', '.iconRemoveRowTable', function () {
    let indexRow = this.parentNode.parentNode.rowIndex;
    let table = document.getElementById("tblTool");
    let row = table.rows[indexRow];
    let toolIDSearch = (row.id.split("_")[1]); // get tool id by row id - row_(toolID)
    let quantityUpdate = table.rows[indexRow].cells[4].innerHTML;
    let tool =arrSearch(toolIDSearch , resData['tools'], 'tool_id');
    tool['num'] = parseInt(tool['num'])+ parseInt(quantityUpdate);
    document.getElementById("tblTool").deleteRow(indexRow);
    //  set số thư tự
    let numRow =  $('#tblTool tr').length;
    for(var i = 1; i< numRow; i++ ){
      stt =i;
      table.rows[i].cells[0].innerHTML = stt;
    }
  });
  var dataTable = [];
  /*
    dataTable = [
                  {
                    toolGroup : {toolGroupValue:1 , toolGroupName: abc},
                    toolType  : {toolTypeValue:1 , toolTypeName: xyz},
                    tool  : {toolValue:1 , toolNameName: xyz},
                    quantity  : 1
                  },
                  {
                    toolGroup : {toolGroupValue:2 , toolGroupName: abc},
                    toolType  : {toolTypeValue:2 , toolTypeName: xyz},
                    tool  : {toolValue:2 , toolName: xyz},
                    quantity  : 1
                  }
  .             ]
  */
  //get data from tool table
  function getDataTable(){
   let dataTable = [];
   let numRow =  $('#tblTool tr').length;
   let table = document.getElementById("tblTool")
   if(numRow > 1){
    for(var i =1 ; i< numRow; i++){
      let element = {};
      let row = table.rows[i];
      let toolID = row.cells[1].id.split("_")[1];
      let toolTypeID = row.cells[2].id.split("_")[2];
      let toolGroupID = row.cells[3].id.split("_")[2];
      let quantity = row.cells[4].innerHTML;
      quantity = parseInt(quantity);
      element.tool_id = toolID;
      element.tool_category_id = toolTypeID;
      element.tool_type = toolGroupID;
      element.num = quantity;
      dataTable.push(element);
    }
    console.log(dataTable);
  }
  return dataTable;
}
  // $('#btnTest').click(function(){
  //   getDataTable();
  // });

  // ====================================================== ./ GUI ===========================================================================


  // ====================================================== ./ DATA ==========================================================================

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

  // function search a element in array
  /*
    value : value search
    arr : array search
    filterCol: column of array
    => return undefined if array is empty or can't find
    */
    function arrSearch(value, arr, filterCol){
    // console.log(arr.length);
    if(arr.length == 0)
      return undefined;
    else{
      if(arr.length == 1){
        if(arr[0][filterCol] == value)
          return arr[0];
      }
      for(var cArr = 0 ; cArr < arr.length; cArr++)
      {
        if(arr[cArr][filterCol] == value)
          return arr[cArr];
      }
    }
    return undefined;
  }

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

//function get lastest Goods

function getLastestGoods(){
      // alert("ttht ne "+orderShow);
      let lastestGoods;
      var frmInfo = {};
      $.each($('form').serializeArray(),function(){
        frmInfo[this.name] = this.value;
      });
    //  ajax
    $.ajax('{{url("/operating/getLastestGoods")}}', {
      type: 'POST',  
      data: frmInfo,
      dataType:"json",
      async: false,
      success: function (result) {
        if(result.success)
        {
          // console.log('------------------------lastest goods-------------------');
          // console.log(result.success);
          lastestGoods = result.success['lastestGoods'];
        }
        if(result.error)
        {
          swal("Thất bại", "Có lỗi trong quá trình xử lý", "error");
        }          
        // console.log(result); 
      }

    });
    //  ./ ajax
    return lastestGoods;
  }
  //getLastestCarInfoByPlace - nơi giao
  function getLastestCarInfoByPlace(){
       // alert("ttht ne "+orderShow);
       let lastestCars;
       var frmInfo = {};
       $.each($('form').serializeArray(),function(){
        frmInfo[this.name] = this.value;
      });
    //  ajax
    $.ajax('{{url("/operating/getLastestCarInfoByPlace")}}', {
      type: 'POST',  
      data: frmInfo,
      dataType:"json",
      async: false,
      success: function (result) {
        if(result.success)
        {
          // console.log('------------------------lastest goods-------------------');
          // console.log(result.success);
          lastestCars = result.success['lastestCars'];
        }
        if(result.error)
        {
          swal("Thất bại", "Có lỗi trong quá trình xử lý", "error");
        }          
        // console.log(result); 
      }

    });
    //  ./ ajax
    return lastestCars;
  }
    //FUNCTION GET DRIVER OR ASISTANT DRIVER FOR OPERATING
    // type = 0 - Driver
    //type = 1 -Assistant driver
    function getDriverInfoForOperating(type = 0){
      // alert("ttht ne "+orderShow);
      // alert("xxxx");
      let driverInfo;
      let msg ="";
      var frmInfo = {};
      $.each($('form').serializeArray(),function(){
        frmInfo[this.name] = this.value;
      });
      frmInfo['type'] = type;
    //  ajax
    $.ajax('{{url("/operating/getDriverInfoForOperating")}}', {
      type: 'POST',  
      data: frmInfo,
      dataType:"json",
      async: false,
      success: function (result) {
        if(result.success)
        {
          // console.log('------------------------car infor -------------------');
         // console.log(result);
         driverInfo = result.success;
         //let driverInfo = getDriverInfoForOperating();
         console.log(driverInfo);
         let numberOfScheduleCurrentMonth = driverInfo['numberOfScheduleCurrentMonth'];
         let numberOfScheduleLastMonth = driverInfo['numberOfScheduleLastMonth'];
         let countHYOSUNG = driverInfo['countHYOSUNG'];
         let countFAR = driverInfo['countFAR'];
         let numberOfScheduleByCarType = driverInfo['numberOfScheduleByCarType'];
         let top = driverInfo['top'];
         let topLastMonth = driverInfo['topLastMonth'];
         let notWorkingDates = driverInfo['notWorkingDates'];
         //console.log('a'+driverInfo['topLastMonth']);

         // let msg = "Thông tin: \n";
         // if(element['note'])
         //  msg += element['note'];
         msg += "\n- Số chuyến đi tháng này: " + numberOfScheduleCurrentMonth;
         if(type == 0 && numberOfScheduleByCarType.length > 0){
          msg += "\n- Số chuyến theo loại xe: ";
          for(let c=0; c < numberOfScheduleByCarType.length; c++){
            msg += "\n   Loại xe: "+numberOfScheduleByCarType[c]['name']+" - Số chuyến: "+numberOfScheduleByCarType[c]['count_row'];
          }
        }
        msg += "\n- Số chuyến đi tháng trước: "+numberOfScheduleLastMonth;
        msg += "\n- Thứ hạng tháng này: " + top;
        msg += "\n- Số ngày trống lệnh: "+notWorkingDates.length;
        msg += "\n- Thứ hạng tháng trước: "+topLastMonth;
        msg += "\n- Số chuyến giao đến HYOSUNG: " +countHYOSUNG;
        msg += "\n- Số chuyến giao đến FAR: "+ countFAR


         // ============================
       }
       if(result.error)
       {
        swal("Thất bại", "Có lỗi trong quá trình xử lý", "error");
      }          
      console.log(result); 
    }

  });
    //  ./ ajax
    console.log(msg);
    return msg;
  }

// filter goods by goods type
/*
let romoocOptions = arrFilter(this.value, resData['freeTrailers'],'trailer_type_id');
      console.log(this.value)
      console.log(romoocOptions);
      addOptionSelectBox('#selRomooc', romoocOptions, 'trailer_id', 'trailer_num');
      */

      var goodsOptions =  arrFilter($('#selGoodsType').val(), resData['goods'],'goods_type');

// add option to select selLoaiHang -  resData['goods']
addOptionSelectBox('#selLoaiHang',goodsOptions, 'goods_id', 'sort_name');
$('#selGoodsType').on('change', function(){
  var goodsOptions =  arrFilter($('#selGoodsType').val(), resData['goods'],'goods_type');
  $("#selLoaiHang option[value!='']").each(function() {
    $(this).remove();
  });
  let goodsType =  $('#selGoodsType').val();
  if(goodsType == 0)
    $('#selLoaiXe').val(4).trigger('change');
  if(goodsType == 1) 
    $('#selLoaiXe').val(2).trigger('change');
  addOptionSelectBox('#selLoaiHang',goodsOptions, 'goods_id', 'sort_name');
})
// select change show infor of selLoaiHang
$('#selLoaiHang').on('change', function() {


  let element =   arrSearch(this.value , resData['goods'], 'goods_id');
  if(element){
    let msgRate = "Tỉ trọng: ";
    if(element['rate'])
      msgRate += element['rate'];
    let msgNote = "\nGhi chú: ";
    if(element['note'])
      msgNote += element['note'];
    let msg = msgRate + msgNote;
    showNotify("#selLoaiHang", msg, "info", "top");
  }
})
// click lblLoaiHang show infor selLaoiHang
$('#lblLoaiHang').click(function(){
  let productID = $('#selLoaiHang').val();
  let element = arrSearch(productID , resData['goods'], 'goods_id');
  if(element){
    let msgRate = "Tỉ trọng: ";
    if(element['rate'])
      msgRate += element['rate'];
    let msgNote = "\nGhi chú: ";
    if(element['note'])
      msgNote += element['note'];
    let msg = msgRate + msgNote;
    showNotify("#selLoaiHang", msg, "info", "top");
  }
});

// add option to select selNoiNhan
addOptionSelectBox('#selNoiNhan', resData['receiptPlaces'], 'place_id', 'name');
// select change show infor of selNoiNhan
$('#selNoiNhan').on('change', function() {
  let element =   arrSearch(this.value , resData['receiptPlaces'], 'place_id');
  if(element){
    let msgNote = "Ghi chú: ";
    if(element['warehouse_note'])
      msgNote += element['warehouse_note'];
    let msgContact ="\nLiên hệ: ";
    if(element['contact_note'])
      msgContact += element['contact_note'];
    let msg = msgNote+msgContact;
    showNotify("#selNoiNhan", msg, "info", "top");
  }
})
// click lblNoiNhan show selNoiNhan's infor 
$('#lblNoiNhan').click(function(){
  let noiNhanID = $('#selNoiNhan').val();
  let element =   arrSearch(noiNhanID , resData['receiptPlaces'], 'place_id');
  if(element){
    let msgNote = "Ghi chú: ";
    if(element['warehouse_note'])
      msgNote += element['warehouse_note'];
    let msgContact ="\nLiên hệ: ";
    if(element['contact_note'])
      msgContact += element['contact_note'];
    let msg = msgNote+msgContact;
    showNotify("#selNoiNhan", msg, "info", "top");
  }
});

// add option to select selNoiGiao
addOptionSelectBox('#selNoiGiao', resData['deliveryPlaces'], 'place_id', 'name');
// select change show infor of selNoiGiao
$('#selNoiGiao').on('change', function() {
  let element =   arrSearch(this.value , resData['deliveryPlaces'], 'place_id');
  if(element){
   let msgNote = "Ghi chú: ";
   if(element['warehouse_note'])
    msgNote += element['warehouse_note'];
  let msgContact ="\nLiên hệ: ";
  if(element['contact_note'])
    msgContact += element['contact_note'];
  let msg = msgNote+msgContact;
  //call ajax get lastest cars
  let lastestCarInfo = getLastestCarInfoByPlace();
  if(lastestCarInfo.length > 0){
    lastestCarMSG = "\nCác xe giao gần nhất: ";
    for(let l=0; l< lastestCarInfo.length; l++){
      lastestCarMSG += "\nSố xe: "+lastestCarInfo[l]['car_num'];
      if(lastestCarInfo[l]['trailer_num'])
        lastestCarMSG+= " - Số Romooc: "+lastestCarInfo[l]['trailer_num'];
    }
    msg += lastestCarMSG;
  }
  // console.log('====================');
  // console.log(lastestCarInfo);
  showNotify("#selNoiGiao", msg, "info", "top");
}
})
// click lblNoiGiao show selNoiGiao infor 
$('#lblNoiGiao').click(function(){
  let noiGiaoID = $('#selNoiGiao').val();
  let element =   arrSearch(noiGiaoID , resData['deliveryPlaces'], 'place_id');
  if(element){
   let msgNote = "Ghi chú: ";
   if(element['warehouse_note'])
    msgNote += element['warehouse_note'];
  let msgContact ="\nLiên hệ: ";
  if(element['contact_note'])
    msgContact += element['contact_note'];
  let msg = msgNote+msgContact;
  //call ajax get lastet car info
  let lastestCarInfo = getLastestCarInfoByPlace();
  if(lastestCarInfo.length > 0){
    lastestCarMSG = "\nCác xe giao gần nhất: ";
    for(let l=0; l< lastestCarInfo.length; l++){
      lastestCarMSG += "\nSố xe: "+lastestCarInfo[l]['car_num'];
      if(lastestCarInfo[l]['trailer_num'])
        lastestCarMSG+= " - Số Romooc: "+lastestCarInfo[l]['trailer_num'];
    }
    msg += lastestCarMSG;
  }
  showNotify("#selNoiGiao", msg, "info", "top");
}
});

// add option to select selChuHang
addOptionSelectBox('#selChuHang', resData['partners'], 'partner_id', 'partner_short_name');
// select change show infor of selChuHang
$('#selChuHang').on('change', function() {
  let element =   arrSearch(this.value , resData['partners'], 'partner_id');
  console.log(element);
  if(element){
    if(element['num'])
      $('#txtSoLuongHangHoa').val(element['num']);
    else
      $('#txtSoLuongHangHoa').val("");
    if(element['document1'])
      $('#txtCTMT1').val(element['document1']); 
    else
      $('#txtCTMT1').val("");
    if(element['document2'])
     $('#txtCTMT2').val(element['document2']); 
   else
    $('#txtCTMT2').val(""); 
  if(element['suggest_note'])
    $('#txtGhiChu').val(element['suggest_note']);
  else
   $('#txtGhiChu').val("");

    // f(element['num'])
    //   $('#txtSoLuongHangHoa').val(element['num']);
  //  console.log(element['note']);
  let msgNote = "Ghi chú: ";
  if(element['note']){
    msgNote += element['note'];
  }

  let msgContact = "\nLiên hệ: ";
  if(element['contact_note'])
    msgContact+= element['contact_note'];

    // let msg = "Thông tin: \n"+element['note'];
    let msg = msgNote + msgContact;
    showNotify("#selChuHang", msg, "info", "top");
    $('#selNoiNhan').val(element['suggest_receipt']).trigger('change.select2');
    $('#selNoiGiao').val(element['suggest_delivery']).trigger('change.select2');
    $('#selNguoiPhuTrach').val(element['suggest_user']).trigger('change.select2');
    $('#selLoaiHang').val(element['suggest_goods']).trigger('change.select2');
  }
  /*
  let tmpCar =  arrSearch(this.value, resData['cars'], 'car_id');
      // console.log(tmpCar['driver_suggestion']);
      $('#selTaiXe').val(tmpCar['driver_suggestion']).trigger('change.select2');
      */
    })
  // click lblChuHang show infor selChuHang
  $('#lblChuHang').click(function(){
    let chuHangID = $('#selChuHang').val();
    let element =   arrSearch(chuHangID , resData['partners'], 'partner_id');
    if(element){
     let msgNote = "Ghi chú: ";
     if(element['note']);
     msgNote += element['note'];

     let msgContact = "\nLiên hệ: ";
     if(element['contact_note'])
       msgContact+= element['contact_note'];

     let msg = msgNote + msgContact;
     showNotify("#selChuHang", msg, "info", "top");
   }
 });

    // add option to select selLoaiRomooc
    addOptionSelectBox('#selLoaiRomooc', resData['trailerTypes'], 'trailer_type_id', 'trailer_type_name');
    // select change show infor of selChuHang
    $('#selLoaiRomooc').on('change', function() {
    // clear option selXe
    $("#selRomooc option[value!='']").each(function() {
      $(this).remove();
    });
    if(freeRule == false){
      let romoocOptions = arrFilter(this.value, resData['freeTrailers'],'trailer_type_id');
      console.log(this.value)
      console.log(romoocOptions);
      addOptionSelectBox('#selRomooc', romoocOptions, 'trailer_id', 'trailer_num');
    }else{
      let romoocOptions = arrFilter(this.value, resData['trailers'],'trailer_type_id');
      addOptionSelectBox('#selRomooc', romoocOptions, 'trailer_id', 'trailer_num');
    }
  })
    // add option to select selRomooc
   // addOptionSelectBox('#selRomooc', resData['trailers'], 'trailer_id', 'trailer_num');
    // select change show infor of selRomooc
    $('#selRomooc').on('change', function() {
      let element =   arrSearch(this.value , resData['trailers'], 'trailer_id');
      if(element){
        let msg = "Thông tin: ";
        if(element['note'])
          msg += element['note'];
        // == call ajax
        if($('#selLoaiXe').val()  == 3){
          // alert("xxxx");
          let lastestGoods = getLastestGoods();
          console.log(lastestGoods);
          if(lastestGoods.length > 0){
            lastestGoodsMSG = "\nCác hóa chất gần nhất: \n";
            for(let l=0; l< lastestGoods.length; l++){
              lastestGoodsMSG += lastestGoods[l]['sort_name'] +", ";
            }
            lastestGoodsMSG = lastestGoodsMSG.substring(0, lastestGoodsMSG.length - 2);
            msg += lastestGoodsMSG;
          }
        }
        showNotify("#selRomooc", msg, "info", "top");
      }
    })
    //click lblroMooc show infor $('#selXe')
    $('#lblRomooc').click(function(){
      let element =   arrSearch($('#selRomooc').val() , resData['trailers'], 'trailer_id');
      if(element){
        let msg = "Thông tin: ";
        if(element['note'])
          msg += element['note'];
        // == call ajax
        if($('#selLoaiXe').val()  == 3){
          // alert("xxxx");
          let lastestGoods = getLastestGoods();
          console.log(lastestGoods);
          if(lastestGoods.length > 0){
            lastestGoodsMSG = "\nCác hóa chất gần nhất: \n";
            for(let l=0; l< lastestGoods.length; l++){
              lastestGoodsMSG += lastestGoods[l]['sort_name'] +", ";
            }
            lastestGoodsMSG = lastestGoodsMSG.substring(0, lastestGoodsMSG.length - 2);
            msg += lastestGoodsMSG;
          }
        }
        showNotify("#selRomooc", msg, "info", "top");
      }
    })

    //function lọc mảng
  // function 
  // add option to select selLoaiXe
  addOptionSelectBox('#selLoaiXe', resData['carTypes'], 'car_type_id', 'name');
  // select change show infor of selChuHang
  $('#selLoaiXe').on('change', function() {

  // console.log(resData['carTypes'][0]['name']);
  if(this.value == 3){
    $('#selRomooc').prop('disabled', false);
    $('#selLoaiRomooc').prop('disabled', false);
  }
  else{
    $('#selRomooc').val('').trigger('change');;
    $('#selLoaiRomooc').val('').trigger('change');
    //alert($('#selRomooc').val());
    $('#selRomooc').prop('disabled', true);
    $('#selLoaiRomooc').prop('disabled', true);
  }
  // clear option selXe
  $("#selXe option[value!='']").each(function() {
    $(this).remove();
  });
  if(freeRule == false){
    let xeOptions = arrFilter(this.value, resData['freeCars'],'car_type_id');
    addOptionSelectBox('#selXe', xeOptions, 'car_id', 'car_num');
  }else{
    let xeOptions = arrFilter(this.value, resData['cars'],'car_type_id');
    addOptionSelectBox('#selXe', xeOptions, 'car_id', 'car_num');
  }
})

    // add option to select selTaiXe
    addOptionSelectBox('#selTaiXe', resData['freeDrivers'], 'user_id', 'nick_name');

    // click Car to suggestion driver 
    $('#selXe').on('change', function() {
      let tmpCar =  arrSearch(this.value, resData['cars'], 'car_id');
      console.log(tmpCar);
      $('#selTaiXe').val(tmpCar['driver_suggestion']).trigger('change.select2');
      $('#selPhuXe').val(tmpCar['assistant_driver_suggestion']).trigger('change.select2');
      let element =   arrSearch(this.value , resData['cars'], 'car_id');
      if(element){
        let msg = "Thông tin: \n";
        if(element['note'])
          msg += element['note'];
        // ==== call ajax to get lastest goods
        if($('#selLoaiXe').val()  == 4){
          let lastestGoods = getLastestGoods();
          if(lastestGoods.length > 0){
            lastestGoodsMSG = "\nCác hóa chất gần nhất: \n";
            for(let l=0; l< lastestGoods.length; l++){
              lastestGoodsMSG += lastestGoods[l]['sort_name'] +", ";
            }
            lastestGoodsMSG = lastestGoodsMSG.substring(0, lastestGoodsMSG.length - 2);
            msg += lastestGoodsMSG;
          }
        }

        showNotify("#selXe", msg, "info", "top");
      }
      //call ajax get lastest goods
    })
    $('#lblXe').click(function(){
      let element =   arrSearch($('#selXe').val() , resData['cars'], 'car_id');
      if(element){
       let msg = "Thông tin: \n";
       if(element['note'])
        msg += element['note'];
       // ==== call ajax to get lastest goods
       if($('#selLoaiXe').val()  == 4){
        let lastestGoods = getLastestGoods();
        if(lastestGoods.length > 0){
          lastestGoodsMSG = "\nCác hóa chất gần nhất: \n";
          for(let l=0; l< lastestGoods.length; l++){
            lastestGoodsMSG += lastestGoods[l]['sort_name'] +", ";
          }
          lastestGoodsMSG = lastestGoodsMSG.substring(0, lastestGoodsMSG.length - 2);
          msg += lastestGoodsMSG;
        }
      }
      showNotify("#selXe", msg, "info", "top");
    }
  })

    //select chang show infor of driver
    $('#selTaiXe').on('change', function() {
      let element =   arrSearch(this.value , resData['drivers'], 'user_id');
      console.log(resData['drivers']);
      console.log(this.value);
      if(element){
        // alert('xxxx');
        // === get driver infor ==============
        let msg = "Thông tin: \n";
        if(element['full_name'])
          msg += "-Họ tên: "+element['full_name'];
        if(element['phone'])
          msg += "\n-SĐT: "+element['phone'];
        if(element['identity_id'])
          msg += "\n-CMND : "+element['identity_id'];
        let driverInfo = getDriverInfoForOperating();
        if(element['note'])
          msg += "\n-Ghi chú: "+ element['note'];

        msg += driverInfo;
      // ==========================
      showNotify("#selTaiXe", msg, "info", "top");
    }
  })
    //Click lblTaiXe show selTaiXe infor
    $('#lblTaiXe').click(function(){
     let element =   arrSearch($('#selTaiXe').val() , resData['drivers'], 'user_id');
     if(element){
      let msg = "Thông tin: \n";
      if(element['full_name'])
        msg += "-Họ tên: "+element['full_name'];
      if(element['phone'])
        msg += "\n-SĐT: "+element['phone'];
      if(element['identity_id'])
        msg += "\n-CMND : "+element['identity_id'];
      let driverInfo = getDriverInfoForOperating();
      // console.log(driverInfo);
      msg += driverInfo;
      if(element['note'])
        msg += element['note'];
      showNotify("#selTaiXe", msg, "info", "top");
    } 
  });

        // add option to select selLoXe
        addOptionSelectBox('#selPhuXe', resData['freeAssistantDrivers'], 'user_id', 'nick_name');
    // select change show infor of selLoXe
    $('#selPhuXe').on('change', function() {
      let element =   arrSearch(this.value , resData['assistantDrivers'], 'user_id');
      if(element){
        let msg = "Thông tin: \n";
        if(element['full_name'])
          msg += "-Họ tên: "+element['full_name'];
        if(element['phone'])
          msg += "\n-SĐT: "+element['phone'];
        if(element['identity_id'])
          msg += "\n-CMND : "+element['identity_id'];

        let driverInfo = getDriverInfoForOperating(1);
        msg += driverInfo;
        if(element['note'])
          msg +="\n-Ghi chú: "+ element['note'];
        showNotify("#selPhuXe", msg, "info", "top");
      }
    })
    // Click lblPhuXe show selPhuXe
    $('#lblPhuXe').click(function(){
      let element =   arrSearch($('#selPhuXe').val() , resData['assistantDrivers'], 'user_id');
      if(element){
        let msg = "Thông tin: \n";
        if(element['full_name'])
          msg += "-Họ tên: "+element['full_name'];
        if(element['phone'])
          msg += "\n-SĐT: "+element['phone'];
        if(element['identity_id'])
          msg += "\n-CMND : "+element['identity_id'];

        let driverInfo = getDriverInfoForOperating(1);
        msg += driverInfo;
        if(element['note'])
          msg +="\n-Ghi chú: "+ element['note']
        
        showNotify("#selPhuXe", msg, "info", "top");
      } 
    });

            // add option to select selXitBon
            addOptionSelectBox('#selXitBon', resData['clearTanks'], 'clear_tank_id', 'clear_tank_name');
    // select change show infor of selXitBon
    $('#selXitBon').on('change', function() {
      let element =   arrSearch(this.value , resData['clearTanks'], 'clear_tank_id');
      if(element){
        let msg = "Thông tin: \n";
        if(element['note'])
          msg += element['note'];
        showNotify("#selXitBon", msg, "info", "top");
      }
    })
    //click lblXitBon show infor 
    $('#lblXitBon').click(function(){
      let element =   arrSearch($('#selXitBon').val() , resData['clearTanks'], 'clear_tank_id');
      if(element){
        let msg = "Thông tin: \n";
        if(element['note'])
          msg += element['note'];
        showNotify("#selXitBon", msg, "info", "top");
      }
    })


  // $('#btnOK').click(function(){
  //   var bien = $('#txtNDTruocNoiNhan').val();
  //   alert(bien);
  // });

  // ////////////////
  // Set default option for selLoaiDungCu
  $('#txtSoLuongDungCu').val(1);
  $('#txtSoLuongDungCu').prop('readonly', true);
  var defaultLoaiDungCuOptions = arrFilter(1, resData['toolCategories'],'tool_type');
  addOptionSelectBox('#selLoaiDungCu', defaultLoaiDungCuOptions, 'tool_category_id', 'name');
    // click selNhom Dung cu change selLoaiDungCu optioons
    $('#selNhomDungCu').on('change', function() {
    // clear option selLoaiDungCu
    $("#selLoaiDungCu option[value!='']").each(function() {
      $(this).remove();
    });
      // clear sel DungCu
      $("#selDungCu option[value!='']").each(function() {
        $(this).remove();
      });
      let loaiDungCuOptions = arrFilter(this.value, resData['toolCategories'],'tool_type');
      addOptionSelectBox('#selLoaiDungCu', loaiDungCuOptions, 'tool_category_id', 'name');
      // set view only if loaiDungCu=1
      let tmpVal =$(this).val();
      if(tmpVal == 1){
        $('#txtSoLuongDungCu').val(1);
        $('#txtSoLuongDungCu').prop('readonly', true);
      }else{
        // $('#txtSoLuongDungCu').val(1);
        $('#txtSoLuongDungCu').val('');
        $('#txtSoLuongDungCu').prop('readonly', false);
        $('#txtSoLuongDungCu').val(1);
      }
      // alert($(this).val());
    })
  // Click selLoaiDungCu to change selDungCu options
  $('#selLoaiDungCu').on('change', function() {
      // clear sel DungCu
      $("#selDungCu option[value!='']").each(function() {
        $(this).remove();
      });
      let selDungCuOptions = arrFilter(this.value, resData['tools'],'tool_category_id');
      if(freeRule)
      {//case free rule
        // console.log('case free rule');
        selDungCuOptions = arrFilter(this.value, resData['toolsFull'],'tool_category_id');
      }
      addOptionSelectBox('#selDungCu', selDungCuOptions, 'tool_id', 'name');
    })

    // Click selDungCu to show note
    $('#selDungCu').on('change', function() {
      let elementNotFull =   arrSearch(this.value , resData['tools'], 'tool_id');
      let elementFull =   arrSearch(this.value , resData['toolsFull'], 'tool_id');
      let element = elementFull;
      if(elementNotFull)
        element = elementNotFull;
      if(element){
        let msg = "";
        if(element['num'] != null)
          msg += "Số lượng: "+ element['num'];
        if(element['parameter'])
          msg += "\nThông số: " + element['parameter'];
        if(element['infomation'])
          msg += "\nThông tin: " + element['infomation']
        showNotify("#selDungCu", msg, "info", "top");
      }
    })
    // click lblTenDungCu Cu show selDungCu infor 
    $('#lblTenDungCu').click(function(){
      let elementNotFull =   arrSearch($('#selDungCu').val() , resData['tools'], 'tool_id');
      let elementFull =   arrSearch($('#selDungCu').val() , resData['toolsFull'], 'tool_id');
      let element = elementFull;
      if(elementNotFull)
        element = elementNotFull;
      if(element){
        let msg = "";
        if(element['num'] != null){
          msg += "Số lượng:" + element['num'];
        }
        if(element['parameter'])
          msg += "\nThông số:" + element['parameter'];
        if(element['infomation'])
          msg += "\nThông tin:" + element['infomation'];
       // console.log(ele);
       showNotify("#selDungCu", msg, "info", "top");
     } 
   });
    // hover table show tool's notify
    $(document).on('mouseover', '.toolNameCell', function() {
      $('.notifyjs-wrapper').trigger('notify-hide'); // hide other notify
      let pos = ($(this).attr('id'));
      let idT = pos.split("_");
      let toolID = (idT[1]);
    //  alert(toolID);
      //========
      let elementNotFull =   arrSearch(toolID , resData['tools'], 'tool_id');
      let elementFull =   arrSearch(toolID , resData['toolsFull'], 'tool_id');
      let element = elementFull;
      if(elementNotFull)
        element = elementNotFull;
      console.log(element);
      if(element){
        let msg = "";
        // if(element['num'] != null){
        //   msg += "Số lượng:" + element['num'];
        // }
        if(element['parameter'])
          msg += "\nThông số:" + element['parameter'];
        if(element['infomation'])
          msg += "\nThông tin:" + element['infomation'];
       // console.log(ele);
       p = "#noty_"+toolID;
       console.log(p);
       showNotify(p, msg, "info", "top");  
     }  

      //=======


    }); 

  // set value selNguoiPhuTrach
  // let selNguoiPhuTrachOptions = arrFilter(15, resData['tools'],'tool_category_id');
  addOptionSelectBox('#selNguoiPhuTrach', resData['curators'], 'user_id', 'nick_name');
  $('#selNguoiPhuTrach').on('change', function() {
    let element =   arrSearch(this.value , resData['curators'], 'user_id');
    if(element){
      let msg = "Thông tin: \n";
      if(element['note'])
        msg += element['note'];
      showNotify("#selNguoiPhuTrach", msg, "info", "top");
    }
  })
  $('#lblNguoiPhuTrach').click(function(){
   let element =   arrSearch($('#selNguoiPhuTrach').val() , resData['curators'], 'user_id');
   if(element){
    let msg = "Thông tin: \n";
    if(element['note'])
      msg += element['note'];
    showNotify("#selNguoiPhuTrach", msg, "info", "top");
  } 
});
  

  // ============== Submit form ==========================
    // Set value for appened fiels
    var txtNDTruocChuHang = "";
    $(document).on('change', '#txtNDTruocChuHang', function() {
      txtNDTruocChuHang = $("#txtNDTruocChuHang").val();
    });
    var txtNDSauChuHang = "";
    $(document).on('change', '#txtNDSauChuHang', function() {
      txtNDSauChuHang = $("#txtNDSauChuHang").val();
    });
    var txtNDTruocNoiNhan = "";
    $(document).on('change', '#txtNDTruocNoiNhan', function() {
      txtNDTruocNoiNhan = $("#txtNDTruocNoiNhan").val();
    });
    var txtNDSauNoiNhan = "";
    $(document).on('change', '#txtNDSauNoiNhan', function() {
      txtNDSauNoiNhan = $("#txtNDSauNoiNhan").val();
    });
    var txtNDTruocNoiGiao = "";
    $(document).on('change', '#txtNDTruocNoiGiao', function() {
      txtNDTruocNoiGiao = $("#txtNDTruocNoiGiao").val();
    })
    var txtNDSauNoiGiao = "";
    $(document).on('change', '#txtNDSauNoiGiao', function() {
      txtNDSauNoiGiao = $("#txtNDSauNoiGiao").val();
    })
    var txtNDTruocTaiXe = "";
    $(document).on('change', '#txtNDTruocTaiXe', function() {
      txtNDTruocTaiXe = $("#txtNDTruocTaiXe").val();
    })
    var txtNDSauTaiXe = "";
    $(document).on('change', '#txtNDSauTaiXe', function() {
      txtNDSauTaiXe = $("#txtNDSauTaiXe").val();
    })
    var txtNDTruocPhuXe = "";
    $(document).on('change', '#txtNDTruocPhuXe', function() {
      txtNDTruocPhuXe = $("#txtNDTruocPhuXe").val();
    })
    var txtNDSauPhuXe = "";
    $(document).on('change', '#txtNDSauPhuXe', function() {
      txtNDSauPhuXe = $("#txtNDSauPhuXe").val();
    })

    // Function get order Show
    function getTTHT(){
      let ttht = $('#txtTTHT').val();
      // if(ttht && !isNaN(ttht))
      // {
      // }else{
        let today = new Date();
        let dd = today.getDate();
        let mm = today.getMonth()+1; //January is 0!
        let yy = today.getFullYear().toString().substr(-2);
        if(dd<10) {
          dd = '0'+dd
        }
        if(mm<10) {
          mm = '0'+mm
        }
        today = yy+mm+dd+"."+ttht;
        ttht =today;
      // }
      return ttht;
    }
    // function setTTHT(){

    // }

    /* Check chkFreeRule checked? 
    checked = true => get all car , all driver, all assistant driver
    checked = false = > only get free cars, frees drivers and free assintant drivers
    */
    // $("#chkFreeRule").click(function(){
    //   alert("xxxx");
    // });
    var freeRule = false;
    $("#chkFreeRule").on("ifChanged", function(){
     $('#selLoaiDungCu').val('').trigger('change');
     let selectedDriver =$('#selTaiXe').val();

     let selectedAssistantDriver = $('#selPhuXe').val();
     let selectedCar = $('#selXe').val();
     let selectedRomooc = $('#selRomooc').val();

      // clear selTaiXe
      $("#selTaiXe option[value!='']").each(function() {
        $(this).remove();
      });
     // clear selLoXe
     $("#selPhuXe option[value!='']").each(function() {
      $(this).remove();
    });
     // clear selXe
     $("#selXe option[value!='']").each(function() {
      $(this).remove();
    });
      // clear selRomooc
      $("#selRomooc option[value!='']").each(function() {
        $(this).remove();
      });
      freeRule = !freeRule;
      console.log("FreeRule: "+freeRule);
      if(freeRule){
         // add option to select selTaiXe with option all Driver
         // alert(selectedDriver);
         addOptionSelectBox('#selTaiXe', resData['drivers'], 'user_id', 'nick_name');
         $('#selTaiXe').val(selectedDriver);
         // console.log( resData['drivers']);
         addOptionSelectBox('#selPhuXe', resData['assistantDrivers'], 'user_id', 'nick_name');
         $('#selPhuXe').val(selectedAssistantDriver);
         let xeOptions = arrFilter($('#selLoaiXe').val(), resData['cars'],'car_type_id');
         addOptionSelectBox('#selXe', xeOptions, 'car_id', 'car_num');
         $('#selXe').val(selectedCar);
         let romoocOptions = arrFilter($('#selLoaiRomooc').val(), resData['trailers'],'trailer_type_id');
         addOptionSelectBox('#selRomooc', romoocOptions, 'trailer_id', 'trailer_num');
         $('#selRomooc').val(selectedRomooc);

       }else{
         addOptionSelectBox('#selTaiXe', resData['freeDrivers'], 'user_id', 'nick_name');
         $('#selTaiXe').val(selectedDriver);
         addOptionSelectBox('#selPhuXe', resData['freeAssistantDrivers'], 'user_id', 'nick_name');
         $('#selPhuXe').val(selectedAssistantDriver);
         let xeOptions = arrFilter($('#selLoaiXe').val(), resData['freeCars'],'car_type_id');
         addOptionSelectBox('#selXe', xeOptions, 'car_id', 'car_num');
         $('#selXe').val(selectedCar);
         let romoocOptions = arrFilter($('#selLoaiRomooc').val(), resData['freeTrailers'],'trailer_type_id');
         addOptionSelectBox('#selRomooc', romoocOptions, 'trailer_id', 'trailer_num');
          // alert(selectedRomooc);//
          console.log(romoocOptions);
          $('#selRomooc').val(selectedRomooc);
         // reset tools here
         let dataTable = getDataTable();
         console.log(dataTable);
         if(dataTable.length >0){
          for(let i =0; i< dataTable.length; i++){
            let searchToolFull = arrSearch(dataTable[i]['tool_id'] , resData['toolsFull'], 'tool_id');
            let searchTool = arrSearch(dataTable[i]['tool_id'] , resData['tools'], 'tool_id');
            // if(searchTool)
            //   searchTool['num'] = searchTool['num'] + dataTable[i]['num'];
            if(searchToolFull && !searchTool){
              searchToolFull['num'] = parseInt(searchToolFull['num'])+ parseInt(dataTable[i]['num']);
              let deleteRowID = '#row_'+dataTable[i]['tool_id'];
              $(deleteRowID).remove();
            }
          }
          // stt =0;
          let table = document.getElementById("tblTool");
          let numRow =  $('#tblTool tr').length;
          for(var i = 1; i< numRow; i++ ){
            stt =i;
            table.rows[i].cells[0].innerHTML = stt;
          }
          //$('.trTool').remove();
        }

         // clear tool table
       }
     });
    // =======================
    var countSubmitForm = 0;
    function addOperation (){

      let orderShow =getTTHT();
      // alert("ttht ne "+orderShow);
      let dataTable = getDataTable();
      var info = {};
      $.each($('form').serializeArray(),function(){
        info[this.name] = this.value;
      });
      info['txtNDTruocChuHang'] = txtNDTruocChuHang;
      info['txtNDSauChuHang']= txtNDSauChuHang;
      info['txtNDTruocNoiNhan'] = txtNDTruocNoiNhan;
      txtNDTruocNoiNhan = "";
      info['txtNDSauNoiNhan'] = txtNDSauNoiNhan;
      txtNDSauNoiNhan = "";
      info['txtNDTruocNoiGiao'] = txtNDTruocNoiGiao;
      txtNDTruocNoiGiao = "";
      info['txtNDSauNoiGiao'] = txtNDSauNoiGiao;
      txtNDSauNoiGiao = "";
      info['txtNDTruocTaiXe'] = txtNDTruocTaiXe;
      txtNDTruocTaiXe = "";
      info['txtNDSauTaiXe'] = txtNDSauTaiXe;
      txtNDSauTaiXe = "";
      info['txtNDTruocPhuXe'] = txtNDTruocPhuXe;
      txtNDTruocPhuXe = "";
      info['txtNDSauPhuXe'] = txtNDSauPhuXe;
      txtNDSauPhuXe = "";
      info['operatingTools'] = dataTable;
      info['orderShow'] = orderShow;
      info['freeRule'] = 0;
      if(freeRule)
        info['freeRule'] = 1;
            // console.log(info);
    //  ajax
    $.ajax('{{url("/creatOperating")}}', {
      type: 'POST',  
      data: info,
      dataType:"json",
      async: true,
      success: function (result) {
        if(result.success)
        {
          console.log(result.success);
          swal("Thành công", "Đã thêm mới 01 lệnh điều xe!", "success")
          .then((value) => {
            window.location.href = "/operating";
          });
          setTimeout(function(){ window.location.href = "/operating"; }, 3000);
        }
        if(result.errors)
        {
          flagSubmit = true;
          swal("Thất bại", "Có lỗi trong quá trình xử lý", "error");
        }
        if(result.errorsBusyData){
         $('.msgError').text('');
         $('.trTool').css("background-color", "#b0daff");
         Object.keys(result.errorsBusyData).forEach(function (key) {
          console.log(typeof result.errorsBusyData[key]);
          if(typeof result.errorsBusyData[key] == 'string'){
            // alert('string');
            let msgError = "msgError_"+key;
            $('#'+msgError).text(result.errorsBusyData[key]);
          }
            //case tool
            if(typeof result.errorsBusyData[key] == 'object'){
              let busyTools = result.errorsBusyData[key];
              Object.values(busyTools).forEach(function (keyTool){
               console.log("tool id "+keyTool);
               $('#row_'+keyTool).css("background-color", "#f2dede");
             });
            }
          });
         // if(result.errorsBusyData.length > 0)
         countSubmitForm = 0;
         swal("Lỗi", "Dữ liệu không hợp lệ, vui lòng kiểm tra lại!", "error");
       }         
       console.log(result); 
     }

   });
    //  ./ ajax
    return false;
  }

  // $('#btnOK').click(function(){
    var flagSubmit = true;
    $( "#btnOK" ).on( "click", function(){
      console.log('btnOk clicked');
      let selGT = $('#selGoodsType').val();
      let selLH = $('#selLoaiHang').val();
      let selChuHang = $('#selChuHang').val();
      let flagError = false;
      if(!selGT){
        $('#msgErrorGT').text("Thiếu thông tin loại hàng");
        flagError=true;
      }else{
        $('#msgErrorGT').text("");
      }
      if(!selLH){
        $('#msgErrorLH').text("Thiếu thông tin mặt hàng");
        flagError=true;
      }else{
        $('#msgErrorLH').text("");
      }
      if(!selChuHang){
        $('#msgErrorCH').text("Thiếu thông tin chủ hàng");
        flagError=true
      }else{
        $('#msgErrorCH').text("");
      }
      if(flagError){
     //  $("#btnOK").one("click");
     swal({
      title: "Thiếu thông tin",
      text: "Vui lòng kiểm tra lại thông tin",
      icon: "error",
          // button: "Aww yiss!",
        });
     flagSubmit = false;
     flagError= false;
   }else{
    flagSubmit = true;
   // countSubmitForm ++;
   if(countSubmitForm > 1){
    countSubmitForm= 0;
   //   alert('stop');
   return;
 }
 if(flagSubmit)
   addOperation();
 flagSubmit = false;
 // alert('submit failed');


}


});

// ====== ./ submit form ================

 // Test Key code
 function getSuggestOperatingByHotKey(){
  var info = {};
  $.each($('form').serializeArray(),function(){
    info[this.name] = this.value;
  });
  // console.log(info);
  $.ajax('{{url("/getSuggestOperatingByHotKey")}}', {
    type: 'POST',  
    data: info,
    dataType:"json",
    async: true,
    success: function (result) {
      if(result.success)
      {
        // console.log(result.success);
        let suggestOperating = result.success['operating'];
        //  console.log(suggestOperating['busyRomoocs1']);
        // console.log(suggestOperating['suggestRomooc1']);
        // console.log('------------------------------');
        // console.log(suggestOperating['suggestRomooc']);
        $('#selLoaiHang').val(suggestOperating['goods_id']).trigger('change.select2');
        if(suggestOperating['num']){
          $('#txtSoLuongHangHoa').val(suggestOperating['num']);
        }
        $('#selNoiNhan').val(suggestOperating['receipt_place_id']).trigger('change.select2');
        $('#selNoiGiao').val(suggestOperating['delivery_place_id']).trigger('change.select2');
        $('#selLoaiXe').val(suggestOperating['car_type_id']).trigger('change.select2');
        $('#selLoaiRomooc').val(suggestOperating['trailer_type_id']).trigger('change.select2');
        // console.log($('#selLoaiXe').val());
        let lx = $('#selLoaiXe').val();
        let lRm = $('#selLoaiRomooc').val();
        if(lx == 3){
          $('#selRomooc').prop('disabled', false);
          $('#selLoaiRomooc').prop('disabled', false);
        }
        else{
          $('#selRomooc').prop('disabled', true);
          $('#selLoaiRomooc').prop('disabled', true);
        }
        $("#selXe option[value!='']").each(function() {
          $(this).remove();
        });
        $("#selRomooc option[value!='']").each(function() {
          $(this).remove();
        });
        if(freeRule == false){
          let xeOptions = arrFilter(lx, resData['freeCars'],'car_type_id');
          addOptionSelectBox('#selXe', xeOptions, 'car_id', 'car_num');
          let trailerOptions = arrFilter(lRm, resData['freeTrailers'],'trailer_type_id');
          addOptionSelectBox('#selRomooc', trailerOptions, 'trailer_id', 'trailer_num');

          $('#selXe').val(suggestOperating['suggestCar']).trigger('change.select2');
          $('#selTaiXe').val(suggestOperating['suggestDriver']).trigger('change.select2');
          $('#selPhuXe').val(suggestOperating['suggestAssistantDriver']).trigger('change.select2');
          $('#selRomooc').val(suggestOperating['suggestRomooc']).trigger('change.select2');

        }else{
          let xeOptions = arrFilter(lx, resData['cars'],'car_type_id');
          addOptionSelectBox('#selXe', xeOptions, 'car_id', 'car_num');
          $('#selXe').val(suggestOperating['suggestCar']).trigger('change.select2');
          $('#selTaiXe').val(suggestOperating['suggestDriver']).trigger('change.select2');
          $('#selPhuXe').val(suggestOperating['suggestAssistantDriver']).trigger('change.select2');
          $('#selRomooc').val(suggestOperating['suggestRomooc']).trigger('change.select2');
        }
        if(suggestOperating['note']){
          $('#txtGhiChu').val(suggestOperating['note']);
        }
        if(suggestOperating['document1']){
          $('#txtCTMT1').val(suggestOperating['document1']);
        }
        if(suggestOperating['document2']){
          $('#txtCTMT2').val(suggestOperating['document2']);
        }
        $('#selNguoiPhuTrach').val(suggestOperating['curator_id']).trigger('change.select2');
        let tmpSTT = suggestOperating['order_show'];
        tmpSTT = tmpSTT.toString();
        tmpSTT = tmpSTT.substr(7);
        // tmpSTT = parseInt(tmpSTT);
        // console.log(tmpSTT);
        $('#txtTTHT').val(tmpSTT);
        $('#txtGioDi').val(suggestOperating['departure_time']);
        // $('#txtGioDi').css({'color' : 'blue'});
        // $(this).css({'background-color' : '#FFFFEEE'});
        // $('#selTinhTrang').val(suggestOperating['status']).trigger('change.select2');
        $('#selXitBon').val(suggestOperating['clear_tank_id']).trigger('change.select2');
        // $('#selTinhTrang').css({'color' : 'blue'});

        //suggest owner note
        if(suggestOperating['before_driver_note'] || suggestOperating['before_driver_note']){
          if($('#contentCHDescription').length ==0 ){
           var ownerDescription = "<div id = 'contentCHDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước CH</label><input type='text' class='form-control' id='txtNDTruocChuHang' placeholder='ND trước chủ hàng'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau CH</label><input type='text' class='form-control' id='txtNDSauChuHang' placeholder='ND sau chủ hàng'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeCHDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
           $("#showNDChuHang").append(ownerDescription).hide().show('slow');
           $('#clickToShowNDChuHang').hide();
         }
         $('#txtNDTruocChuHang').val(suggestOperating['before_owner_note']);
         $('#txtNDSauChuHang').val(suggestOperating['after_owner_note']);
         txtNDTruocChuHang = $('#txtNDTruocChuHang').val();
         txtNDSauChuHang =  $('#txtNDSauChuHang').val();
       }
        // suggest driver's note
        if(suggestOperating['before_driver_note'] || suggestOperating['before_driver_note']){
          if($('#contentDriverDescription').length ==0 ){
            var driverDescription = "<div id = 'contentDriverDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước TX</label><input type='text' class='form-control' id='txtNDTruocTaiXe' placeholder='ND trước tài xế'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau TX</label><input type='text' class='form-control' id='txtNDSauTaiXe' placeholder='ND sau tài xế'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeDriverDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
            $("#showDriverDescription").append(driverDescription).hide().show('slow');
            $('#clickToShowDriverDescription').hide();
          }
          $('#txtNDTruocTaiXe').val(suggestOperating['before_driver_note']);
          $('#txtNDSauTaiXe').val(suggestOperating['after_driver_note']);
          txtNDTruocTaiXe = $('#txtNDTruocTaiXe').val();
          txtNDSauTaiXe =  $('#txtNDSauTaiXe').val();
        }
        // suggest assistant driver's note
        if(suggestOperating['before_assistant_note'] || suggestOperating['after_assistant_note']){
          if($('#contentAssistantDriverDescription').length ==0 ){
           var assistantDriverDescription = "<div id = 'contentAssistantDriverDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước PX</label><input type='text' class='form-control' id='txtNDTruocPhuXe' placeholder='ND trước phụ xe'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau PX</label><input type='text' class='form-control' id='txtNDSauPhuXe' placeholder='ND sau phụ xe'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeAssistantDriverDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
           $("#showAssistantDriverDescription").append(assistantDriverDescription).hide().show('slow');
           $('#clickToShowAssistantDriverDescription').hide();
         }
         $('#txtNDTruocPhuXe').val(suggestOperating['before_assistant_note']);
         $('#txtNDSauPhuXe').val(suggestOperating['after_assistant_note']);
         txtNDTruocPhuXe = $('#txtNDTruocPhuXe').val();
         txtNDSauPhuXe = $('#txtNDSauPhuXe').val();
       }
        // suggest _receipt_note
        if(suggestOperating['before_receipt_note'] || suggestOperating['after_receipt_note']){
          if($('#ndTruocNoiNhan').length ==0 ){
            var ndTruocNoiNhan = "<div id = 'ndTruocNoiNhan'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước nơi nhận</label><input type='text' class='form-control' id='txtNDTruocNoiNhan' placeholder='ND trước nơi nhận'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau nơi nhận</label><input type='text' class='form-control' id='txtNDSauNoiNhan' placeholder='ND sau nơi nhận'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeNDNoiNhan'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
            $("#showNDTruocNoiNhan").append(ndTruocNoiNhan).hide().show('slow');
            $('#clickToShowNDTruocNoiNhan').hide();
          }
          $('#txtNDTruocNoiNhan').val(suggestOperating['before_receipt_note']);
          $('#txtNDSauNoiNhan').val(suggestOperating['after_receipt_note']);
          txtNDTruocNoiNhan = $('#txtNDTruocNoiNhan').val();
          txtNDSauNoiNhan =  $('#txtNDSauNoiNhan').val();
        }
        // suggest delivery_notet note
        if(suggestOperating['before_delivery_note'] || suggestOperating['after_delivery_note']){
          if($('#ndNoiGiao').length ==0 ){
           var ndNoiGiao = "<div id = 'ndNoiGiao'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước nơi giao</label><input type='text' class='form-control' id='txtNDTruocNoiGiao' placeholder='ND trước nơi giao'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau nơi giao</label><input type='text' class='form-control' id='txtNDSauNoiGiao' placeholder='ND sau nơi giao'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeNDNoiGiao'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
           $("#showNDNoiGiao").append(ndNoiGiao).hide().show('slow');;
           $('#clickToShowNDNoiGiao').hide();
         }
         $('#txtNDTruocNoiGiao').val(suggestOperating['before_delivery_note']);
         $('#txtNDSauNoiGiao').val(suggestOperating['after_delivery_note']);
         txtNDTruocNoiGiao = $('#txtNDTruocNoiGiao').val();
         txtNDSauNoiGiao =  $('#txtNDSauNoiGiao').val();
       }
       //suggest tools list 
    // tạm thông báo lỗi, cần update
    if(suggestOperating['errSuggestTool']){
      let errSuggestTool='<div class="alert alert-warning alert-dismissible msgErrorTableTool"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h4><i class="icon fa fa-warning"></i> Cảnh báo!</h4>Không thể gợi ý công cụ, vui lòng kiểm tra lại dữ liệu và thêm công cụ bằng cách thủ công!</div>';  
      if ($(".msgErrorTableTool").length > 0){$('.msgErrorTableTool').remove();}
      $('#showErrorTable').append(errSuggestTool);  
    }else{
        // ----------------------------------------------
        if(suggestOperating['operatingTools'] ){
          $("#tblTool:not(:first)").remove();
          $stt =0;
          var operatingTools = suggestOperating['operatingTools'];
          var rowTable ="";
          if(operatingTools.length > 0){

            for(var i = 0; i< operatingTools.length; i++){
              let rowID = operatingTools[i]['tool_id'];
              let toolTypeCell = 'toolTypeCell_'+rowID+'_'+operatingTools[i]['tool_category_id'];
              let toolGroupCell = 'toolGroupCell_'+rowID+'_'+operatingTools[i]['tool_type'];
              let toolCell = 'toolCell_'+rowID+'_'+operatingTools[i]['tool_id'];
              let tool =  arrSearch(operatingTools[i]['tool_id'], resData['tools'], 'tool_id');
              let toolType = arrSearch(operatingTools[i]['tool_category_id'], resData['toolCategories'], 'tool_category_id');
              let toolGroup = operatingTools[i]['tool_type'];
              let toolGroupText = "DỤNG CỤ 1";
              if(toolGroup != 1){
                toolGroupText = "DỤNG CỤ 2";
              }
              stt = i+1;
              let quantity = operatingTools[i]['num'];
              rowTable +='<tr style="background-color: #b0daff;" class="trAddTool" id="row_'+rowID+'" ><td rowspan="1" style="vertical-align: inherit;" id="td_1_4">' + stt + '</td><td id = "'+toolCell+'">' + tool['name'] + '</td><td rowspan="1" style="vertical-align: inherit;" id="'+toolTypeCell+'">' + toolType['name'] + '</td><td id = "'+toolGroupCell+'"> ' + toolGroupText + '</td><td id = "toolQuantityCell_'+rowID+'">' + quantity + '</td><td style="vertical-align: inherit;"><div class=" iconRemoveRowTable"><span class="glyphicon glyphicon-remove-sign"></span></div></td></tr>';
            }
            $('#tblTool').append(rowTable);
                //remove error message div if it exist
                if ($(".msgErrorTableTool").length > 0){
                  $('.msgErrorTableTool').remove();
                }   

              }

            }
        // ----------------------------------------------
      }
       // ./ suggest tools list 

        // ------------------------

      }
      if(result.error)
      {
        swal("Thất bại", "Có lỗi trong quá trình xử lý", "error");
      }          
      console.log(result); 
    }

  });

}
//----------------------------------------------------------------
var notShowAlertAgain1 = false;
$(document).on('click', '#chkNotShowAgian', function () {
  if ($(this).is(':checked')){
    notShowAlertAgain1 = true;
    console.log("not show alert again");
    if (typeof(Storage) !== "undefined") {
          sessionStorage.notShowAlertAgain = true;
          var notShowAlertAgain = sessionStorage.notShowAlertAgain;
      console.log(notShowAlertAgain);
    } 
  }
});
document.onkeydown=function(e){
    var e = e || window.event; // for IE to cover IEs window object
    if(e.altKey && e.which == 65) 
    {
      // check not show alert agian
      if (typeof(Storage) !== "undefined") {
        if(!sessionStorage.notShowAlertAgain){
          var span = document.createElement("span");
          span.innerHTML = "<input type='checkbox' name='vehicle' id ='chkNotShowAgian' value='Bike' > Tắt lặp lại thông báo này";
          swal({
            title: "Chú ý",
            text: "Khi bạn sử dụng chức năng gợi ý, bạn cần tự kiểm soát mọi ràng buộc về dữ liệu!",
            content: span,
            icon: "warning",
            dangerMode: false,
            buttons: true,       
          })
          .then((willDelete) => {
            if (willDelete) {
              $("#tblTool tr:not(:first)").remove();

              getSuggestOperatingByHotKey();
            } else {
            }
          });
        }else{
          $("#tblTool tr:not(:first)").remove();
          getSuggestOperatingByHotKey();
        }
      }
    }
  }
  // ---------------------------------------------------------
  /*
      var span = document.createElement("span");
     span.innerHTML = "Testno  sporocilo za objekt <b>test</b>";

     swal({
      title: "xxx", 
      content: span,
      confirmButtonText: "V redu", 
      allowOutsideClick: "true" 
    })
    */

  // document.onkeydown=function(e){
  //   var e = e || window.event; // for IE to cover IEs window object
  //   if(e.altKey && e.which == 65) 
  //   {

  //     getSuggestOperatingByHotKey();
  //     // alert('ALT + A!');
  //     // return false;
  //   }
  // }

/*
swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this imaginary file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("Poof! Your imaginary file has been deleted!", {
      icon: "success",
    });
  } else {
    swal("Your imaginary file is safe!");
  }
});
*/
  //  ./ test hot key


});

// ============================================================== DATA ========================================================================
</script>
<!-- =========================================================================== ./ PAGE SCRIPT ================================================ -->

@endsection