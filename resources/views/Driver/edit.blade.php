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
      <div class="col-md-12 titleDieuXe">CẬP NHẬT THÔNG TIN TÀI XẾ</div>
    </div>
    <!-- ./ title -->
    <!-- back page -->
    <div class="row">
      <div class="col-md-12 prePage">
        <a href="/driver" class="">
          <span class="glyphicon glyphicon-step-backward">
            <span class="prePage">DANH SÁCH TÀI XẾ</span>
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
              <b>Công ty</b> <a class="pull-right"></a>
            </li>
            <li class="list-group-item">
              <b>Phòng ban</b> <a class="pull-right"></a>
            </li>
            <li class="list-group-item">
              <b>Số điện thoại:</b> <a class="" style="padding-left: 20px;" id="lblPhone"></a>
            </li>
          </ul>

        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <div class="col-md-9">
     <form action="#"  method="POST" id="frmDriver" enctype='multipart/form-data'>
      <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#thongtinnguoidung" data-toggle="tab">Thông tin người dùng</a>
          </li></ul>
          <div class="tab-content">
           <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label style="font-family: Arial;">Họ tên(*)</label><span style="color: red;" id="msgErrorFullName"></span>
                <input type="text" class="form-control" name="txtFullName" id="txtFullName" placeholder="--Họ tên tài xế--">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label style="font-family: Arial;">Biệt danh (*)</label> <span style="color: red;" id="msgErrorNickName"></span>
                <input type="text" class="form-control" name = "txtNickName" id="txtNickName" placeholder="-- Biệt danh --">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
             <div class="form-group">
              <label style="font-family: Arial;">Số điện thoại</label>
              <!-- <input type="text" class="form-control" name ="txtPhoneNumber" id="txtPhoneNumber" placeholder="-- Số điện thoại --" > -->
              <textarea class="form-control" rows="2" cols="10" id="txtPhoneNumber" name="txtPhoneNumber" placeholder="Số điện thoại"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
           <div class="form-group">
            <label style="font-family: Arial;">Số CMND</label>
            <input type="text" class="form-control" name = "txtIdentityCardNumber" id="txtIdentityCardNumber" placeholder="-- CMND --">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label style="font-family: Arial;">Ngày sinh</label>
            <input type="text" class="form-control" name ="txtBirthDate" id="txtBirthDate" placeholder="-- Ngày sinh --" >
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
         <div class="form-group">
          <label style="font-family: Arial;">Địa chỉ</label>
          <input type="text" class="form-control" name ="txtAddress" id="txtAddress" placeholder="-- Địa chỉ --" >
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
       <div class="form-group">
        <label style="font-family: Arial;">Trạng thái</label>
        <select class="form-control" id="selStatus" name="selStatus">
          <option value="0" selected="">Đang làm</option>
          <option value="1">Đã nghỉ làm</option>
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
     <div class="form-group">
      <label style="font-family: Arial;">Hình đại diện</label><span style="color: red;" id="msgErrorAvatar"></span>
      <input type="file" name="avatar" id="avatar">
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12"><label>Giấy phép lái xe</label></div>
  <div class="col-md-4">
    <div class="form-group">
     <label style="font-family: Arial;">Số GPLX</label>
     <input type="text" class="form-control" name = "txtDrivingLicenseNumber" id="txtDrivingLicenseNumber" placeholder="Số GPLX">
   </div>
 </div>
 <div class="col-md-4">
  <div class="form-group">
   <label style="font-family: Arial;">Hạng GPLX</label>
   <select class="form-control" name="selDrivingLicenseClass" id="selDrivingLicenseClass">
    <option value="" selected disabled>Hạng GPLX</option>
    <!-- <option value="1">Dấu A</option>
    <option value="2">Dấu B</option>
    <option value="3">Dấu C</option> -->
  </select>
</div>
</div>
<div class="col-md-3">
  <div class="form-group">
   <label style="font-family: Arial;">Ngày hết hạn</label>
   <input type="date" class="form-control" name = "txtEndDate" id="txtEndDate" placeholder="-- CMND --">
 </div>
</div>
<div class="col-md-1">
  <div class="form-group">
    <button type="button" class="btn btn-success" name="btnAddDrivingLicense" id="btnAddDrivingLicense" style="margin-top: 24px;">Xác nhận</button>
  </div>
