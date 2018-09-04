@extends('blank')
@section('content')
<?php
function arrSearch($value, $arr, $filterCol){
    //alert('xxx');
 $chilArrayFilter =[];
 if(count($arr) == 0)
  return false;
if(count($arr) == 1){
  if($arr[0]->$filterCol == $value){
   return true;
 }else{
  return false;
}
}
if(count($arr) > 1){
  for( $cArrFilter = 0 ; $cArrFilter < count($arr); $cArrFilter++){
    if($arr[$cArrFilter]->$filterCol == $value){
      return true;
    }
  }
}
return false;
} 

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <!-- <h1>
      Advanced Form Elements
      <small>Preview</small>
    </h1> -->
    <!-- title -->
    <div class="row">
      <div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('driver') }}</div>
    </div>
    <!-- ./ title -->
    <!-- back page -->
    <div class="row">

    </div>
    <!-- ./ back page -->
    <!-- tips -->

  </section>

  <!-- Main content -->
  <section class="content" id="mContent">
    <div class="box box-warning">
      <!-- /.box-header -->
      <div class="box-body boxPadding">
        <form name="frmOperation" id "frmOperation" method = "get" action="/driver/searchDriver">
          <div class="row well well-lg" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-2">
              <input type="text" class="form-control" id="txtDriverName" placeholder="Tên tài xế"  name="txtDriverName">
              <!-- <select class="form-control select2" name = "selName" id = "selName" style="width: 100%; " data-placeholder="-- Nhập tên tài xế --">
                <option value=""></option>
                <!-- append options here -->
                <!-- </select> -->
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" id="txtNickName" placeholder="Tên đi xe"  name="txtNickName">
              </div>
              <div class="form-group col-md-2">
                <input type="text" class="form-control" id="txtDrivingLicense" placeholder="Số giấy phép lái xe"  name="txtDrivingLicense">
              </div>
         <!--  </div>
          <div class="row" -->
            <div class="form-group col-md-2">
              <input type="text" class="form-control" id="txtPhoneNumber" placeholder="Số điện thoại"  name="txtPhoneNumber">
            </div>
            <div class="form-group col-md-2">
              <input type="text" class="form-control" id="txtIdentityCardNumber" placeholder="Số CMND"  name="txtIdentityCardNumber">
            </div>
            <div class="form-group col-md-2">
                <input type="text" class="form-control" id="txtGhichu" placeholder="Ghi chú "  name="txtGhichu">
            </div>
          </div>
          <div class="row" style="margin-bottom: 10px">
            <div class="col-md-3">
              <input type="button" class="btn btn-success" value="Thêm mới" onClick="btnCreate()">
            </div>
            <div class="col-md-9" style="text-align: right;">
              <input type="submit" class="btn btn-success" value="Tìm kiếm" id="btnSearch1">
              {{-- <input type="button" class="btn btn-success" value="Tất Cả" id="btnReload" > --}}
              <a href="/driver" class="btn btn-success"> Tất cả </a>
              <!-- <input type="button" class="btn btn-success" value="xx" id="btnxx" > -->
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                <table id="tblDriver" class="table table-bordered dataTable table-hover no-footer" role="grid" aria-describedby="example2_info">
                  <thead style="background-color: #3C8DBC; color: #FFFFFF">
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="STT: activate to sort column descending" style="width: 10px;" aria-sort="ascending">STT</th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Username
                      : activate to sort column ascending">Tên tài xế
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Họ và tên
                    : activate to sort column ascending">Biệt danh
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Chức vụ
                  : activate to sort column ascending">Năm sinh
                </th>
                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                : activate to sort column ascending">Điện thoại
              </th>
              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
              : activate to sort column ascending">CMND
            </th>
            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
            : activate to sort column ascending">Điạ chỉ
          </th>
          <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
          : activate to sort column ascending" >Giấy phép lái xe
        </th>
        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
        : activate to sort column ascending">Ghi chú
      </th>
      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
      : activate to sort column ascending">Trạng thái
    </th>
    <th style="width: 30px" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Chức năng: activate to sort column ascending">Chức năng</th>
  </tr>
