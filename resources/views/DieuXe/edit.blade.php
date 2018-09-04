@extends('blank')
@section('content')
<style type="text/css">
.hideDiv{
  display: none;
}
</style>
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
    </section>

    <!-- Main content -->
    <section class="content">
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
                <input type="text" class="form-control" name ="txtMaGopChuyen" id="txtMaGopChuyen" placeholder="-- Mã gộp chuyến --">
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
                <option value="0" selected="" >Hàng bồn</option>
                <option value="1" ="">Hàng phi</option>
                <!-- append options here -->
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label id="lblLoaiHang" style="font-family: Arial;">Loại hàng(*)</label>   <i style="color: red" id="msgErrorLH"></i>
              <select class="form-control select2" name = "selLoaiHang" id = "selLoaiHang" style="width: 100%; " data-placeholder="-- Chọn loại hàng --">
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
              <label style="font-family: Arial;" id="lblNoiNhan">Nơi nhận</label>
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
              <label style="font-family: Arial;" id="lblNoiGiao">Nơi giao</label>
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
              <input type="text" class="form-control" name = "txtCTMT1" id="txtCTMT1" placeholder="Chứng từ mang theo số 1">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label style="font-family: Arial;">Chứng từ mang theo 2</label>
              <input type="text" class="form-control" name="txtCTMT2" id="txtCTMT2" placeholder="Chứng từ mang theo số 2">
            </div>
          </div>
        </div>
        <!-- ./ row 6 -->
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
              <label style="font-family: Arial;">Nhóm dụng cụ</label>
              <select name="selNhomDungCu" id="selNhomDungCu" class="form-control " style="width: 100%; " data-placeholder="-- Chọn nhóm dụng cụ --">
                <option value = "1">DỤNG CỤ 1</option>
                <option value ="2">DỤNG CỤ 2</option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label style="font-family: Arial;">Loại dụng cụ</label>
              <select name="selLoaiDungCu" id="selLoaiDungCu" class="form-control select2" style="width: 100%; " data-placeholder="-- Chọn loại dụng cụ --">
                <option value=""></option>
              </select>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label id="lblTenDungCu" style="font-family: Arial;">Tên dụng cụ</label>
              <select name="selDungCu" id="selDungCu" class="form-control select2" style="width: 100%; " data-placeholder="-- Chọn dụng cụ --">
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
                  <th class="th" style="width:110px;" style="text-align: center;">
                    Xóa
                  </th>
                </tr>
                <!-- append tr here -->
                <!-- </tbody> -->
              </table>
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
                <label style="font-family: Arial;" id="lblXe">Xe</label><i style="color: red; padding-left: 15px;" class="msgError" id="msgError_selXe"></i>
                <select class="form-control select2" name ="selXe" id="selXe" style="width: 100%; " data-placeholder="-- Chọn xe--">
                  <option value=""></option>
                  <!-- Append option here -->
                </select>
              </div>
            </div>


          </div>
          <!-- ./ row 9 -->
          <!-- row 10 -->
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <label style="font-family: Arial;">Loại Romooc</label>
                <select class="form-control select2" name ="selLoaiRomooc" id="selLoaiRomooc" disabled style="width: 100%; " data-placeholder="-- Chọn Romooc --">
                  <option value=""></option>
                  <!-- append options here -->
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label style="font-family: Arial;" id="lblRoMoc">Số Romooc</label><i style="color: red; padding-left: 15px;" class="msgError" id="msgError_selRomooc"></i>
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
                </select>
              </div>
            </div>

          </div>
          <!-- ./ row 10 -->
          <!-- row 11 -->
          <div class="row">
             <!--  <div class="col-md-6">
                <div class="form-group">
                  <label style="font-family: Arial;">Xe</label>
                  <select class="form-control select2" name ="selXe" id="selXe" style="width: 100%; " data-placeholder="-- Chọn xe--">
                    <option value=""></option>
                  </select>
                </div>
              </div> -->
            <!--   <div class="col-md-6">
                <div class="form-group">
                  <label id="lblNguoiPhuTrach" style="font-family: Arial;">Người phụ trách</label>
                  <select class="form-control select2" name = "selNguoiPhuTrach" id ="selNguoiPhuTrach" style="width: 100%; " data-placeholder="-- Chọn người phụ trách --">
                    <option value=""></option>
                </select>
              </div>
            </div> -->
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
                <label style="font-family: Arial;" id="lblXitBon">Xịt bồn</label>
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
                <input type="text" name ="txtTTHT"  class="form-control" id="txtTTHT" placeholder="-- Thứ tự --">
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
                    <input type="checkbox" class="flat-red" style="position: absolute; opacity: 0;" name="chkFreeRule" id="chkFreeRule">
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
                <button type="button" class="btn btn-success" id="btnOK">XÁC NHẬN</button>
                <button type="button" class="btn btn-danger" id="btnCopy">COPY</button>
                <button type="button" class="btn btn-success hideDiv" id="btnPoolOperating">LỆNH TỔNG ĐÃ CHỈNH SỬA</button>
                <button type="button" class="btn btn-warning hideDiv " id="btnReset">RESET</button>
                <button type="button" class="btn btn-default" id="btnCancle" >RELOAD</button>
                
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
  // if(isset($id)){
  //   echo "<h1>".$id."</h1>";
  // }
  ?>
  <script>
  //  var tmpStr  ='<?php //if(isset($res)) echo str_replace('\r\n', '\\\n',  json_encode($res)); else echo (json_encode([])) ?>';
    // var resData = JSON.parse(tmpStr);
    var url_string =window.location.href;
    
    var resData;
    var operating ;
    $(document).ready(function () {
      // alert('dđ');
     // alert('{{url("/editOperating/". $page)}}');
     $.ajax('{{url("/editOperating/". $id)}}', {
      type: 'GET',  
      data: {},
      dataType:"json",
      async: false,
      success: function (result) {
        if(result.success)
        {
         resData = result.success;
         operating = resData['operating'][0];
         console.log(resData);
           // console.log(resData);
           // swal("Thành công", "ok!", "success");
         }else{
          // swal("Lỗi", "Không tìm thấy lệnh điều xe!", "error");
          window.location = "/operating"
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
      { position: position,
        autoHideDelay: 30000 }
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
  // document.getElementById("txtNgayDieuXe").valueAsDate = dateVal;
  // document.getElementById("txtNgayDieuXe").value = "2014-02-09 00:00:00";
  // var tmpTime = 
  if(operating['operating_date'] && operating['operating_date'] != null){
    let tmpSqlTime = operating['operating_date'];
    var tmpTime = tmpSqlTime.split(" ");
    document.getElementById("txtNgayDieuXe").value = tmpTime[0];
  }
  // ---------
  // Draw table
  // -------------------------------------------------------------------------------------
  console.log("--------------------------------------------------------");
  console.log(resData['operatingTools']);
  var rowTable ="";
  var operatingTools = resData['operatingTools'];
  var stt = 0;
  if(operatingTools.length > 0){
    // console.log(operatingTools);
    for(var i = 0; i< operatingTools.length; i++){
      // console.log(operatingTools[i]['tool_id']);
      let rowID = operatingTools[i]['tool_id'];
      let toolTypeCell = 'toolTypeCell_'+rowID+'_'+operatingTools[i]['tool_category_id'];
      let toolGroupCell = 'toolGroupCell_'+rowID+'_'+operatingTools[i]['tool_type'];
      let toolCell = 'toolCell_'+rowID+'_'+operatingTools[i]['tool_id'];
      // let tool =  arrSearch(operatingTools[i]['tool_id'], resData['tools'], 'tool_id');
      let tool =  arrSearch(operatingTools[i]['tool_id'], resData['fullTools'], 'tool_id');
      
      let toolType = arrSearch(operatingTools[i]['tool_category_id'], resData['toolCategories'], 'tool_category_id');
      let toolGroup = operatingTools[i]['tool_type'];
      let toolGroupText = "DỤNG CỤ 1";
      if(toolGroup != 1){
        toolGroupText = "DỤNG CỤ 2";
      }
      stt = i+1;
      // console.log(tool['name']);
      var defaultNotyID = "defaultNoty_"+operatingTools[i]['tool_id'];
      var notyID = "noty_"+tool;
      let quantity = operatingTools[i]['num'];

      rowTable +='<tr style="background-color: #b0daff;" class="trTool" id="row_'+rowID+'"><td rowspan="1" style="vertical-align: inherit;" id="td_1_4">' + stt + '</td><td id = "'+toolCell+'"><div class="notifyjs-wrapper notifyjs-hidable" id="noty_'+rowID+'" ></div> <span class = "toolNameCell" id = '+defaultNotyID+' >' + tool['name'] + '</span></td><td rowspan="1" style="vertical-align: inherit;" id="'+toolTypeCell+'">' + toolType['name'] + '</td><td id = "'+toolGroupCell+'">'   + toolGroupText + ' </td><td id = "toolQuantityCell_'+rowID+'">' + quantity + '</td><td style="vertical-align: inherit;"><div class=" iconRemoveRowTable"><span class="glyphicon glyphicon-remove-sign"></span></div></td></tr>';
    }
  }
  // let rowID = tool;
  // let toolTypeCell = 'toolTypeCell_'+rowID+'_'+toolType;
  // let toolGroupCell = 'toolGroupCell_'+rowID+'_'+toolGroup;
  // let toolCell = 'toolCell_'+rowID+'_'+tool;
  // let rowHTML = '<tr style="background-color: #b0daff;" class="trTool" id="row_'+rowID+'"><td rowspan="1" style="vertical-align: inherit;" id="td_1_4">' + stt + '</td><td id = "'+toolCell+'">' + toolName + '</td><td rowspan="1" style="vertical-align: inherit;" id="'+toolTypeCell+'">' + toolTypeName + '</td><td id = "'+toolGroupCell+'"> ' + toolGroupName + '</td><td id = "toolQuantityCell_'+tool+'">' + toolQuantity + '</td><td style="vertical-align: inherit;"><div class=" iconRemoveRowTable"><span class="glyphicon glyphicon-remove-sign"></span></div></td></tr>';
  $('#tblTool').append(rowTable);
  console.log("---------------------------------------------------------");
  // --------------------------------------------------------------------------------------
    //click show nd chủ hàng
    $("#clickToShowNDChuHang").click(function () {
      var driverDescription = "<div id = 'contentCHDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước CH</label><input type='text' class='form-control' id='txtNDTruocChuHang' placeholder='ND trước chủ hàng'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau CH</label><input type='text' class='form-control' id='txtNDSauChuHang' placeholder='ND sau chủ hàng'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeCHDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
      $("#showNDChuHang").append(driverDescription).hide().show('slow');
      $(this).hide();
    });
    // click to remove CH description
    $(document).on('click', '#closeCHDescription', function () {
      $('#contentCHDescription').remove(); 
      $('#clickToShowNDChuHang').show();

    });
  //click to show driver description
  $("#clickToShowDriverDescription").click(function () {
    var driverDescription = "<div id = 'contentDriverDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước TX</label><input type='text' class='form-control' id='txtNDTruocTaiXe' placeholder='ND trước tài xế'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau TX</label><input type='text' class='form-control' id='txtNDSauTaiXe' placeholder='ND sau tài xế'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeDriverDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
    $("#showDriverDescription").append(driverDescription).hide().show('slow');
    $(this).hide();
  });

  // click to remove drive description
  $(document).on('click', '#closeDriverDescription', function () {
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
    $('#ndNoiGiao').remove();
    $('#clickToShowNDNoiGiao').show();
  });


  //remove row of table tool by click
  $('.tblTool tr').each(function () {
    var cellText = $(this).html();
    console.log(cellText);
  });

  // Click button addTool to add row table
  var stt = $('#tblTool tr').length -1;
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
        // var srchTool  =   arrSearch(tool , resData['fullTools'], 'tool_id');
        // srchTool['num'] = srchTool['num'] - toolQuantity;
        // ==============================================
        var srchTool  =   arrSearch(tool , resData['fullTools'], 'tool_id');
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
        // ==============================================
      }
    }
    // add row to tblTool
    var toolTypeName = $('#selLoaiDungCu').select2('data')[0].text;
    var toolName = $('#selDungCu').select2('data')[0].text;
    var toolGroupName = $('#selNhomDungCu').children("option").filter(":selected").text();
    if (toolGroup && tool && toolType && toolQuantity && checkToolQuantity) {
      let rowID = tool;
      let toolTypeCell = 'toolTypeCell_'+rowID+'_'+toolType;
      let toolGroupCell = 'toolGroupCell_'+rowID+'_'+toolGroup;
      let toolCell = 'toolCell_'+rowID+'_'+tool;
      let toolQuantityCell = '#toolQuantityCell_'+tool;

      var notyID = "defaultNoty_"+tool;
      var notyID1 = "noty_"+tool;

      console.log('toolQuantityCell_'+tool);
      if($('#'+toolCell).length == 0){
        stt++;
        let rowHTML = '<tr style="background-color: #b0daff;" class="trTool" id="row_'+rowID+'"><td rowspan="1" style="vertical-align: inherit;" id="td_1_4">' + stt + '</td><td id = "'+toolCell+'"><div class="notifyjs-wrapper notifyjs-hidable" id="noty_'+tool+'" ></div><span class = "toolNameCell" id = '+notyID+' >' + toolName + '</span></td><td rowspan="1" style="vertical-align: inherit;" id="'+toolTypeCell+'">' + toolTypeName + '</td><td id = "'+toolGroupCell+'"> ' + toolGroupName + '</td><td id = "toolQuantityCell_'+tool+'">' + toolQuantity + '</td><td style="vertical-align: inherit;"><div class=" iconRemoveRowTable"><span class="glyphicon glyphicon-remove-sign"></span></div></td></tr>';
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
  function compareSortTool(a,b) {
    if (a.name < b.name)
      return -1;
    if (a.name > b.name)
      return 1;
    return 0;
  }
  //  remove row table
  $('#tblTool').on('click', '.iconRemoveRowTable', function () {
    let indexRow = this.parentNode.parentNode.rowIndex;
    let table = document.getElementById("tblTool");
    let row = table.rows[indexRow];
    let toolIDSearch = (row.id.split("_")[1]); // get tool id by row id - row_(toolID)
    let quantityUpdate = table.rows[indexRow].cells[4].innerHTML;
    let tool =arrSearch(toolIDSearch , resData['tools'], 'tool_id');
    let toolInToolFull =arrSearch(toolIDSearch , resData['fullTools'], 'tool_id');
    if(tool){
      tool['num'] = parseInt(tool['num'])+ parseInt(quantityUpdate);
    }else{
      if(toolInToolFull){
        // console.log(resData['fullTools']);
        console.log(toolInToolFull);
        toolInToolFull['num'] = parseInt(toolInToolFull['num'])+ parseInt(quantityUpdate);
        (resData['tools']).push(toolInToolFull);
        resData['tools'].sort(compareSortTool);
        console.log( resData['tools']);
      }
    }
    
    document.getElementById("tblTool").deleteRow(indexRow);
    //  set số thư tự
    let numRow =  $('#tblTool tr').length;
    for(var i = 1; i< numRow; i++ ){
      stt =i;
      table.rows[i].cells[0].innerHTML = stt;
    } 
  });

  // var hihi = getDataTable();
  // console.log('hihi');
  // console.log(hihi);

  //calculate num of tools on Complete mode
  console.log(resData['tools']);
  function calculateToolNumModeComplete(){
    if(resData['operating'][0]['status'] == 2 && resData['operating'][0]['can_pull'] ==0 ){// mode complete{
      let dataTable = getDataTable();
      // show button pull operating pool
      $( "#btnPoolOperating" ).removeClass( "hideDiv" );
      console.log('aaaa');
      console.log(resData['operatingTools']);
      console.log(dataTable);
      
      if(dataTable.length > 0){
        for(let i=0; i< dataTable.length; i++){
          let searchTool  =   arrSearch(dataTable[i]['tool_id'] , resData['tools'], 'tool_id');
          console.log(resData['tools']);
          console.log(searchTool);
          if(searchTool)
            searchTool['num'] = searchTool['num'] - dataTable[i]['num'];
          else{
            let searchToolFull  =   arrSearch(dataTable[i]['tool_id'] , resData['fullTools'], 'tool_id');
            if(searchToolFull){
              searchToolFull['num'] = searchToolFull['num'] - dataTable[i]['num'];
              resData['tools'].push(searchToolFull);

            }
          }
          // removeElementFromArrray1(resData['operatingTools'], dataTable[i]['tool_id'], 'tool_id');
          console.log(searchTool);
        }
      }
      // var srchTool  =   arrSearch(tool , resData['tools'], 'tool_id');
      console.log(resData['tools']);
    }
    // let dataTable = dataTable();
    // if()
    console.log('xxxxxxxxxxxx');
    console.log(resData['operating'][0]['status']);
  }
  calculateToolNumModeComplete();


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
    $('#btnCancle').click(function(){
      location.reload();
    });


  // ====================================================== ./ GUI ===========================================================================


  // ====================================================== ./ DATA ==========================================================================

  // function add option to selectBox
  /*
    select: where add option (.class or id of selectbox)
    options : array[{'value':'Value of option' , 'text': 'text display'}]
    */
    function addOptionSelectBox(select, options, colValue, colText, selectedValue = null){
      $.each(options, function (i, item) {
      // var lol = ''+colValue;
      // console.log(item[lol]);
      $(select).append($('<option>', { 
        value: item[colValue],
        text :  item[colText]
      }));

      if(selectedValue){
        // $('#selTaiXe').val(tmpCar['driver_suggestion']).trigger('change.select2');
        $(select).val(selectedValue).trigger('change.select2');
      }

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
      if(arr.length == 1 && arr[0][filterCol] == value){
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
        msg += "\n- Thứ hạng tháng trước: " + topLastMonth;
        msg += "\n- Số chuyến giao đến HYOSUNG: " +countHYOSUNG;
        msg += "\n- Số chuyến giao đến FAR: "+ countFAR;


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
  // set freeRule
  var freeRule = false;
  if(operating['rerule'] && operating['rerule'] == 1){
    freeRule = true;
    $('#chkFreeRule').iCheck('check');
  }
//set selected goodtype selectbox
$('#selGoodsType').val(operating['goods_type']).trigger('change.select2');
// add option to select selLoaiHang
var goodsOptions =  arrFilter($('#selGoodsType').val(), resData['goods'],'goods_type');
addOptionSelectBox('#selLoaiHang',goodsOptions, 'goods_id', 'sort_name', operating['goods_id']);
// addOptionSelectBox('#selLoaiHang', resData['goods'], 'goods_id', 'full_name', operating['goods_id']);
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
//=======================

// select change show infor of selLoaiHang
$('#selLoaiHang').on('change', function() {
  let element =   arrSearch(this.value , resData['goods'], 'goods_id');
  if(element){
    let msg = "Tỉ trọng: ";
    if(element['rate'])
      msg += element['rate']; 
    msg += "\n Ghi chú: ";
    if(element['note'])
      msg += element['note'];
    showNotify("#selLoaiHang", msg, "info", "top");
  }
})
// click lblLoaiHang show infor selLaoiHang
$('#lblLoaiHang').click(function(){
  let productID = $('#selLoaiHang').val();
  let element = arrSearch(productID , resData['goods'], 'goods_id');
  if(element){
    let msg = "Tỉ trọng: ";
    if(element['rate'])
      msg += element['rate']; 
    msg += "\n Ghi chú: ";
    if(element['note'])
      msg += element['note'];
    showNotify("#selLoaiHang", msg, "info", "top");
  }
});

// add option to select selNoiNhan
addOptionSelectBox('#selNoiNhan', resData['receiptPlaces'], 'place_id', 'name', operating['receipt_place_id']);
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
//click lblNoiNhan show infor 
$('#lblNoiNhan').click(function(){
 let element =   arrSearch($('#selNoiNhan').val() , resData['receiptPlaces'], 'place_id');
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
addOptionSelectBox('#selNoiGiao', resData['deliveryPlaces'], 'place_id', 'name', operating['delivery_place_id']);
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
  showNotify("#selNoiGiao", msg, "info", "top");
}
})
//click lblnoiGiao show notify 
$('#lblNoiGiao').click(function(){
 let element =   arrSearch($('#selNoiGiao').val() , resData['deliveryPlaces'], 'place_id');
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
  showNotify("#selNoiGiao", msg, "info", "top");
}
});

// add option to select selChuHang
addOptionSelectBox('#selChuHang', resData['partners'], 'partner_id', 'partner_short_name', operating['owner_id']);
// select change show infor of selChuHang
$('#selChuHang').on('change', function() {

  //$('.notifyjs-container').trigger('notify-hide');
  let element =   arrSearch(this.value , resData['partners'], 'partner_id');
  if(element){
    //
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
    //
    let msgNote = "Ghi chú: ";
    if(element['note']){
      msgNote += element['note'];
    }

    let msgContact = "\nLiên hệ: ";
    if(element['contact_note'])
      msgContact+= element['contact_note'];
    let msg = msgNote + msgContact;
    showNotify("#selChuHang", msg, "info", "top");
    $('#selNoiNhan').val(element['suggest_receipt']).trigger('change.select2');
    $('#selNoiGiao').val(element['suggest_delivery']).trigger('change.select2');
    $('#selNguoiPhuTrach').val(element['suggest_user']).trigger('change.select2');
    $('#selLoaiHang').val(element['suggest_goods']).trigger('change.select2');
  }
})
// click lblChuHang show infor selChuHang
$('#lblChuHang').click(function(){
  let chuHangID = $('#selChuHang').val();
  let element =   arrSearch(chuHangID , resData['partners'], 'partner_id');
  if(element){
    let msgNote = "Ghi chú: ";
    if(element['note'])
      msgNote += element['note'];

    let msgContact = "\nLiên hệ: ";
    if(element['contact_note'])
      msgContact+= element['contact_note'];
    let msg = msgNote + msgContact;
    showNotify("#selChuHang", msg, "info", "top");
  }
});


    // add option to select selRomooc
   //  console.log(resData['trailers']);
   //  if(operating['rerule'] == 0)
   //    addOptionSelectBox('#selRomooc', resData['freeTrailers'], 'trailer_id', 'trailer_num', operating['trailer_id']);
   //  else{
   //   addOptionSelectBox('#selRomooc', resData['trailers'], 'trailer_id', 'trailer_num', operating['trailer_id']);
   // }

   addOptionSelectBox('#selLoaiRomooc', resData['trailerTypes'], 'trailer_type_id', 'trailer_type_name', operating['trailer_type_id']);
   //operating['trailer_id'] || 
   // console.log('ech - '+operating['car_type_id']);
   if(operating['car_type_id'] && operating['car_type_id'] == 3){
    $('#selRomooc').prop('disabled', false);
    $('#selLoaiRomooc').prop('disabled', false);
    if(operating['trailer_type_id'] ){
      $("#selRomooc option[value!='']").each(function() {
        $(this).remove();
      });
      let trailerOptions = arrFilter(operating['trailer_type_id'], resData['freeTrailers'],'trailer_type_id');
      if(operating['rerule'] == 1)
       trailerOptions = arrFilter(operating['trailer_type_id'], resData['trailers'],'trailer_type_id');
     addOptionSelectBox('#selRomooc', trailerOptions, 'trailer_id', 'trailer_num',operating['trailer_id']);
   }
 }
    // select change show infor of selRomooc
    $('#selRomooc').on('change', function() {
      let element =   arrSearch(this.value , resData['trailers'], 'trailer_id');
      if(element){
        let msg = "Thông tin: \n";
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
    //click lblRomoc show infor
    $('#lblRoMoc').click(function(){

      let element =   arrSearch($('#selRomooc').val() , resData['trailers'], 'trailer_id');
      if(element){
        let msg = "Thông tin: \n";
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
    });
    $('#selLoaiRomooc').on('change', function(){
      // clear option selromooc
      $("#selRomooc option[value!='']").each(function() {
        $(this).remove();
      });
      if(freeRule == false){
        let xeOptions = arrFilter(this.value, resData['freeTrailers'],'trailer_type_id');
        addOptionSelectBox('#selRomooc', xeOptions, 'trailer_id', 'trailer_num');
      }else{
        let xeOptions = arrFilter(this.value, resData['trailers'],'trailer_type_id');
        addOptionSelectBox('#selRomooc', xeOptions, 'trailer_id', 'trailer_num');
      }
    })
  // add option to select selLoaiXe
  addOptionSelectBox('#selLoaiXe', resData['carTypes'], 'car_type_id', 'name', operating['car_type_id']);
  //check if car type = 3 enable selRomoc
  if(resData['carTypes'] == 3){
    $('#selRomooc').prop('disabled', false);
    $('#selLoaiRomooc').prop('disabled', false);
  }
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
  // let xeOptions = arrFilter(this.value, resData['cars'],'car_type_id');
  // console.log(xeOptions);
  // addOptionSelectBox('#selXe', xeOptions, 'car_id', 'car_num', operating['car_id']);
})

    // add option to select selTaiXe
    if(freeRule == false)
      addOptionSelectBox('#selTaiXe', resData['freeDrivers'], 'user_id', 'nick_name', operating['driver_id']);
    else
      addOptionSelectBox('#selTaiXe', resData['drivers'], 'user_id', 'nick_name', operating['driver_id']);

    // click Car to suggestion driver 
    $('#selXe').on('change', function() {
      let tmpCar =  arrSearch(this.value, resData['cars'], 'car_id');
      $('#selTaiXe').val(tmpCar['driver_suggestion']).trigger('change.select2');
      $('#selPhuXe').val(tmpCar['assistant_driver_suggestion']).trigger('change.select2');
      // console.log(tmpCar['driver_suggestion']);
      $('#selTaiXe').val(tmpCar['driver_suggestion']).trigger('change.select2');
      //show notify
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
    })
    //click label Xe show notify
    $('#lblXe').click(function(){
     let element =   arrSearch($('#selXe').val() , resData['cars'], 'car_id');
     if(element){
      let msg = "Thông tin: \n";
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
  });


    //select chang show infor of driver
    $('#selTaiXe').on('change', function() {
      let element =   arrSearch(this.value , resData['drivers'], 'user_id');
      if(element){
        let msg = "Thông tin: \n";
        if(element['full_name'])
          msg += "-Họ tên: "+element['full_name'];
        if(element['phone'])
          msg += "\n-SĐT: "+element['phone'];
        if(element['identity_id'])
          msg += "\n-CMND : "+element['identity_id'];
        let driverInfo = getDriverInfoForOperating();
        msg += driverInfo;
        if(element['note'])
          msg += element['note'];
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
      msg += driverInfo;
      if(element['note'])
        msg += element['note'];
      showNotify("#selTaiXe", msg, "info", "top");
    } 
  });

        // add option to select selLoXe
        if(freeRule == false)
          addOptionSelectBox('#selPhuXe', resData['freeAssistantDrivers'], 'user_id', 'nick_name', operating['assistant_driver_id']);
        else
         addOptionSelectBox('#selPhuXe', resData['assistantDrivers'], 'user_id', 'nick_name', operating['assistant_driver_id']);
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
          msg += "\n-Ghi chú: "+ element['note'];
        showNotify("#selPhuXe", msg, "info", "top");
      } 
    });

            // add option to select selXitBon
            addOptionSelectBox('#selXitBon', resData['clearTanks'], 'clear_tank_id', 'clear_tank_name', operating['clear_tank_id']);
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
    $('#lblXitBon').click(function(){
      let element =   arrSearch($('#selXitBon').val() , resData['clearTanks'], 'clear_tank_id');
      if(element){
        let msg = "Thông tin: \n";
        if(element['note'])
          msg += element['note'];
        showNotify("#selXitBon", msg, "info", "top");
      }
    });

    $('#selTinhTrang').on('change', function() {
      let tmpStatus =  $('#selTinhTrang').val();
      if(tmpStatus == 2)
        $('#btnPoolOperating').prop('disabled', false);
      else
        $('#btnPoolOperating').prop('disabled', true);
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
    })
  // Click selLoaiDungCu to change selDungCu options
  $('#selLoaiDungCu').on('change', function() {
      // clear sel DungCu
      $("#selDungCu option[value!='']").each(function() {
        $(this).remove();
      });
      let selDungCuOptions = arrFilter(this.value, resData['tools'],'tool_category_id');
      // let selDungCuOptions = arrFilter(this.value, resData['tools'],'tool_category_id');
      if(freeRule)//case free rule
        selDungCuOptions = arrFilter(this.value, resData['fullTools'],'tool_category_id');
      addOptionSelectBox('#selDungCu', selDungCuOptions, 'tool_id', 'name');
    })

    // Click selDungCu to show note
    $('#selDungCu').on('change', function() {
      let elementNotFull =   arrSearch(this.value , resData['tools'], 'tool_id');
      let elementFull =   arrSearch(this.value , resData['fullTools'], 'tool_id');
      let element = elementFull;
      if(elementNotFull)
        element = elementNotFull;
      if(element){
        console.log(element);
        let msg = "Số lượng: ";
        if(element['num'] != null )
          msg += element['num'];
        showNotify("#selDungCu", msg, "info", "top");
      }
    })
    // click lblTenDungCu Cu show selDungCu infor 
    $('#lblTenDungCu').click(function(){
      let elementNotFull =   arrSearch($('#selDungCu').val() , resData['tools'], 'tool_id');
      let elementFull =   arrSearch($('#selDungCu').val() , resData['fullTools'], 'tool_id');
      let element = elementFull;
      if(elementNotFull)
        element= elementNotFull;

      if(element){
        let msg = "Số lượng: ";
        if(element['num'] != null)
          msg += element['num'];
        showNotify("#selDungCu", msg, "info", "top");
      } 
    });
       // hover table show tool's notify
       $(document).on('mouseover', '.toolNameCell', function() {
      $('.notifyjs-wrapper').trigger('notify-hide'); // hide other notify
      let pos = ($(this).attr('id'));
      let idT = pos.split("_");
      let toolID = (idT[1]);
      //========
      let elementNotFull =   arrSearch(toolID , resData['tools'], 'tool_id');
      let elementFull =   arrSearch(toolID , resData['fullTools'], 'tool_id');
      let element = elementFull;
      if(elementNotFull)
        element = elementNotFull;
      if(element){
        let msg = "";
        // if(element['num'] != null){
        //   msg += "Số lượng:" + element['num'];
        // }
        if(element['parameter'])
          msg += "\nThông số: " + element['parameter'];
        if(element['infomation'])
          msg += "\nThông tin: " + element['infomation'];
       // console.log(ele);
       p = "#noty_"+toolID;
       // console.log(typeof msg);
       showNotify(p, msg, "info", "top");  
     }  

      //=======
    }); 

  // set value selNguoiPhuTrach
  // let selNguoiPhuTrachOptions = arrFilter(15, resData['tools'],'tool_category_id');
  addOptionSelectBox('#selNguoiPhuTrach', resData['curators'], 'user_id', 'nick_name', operating['curator_id']);
  $('#selNguoiPhuTrach').on('change', function() {
    let element =   arrSearch(this.value , resData['curators'], 'user_id');
    if(element){
      let msg = "Thông tin: ";
      if(element['note'])
        msg += element['note'];
      showNotify("#selNguoiPhuTrach", msg, "info", "top");
    }
  })
  $('#lblNguoiPhuTrach').click(function(){
   let element =   arrSearch($('#selNguoiPhuTrach').val() , resData['curators'], 'user_id');
   if(element){
    let msg = "Thông tin: ";
    if(element['note'])
      msg += element['note'];
    showNotify("#selNguoiPhuTrach", msg, "info", "top");
  } 
});

// SEt selected status sel
$('#selTinhTrang').val(operating['status']).trigger('change.select2');
//  show nội dung chủ hàng nếu có trong DB
if(operating['before_owner_note'] || operating['after_owner_note']){
  var nDTCH = "";
  var nDSCH = "";
  if(operating['before_owner_note'] != null)
    nDTCH = operating['before_owner_note'];
  if(operating['after_owner_note'] != null)
    nDSCH = operating['after_owner_note'];
  $("#clickToShowNDChuHang").hide();
  var ndCH = "<div id = 'contentCHDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước chủ hàng</label><input type='text' class='form-control' id='txtNDTruocChuHang' placeholder='ND trước chủ hàng' value = '"+nDTCH+"'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau chủ hàng</label><input type='text' class='form-control' id='txtNDSauChuHang' placeholder='ND sau nơi nhận' value = '"+nDSCH+"'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeCHDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
  $("#showNDChuHang").append(ndCH).hide().show();
}
//  show nội dung nơi nhận nếu có trong DB
if(operating['before_receipt_note'] || operating['after_receipt_note']){
  var nDTNN = "";
  var nDSNN = "";
  if(operating['before_receipt_note'] != null)
    nDTNN = operating['before_receipt_note'];
  if(operating['after_receipt_note'] != null)
    nDSNN = operating['after_receipt_note'];
  $("#clickToShowNDTruocNoiNhan").hide();
  var ndTruocNoiNhan = "<div id = 'ndTruocNoiNhan'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước nơi nhận</label><input type='text' class='form-control' id='txtNDTruocNoiNhan' placeholder='ND trước nơi nhận' value = '"+nDTNN+"'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau nơi nhận</label><input type='text' class='form-control' id='txtNDSauNoiNhan' placeholder='ND sau nơi nhận' value = '"+nDSNN+"'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeNDNoiNhan'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
  $("#showNDTruocNoiNhan").append(ndTruocNoiNhan).hide().show();
}
    // Show nội dung nơi giao
    if(operating['before_delivery_note'] || operating['after_delivery_note']){
      let nDTNG = "";
      let nDSNG = "";
      if(operating['before_delivery_note'] != null)
        nDTNG = operating['before_delivery_note'];
      if(operating['after_delivery_note'] != null)
        nDSNG=operating['after_delivery_note'];
      $("#clickToShowNDNoiGiao").hide();
      var ndNoiGiao = "<div id = 'ndNoiGiao'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước nơi giao</label><input type='text' class='form-control' id='txtNDTruocNoiGiao' placeholder='ND trước nơi giao' value = '"+nDTNG+"'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau nơi giao</label><input type='text' class='form-control' id='txtNDSauNoiGiao' placeholder='ND sau nơi giao' value = '"+nDSNG+"'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeNDNoiGiao'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
      $("#showNDNoiGiao").append(ndNoiGiao).hide().show();
    }

    // show nd tài xế
    if(operating['before_driver_note'] || operating['after_driver_note']){
      let nDTTX = "";
      let nDSTX = "";
      if(operating['before_driver_note'] != null)
        nDTTX = operating['before_driver_note'];
      if(operating['after_driver_note'] != null)
        nDSTX = operating['after_driver_note'];
      $("#clickToShowDriverDescription").hide();
      var driverDescription = "<div id = 'contentDriverDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước TX</label><input type='text' class='form-control' id='txtNDTruocTaiXe' placeholder='ND trước tài xế' value = '"+nDTTX+"'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau TX</label><input type='text' class='form-control' id='txtNDSauTaiXe' placeholder='ND sau tài xế' value='"+nDSTX+"'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeDriverDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
      $("#showDriverDescription").append(driverDescription).hide().show();
    }
      // Show nội dung lơ xe
      if(operating['before_assistant_note'] || operating['after_assistant_note']){
        let nDTLX = "";
        let nDSLX = "";
        if(operating['before_assistant_note']  != null)
          nDTLX =operating['before_assistant_note'];
        if(operating['after_assistant_note'] != null)
          nDSLX = operating['after_assistant_note'];
        $("#clickToShowAssistantDriverDescription").hide();
        var assistantDriverDescription = "<div id = 'contentAssistantDriverDescription'><div class='col-xs-5 col-md-5 '><div class='form-group'><label style='font-family: Arial;'>Nội dung trước PX</label><input type='text' class='form-control' id='txtNDTruocPhuXe' placeholder='ND trước phụ xe' value = '"+nDTLX+"'></div></div><div class='col-xs-5 col-md-5'><div class='form-group'><label style='font-family: Arial;'>Nội dung sau PX</label><input type='text' class='form-control' id='txtNDSauPhuXe' placeholder='ND sau phụ xe' value = '"+nDSLX+"'></div></div><div class='col-xs-2 col-md-2' style='margin-top: 30px; font-size: 20px; '><div class='handCursor' id='closeAssistantDriverDescription'  style='color: red;'><span class='glyphicon glyphicon-remove'></span></div></div></div>";
        $("#showAssistantDriverDescription").append(assistantDriverDescription).hide().show();
      }
      // Show mẫ gộp chuyến
      if(operating['group_num']){
        $("#txtMaGopChuyen").val(operating['group_num']);
      }
      // txtSoLuongHangHoa Show số lượng hàng hóa
      if(operating['num']){
        $("#txtSoLuongHangHoa").val(operating['num']);
      }
      if(operating['departure_time']){
        $("#txtGioDi").val(operating['departure_time']);
      }
      if(operating['document1']){
        $("#txtCTMT1").val(operating['document1']);
      }
      if(operating['document2']){
        $("#txtCTMT2").val(operating['document2']);
      }
      if(operating['note']){
        $("#txtGhiChu").val(operating['note']);
      }
      if(operating['order_show']){
        $("#txtTTHT").val(operating['order_show']);
      }

      var tmpLoaiXeID = $('#selLoaiXe').val();
      // alert(tmp);
      // function arrFilter(value, arr, filterCol)
      if(operating['rerule'] && operating['rerule'] == 1){
        var arrTmpXe = arrFilter(tmpLoaiXeID, resData['cars'], 'car_type_id');
      // add option to selCar
      addOptionSelectBox('#selXe', arrTmpXe, 'car_id', 'car_num', operating['car_id']);
    }else{
      var arrTmpXe = arrFilter(tmpLoaiXeID, resData['freeCars'], 'car_type_id');
      // add option to selCar
      addOptionSelectBox('#selXe', arrTmpXe, 'car_id', 'car_num', operating['car_id'])
      // console.log(arrTmpXe);
    }



  // ============== Submit form ==========================
    // Set value for appened fiels
    var txtNDTruocChuHang = $("#txtNDTruocChuHang").val();
    $(document).on('change', '#txtNDTruocChuHang', function() {
      txtNDTruocChuHang = $("#txtNDTruocChuHang").val();
    });
    var txtNDSauChuHang = $("#txtNDSauChuHang").val();
    $(document).on('change', '#txtNDSauChuHang', function() {
      txtNDSauChuHang = $("#txtNDSauChuHang").val();
    });
    // var txtNDTruocNoiNhan = "";

    var txtNDTruocNoiNhan = $("#txtNDTruocNoiNhan").val();
    $(document).on('change', '#txtNDTruocNoiNhan', function() {
      txtNDTruocNoiNhan = $("#txtNDTruocNoiNhan").val();
    });
    // var txtNDSauNoiNhan = "";
    var txtNDSauNoiNhan = $("#txtNDSauNoiNhan").val();
    $(document).on('change', '#txtNDSauNoiNhan', function() {
      txtNDSauNoiNhan = $("#txtNDSauNoiNhan").val();
    });
    // var txtNDTruocNoiGiao = "";
    var txtNDTruocNoiGiao = $("#txtNDTruocNoiGiao").val();
    $(document).on('change', '#txtNDTruocNoiGiao', function() {
      txtNDTruocNoiGiao = $("#txtNDTruocNoiGiao").val();
    })
    // var txtNDSauNoiGiao = "";
    var txtNDSauNoiGiao = $("#txtNDSauNoiGiao").val();
    $(document).on('change', '#txtNDSauNoiGiao', function() {
      txtNDSauNoiGiao = $("#txtNDSauNoiGiao").val();
    })
    // var txtNDTruocTaiXe = "";
    var txtNDTruocTaiXe = $("#txtNDTruocTaiXe").val();
    $(document).on('change', '#txtNDTruocTaiXe', function() {
      txtNDTruocTaiXe = $("#txtNDTruocTaiXe").val();
    })
    // var txtNDSauTaiXe = "";
    var txtNDSauTaiXe = $("#txtNDSauTaiXe").val();
    $(document).on('change', '#txtNDSauTaiXe', function() {
      txtNDSauTaiXe = $("#txtNDSauTaiXe").val();
    })
    // var txtNDTruocPhuXe = "";
    var txtNDTruocPhuXe = $("#txtNDTruocPhuXe").val();
    $(document).on('change', '#txtNDTruocPhuXe', function() {
      txtNDTruocPhuXe = $("#txtNDTruocPhuXe").val();
    })
    // var txtNDSauPhuXe = "";
    var txtNDSauPhuXe = $("#txtNDSauPhuXe").val();
    $(document).on('change', '#txtNDSauPhuXe', function() {
      txtNDSauPhuXe = $("#txtNDSauPhuXe").val();
    })

    
    // Function get order Show
    function getTTHT(){
      let ttht = $('#txtTTHT').val();
      if(ttht && !isNaN(ttht))
      {
        // alert(ttht)
      }else{
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
        today = yy+mm+dd+"0";
        ttht =today;
      }
      return ttht;
    } 
    // var freeRule = false;

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
      // clear selXe
      $("#selRomooc option[value!='']").each(function() {
        $(this).remove();
      });
      freeRule = !freeRule;
      console.log("Free Rule "+freeRule);
      if(freeRule){
         // add option to select selTaiXe with option all Driver
         addOptionSelectBox('#selTaiXe', resData['drivers'], 'user_id', 'nick_name', selectedDriver);
         addOptionSelectBox('#selPhuXe', resData['assistantDrivers'], 'user_id', 'nick_name', selectedAssistantDriver);
         let xeOptions = arrFilter($('#selLoaiXe').val(), resData['cars'],'car_type_id');
         addOptionSelectBox('#selXe', xeOptions, 'car_id', 'car_num', selectedCar);
         let romoocOptions = arrFilter($('#selLoaiRomooc').val(), resData['trailers'],'trailer_type_id');
         addOptionSelectBox('#selRomooc', romoocOptions, 'trailer_id', 'trailer_num', selectedRomooc);
       }else{
         addOptionSelectBox('#selTaiXe', resData['freeDrivers'], 'user_id', 'nick_name', selectedDriver);
         addOptionSelectBox('#selPhuXe', resData['freeAssistantDrivers'], 'user_id', 'nick_name', selectedAssistantDriver);
         let xeOptions = arrFilter($('#selLoaiXe').val(), resData['freeCars'],'car_type_id');
         addOptionSelectBox('#selXe', xeOptions, 'car_id', 'car_num', selectedCar);
         let romoocOptions = arrFilter($('#selLoaiRomooc').val(), resData['freeTrailers'],'trailer_type_id');
         addOptionSelectBox('#selRomooc', romoocOptions, 'trailer_id', 'trailer_num',selectedRomooc);
          // reset tools here
          let dataTable = getDataTable();
          if(dataTable.length >0){
            console.log(dataTable);

            for(let i =0; i< dataTable.length; i++){

              let tool =arrSearch(dataTable[i]['tool_id'] , resData['tools'], 'tool_id');
              let toolInToolFull =arrSearch(dataTable[i]['tool_id'] , resData['fullTools'], 'tool_id');
              //let currentTool = null;
              let currentTool= arrSearch(dataTable[i]['tool_id'] , resData['operatingTools'], 'tool_id');
            //  alert(tool['tool_id']);
              /*
              if(tool){
                tool['num'] = parseInt(tool['num'])+ parseInt(dataTable[i]['num']);
              }else{
                if(toolInToolFull){
                  console.log(toolInToolFull);
                  toolInToolFull['num'] = parseInt(toolInToolFull['num'])+ parseInt(dataTable[i]['num']);
                  (resData['tools']).push(toolInToolFull);
                  console.log( resData['tools']);
                }
              }
              */
             // console.log(resData['fullTools']);
             // console.log('flacgcopy '+flagCopy);
             if(toolInToolFull && !tool && !currentTool){
              toolInToolFull['num'] = parseInt(toolInToolFull['num'])+ parseInt(dataTable[i]['num']);
              console.log(resData['fullTools']);
              let deleteRowID = '#row_'+dataTable[i]['tool_id'];
              $(deleteRowID).remove();
            }
          }
          let table = document.getElementById("tblTool");
          let numRow =  $('#tblTool tr').length;
          for(var i = 1; i< numRow; i++ ){
            stt =i;
            table.rows[i].cells[0].innerHTML = stt;
          } 
        }
         ///
       }
     });  

    // =======================

    var routeName = '{{url("/postEditOperating")}}';
    function addOperation (routeName){
      let dataTable = getDataTable();
      let orderShow =getTTHT();
      var info = {};
      $.each($('form').serializeArray(),function(){
        info[this.name] = this.value;
      });
      info['txtNDTruocChuHang'] = txtNDTruocChuHang;
      info['txtNDSauChuHang'] = txtNDSauChuHang;
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
      info['operating_id'] = operating['operating_id'];
      info['orderShow'] = orderShow;
      info['oldOperatingTools']= resData['operatingTools']; 
      info['operatingTools']= dataTable;
      info['oldDriver']= resData['currentDriver'];
      info['oldAsssistantDriver'] = resData['currentAssistantDriver'];
      info['oldCar']= resData['currentCar'];
      info['oldTrailer'] = resData['currentTrailer'];
      info['oldStatus'] = resData['operating'][0]['status'];
      info['freeRule'] = 0;
     // info['oldDriver'] = operating['driver_id'];
     // info['oldAsssistantDriver']
     if(freeRule)
      info['freeRule'] = 1;
      // console.log(info);
      // return; 
      // console.log(info);
    //  ajax
    $.ajax(routeName, {
      type: 'POST',  
      data: info,
      dataType:"json",
      async: true,
      success: function (result) {
       console.log('---------------------------------'); 
       console.log(result); 
       if(result.success)
       {
        swal("Thành công", "Cập nhật lệnh điều xe thành công!", "success")
        .then((value) => {
          //alert(flagCopy);
          // let scrollID = operating['operating_id'];
          // window.location.href = "/operating?page=" + '{{$page}}';
          let scrollToDiv="";
          let scrollID = operating['operating_id'];
          if(!flagCopy){
            scrollToDiv = "&top="+scrollID;
          }
          if ('referrer' in document) {
            let prePage = document.referrer;
            if (prePage.indexOf('?') > -1){
              if(prePage.indexOf('top') > -1){
                prePage = prePage.substring(0, prePage.indexOf('top'));
                scrollToDiv = "top="+scrollID;
                window.location = prePage+scrollToDiv;
              }else{
                scrollToDiv = "&top="+scrollID;
                window.location = prePage+scrollToDiv;

              }
            }else{
              if(prePage.indexOf('top') > -1){
                prePage = prePage.substring(0, prePage.indexOf('top'));
                scrollToDiv = "top="+scrollID;
                window.location = prePage+scrollToDiv;

              }else{
                scrollToDiv = "?top="+scrollID;
                window.location = prePage+scrollToDiv;

              }
            }
          } else {
            window.history.back();
          }

          //window.location.href = "/operating?page=" + '{{$page}}'+scrollToDiv;
          //if (prePage.indexOf('?') > -1)
          // if (typeof(Storage) !== "undefined") {
          //   var operatingCurentPage = localStorage.getItem('operatingCurentPage');
          //   if (operatingCurentPage.indexOf('?') > -1){
          //     operatingCurentPage += "&page=" + '{{$page}}'+scrollToDiv;
          //     window.location.href = operatingCurentPage ;
          //   }else{
          //     window.location.href = "/operating?page=" + '{{$page}}'+scrollToDiv;
          //   }
          //     //alert(operatingCurentPage);
          //   } else {
          //     document.write('Trình duyệt của bạn không hỗ trợ local storage');
          //   }
          // window.location.href = "/operating/search?dateStart=&dateEnd=2018-08-25&status=&page=" + '{{$page}}'+scrollToDiv;
          
          // window.location.reload(history.back());
          // window.history.back(window.location.reload());
        });
        setTimeout(function(){ 
          let scrollToDiv="";
          let scrollID = operating['operating_id'];
          if(!flagCopy){
            scrollToDiv = "&top="+scrollID;
          }
          
          // if (typeof(Storage) !== "undefined") {
          //   var operatingCurentPage = localStorage.getItem('operatingCurentPage');
          //   if (operatingCurentPage.indexOf('?') > -1){
          //     operatingCurentPage += "&page=" + '{{$page}}'+scrollToDiv;
          //     window.location.href = operatingCurentPage ;
          //   }else{
          //     window.location.href = "/operating?page=" + '{{$page}}'+scrollToDiv;
          //   }
          //     //alert(operatingCurentPage);
          //   } else {
          //     document.write('Trình duyệt của bạn không hỗ trợ local storage');
          //   }
          // if ('referrer' in document) {
          //       let prePage = document.referrer;
                // alert(prePage)
                // window.location = prePage+scrollToDiv;
                /* OR */
                //location.replace(document.referrer);
            // } else {
            //     window.history.back();
            // }
      //    window.location.href = "/operating?page=" + '{{$page}}'+scrollToDiv;

      if ('referrer' in document) {
        let prePage = document.referrer;
        if (prePage.indexOf('?') > -1){
          if(prePage.indexOf('top') > -1){
            prePage = prePage.substring(0, prePage.indexOf('top'));
            scrollToDiv = "top="+scrollID;
            window.location = prePage+scrollToDiv;
          }else{
            scrollToDiv = "&top="+scrollID;
            window.location = prePage+scrollToDiv;

          }
        }else{
          if(prePage.indexOf('top') > -1){
            prePage = prePage.substring(0, prePage.indexOf('top'));
            scrollToDiv = "top="+scrollID;
            window.location = prePage+scrollToDiv;

          }else{
            scrollToDiv = "?top="+scrollID;
            window.location = prePage+scrollToDiv;

          }
        }
      } else {
        window.history.back();
      }

    }, 3000);
      }
      if(result.errors)
      {
        flagSubmit = true;
        swal("Thất bại", "Có lỗi trong quá trình xử lý", "error");
      }


      if(result.errorsBusyData){
        flagSubmit = true;
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
         swal("LỖI", "Sai thông tin vui lòng kiểm tra lại", "error");
       }          

     }

   });
    //  ./ ajax
    return false;
  }
  var flagSubmit = true;
  // $('#btnOK').click(function()
  $( "#btnOK" ).on( "click", function(){
    // alert(routeName);
    let flagError = false;
    let selGT = $('#selGoodsType').val();
    if(!selGT){
      $('#msgErrorGT').text("Thiếu thông tin loại hàng");
      flagError=true;
    }else{
      $('#msgErrorGT').text("");
    }
    let selLH = $('#selLoaiHang').val();
    let selChuHang = $('#selChuHang').val();
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
     swal({
      title: "Thiếu thông tin",
      text: "Vui lòng kiểm tra lại thông tin",
      icon: "error",
          // button: "Aww yiss!",
        });
     flagSubmit = true;
     flagError= false;
   }else{
    if(flagSubmit){
      // routeName = '{{url("/postEditOperating")}}';
      addOperation(routeName);
    }
    flagSubmit = false;
  }


});
  // ====================PULL OPERATING POOL - START ==============
  function pullOperating(){
    let flagError = false;
    let selGT = $('#selGoodsType').val();
    if(!selGT){
      $('#msgErrorGT').text("Thiếu thông tin loại hàng");
      flagError=true;
    }else{
      $('#msgErrorGT').text("");
    }
    let selLH = $('#selLoaiHang').val();
    let selChuHang = $('#selChuHang').val();
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
     swal({
      title: "Thiếu thông tin",
      text: "Vui lòng kiểm tra lại thông tin",
      icon: "error",
          // button: "Aww yiss!",
        });
     flagSubmit = true;
     flagError= false;
   }else{
    if(flagSubmit){
      routeName = '{{url("/pullOperatingPool")}}';
      addOperation(routeName);
    }
    flagSubmit = false;
  }
}
$( "#btnPoolOperating" ).on( "click", function(){
 swal({
  title: "THÔNG BÁO",
  text: "Bạn có chắc muốn chuyển lệnh điều xe này sang Lệnh tổng đã chỉnh sửa?",
  icon: "warning",
  buttons: {
    confirm: 'Có',
    cancel: 'Hủy'
  },
  dangerMode: true,
})
 .then((willDelete) => {
  if (willDelete) {
   pullOperating();
 }
});


});
  //  =================== PULL OPERATING POOL - END =================

// btnPoolOperating
  //Copy btnCopy
  //function remove element in array
  function removeElementFromArrray1(arr, id, colFilter){
    //var arrResult = [];
    for(var eoa = 0 ; eoa < arr.length; eoa++){
      if(arr[eoa][colFilter] !== id){
        // arr.splice(ea, 1);
        //arrResult.push(arr[ea]);
        arr.splice(eoa, 1);
      }
    }
  //  return arrResult;
}
  //input array , where clause, column fulter
  function removeElementFromArrray(arr, id, colFilter){
    var arrResult = [];
    for(var ea = 0 ; ea < arr.length; ea++){
      if(arr[ea][colFilter] !== id){
        // arr.splice(ea, 1);
        arrResult.push(arr[ea]);
      }
    }
    return arrResult;
  }

  var countICheck = 0;
  var flagCopy =false;
  //keeping old values
  var tmpFreeCars = resData['freeCars'];
  var tmpfreeTrailers = resData['freeTrailers'];
  var tmpfreeDrivers = resData['freeDrivers'];
  var tmpfreeAssistantDrivers = resData['freeAssistantDrivers'];// sáng mai làm

  /*var tmpFreeCarsCopy = resData['tmpFreeCarsCopy'];
  var tmpfreeTrailersCopy =  resData['tmpfreeTrailersCopy'];
  var tmpfreeDriversCopy =  resData['tmpfreeDriversCopy'];
  var tmpfreeAssistantDriversCopy = resData['tmpfreeAssistantDriversCopy'];*/

  $('#btnCopy').click(function(){
    // SET ttht
    
      // cal Tools operating
      let dtTable =  getDataTable();
      console.log("---------yyyy--------");
      console.log(dtTable);
      for(let i = 0; i< dtTable.length; i++){
        let searchT =  arrSearch(dtTable[i]['tool_id'], resData['tools'], 'tool_id');
        if(!searchT){
         // $('#row_'+dtTable[i]['tool_id']).remove();
       }


       console.log("---------yyyy--------");
      // end - cal tools operating
      let today1 = new Date();
      let dd1 = today1.getDate();
        let mm1 = today1.getMonth()+1; //January is 0!
        let yy1 = today1.getFullYear().toString().substr(-2);
        if(dd1<10) {
          dd1 = '0'+dd1
        }
        if(mm1<10) {
          mm1 = '0'+mm1
        }
        today1 = yy1+mm1+dd1+".00";
        $('#txtTTHT').val(today1);
      }
    // Set Date field is next date
    var dateVal = new Date();
    var today = dateVal.getDate();
    dateVal.setDate(today+1);
    document.getElementById("txtNgayDieuXe").valueAsDate = dateVal;
    //===
    flagCopy =!flagCopy;
    if(flagCopy){
      // set default status
      $('#selTinhTrang').val(1);
      console.log('flag copy '+ flagCopy);
      routeName = '{{url("/creatOperating")}}';
      $('#btnOK').text("LƯU MỚI");
      $('#btnCopy').text("HỦY COPY");
       $("#btnReset").removeClass("hideDiv");
      countICheck++;
     // if(countICheck !== 1) // if count !== 1 && checking => not change state

     var currentSelectCar = $('#selXe').val();
     var currentSelectTrailer = $('#selRomooc').val();
     var currentSelectDriver = $('#selTaiXe').val();
     var currentSelectAssistantDriver = $('#selPhuXe').val();
     
     $('#chkFreeRule').iCheck('check');
     //console.log(operating);
     $('#selTaiXe').val(currentSelectDriver);
     $('#selPhuXe').val(currentSelectAssistantDriver);
     $('#selXe').val(currentSelectCar);
     $('#selRomooc').val(currentSelectTrailer);
     $("#chkFreeRule").on("ifChanged", function(){

     /* if(operating['status'] == 1){
        $('#chkFreeRule').on('ifUnchecked', function(event){
          $('.trTool').remove();
        });
      }*/
      
        //nên clone biến 
      });

   }else{
    console.log('flag copy '+ flagCopy);
    currentSelectCar = $('#selXe').val();
    currentSelectTrailer = $('#selRomooc').val();
    currentSelectDriver = $('#selTaiXe').val();
    currentSelectAssistantDriver = $('#selPhuXe').val();
    
    // reset values
   // var currentSelectCar = $('#selXe').val();
     // console.log('Currrent carr '+currentSelectCar);
     resData['freeCars'] = tmpFreeCars;
     $("#selXe option[value!='']").each(function() {
      $(this).remove();
    });
     let xeOptions = arrFilter($('#selLoaiXe').val(), resData['freeCars'],'car_type_id');
     addOptionSelectBox('#selXe', xeOptions, 'car_id', 'car_num', currentSelectCar);

    // var currentSelectTrailer = $('#selRomooc').val();
    resData['freeTrailers'] = tmpfreeTrailers;
    $("#selRomooc option[value!='']").each(function() {
      $(this).remove();
    });
    let romoocOptions = arrFilter($('#selLoaiRomooc').val(), resData['freeTrailers'],'trailer_type_id');
    addOptionSelectBox('#selRomooc', romoocOptions, 'trailer_id', 'trailer_num', currentSelectTrailer);

    resData['freeDrivers'] = tmpfreeDrivers;
    $("#selTaiXe option[value!='']").each(function() {
      $(this).remove();
    });
    addOptionSelectBox('#selTaiXe', resData['freeDrivers'], 'user_id', 'nick_name', currentSelectDriver);


   // console.log(resData['freeDrivers']);
   resData['freeAssistantDrivers'] = tmpfreeAssistantDrivers;
   $("#selPhuXe option[value!='']").each(function() {
    $(this).remove();
  });
   addOptionSelectBox('#selPhuXe', resData['freeAssistantDrivers'], 'user_id', 'nick_name', currentSelectAssistantDriver);
    // addOptionSelectBox('#selPhuXe', resData['assistantDrivers'], 'user_id', 'full_name', operating['assistant_driver_id'])

    // let driverOptions = arrFilter(operating[], resData['freeDrivers'],'user_id');
    // addOptionSelectBox('#selTaiXe', driverOptions, 'user_id', 'full_name');



    routeName = '{{url("/postEditOperating")}}';
    $('#btnOK').text("XÁC NHẬN");
    $('#btnCopy').text("COPY");
    $("#btnReset").addClass("hideDiv");
   // $('#chkFreeRule').iCheck('unCheck');
 }
});


// ====== ./ submit form ================
$('#btnReset').click(function(){
  /**/
  let tbl = getDataTable();
  if(tbl.length > 0){
    for(let t= 0; t< tbl.length; t++){
     let tool =arrSearch(tbl[t]['tool_id'] , resData['tools'], 'tool_id');
     let toolInToolFull =arrSearch(tbl[t]['tool_id'] , resData['fullTools'], 'tool_id');
     if(tool){
      tool['num'] = parseInt(tool['num'])+ parseInt(tbl[t]['num']);
      let tmpDelRow = '#row_'+tbl[t]['tool_id'];
      $(tmpDelRow).remove();
    }else{
      if(toolInToolFull){
        // console.log(resData['fullTools']);
        console.log(toolInToolFull);
        toolInToolFull['num'] = parseInt(toolInToolFull['num'])+ parseInt(tbl[t]['num']);
        (resData['tools']).push(toolInToolFull);
        resData['tools'].sort(compareSortTool);
        let tmpDelRow = '#row_'+tbl[t]['tool_id'];
        $(tmpDelRow).remove();
        console.log( resData['tools']);
      }
    }
  }
}

/**/
$('#selTaiXe').val('').trigger("change");
$('#selPhuXe').val('').trigger("change");
$('#selRomooc').val('').trigger("change");
$('#selXe').val('').trigger("change");


});

 // Test Key code
 document.onkeyup=function(e){
    var e = e || window.event; // for IE to cover IEs window object
    if(e.altKey && e.which == 65) {
      alert('ALT + A!');
      return false;
    }
  }

});

// ============================================================== DATA ========================================================================
</script>
<!-- =========================================================================== ./ PAGE SCRIPT ================================================ -->

@endsection