</div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="table" id="tblDrivingLicense">
      <thead style="background-color: #3C8DBC; color: #FFFFFF">
        <tr role="row">
          <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  style="width: 20px;" id="vt1" title="Vị trí 1">STT</th>
          <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt2" title="Vị trí 2">Số giấy phép LX</th>
          <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt3"title="Vị trí 3">Hạng</th>
          <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt4"title="Vị trí 4">Ngày hết hạn</th>
          <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt4"title="Vị trí 4">Xóa</th>
        </tr>

      </thead>
      <tbody style="border: none; " id="tBodyLicense" >
        <!-- row data appened here -->
      </tbody>
    </table>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <label for="comment">Ghi chú</label>
      <textarea class="form-control" rows="5" id="txtNote" name="txtNote"></textarea>
    </div>
  </div>
</div>
</div>
</div>


<div class="box-footer">
 <div class="form-group">
  <label for=""></label>
  <button type="button" id="btnOK" class="btn btn-success btn-md postbutton">Lưu</button>
  &nbsp;


</div>
</div>
</from>
</div>
</div>
</section>
<!-- /.content -->
<!-- ==================================================================  JAVASCRIPT ====================================================== -->
<script>
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
    //alert('xxx');
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
    // FUNCTION REMOVE ELEMENT FROM ARRAY
    function removeElementFromArray(value, arr, filterColumn){
      if(arr.length > 0){
        for(let e = 0; e < arr.length; e++){
          if(arr[e][filterColumn] == value)
            arr.splice(e, 1);
        }
      }
    }

    //REVIEW IMAGE BEFORE UPLOAD
    function readURL(input) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#imgAvatar').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#avatar").change(function() {
      readURL(this);
    });
    var url_string =window.location.href;
    var resData;
    var operating ;
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
      { position: position }
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
<script>
  $(function () {
    $('#tblDriver').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true
    })
  })