</thead>
<style type="text/css">
tbody:nth-child(odd) {
  background: #E9F6FC;
}
tr.even{
  background: #FFFFFF;
}
</style>
<tbody id="tbodyDriver"> 
  <!-- row data appened here -->
  <?php
 // dd($resData->drivers);
  if(isset($resData->drivers) && !empty($resData->drivers)){
    $drivers = $resData->drivers;
    for($i = 0; $i < count($drivers); $i++ ){
     $fullName = "";
     if($drivers[$i]->full_name)
      $fullName = $drivers[$i]->full_name;
    $nickName = "";
    if($drivers[$i]->nick_name)
      $nickName = $drivers[$i]->nick_name;
    $phone = "";
    if($drivers[$i]->phone)
      $phone = $drivers[$i]->phone;
    $ii= "";
    if($drivers[$i]->identity_id)
      $ii = $drivers[$i]->identity_id;
    $address = "";
    if($drivers[$i]->address)
      $address = $drivers[$i]->address;
    $note = "";
    if($drivers[$i]->note)
      $note = $drivers[$i]->note;
    $birthDate ="";
    if($drivers[$i]->birthday){
      $date = $drivers[$i]->birthday;
      $tmpD = (string)$drivers[$i]->birthday;
      $tmpDate  = explode("-",$tmpD);
      $tmpDate = explode("-",$tmpDate[0]);
      if(count($tmpDate) == 3)
        $birthDate = $tmpDate[2] ."/".$tmpDate[1]."/".$tmpDate[0];
    }
    $date2="";
    if($drivers[$i]->birthday !=null){
      $date2 = $drivers[$i]->birthday;
    }


    $stt = $i+1;
    $colorStatus = ($drivers[$i]->work_status == 1)? "red" : "none";
    $statusDriver = ($drivers[$i]->work_status == 0)? "Đang làm" : "Đã nghỉ làm";
   // var drivingLicenses  = arrFilter(drivers[i]['user_id'], resData['drivingLicenses'], 'user_id');
    $classStyle = "even";
    if($i %2 == 0)
      $classStyle = "odd";
    $rowData ="";
    $rowData .= '<tr role="row" class="'.$classStyle.' rowDriver" id="row_'.$drivers[$i]->user_id.'">';
    $rowData .= '<td>'.$stt.'</td>';
    $rowData .= '<td>'.$fullName.'</td>';
    $rowData .= '<td>'.$nickName.'</td>';
    $rowData .= '<td>'.$date2.'</td>';
    $rowData .= '<td>'.$phone.'</td>';
    $rowData .= '<td>'.$ii.'</td>';
    $rowData .= '<td>'.$address.'</td>';
    $drivingLicenses ="<td>Chưa cập nhật giấy phép</td>";
  // dd($resData->drivingLicenses );
    if(arrSearch($drivers[$i]->user_id, $resData->drivingLicenses, 'user_id'))
      $drivingLicenses ='<td><a  class = "showLicense" id = "license_'.$drivers[$i]->user_id.'" data-license = "'.$drivers[$i]->user_id.'" data-name = "'.$drivers[$i]->full_name.'">Xem giấy phép</a></td>';

    $rowData .= $drivingLicenses;
    // if ($drivingLicenses== null){
    //   rowData .= '<td>Chưa cập nhật giấy phép</td>';
    // }
    // else{
    //   rowData += '<td><a href ="#" class = "showLicense" id = "license_'+drivers[i]['user_id']+'" data-license = "'+drivers[i]['user_id']+'" data-name = "'+drivers[i]['full_name']+'">Xem giấy phép</a></td>';
    // }
    $rowData .= '<td>'.$note.'</td>';
    $rowData .= '<td style = "background: '.$colorStatus.'">'.$statusDriver.'</td>';
    $rowData .= '<td style="width: 80px"><a class="edit" title="Sửa" href="/driver/detail/'.$drivers[$i]->user_id.'"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;<a class="delete" href="#" data-id = "'.$drivers[$i]->user_id.'" title="Xóa"><i class="glyphicon glyphicon-trash"></i></a></td>';
    $rowData .= '</tr>';
    echo $rowData;


  }
}
?>
</tbody>
</table>
</div>
</div>
<div class="row">
  <div class="col-sm-5">
  </div><div class="col-sm-7">

  </div>
</div>
</div>

</div>
</div>
</div>
</div>