</script>
<?php
// if(isset($id))
// echo "$id";
?>
<!-- =========================================================================== PAGE SCRIPT ================================================ -->
<script>
  var resData;
  var driver;
  var drivingLicenseClass;
  var oldDrivingLicenses = [];
  var newDrivingLicenses = [];
  // Get data
  $.ajax('{{url("/driver/edit/". $id)}}', {
    type: 'GET',  
    data: {},
    dataType:"json",
    async: false,
    success: function (result) {
      if(result.success)
      {
       resData = result.success;
       // console.log(resData);
       if(resData['driver'].length > 0){
        driver = resData['driver'][0];
        drivingLicenseClass= resData['drivingLicenseClass'];
        oldDrivingLicenses= resData['drivingLicenses'];
        console.log(resData);
      }else{
        swal("Lỗi", "Không tìm thấy tài xế!", "error");
      }
    }else{
      swal("Lỗi", "Không tìm thấy lệnh điều xe!", "error");
    } 
  }
});
  $(document).ready(function () {
    // change lblPhone allow txtPhoneNumber
    $("#txtPhoneNumber").bind("change paste keyup", function() {
       //alert($(this).val()); 
       let newPhone = $(this).val();
       $('#lblPhone').text(newPhone);

     });

    if(driver){
      //  ==== APPEND DATA
      if(drivingLicenseClass.length >0)
        addOptionSelectBox('#selDrivingLicenseClass',drivingLicenseClass, 'vehicle_class_id', 'vehicle_class_title')
      $('#txtFullName').val(driver['full_name']);
      $('#txtNickName').val(driver['nick_name']);
      if(driver['phone']){
        $('#lblPhone').text(driver['phone']);
        $('#txtPhoneNumber').val(driver['phone']);
      }
      $('#txtIdentityCardNumber').val(driver['identity_id']);
      $('#txtAddress').val(driver['address']);
      $('#txtNote').val(driver['note']);
      $('#selStatus').val(driver['work_status']);

      if(driver['birthday'] && driver['birthday'] != null){
        let tmpSqlTime = driver['birthday'];
        var tmpTime = tmpSqlTime.split(" ");
        document.getElementById("txtBirthDate").value = tmpTime[0];
      }


      if(driver['avatar']){
        let srcAvatar = "/img/Users/"+driver['avatar'];
        $('#imgAvatar').attr('src', srcAvatar);
      }
    }
    if(oldDrivingLicenses.length > 0){
      for(let e = 0; e< oldDrivingLicenses.length ; e++){
        let tmpDrivingLicense = oldDrivingLicenses[e];
        tmpDrivingLicense.type = 0;
        tmpDrivingLicense.no = e+1;
        newDrivingLicenses.push(tmpDrivingLicense);

        console.log('-----new license----');
        console.log(newDrivingLicenses);
      //DRAW TABLE WITH OLD LICENSE
      let rowTable = '<tr style = "background-color: #b0daff;"  id= "row_'+tmpDrivingLicense['no']+'">';
      rowTable += '<td>'+tmpDrivingLicense['no']+'</td>';
      rowTable += '<td>'+tmpDrivingLicense['driver_license_num']+'</td>';
      rowTable += '<td>'+tmpDrivingLicense['vehicle_class_title']+'</td>';
      rowTable += '<td>'+tmpDrivingLicense['expiration_date']+'</td>';
      rowTable += '<td style="vertical-align: inherit; color: red; text-align: center; font-size: 20px;" ><span class="glyphicon glyphicon-remove-sign delRow" id = "del_'+tmpDrivingLicense['no']+'" data-oldid ="'+tmpDrivingLicense['driver_license']+'"></span></td>';
      rowTable += '</tr>';
        /*
        <td style="vertical-align: inherit;"><div class=" iconRemoveRowTable"><span class="glyphicon glyphicon-remove-sign"></span></div></td>
        */
        $('#tBodyLicense').append(rowTable);

     ///
   }
 }
 // ======= CLICK BUTTON ADD NEW LICENSE
 var arrDrivingLicense = [];
 var no =  $('#tblDrivingLicense tr').length;
 $('#btnAddDrivingLicense').click(function(){
  let txtDrivingLicenseNumber = $('#txtDrivingLicenseNumber').val();
  let selDrivingLicenseClass = $('#selDrivingLicenseClass').val();
  let selDrivingLicenseClassText = $('#selDrivingLicenseClass option:selected').text();
  let txtEndDate =  $('#txtEndDate').val();
  let flagDrivingLicenseError = false;
  if(!txtDrivingLicenseNumber){
    flagDrivingLicenseError =true;
    showNotify('#txtDrivingLicenseNumber', "Thiếu thông tin số GPLX", 'error', 'top');
  }
  if(!selDrivingLicenseClass){
    flagDrivingLicenseError =true;
    showNotify('#selDrivingLicenseClass', "Thiếu thông tin hạng giấy phép", 'error', 'top');
  }
  if(!txtEndDate){
    flagDrivingLicenseError =true;
    showNotify('#txtEndDate', "Thiếu thông tin ngày hết hạn", 'error', 'top');
  }
  if(!flagDrivingLicenseError){

        //01. draw table -tBodyLicense
        let rowTable = '<tr style = "background-color: #b0daff;"  id= "row_'+no+'">';
        rowTable += '<td>'+no+'</td>';
        rowTable += '<td>'+txtDrivingLicenseNumber+'</td>';
        rowTable += '<td>'+selDrivingLicenseClassText+'</td>';
        rowTable += '<td>'+txtEndDate+'</td>';
        rowTable += '<td style="vertical-align: inherit; color: red; text-align: center; font-size: 20px;" ><span class="glyphicon glyphicon-remove-sign delRow" id = "del_'+no+'"></span></td>';
        rowTable += '</tr>';
        /*
        <td style="vertical-align: inherit;"><div class=" iconRemoveRowTable"><span class="glyphicon glyphicon-remove-sign"></span></div></td>
        */
        $('#tBodyLicense').append(rowTable);


        // 02. create object add to arr

        let rowData = {};
        rowData.driver_license_num = txtDrivingLicenseNumber;
        rowData.vehicle_class_id = selDrivingLicenseClass;
        rowData.expiration_date = txtEndDate;
        rowData.no = no;
        newDrivingLicenses.push(rowData);
        no++;

      }
    });
 // ======= ./ CLICK BUTTON ADD NEW LINCESE
 // ======= CLICK ICON REMOVE LICENSE FROM TABLE]
     // REMOVE DRIVING LICENSE
     $('#tblDrivingLicense').on('click', '.delRow', function () {
      let rowID =  $(this).attr('id');
      let arrID =  rowID.split("_");
      let eID =  arrID[1];
      removeElementFromArray(eID, newDrivingLicenses, 'no');
      $('#row_'+eID).remove();
      // ===========
      let table = document.getElementById("tblDrivingLicense");
       let numRow =  $('#tblDrivingLicense tr').length;
      for(var i = 1; i< numRow; i++ ){
        stt =i;
        table.rows[i].cells[0].innerHTML = stt;
      }
      // ==========
    });
 // ======= ./ CLICK ICON REMOVE LICENSE FROM TABLE
 // CALL AJAX TO UPDATE 
  // Call ajax function
  $('#btnOK').click(function(){
      // alert('ahihihi');
      edit();
   });
});

var check = 0;
function edit(){
  if(!$('#txtNickName').val() || !$('#txtFullName').val()){
        //msgErrorFullName
        if(!$('#txtNickName').val())
          $('#msgErrorNickName').text("Thiếu thông tin biệt danh tài xế");
        else
          $('#msgErrorNickName').text("");
        if(!$('#txtFullName').val())
          $('#msgErrorFullName').text("Thiếu thông tin họ tên tài xế");
        else
          $('#msgErrorFullName').text("");
        swal("Lỗi", "Thiếu thông tin, vui lòng kiểm tra lại!", "error");

      }else{
       $('#msgErrorNickName').text("");
       // console.log(JSON.stringify(arrDrivingLicense));
       var avatar = $('#avatar').prop('files')[0];
       var txtNickName = $('#txtNickName').val();
       var txtFullName = $('#txtFullName').val();
       var txtPhoneNumber = $('#txtPhoneNumber').val();
       var txtIdentityCardNumber = $('#txtIdentityCardNumber').val();
       var txtAddress = $('#txtAddress').val();
       var selStatus = $('#selStatus').val();
       var txtNote =  $('#txtNote').val();
       var txtBirthDate = $('#txtBirthDate').val();
       var form_data = new FormData();
       form_data.append('avatar', avatar);
       form_data.append('txtNickName', txtNickName);
       form_data.append('txtFullName', txtFullName);
       form_data.append('txtPhoneNumber',txtPhoneNumber);
       form_data.append('txtIdentityCardNumber',txtIdentityCardNumber);
       form_data.append('txtAddress',txtAddress);
       form_data.append('selStatus',selStatus);
       form_data.append('txtNote',txtNote);
       form_data.append('txtBirthDate', txtBirthDate);
       form_data.append('newDrivingLicenses', JSON.stringify(window.newDrivingLicenses));
       form_data.append('oldDrivingLicenses',  JSON.stringify(window.oldDrivingLicenses))
       form_data.append('user_id', '{{$id}}');
       form_data.append('check',check);

       $.ajaxSetup({
        headers: {
          'X-CSRF-Token': $('#_token').val()
        }
      });
       var routeName = '{{url("/driver/edit")}}';
       $.ajax(routeName, {
        type: 'POST',  
        data: form_data,
        dataType:"json",
        async: true,
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false,
            success: function (result) {
              if(result.error1){
                swal({
                  title: "Lỗi !!!",
                  text: "Biệt danh này trùng với người đã nghỉ, bạn có muốn tiếp tục?",
                  icon: "warning",
                  buttons: {
                    confirm: 'Có',
                    cancel: 'Hủy'
                  },
                  dangerMode: true,
                }).then((willCreate) => {
                  if(willCreate){
                    window.check=1;
                    edit();
                    window.check=0;
                  }
                });	
              }
              if(result.errors)
              {
                // console.log(result.errors['fileanh'][0]);
                if(result.errors['unique'])
                  $('#msgErrorNickName').text(" Biệt danh này đã tồn tại");
                else
                  $('#msgErrorNickName').text("");

                // ---------------------
                if(result.errors['fileanh'])
                  $('#msgErrorAvatar').text(" "+result.errors['fileanh'][0]);
                else{
                  $('#msgErrorAvatar').text("");
                }
                // if(result.errors['txtNickName'])
                //   $('#msgErrorNickName').text(result.errors['txtNickName']);
                // else
                //   $('#msgErrorNickName').text("");
                swal("Thất bại", "Có lỗi trong quá trình xử lý", "error");

              }
              if (result.success)
              {
                if ('referrer' in document) {
                        let prePage = document.referrer;
                        window.location = prePage;
                        /* OR */
                        //location.replace(document.referrer);
                    } else {
                        window.history.back();
                    }
               // window.location.reload(history.back());
              //  window.location.href = "/driver";
              // console.log(result.success);
              // swal("Thành công", "Đã cập nhật thông tin tài xế!", "success")
              // .then((value) => {
              //     //window.location.href = "/driver";
              //   });
             //   setTimeout(function(){ window.location.href = "/driver"; }, 3000);
            ///
          }          
        }
      });
     }
}
// $('#btnCancle').click(function(){
//   location.reload();
// });
// ============================================================== DATA ========================================================================
</script>
<!-- =========================================================================== ./ PAGE SCRIPT ================================================ -->

@endsection