<!-- MODAL LICENSE - START -->
<div class="modal fade" id="modalLicense" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div style="text-align: center;">
          <h3 class="modal-title"><strong>GIẤY PHÉP LÁI XE </strong><strong id="driverName" style="color: orange;"></strong></h3>
        </div>
      </div>
      <div class="modal-body">
       <table class="table">
        <thead style="background-color: #3C8DBC; color: #FFFFFF">
          <tr role="row">
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  style="width: 20px;" id="vt1" title="Vị trí 1">STT</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt2" title="Vị trí 2">Số giấy phép LX</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt3"title="Vị trí 3">Hạng</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt4"title="Vị trí 4">Ngày hết hạn</th>
          </tr>

        </thead>
        <tbody style="border: none; " id="tBodyLicense" >
          <!-- row data appened here -->
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>
<!-- MODAL LICENSE - END -->
<!-- /.box-body -->
<div class="box-footer">

</div>
</div>
<!-- /.box -->




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
  // FUNCTION DRAW TABLE
  $(document).ready(function () {
      // GET DATA
      $.ajax('{{url("/driver/getListcense")}}', {
        type: 'GET',  
        data: {},
        dataType:"json",
        async: false,
        success: function (result) {
          if(result.success)
          {
           resData = result.success;
           // console.log(resData);
           
           // swal("Thành công", "ok!", "success");
         }else{
          swal("Lỗi", "Không tìm thấy lệnh điều xe!", "error");
        } 
      }
    });

    // ============= show license
    $(document).on("click", ".showLicense", function(){
      $('.rowLicense').remove();
      $('#driverName').text(this.getAttribute("data-name"));
      let drivingLicenseData = "";
      var drivingLicenses  = arrFilter(this.getAttribute("data-license"), resData['drivingLicenses'], 'user_id');
      if(drivingLicenses.length >0){
        for(let j= 0; j< drivingLicenses.length; j++){
        //let licenseClass = "HẠNG A";
        let countRow = j+1;
        drivingLicenseData += '<tr class = "rowLicense">';
        drivingLicenseData += '<td>'+countRow+'</td>';
        drivingLicenseData += '<td>'+drivingLicenses[j]['driver_license_num']+'</td>';
        drivingLicenseData += '<td>'+drivingLicenses[j]['vehicle_class_title']+'</td>';
        drivingLicenseData += '<td>'+drivingLicenses[j]['expiration_date']+'</td>';
        drivingLicenseData+= '</tr>';
      }
      $('#tBodyLicense').append(drivingLicenseData);
    }

    $('#modalLicense').modal('show');
  });
    //================= ./ show license  
     // DELETE 
     $(document).on("click", ".delete", function(){
    // alert(this.getAttribute("data-id"));
    let deleteID = this.getAttribute("data-id");
    if(deleteID){
      swal({
        title: "Xóa tài xế?",
        // text: "Once deleted, you will not be able to recover this imaginary file!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          // ajax call delete function
          $.ajax('{{url("/driver/delete")}}'+"/"+deleteID, {
            type: 'GET',  
            data: {},
            dataType:"json",
            async: false,
            success: function (result) {
              if(result.success)
              {
               swal("Xóa thành công!", {
                icon: "success",
              }).then(location.reload());
             }else{
              swal("Lỗi", "Không tìm thấy tài xế!", "error");
            } 
          }
        });
        } 
      });
    }
      // ajax call delte function
    });
// === ./ delete
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
  $('#txtDriverName').val(getUrlParameter('txtDriverName'));
  $('#txtNickName').val(getUrlParameter('txtNickName'));
  $('#txtDrivingLicense').val(getUrlParameter('txtDrivingLicense'));
  $('#txtPhoneNumber').val(getUrlParameter('txtPhoneNumber'));
   $('#txtIdentityCardNumber').val(getUrlParameter('txtIdentityCardNumber'));
   $('#txtGhichu').val(getUrlParameter('txtGhichu'));
});
})
</script>
<script>
  var oTable;
  $(function () {
   oTable=$('#tblDriver').DataTable({
    'paging'      : true,
    'lengthChange': true,
    'searching'   : false,
    'ordering'    : true,
    'info'        : false,
    'autoWidth'   : false,
    "bStateSave": true,
      // recordsFiltered :20
    })
 })
</script>
<script type="text/javascript">
   function btnCreate(){

    document.location.href='../driver/create';

  }
</script>
<!-- =========================================================================== ./ PAGE SCRIPT ================================================ -->

@endsection