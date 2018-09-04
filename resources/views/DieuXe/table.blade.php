
@extends('blank')
@section('content')
{{-- ----------------------------- --}}
<style type="text/css">
.styleEdit{
  color: #3c8dbc;
}
.styleEdit:hover{
  color: #b0daff;
}
</style>
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
<style type="text/css">
@media screen and (max-width: 1920px) {

  .notifyjs-wrapper {
    z-index: 1050;
    text-align: left;
    margin-left: 10px;
  }

  .titleTT{
    width:30px !important;
  }

  .titleCheckAll{
    width:30px !important;
  }

  .titleOperatingDate{
    width:70px !important;
  }

  .titleNumberCar{
    width:120px !important;
  }

  .titleGoods{
    width:90px !important;
  }

  .titleRecipients{
    width:250px !important;
  }

  .titleDelivery{
    width:250px !important;
  }

  .titlePartner{
    width:250px !important;
  }

  .titleAmount{
    width:250px !important;
  }

  .titleDriver{
    width:250px !important;
  }

  .titleAssistant{
    width:130px !important;
  }

  .titlePosition{
    width:50px !important;
  }

  .titleStatus{
    width:100px !important;
  }
  .titleSetting{
    width:50px !important;
  }

}

@media (min-width: 1440px) and (max-width: 1808px) {
  .notifyjs-wrapper {
    z-index: 1050;
    text-align: left;
    margin-left: 10px;
  }

  .titleNumberCar{
    min-width: 90px !important;
  }

  .titleRecipients{
    min-width:100px !important;
  }

  .titleDelivery{
    min-width:100px !important;
  }

  .titlePartner{
    min-width:100px !important;
  }

  .titleAmount{
    min-width:100px !important;
  }

  .titleDriver{
    min-width:100px !important;
  }

}

@media screen and (max-width: 767px) {
  .notifyjs-wrapper {
    z-index: 1050;
    text-align: left;
  }

  .titleTT{
    width:30px !important;
  }

  .titleCheckAll{
    width:30px !important;
  }

  .titleOperatingDate{
    width:70px !important;
  }

  .titleNumberCar{
    width:120px !important;
  }

  .titleGoods{
    width:90px !important;
  }

  .titleRecipients{
    width:250px !important;
  }

  .titleDelivery{
    width:250px !important;
  }

  .titlePartner{
    width:250px !important;
  }

  .titleAmount{
    width:250px !important;
  }

  .titleDriver{
    width:250px !important;
  }

  .titleAssistant{
    width:130px !important;
  }

  .titlePosition{
    width:50px !important;
  }

  .titleStatus{
    width:100px !important;
  }
  .titleSetting{
    width:50px !important;
  }

  .table-responsive>.table>tbody>tr>td, .table-responsive>.table>tbody>tr>th, .table-responsive>.table>tfoot>tr>td, .table-responsive>.table>tfoot>tr>th, .table-responsive>.table>thead>tr>td, .table-responsive>.table>thead>tr>th{
    white-space: normal !important;
  }


}


 /* .data-notify-text{
    width: 50% !important;
    } */
  </style>
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

    use App\Http\Controllers\checkAuthController;
    $checkAuthExcel = checkAuthController::checkAuth("excel","get",$currentUser_type);

    ?>
    <section class="content-header">
    <!-- <h1>
      Advanced Form Elements
      <small>Preview</small>
    </h1> -->
    <!-- title -->
    <div class="row">
      <div class="col-md-12 titleDieuXe">{{ App\TitleList::ListTitle('/operating') }}</div>
      <div class="col-md-12"><span style="color: red"><b>Tips: Khi bạn muốn xem thông tin khác về dữ liệu nào đó trong bảng. Hãy rê chuột vào thông tin đó. Dữ liệu nào có thông tin khác, nó sẽ hiển thị lên cho bạn thấy, và sẽ ẩn đi khi bạn rời chuột khỏi nó! Những lệnh điều xe có màu đen là những lệnh chưa hoàn thành, màu đỏ là đã hoàn thành, màu xanh da trời là những lệnh điều xe không ràng buộc dữ liệu.</b></span></div>
    </div>
    <!-- ./ title -->
  </section>
  <section class="content">
    <div class="box box-primary">
      <div class="box-header">
        <form  action = "/operating/search" method="GET" id="searchForm">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="row" style="padding-top:20px;padding-bottom:20px;">
            <div class="col-md-3" >
              <div class="form-group">
                <label for="" class="col-sm-3 control-label hello" style = "width:30% !important;margin-top:5px;">Từ ngày</label>
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input class="form-control date" id="datepicker13" placeholder="Từ ngày" name="dateStart" value type="date" style="width:95%;">
                </div>
              </div>
            </div>
            {{-- ----------------------------------- --}}
            <div class="col-md-3">
              <div class="form-group">
                <label for="" class="col-sm-3 control-label" style = "width:30% !important;margin-top:5px;">Đến ngày</label>
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input class="form-control date" id="datepicker13" placeholder="Đến ngày" name="dateEnd" value type="date" style="width:95%;">
                </div>
              </div>
            </div>
            {{-- ----------------------------------- --}}
            <div class="col-md-3">
              <div class="form-group tinhtrang">
                <select class="form-control select2 " name = "status" id = "status" data-placeholder="-- Chọn tình trạng --" style="width:95%;">
                  <option></option>
                  <option id="0" value="0">Tất cả</option>
                  <option id = "2" value="2">Hoàn thành</option>
                  <option id = "1" value="1">Chưa hoàn thành</option>
                </select>
              </div>

            </div>
            {{-- ----------------------------------- --}}
            <style>
            .dropdown {
              position: relative;
              display: inline-block;
              vertical-align: middle;
            }
          </style>
          <div class="col-md-3" style="text-align:right;">
            <!-- <div class="dropdown"> -->
              <div class="form-group tinhtrang">
                <a href="#" class="btn btn-success" id="addsearch" style="font-size: 13px;"><i class="glyphicon glyphicon-plus"></i></a>
                <button type="submit" class="btn btn-success" style="height: 32px"><i class="fa fa-search"></i>&nbsp&nbspTìm kiếm</button>
                <div class="btn-group dropdown">
                  <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" style="height: 32px;" ><i class="fa fa-search"></i>&nbsp&nbspTìm theo ngày</button>
                  <ul class="dropdown-menu">
                    <li onclick="setDate(0)"><a href="#">Ngày hiện tại</a></li>
                    <li onclick="setDate(1)"><a href="#">Ngày hiện tại + 1</a></li>
                    <li onclick="setDate(2)"><a href="#">Ngày hiện tại + 2</a></li>
                    <li onclick="setDate(3)"><a href="#">Ngày hiện tại + 3</a></li>
                  </ul>
                </div>
              </div>
            </div>
            {{-- ----------------------------------- --}}
          </div>
          {{-- --------------- --}}
          <div class="row row-search">
          </div>
        </form>
        {{--  --}}
        <div class="row">
          <div class="col-md-12">
            <button id="createoperating" type="button" onClick="btnCreate()" class="btn btn-success pull-left" {{ App\Role::isDisabled($currentUser_type,'operating-create','get') }}><i class="fa fa-plus"></i>&nbsp&nbspThêm mới</button>
            <div class="pull-right">
              <a class="btn btn-success"  onclick="btnComplete()">Hoàn thành</a>
              <a class="btn btn-success"  onclick="btnPrint()">In lệnh</a>
              @if($checkAuthExcel == 0)
              <a class="btn btn-success" name="btnExport" id="btnExport" onclick="btnExport()" style="display: none">Xuất Excel</a>
              @else
              <a class="btn btn-success" name="btnExport" id="btnExport" onclick="btnExport()">Xuất Excel</a>
              @endif
              <a class="btn btn-success"  onclick="btnReload()">Reload</a>
            </div>
          </div>
        </div>
        <div class="row">
          <br>
          <div class="col-md-12">
            Show
            <select class="l" id="selEntries" style="width: 60px; height: 25px;">
              <option value="20">20</option>
              <option value="30">30</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select> 
            entries
          </div>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="table-responsive">
              <table class="table">
                <thead style="background-color: #3C8DBC; color: #FFFFFF;">
                  <tr role="row">
                    <th tabindex="0" aria-controls="example2" rowspan="1" colspan="1" class = "titleTT"/>TT</th>
                    <th class="cb" class = "titleCheckAll">
                      <label class ="container-header">
                        <!-- <input type="checkbox" onclick="for(c in document.getElementsByName('rfile')) document.getElementsByName('rfile').item(c).checked = this.checked">  -->
                        <input type="checkbox" id="checkall">
                        <span class="checkmark1"></span>
                      </label>
                    </th>
                    <th class = "titleOperatingDate" style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" id="vt1" title="Vị trí 1">NGÀY Đ.XE</th>
                    <th class = "titleNumberCar" style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" id="vt2" title="Vị trí 2">SỐ XE</th>
                    <th class = "titleGoods" style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" id="vt3" title="Vị trí 3" >LOẠI HÀNG</th>
                    <th class = "titleRecipients" style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" id="vt4" title="Vị trí 4">NƠI NHẬN</th>
                    <th class = "titleDelivery" style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" id="vt5" title="Vị trí 5">NƠI GIAO</th>
                    <th class = "titlePartner" style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" id="vt6" title="Vị trí 6">CHỦ HÀNG</th>
                    <th class = "titleAmount" style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" id="vt7" title="Vị trí 7" >S.LƯỢNG</th>
                    <th class = "titleDriver"style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" id="vt8" title="Vị trí 8">TÀI XẾ</th>
                    <th class = "titleAssistant" style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" id="vt9" title="Vị trí 9">LƠ</th>
                    <th class = "titlePosition" style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" id="vt10" title="Vị trí 10">VT</th>
                    <th class = "titleStatus" style = "text-align: center !important;" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  >TÌNH TRẠNG</th>
                    <th class = "titleSetting" style = "text-align: center !important;" >CHỨC NĂNG</th>
                  </tr>
                  {{-- <tr>
                    <th></th>
                    <th></th>
                    <th title="Vị trí 11">Giờ đi</th>
                    <th title="Vị trí 12">Kéo rơ mooc</th>
                    <th title="Vị trí 13">Xịt bồn</th>
                    <th title="Vị trí 14">CTMT 1</th>
                    <th title="Vị trí 15">CTMT 2</th>
                    <th title="Vị trí 16">Dụng cụ 1</th>
                    <th title="Vị trí 17">Dụng cụ 2</th>
                    <th title="Vị trí 18">Ghi chú</th>
                    <th title="Vị trí 19">Người p.trách</th>
                    <th title="Vị trí 20">Trống</th>
                    <th ></th>
                    <th></th>
                  </tr> --}}
                </thead>
                <?php 
                $tblcount = 0;
                if(!empty($tbl))
                {
                  $tblcount = count($tbl);
                }
                $total = $start+$tblcount;
                $stt = 1;
                $edit_check = App\Role::hasAuth($currentUser_type,'operating-edit','get');
                $delete_check = App\Role::hasAuth($currentUser_type,'getDeleteOperating','get');
                $complete_check = App\Role::hasAuth($currentUser_type,'completeOneOperating','get');
                ?>
                @for($i=$start;$i < $total;$i++)
                <tbody style="border: none;@if($tbl[$i]->status == 2 ) color: red; @endif">
                  <tr>
                    {{-- so thu tu --}}
                    <td rowspan="2"><?php echo $stt; $stt++ ?></td>
                    {{-- checkbox --}}
                    <td class = "cb" rowspan="2" style="max-width: 42px" >
                      <label class="container">
                        <input type="checkbox" name="rfile" class="rfile" value="{{$tbl[$i]->id}}" style="height: auto;">
                        <span class="checkmark"></span>
                      </label>
                      {{-- <input type="checkbox" name="rfile" value="{{$tbl[$i]->id}}" style="height: auto;"> --}}
                    </td>
                    {{-- ngay dieu xe --}}
                    <td style = "text-align: center !important;" class = "formatDate"><div>{{date('d/m/Y',strtotime($tbl[$i]->daycar))}}</div>
                    </td>
                    {{-- so xe --}}
                    <td style = "text-transform: uppercase;text-align: center !important;">
                      @if(empty($tbl[$i]->carID) == true)
                      {{""}}
                      @else
                      <?php $carid = 'car_'.$i.'id_'.$tbl[$i]->carID;
                      $caridshow = 'scar_'.$i.'id_'.$tbl[$i]->carID;
                      ?>
                      <div class="notifyjs-wrapper notifyjs-hidable" id="{{$caridshow}}" ></div>
                      <span style = "<?php
                      if($tbl[$i]->status == 1)
                      { 
                        for($j =0 ; $j < count($tbl[$i]->operatingstatus) ; $j++)  
                        {
                          $checkNumberCar = $tbl[$i]->operatingstatus[$j]->itemType;
                          $checkStatus =  $tbl[$i]->operatingstatus[$j]->itemStatus;
                          if($checkNumberCar == 3 && $checkStatus == 1)
                          {
                            echo "color:blue;";
                          }
                        }
                      }
                      ?>" id="{{$carid}}" class="car">{{mb_strtoupper($tbl[$i]->carNum,'UTF-8')}}</span><span> {{mb_strtoupper($tbl[$i]->codeJoin,'UTF-8')}}</span>
                      {{-- ?>" id="{{$carid}}" class="car" onmouseout="CLOSE(this)">{{mb_strtoupper($tbl[$i]->carNum,'UTF-8')}}</span><span> {{mb_strtoupper($tbl[$i]->codeJoin,'UTF-8')}}</span> --}}
                      @endif
                    </td>
                    {{-- loai hang --}}
                    <td style = "text-align: center !important;">
                      @if(empty($tbl[$i]->goodsID) == true)
                      {{""}}
                      @else
                      <?php $lhid = 'lh_'.$i.'id_'.$tbl[$i]->goodsID;
                      $lhidshow = 'slh_'.$i.'id_'.$tbl[$i]->goodsID;
                      ?>
                      <div class="text-center notifyjs-wrapper notifyjs-hidable" id="{{$lhidshow}}"></div>
                      <span id="{{$lhid}}" class=" lh">{{mb_strtoupper($tbl[$i]->sortName,'UTF-8')}}</span>
                      {{-- <span id="{{$lhid}}" class=" lh"onmouseout="CLOSE(this)">{{mb_strtoupper($tbl[$i]->sortName,'UTF-8')}}</span> --}}
                      @endif
                    </td>
                    {{-- noi nhan --}}
                    <td  style = "text-align: center !important;">
                      @if(empty($tbl[$i]->receiptID) == true)
                      {{""}}
                      @else
                      <?php $noinhanid = 'nn_'.$i.'id_'.$tbl[$i]->receiptID;
                      $noinhanidshow = 'snn_'.$i.'id_'.$tbl[$i]->receiptID;
                      ?>
                      <div class="notifyjs-wrapper notifyjs-hidable" id="{{$noinhanidshow}}"></div>
                      <span  id="{{$noinhanid}}" class=" nn"><?php echo mb_strtoupper($tbl[$i]->ndTNN,'UTF-8').' '.mb_strtoupper($tbl[$i]->receiptName,'UTF-8').' '.mb_strtoupper($tbl[$i]->ndSNN,'UTF-8'); ?></span>
                      @endif
                    </td >
                    {{-- noi giao --}}
                    <td style = "text-align: center !important;">
                     @if(empty($tbl[$i]->deliveryID) == true)
                     {{""}}
                     @else
                     <?php $noigiaoid = 'ng_'.$i.'id_'.$tbl[$i]->deliveryID;
                     $noigiaoidshow = 'sng_'.$i.'id_'.$tbl[$i]->deliveryID;
                     ?>
                     <div class="notifyjs-wrapper notifyjs-hidable" id="{{$noigiaoidshow}}"></div>
                     <span  id="{{$noigiaoid}}" class=" ng"><?php echo mb_strtoupper($tbl[$i]->ndTNG,'UTF-8').' '.mb_strtoupper($tbl[$i]->deliveryName,'UTF-8').' '.mb_strtoupper($tbl[$i]->ndSNG,'UTF-8') ?></span>
                     @endif
                   </td>
                   {{-- chu hang --}}
                   <td style = "text-align: center ; !important;width:50px;" >
                    @if(empty($tbl[$i]->partnerID) == true)
                    {{""}}
                    @else
                    <?php $chuhangid = 'ch_'.$i.'id_'.$tbl[$i]->partnerID;
                    $chuhangidshow = 'sch_'.$i.'id_'.$tbl[$i]->partnerID;
                    ?>
                    <div class="notifyjs-wrapper notifyjs-hidable" id="{{$chuhangidshow}}"></div>
                    <span  id="{{$chuhangid}}" class=" ch"><?php echo mb_strtoupper($tbl[$i]->ndTCH,'UTF-8').' '.mb_strtoupper($tbl[$i]->partnerName,'UTF-8').' '.mb_strtoupper($tbl[$i]->ndSCH,'UTF-8') ?></span>
                    @endif
                  </td>
                  {{-- so luong --}}
                  <td style = "text-align: center !important;" >
                    {{mb_strtoupper($tbl[$i]->amount,'UTF-8')}}
                  </td>
                  {{-- tai xe --}}
                  <td style = "
                  <?php 
                  if($tbl[$i]->status == 1)
                  {
                    for($j =0 ; $j < count($tbl[$i]->operatingstatus) ; $j++)  
                    {
                      $checkDriver = $tbl[$i]->operatingstatus[$j]->itemType;
                      $checkStatus =  $tbl[$i]->operatingstatus[$j]->itemStatus;
                      if($checkDriver == 1 && $checkStatus == 1 )
                      {
                        echo "color:blue;";
                      }
                    }
                  }
                  ?> 
                  text-transform: uppercase;text-align: center !important;">
                  @if(empty($tbl[$i]->driverID) == true)
                  {{""}}
                  @else
                  <?php $taixeid = 'tx_'.$i.'id_'.$tbl[$i]->driverID;
                  $taixeidshow = 'stx_'.$i.'id_'.$tbl[$i]->driverID;
                  ?>
                  <div class="notifyjs-wrapper notifyjs-hidable" id="{{$taixeidshow}}" ></div>
                  <span style = "text-align: center !important;" id="{{$taixeid}}" class=" tx"><?php echo mb_strtoupper($tbl[$i]->ndTTX).' '.mb_strtoupper($tbl[$i]->driverName,'UTF-8').' '.mb_strtoupper($tbl[$i]->ndSTX)?></span>
                  @endif
                </td>

                {{-- lo xe --}}
                <td style = "
                <?php 
                if($tbl[$i]->status == 1)
                {
                  for($j =0 ; $j < count($tbl[$i]->operatingstatus) ; $j++)  
                  {
                    $checkAssistant = $tbl[$i]->operatingstatus[$j]->itemType;
                    $checkStatus =  $tbl[$i]->operatingstatus[$j]->itemStatus;

                    if($checkAssistant == 2 && $checkStatus == 1)
                    {
                      echo "color:blue;";
                    }
                  }
                }
                ?> 
                text-transform: uppercase;text-align: center !important;">
                @if(empty($tbl[$i]->assistantID) == true)
                {{""}}
                @else
                <?php $loid = 'lx_'.$i.'id_'.$tbl[$i]->assistantID;
                $loidshow = 'slx_'.$i.'id_'.$tbl[$i]->assistantID;
                ?>
                <div class="notifyjs-wrapper notifyjs-hidable" id="{{$loidshow}}"></div>
                <span  id="{{$loid}}" class=" lx" ><?php echo mb_strtoupper($tbl[$i]->ndTLX).' '.mb_strtoupper($tbl[$i]->assistantName, 'UTF-8').' '. mb_strtoupper($tbl[$i]->ndSLX) ?></span>
                @endif
              </td>
              {{-- vi tri --}}
              <td style = "text-align: center !important;" rowspan="2" style = "text-transform: uppercase;">
                <?php 
                $position = $tbl[$i]->position;

                $position = explode('.',$position);

                if(count($position) == 1) echo $position[0]; if(count($position) >1) echo $position[1]."<br/>".$position[0]
                ?>

              </td>
              {{-- tinh trang --}}
              <td style = "text-align: center !important;" rowspan="2"  style = "text-transform: uppercase;">
                @if($tbl[$i]->status == 2)
                {{"Hoàn thành"}}
                @elseif($tbl[$i]->status == 1)
                {{"Chưa hoàn thành"}}
                @endif
              </td>
              {{-- chuc nang --}}
              <td style = "text-align:left;" rowspan="2"  >
               @if($edit_check)
               <span style=" cursor: pointer;" class="edit styleEdit" title="Sửa" id="editScroll_{{$tbl[$i]->id}}"  onClick="btnEdit('{{$tbl[$i]->id}}')">
                 <i class="glyphicon glyphicon-edit"></i>
               </span>&nbsp;&nbsp;&nbsp;
               @else 
               <a class="edit" title="Sửa" href="#" style="color: #545b62; cursor: not-allowed;" ><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
               @endif
               @if($delete_check)
               <a class="delete" href="#" onClick = "btnDelete('{{$tbl[$i]->id}}')" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
               @else 
               <a class="delete" href="#" title="Xóa" style="color: #545b62; cursor: not-allowed;"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
               @endif
               @if($complete_check)
               <a class="delete" href="#" 
               {{ $tbl[$i]->status == 1 ?  'onClick =checkComplete('.$tbl[$i]->id.')' : ' style=color:#545b62;cursor:not-allowed;'}}  title="Hoàn thành" >
               <i class="glyphicon glyphicon-ok"></i>
             </a>
             @else 
             <a class="delete" href="#" style="color: #545b62; cursor: not-allowed;" title="Hoàn thành" ><i class="glyphicon glyphicon-ok"></i></a>
             @endif
             <!-- <a class="undo" href = "#" style="color: #545b62; cursor: not-allowed;" title="Undo"><i class=""> -->
             </td>
             <tr >
               {{-- gio di --}}
               <td style = "text-transform: uppercase;text-align:center !important;" >{{mb_strtoupper($tbl[$i]->timego,'UTF-8')}}</td>
               {{-- so romooc --}}

               <td  style = "text-transform: uppercase;text-align: center !important;
               <?php 
               if($tbl[$i]->status == 1)
               {
                for($j =0 ; $j < count($tbl[$i]->operatingstatus) ; $j++)  
                {
                  $checkTrailer = $tbl[$i]->operatingstatus[$j]->itemType;
                  $checkStatus =  $tbl[$i]->operatingstatus[$j]->itemStatus;
                  if($checkTrailer == 4 && $checkStatus == 1)
                  {
                    echo "color:blue;";
                  }
                }
              }
              ?> 
              "> 
              @if(empty($tbl[$i]->trailerID) == true)
              {{""}}
              @else
              <?php $roid = 'ro_'.$i.'id_'.$tbl[$i]->trailerID;
              $roidshow = 'sro_'.$i.'id_'.$tbl[$i]->trailerID;
              ?>
              <div class="notifyjs-wrapper notifyjs-hidable" id="{{$roidshow}}"></div>
              <span style = "text-align: center !important;" id="{{$roid}}" class="ro">{{mb_strtoupper($tbl[$i]->trailerNum,'UTF-8')}}</span>
              @endif
            </td>
            {{-- xit bon --}}
            <td style = "text-transform: uppercase;text-align: center !important;">
              @if(empty($tbl[$i]->tankID) == true)
              {{""}}
              @else
              {{mb_strtoupper($tbl[$i]->tankName,'UTF-8')}}
              @endif
            </td>
            {{-- chung tu mang theo 1 --}}
            <td style = "text-transform: uppercase;">{{mb_strtoupper($tbl[$i]->ct1,'UTF-8')}}</td>
            {{-- chung tu mang theo 2 --}}
            <td style = "text-transform: uppercase;">{{mb_strtoupper($tbl[$i]->ct2,'UTF-8')}}</td>
            {{-- dung cu 1 --}}
            <td style = "text-transform: uppercase;">
              @if($tbl[$i]->tool1->count() < 1)
              {{""}}
              @else
              <?php
              // dd($tbl[$i]->id);
              // if($tbl[$i]->id == 1123)
              //   dd($tbl[$i]->tool1);
              $toid = 'to_'.$i.'id_'.$tbl[$i]->tool1[0]->toolID1;
              $toidshow = 'sto_'.$i.'id_'.$tbl[$i]->tool1[0]->toolID1;
              if(count($tbl[$i]->tool1) == 1){
                if($tbl[$i]->status == 1)
                {
                  if($tbl[$i]->tool1[0]->itemStatus1 == 1)
                  {
                    echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow.'"></div>';
                    echo '<span style = "color:blue;" id = "'.$toid.'" class="to">' .$tbl[$i]->tool1[0]->toolName1. '</span>';
                  }
                  else
                  {
                    echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow.'"></div>';
                    echo '<span id = "'.$toid.'" class="to">'. $tbl[$i]->tool1[0]->toolName1 .'</span>';
                  }
                }
                if($tbl[$i]->status == 2)
                {
                  echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow.'"></div>';
                  echo '<span id = "'.$toid.'" class="to">'. $tbl[$i]->tool1[0]->toolName1 .'</span>';
                }
              }
              else
              {
                if($tbl[$i]->status == 1)
                {        
                  if($tbl[$i]->tool1[0]->itemStatus1 == 1)
                  {
                    echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow.'"></div>';
                    echo '<span style = "color:blue;" id = "'.$toid.'" class="to">' .$tbl[$i]->tool1[0]->toolName1. '</span>';
                  }
                  else
                  {
                    echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow.'"></div>';
                    echo '<span id = "'.$toid.'" class="to">'. $tbl[$i]->tool1[0]->toolName1 .'</span>';
                  }
                }

                if($tbl[$i]->status == 2)
                {
                  echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow.'"></div>';
                  echo '<span id = "'.$toid.'" class="to">'. $tbl[$i]->tool1[0]->toolName1 .'</span>';
                }

                for($j = 1 ; $j < count($tbl[$i]->tool1) ; $j++)
                {
                  $toid1 = 'to_'.$i.'id_'.$tbl[$i]->tool1[$j]->toolID1;
                  $toidshow1 = 'sto_'.$i.'id_'.$tbl[$i]->tool1[$j]->toolID1;
                  $checkStatus = $tbl[$i]->tool1[$j];

                  if($tbl[$i]->status == 1)
                  {        
                    if($checkStatus->itemStatus1 == 1 )
                    {
                          // echo '';
                      echo ', <div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow1.'"></div> <span style = "color:blue;" id = "'.$toid1.'" class="to">' .$tbl[$i]->tool1[$j]->toolName1 . '</span>';
                    }

                    if($checkStatus->itemStatus1 == 0 )
                    {
                          // echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow1.'"></div>';
                      echo ' ,<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow1.'"></div><span id = "'.$toid1.'" class="to">'. $tbl[$i]->tool1[$j]->toolName1 .'</span>';
                    }
                  }
                  else
                  {
                        // echo '<div class="notifyjs-wrapper notifyjs-hidable" id="{{$toidshow1}}"></div>';
                    echo ' ,<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow1.'"></div><span id = "'.$toid1.'" class="to">'. $tbl[$i]->tool1[$j]->toolName1 .'</span>';
                  }
                }
              }
              ?>
              @endif
            </td>
            {{-- dung cu 2 --}}
            <td  style = "text-transform: uppercase;">
              @if($tbl[$i]->tool2->count() < 1)
              {{""}}
              @else
              <?php
              $toid2 = 'to_'.$i.'id_'.$tbl[$i]->tool2[0]->toolID2;
              $toidshow2 = 'sto_'.$i.'id_'.$tbl[$i]->tool2[0]->toolID2;
              if(count($tbl[$i]->tool2) == 1)
              {
                if($tbl[$i]->tool2[0]->num > 1 ){ 
                  if($tbl[$i]->tool2[0]->num < 10){
                    echo ' 0'.$tbl[$i]->tool2[0]->num;
                  } 
                }
                if($tbl[$i]->status == 1)
                {
                  if($tbl[$i]->tool2[0]->itemStatus2 == 1)
                  {
                    echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow2.'"></div>';
                    echo '<span style = "color:blue;" id = "'.$toid2.'" class="to">' .$tbl[$i]->tool2[0]->toolName2. '</span>  ';
                  }else{
                    echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow2.'"></div>';
                    echo '<span id = "'.$toid2.'" class="to">' .$tbl[$i]->tool2[0]->toolName2. '</span>  ';
                  }
                }
                if($tbl[$i]->status == 2)
                {
                  echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow2.'"></div>';
                  echo '<span id = "'.$toid2.'" class="to">' .$tbl[$i]->tool2[0]->toolName2. '</span>  ';
                }

              }
              else{

                if($tbl[$i]->tool2[0]->num > 1 ){
                  if($tbl[$i]->tool2[0]->num < 10 ){
                    echo ' 0'.$tbl[$i]->tool2[0]->num.' ';
                  }else echo $tbl[$i]->tool2[0]->num.' ';
                }
                if($tbl[$i]->status == 1)
                {
                  if($tbl[$i]->tool2[0]->itemStatus2 == 1)
                  {
                    echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow2.'"></div>';
                    echo '<span style = "color:blue;" id = "'.$toid2.'" class="to">' .$tbl[$i]->tool2[0]->toolName2. '</span>  ';
                  }else{
                    echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow2.'"></div>';
                    echo '<span id = "'.$toid2.'" class="to">' .$tbl[$i]->tool2[0]->toolName2. '</span>  ';
                  }
                }
                if($tbl[$i]->status == 2)
                {
                  echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow2.'"></div>';
                  echo '<span id = "'.$toid2.'" class="to">' .$tbl[$i]->tool2[0]->toolName2. '</span>';
                }
                for($j =1 ; $j < count($tbl[$i]->tool2) ; $j++){
                  $toid3 = 'to_'.$i.'id_'.$tbl[$i]->tool2[$j]->toolID2;
                  $toidshow3 = 'sto_'.$i.'id_'.$tbl[$i]->tool2[$j]->toolID2;
                  echo ', ';
                  if($tbl[$i]->tool2[$j]->num > 1 ) 
                  {
                    if($tbl[$i]->tool2[$j]->num < 10 ) 
                      echo ' 0'.$tbl[$i]->tool2[$j]->num.' ';
                    else  echo $tbl[$i]->tool2[0]->num.' ';
                  }
                  // echo $tbl[$i]->tool2[$j]->toolName2;
                  if($tbl[$i]->status == 1)
                  {
                    if($tbl[$i]->tool2[$j]->itemStatus2 == 1)
                    {
                      echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow3.'"></div>';
                      echo '<span style = "color:blue;" id="'.$toid3.'" class = "to">' .$tbl[$i]->tool2[$j]->toolName2. '</span>  ';
                    }else{
                      echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow3.'"></div>';
                      echo '<span id="'.$toid3.'" class = "to">' .$tbl[$i]->tool2[$j]->toolName2. '</span>  ';                    }
                    }

                    if($tbl[$i]->status == 2)
                    {
                      echo '<div class="notifyjs-wrapper notifyjs-hidable" id="'.$toidshow3.'"></div>';
                      echo '<span id="'.$toid3.'" class = "to">' .$tbl[$i]->tool2[$j]->toolName2. '</span>  '; 
                    }

                  }
                }

                ?>
                @endif
              </td>
              {{-- ghi chu --}}
              <td style = "text-transform: uppercase;">{{mb_strtoupper($tbl[$i]->note,'UTF-8')}}</td>
              {{-- nguoi phu trach --}}
              <td style = "text-transform: uppercase;text-align: center !important;">
                @if(empty($tbl[$i]->curatorID) == true)
                {{""}}
                @else
                {{mb_strtoupper($tbl[$i]->curatorName,'UTF-8')}}
                @endif
              </td>
            </tr>
          </tr>
        </tbody>
        @endfor
      </table>
    <?php //$table->appends(request()->input())->links()  
    //echo "<pre>"; var_dump(count($table)); echo "</pre>";exit();?>
    {{  $table->appends(request()->input())->links() }}
  </div>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
<?php
if(session('msgDeleteOperating')){
  $msgShow = "Xóa lệnh điều xe thành công";
  $msgIcon = "success";
  if(strcmp(session('msgDeleteOperating'), "success") != 0){
    $msgShow = "Xóa lệnh điều xe thất bại";
    $msgIcon ="error";
  }
  echo '<script type="text/javascript">';
  echo "$(document).ready(function(){";
  echo 'swal("'.$msgShow.'", {
    icon: "'.$msgIcon.'",
  });';
  echo "});";
  echo '</s'+'cript>';
}
?>

<!-- Modal -->
<div id="mymodal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg modal-dialog-centered">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <div style="text-align: center;">
          <h3 class="modal-title"><strong>NHỮNG LỆNH ĐIỀU XE ĐÃ HOÀN THÀNH</strong></h3>
        </div>
      </div>
      <div class="modal-body">
        <table id="table_id" class="table display">
          <thead style="background-color: #3C8DBC; color: #FFFFFF">
            <tr>
              <th>NGÀY ĐIỀU XE</th>
              <th>SỐ XE</th>
              <th>LOẠI HÀNG</th>
              <th>NƠI NHẬN</th>
              <th>NƠI GIAO</th>
              <th>CHỦ HÀNG</th>
            </tr>
          </thead>
          <style type="text/css">
          #table_id tbody tr:nth-child(odd) {
            background: #E9F6FC;
          }
          #table_id tbody tr:nth-child(even) {
            background: #FFFFFF;
          }
        </style>
        <tbody id="table-body">
              <!-- <tr>
                  <td>Row 1 Dat a 1</td>
                  <td>Row 1 Data 2</td>
              </tr>
              <tr>
                  <td>Row 2 Data 1</td>
                  <td>Row 2 Data 2</td>
                </tr> -->
              </tbody>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
          </div>
        </div>

      </div>
    </div>
    <!-- End Modal -->
  </section>
  <!-- page script -->
  <script>

    /*======================================================================*/
    function btnCreate(){
	  /*
    if({{$currentUser_type}} == 1 || {{$currentUser_type}} == 16){
      document.location.href='../operating/create';
    }
    else 
      swal('Không có quyền thêm mới lệnh điều xe !');
    */
    document.location.href='../operating/create';
  }
  function btnExport(){
    var type =[];
    $("input[name='rfile']:checked").each(function (i) {
      type[i] = $(this).val();
    });
      //alert(type);
      if(type.length <1){
        swal("Thất bại", "Bạn chưa chọn lệnh nào !", "warning");
        return;
      }
      //---------Ajax----------------
      $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var strType = "?_token="+CSRF_TOKEN;
        for(let c =0; c< type.length; c++){
          strType += '&data[]='+type[c];
        }
        var customWindow = window.open('{{url("/excel")}}'+strType, '_blank', '');
              // customWindow.close();
            });
    }
    function checkComplete(id){
      var type = [];
      type = id;
    //---------Ajax----------------
    $(document).ready(function(){
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            // $(".btnExport").click(function(){
              $.ajax({
                /* the route pointing to the post function */
                url: '/completeOneOperating',
                type: 'GET',

                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, data : type},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (result) {
                  if(result.success)
                    {;
                      swal("Thành công","Cập nhật lệnh điều xe thành công" ,"success")
                      .then((value) => {
                       location.reload();
                     });
                    }
                    if(result.error)
                    {
                      swal("Thất bại", "Có lỗi trong quá trình xử lý", "error");
                    }           
                  }
                }); 
            });
  }
  function btnPrint(){
    var type =[];
    $("input[name='rfile']:checked").each(function (i) {
      type[i] = $(this).val();
    });
    if(type.length <1){
      swal("Thất bại", "Bạn chưa chọn lệnh nào !", "warning");
      return;
    }
    var idPrint = "";
    for(let c =0; c< type.length; c++){
      if(c != (type.length - 1))
        idPrint += type[c] +"-";
      else{
        idPrint += type[c];
        var customWindow = window.open('{{url("/print")}}?id='+idPrint, '_blank', '');
          // if(c == type.length -1)
          // idPrint += type[c];
        }
      }
    }
    function btnComplete(){
      var type =[];
      $("input[name='rfile']:checked").each(function (i) {
        type[i] = $(this).val();
      });
      // console.log(type);
      //---------Ajax----------------
      if(type.length <1){
        swal("Thất bại", "Bạn chưa chọn lệnh nào !", "warning");
        return;
      }
      $(document).ready(function(){
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        swal({
          title: "Vui lòng chờ",
          text: "Đang thực hiện tác vụ, vui lòng chờ",
          icon: "{{asset('img/web/ajaxloader.gif')}}",
          button: false,
          allowOutsideClick: false,
          closeOnClickOutside: false
        });
            // $(".btnExport").click(function(){
              $.ajax({
                /* the route pointing to the post function */
                url: '/completeOperating',
                type: 'GET',

                /* send the csrf-token and the input to the controller */
                data: {_token: CSRF_TOKEN, data : type},
                dataType: 'JSON',
                /* remind that 'data' is the response of the AjaxController */
                success: function (result) {
                  if(result.success)
                  {
                    setTimeout(function(){swal.close();}, 1200);
                    let operatingArr = result.arr;
                    for (let i=0; i<operatingArr.length ;i++){
                      let car_num = operatingArr[i].car_num;
                      if(car_num===null){
                        car_num="";
                      }
                      let sort_name = operatingArr[i].sort_name;
                      if(sort_name===null){
                        sort_name="";
                      }
                      let receipt = operatingArr[i].receipt;
                      if(receipt===null){
                        receipt="";
                      }
                      let delivery = operatingArr[i].delivery;
                      if(delivery===null){
                        delivery="";
                      }
                      let partner_short_name = operatingArr[i].partner_short_name;
                      if(partner_short_name===null){
                        partner_short_name="";
                      }
                      let appendArr = `<tr role="row">
                      <td>`+convertDate(operatingArr[i].operating_date)+`</td>
                      <td>`+car_num+`</td>
                      <td>`+sort_name+`</td>
                      <td>`+receipt+`</td>
                      <td>`+delivery+`</td>
                      <td>`+partner_short_name+`</td>
                      </tr>`
                      $('#table-body').append(appendArr);
                    }
                    $(this).delay(1200).queue(function() {
                      $('#mymodal').modal('show');
                    });
                    $('#mymodal').on('hidden.bs.modal', function () {
                      location.reload();
                    });


                        // swal("Thành công","Cập nhật lệnh điều xe thành công" ,"success")
                        // .then((value) => {
                        //   window.location.href = "/operating";
                        // });
                      }
                      if(result.error)
                      {
                        swal("Thất bại", "Có lỗi trong quá trình xử lý", "error");
                      }           
                    }
                  }); 
            // });
          });
    }
    function btnDelete(id){

      swal({
        title: "Xóa thông tin điều xe",
        text: "Bạn chắc chắn xóa điều xe này chứ?",
        icon: "warning",
        buttons: {
         confirm: 'Có',
         cancel: 'Hủy'
       },
       dangerMode: true,
     })
      .then((willDelete) => {
        if (willDelete) {
          document.location.href="/operating/delete/"+id;
          // deleteOperating(id);
        }
      });
    }
    function btnEdit(id){
      var url = new URL(window.location.href);
     // alert(window.location.href);
     var operatingCurentPage  = window.location.href;
     // let xxx = window.location.href;
      //
      if (operatingCurentPage.indexOf('&page') > -1)
        operatingCurentPage = operatingCurentPage.substring(0, operatingCurentPage.indexOf('&page'));

      //
      var page = url.searchParams.get("page");
      if(!page)
        page = 1;
      id += "-"+ page;
      // alert(id);
      if (typeof(Storage) !== "undefined") {

        localStorage.setItem('operatingCurentPage', operatingCurentPage);
      } else {
        document.write('Trình duyệt của bạn không hỗ trợ local storage');
      }
      document.location.href="/operating/detail/"+id;
    }

// function search a element in array
  /*
    value : value search
    arr : array search
    filterCol: column of array
    => return undefined if array is empty or can't find
    */
    function arrSearch(value, arr, filterCol){
      if(arr.length == 0)
        return undefined;
      else{
        if(arr.length == 1){
          return arr[0];
        }
        for(var cArr = 0 ; cArr < arr.length; cArr++)
        {
       // console.log(arr[cArr][filterCol])
       if(arr[cArr][filterCol] == value)
        return arr[cArr];
    }
  }
  return undefined;
}

function arrSearch1(value, arr, filterCol){
  if(arr.length == 0)
    return undefined;
  else{
    if(arr.length == 1){
      return arr[0];
    }
    for(var cArr = 0 ; cArr < arr.length; cArr++)
    {
        // console.log(arr[cArr][filterCol])
        if(arr[cArr][filterCol] == value)
          return arr[cArr];
      }
    }
    return undefined;
  }
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
        autoHideDelay: 30000, }
        );

  } 

  $('.car').on('mouseover', function() {
    CLOSE();
    let pos = ($(this).attr('id'));
    let carid = pos.split("_",3);
    let car = arrSearch(carid[2],resData['car'],'car_id');
    let msg = 'Ghi chú: '+((car['note'] != null) ? car['note'] : '');
    showNotify('#s'+pos, msg, "info", "top center");
  })
  $('.lh').on('mouseover', function() {
    CLOSE()
    let pos = ($(this).attr('id'));
    let lhid = pos.split("_",3);
    let lh = arrSearch(lhid[2],resData['goods'],'goods_id');
    let msg = 'T.Tin TỶ TRỌNG: '
    +((lh['rate'] != null) ? lh['rate'] : '')+'\r\nGhi chú: '
    +((lh['note'] != null) ? lh['note'] : '');
    showNotify('#s'+pos, msg, "info", "top center");
  })

  $('.nn').on('mouseover', function() {
    CLOSE()
    let pos = ($(this).attr('id'));
    let nnid = pos.split("_",3);
    let nn = arrSearch(nnid[2],resData['nng'],'place_id');
    let msg = 'Thông tin người liên hệ: '
    +((nn['contact_note'] != null) ? nn['contact_note'] : '')
    +'\r\nThông tin nơi nhận: '+((nn['warehouse_note'] != null) ? nn['warehouse_note'] : '');
    showNotify('#s'+pos, msg, "info", "top center");
  })

  $('.ng').on('mouseover', function() {
    CLOSE()
    let pos = ($(this).attr('id'));
    let ngid = pos.split("_",3);
    let ng = arrSearch(ngid[2],resData['nng'],'place_id');
    // console.log(JSON.stringify(resData['nng']));
    let msg = 'Thông tin người liên hệ: '
    +((ng['contact_note'] != null) ? ng['contact_note'] : '')
    +'\r\nThông tin nơi giao: '+((ng['warehouse_note'] != null) ? ng['warehouse_note'] : '')
    +'\r\nXe gần nhất: '+((ng['carNote'][0] != null) ? ng['carNote'][0]: "")
    +'\r\n'+((ng['carNote'][1] != null) ? ng['carNote'][1]: "")
    +'\r\n'+((ng['carNote'][2] != null) ? ng['carNote'][2]: "");
    showNotify('#s'+pos, msg, "info", "top center");
  })

  $('.ch').on('mouseover', function() {
    CLOSE()
    let pos = ($(this).attr('id'));
    let chid = pos.split("_",3);
    let ch = arrSearch(chid[2],resData['chuhang'],'partner_id');
    let msg = 'Thông tin liên hệ: '
    +((ch['contact_note'] != null) ? ch['contact_note'] : '')
    +'\r\nGhi chú: '+((ch['note'] != null) ? ch['note'] : '')
    +'\r\nXe gần nhất: '+((ch['carNo'][0] != null) ? ch['carNo'][0]: "")
    +'\r\n'+((ch['carNo'][1] != null) ? ch['carNo'][1]:"")
    +'\r\n'+((ch['carNo'][2] != null) ? ch['carNo'][2]:"")
    ;
    showNotify('#s'+pos, msg, "info", "top center");
  })
  $('.tx').on('mouseover', function() {
    CLOSE()
    let pos = ($(this).attr('id'));
    let txid = pos.split("_",3);
    let tx = arrSearch(txid[2],resData['user'],'user_id');
    let msg = 'Tên đầy đủ: '
    +((tx['full_name'] != null) ? tx['full_name'] : '')
    +'\r\n SĐT: '+((tx['phone'] != null) ? tx['phone'] : '')
    +'\r\n CMND: '+((tx['identity_id'] != null) ? tx['identity_id'] : '')
    +'\r\nGhi chú: '+((tx['note'] != null) ? tx['note'] : '')
    showNotify('#s'+pos, msg, "info", "top center");
  })
  $('.lx').on('mouseover', function() {
    CLOSE()
    let pos = ($(this).attr('id'));
    let lxid = pos.split("_",3);
    let lx = arrSearch(lxid[2],resData['user'],'user_id');
    let msg = 'Tên đầy đủ: '
    +((lx['full_name'] != null) ? lx['full_name'] : '')
    +'\r\n SĐT: '+((lx['phone'] != null) ? lx['phone'] : '')
    +'\r\n CMND: '+((lx['identity_id'] != null) ? lx['identity_id'] : '')
    +'\r\nGhi chú: '+((lx['note'] != null) ? lx['note'] : '')
    showNotify('#s'+pos, msg, "info", "top center");
  })
  $('.ro').on('mouseover', function() {
    CLOSE()
    let pos = ($(this).attr('id'));
    let roid = pos.split("_",3);
    let ro = arrSearch(roid[2],resData['romooc'],'trailer_id');
    let msg = 'Ghi chú: '+((ro['note'] != null) ? ro['note'] : '');
    showNotify('#s'+pos, msg, "info", "top center");
  })

  $('.to').on('mouseover',function() {
    CLOSE()
    let pos = ($(this).attr('id'));

    let toid = pos.split("_",3);
    console.log(toid);
    let to = arrSearch(toid[2],resData['dungcu'],'tool_id');
    let msg = 'Thông số: '
    +((to['parameter'] != null) ? to['parameter'] : '')
    +'\r\n Thông tin: '+((to['infomation'] != null) ? to['infomation'] : '')
    showNotify('#s'+pos, msg, "info", "top center");
  })



//--------------------------------------HIDE NOTIFY------------------------------------------
function CLOSE() {
  $('.notifyjs-wrapper').trigger('notify-hide');
}
<?php
$str = str_replace('\r\n', '\\\n',  json_encode($arrOperatingID)) ;
$str = str_replace("'", '\\\'',  $str) ;
$arrayOperatingIDPerPage = json_encode($arrOperatingID);
?>
var arrayOperatingIDPerPage = <?php echo $arrayOperatingIDPerPage; ?>;
    //------------------------------------ajax get data--------------------------------------


    var url_string =window.location.href;
    var resData;
    //var operating ;
    $(document).ready(function () {
      // alert('dđ');
      let stringArrOperatingID = '';
      if(arrayOperatingIDPerPage.length >0 ){
        for(let i = 0; i < arrayOperatingIDPerPage.length; i++){
          stringArrOperatingID += arrayOperatingIDPerPage[i]+"-";
        }
        stringArrOperatingID = stringArrOperatingID.slice(0, -1);
       // alert(stringArrOperatingID);
     }
     $.ajax('{{url("/operating2")}}', {
      type: 'GET',  
      data: {
        arrayOperatingIDPerPage: arrayOperatingIDPerPage
      },
      dataType:"json",
      async: false,
      success: function (result) {
        if(result.success)
        {
         resData = result.success;

           //Write undo redo 



          //End write undo redo  

           //console.log(resData);
           
           // swal("Thành công", "ok!", "success");
         }else{
          swal("Lỗi", "Không tìm thấy lệnh điều xe!", "error");
        } 
      }

    });
   })
    
 </script>
 {{--  DANH MỤC TÌM 1,2,3  --}}
 <script>


   function convertDate(dateString){
    var p = dateString.split(/\D/g)
    return [p[2],p[1],p[0]].join("-")
  }
  function SearchOld(stt, search, ContentSearch) {
    var searchF = getParameterByName(search);
    var contentSearchF = getParameterByName(ContentSearch);
    var searchOP = '.search[name='+search+'] option';
    var insearch = '.inputsearch'+stt;
    $('#addsearch').click();
    if(searchF && contentSearchF ) {
     $(searchOP).each(function() {
      if($( this).val() == searchF) {
       $( this).prop('selected', true).change();
       $(insearch).val(contentSearchF);
     }
   });
   }
 }
 function DateSet(Value,Input) {
  var today = new Date(Value);
  var dd = today.getDate();
		var mm = today.getMonth()+1; //January is 0!
		var yyyy = today.getFullYear();
		if(dd<10){ dd='0'+dd; } 
		if(mm<10){ mm='0'+mm; } 
		var today = yyyy+'-'+mm+'-'+dd;
		var InputSet = 'input[name="'+Input+'"]';
		$(InputSet).val(today);
	}
	function getParameterByName(name, url) {
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, '\\$&');
		var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
   results = regex.exec(url);
   if (!results) return null;
   if (!results[2]) return '';
   return decodeURIComponent(results[2].replace(/\+/g, ' '));
 }
 $(document).on('click','.remove-btn', function(){
  $(this).parents('.form-group').remove();
  $('.row-search label.danhmuc').each(function(index) {
   $(this).text('Danh mục tìm '+(index+1)+':');
 });
  $('.row-search .search-left').each(function(index){
   $(this).attr('name','search'+(index+1))
 })
  $('.row-search .search-right').each(function(index){
   $(this).attr('name','ContentSearch'+(index+1))
 })
});
 $('#addsearch').on('click', function(){
  if($('.row-search > .form-group').length < 3 ) {
   let stt = $('.row-search > .form-group').length + 1;
   $('.row-search ').append(`
    <div class="form-group row">
    <div class="col-md-12">
    <div class = "col-md-2"></div>
    <div class="col-md-4">
    <div class="form-group">
    <label  for="" class="col-sm-5 control-label danhmuc" style = "margin-top:5px;">Danh mục tìm `+stt+` :</label>
    <div class="col-md-7">
    <select class="form-control select2 search search-left" name ="search`+stt+`" stt="`+stt+`" data-placeholder="-- Chọn danh mục --">
    <option value=""></option>
    <option value="search_car">Số xe</option>
    <option value="search_goods">Loại hàng</option>
    <option value="search_receipt">Nơi nhận</option>
    <option value="search_delivery">Nơi giao</option>
    <option value="search_owner">Chủ hàng</option>
    <option value="search_num" data-s="input">Số lượng</option>
    <option value="search_driver">Tài xế</option>
    <option value="search_assistant_driver">Phụ xe (lơ)</option>
    <option value="search_departure_time" data-s="input">Giờ đi</option>
    <option value="search_clear">Xịt bồn</option>
    <option value="search_trailer">RoMooc</option>
    <option value="search_document1" data-s="input">Chứng từ 1</option>
    <option value="search_document2" data-s="input">Chứng từ 2</option>
    <option value="search_tool1">Dụng cụ 1</option>
    <option value="search_tool2">Dụng cụ 2</option>
    <option value="search_note"data-s="input">Ghi chú</option>
    <option value="search_curator">Người phụ trách</option>
    <option value="search_ordershow" data-s="input">Vị trí</option>
    </select>
    </div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
    <label  for="" class="col-md-5 control-label" style = "margin-top:5px;">Nội dung tìm :</label>
    <div class="col-md-7">
    <input type="text" class="form-control inputsearch`+stt+` search-right" name="ContentSearch`+stt+`">
    </div>
    </div>
    </div>
    <div class="col-md-2"><a href="#" class="btn btn-danger remove-btn"><i class="glyphicon glyphicon-remove"></i></a></div>
    </div>
    </div>
    `);
   $('.select2').select2({allowClear: true});
 }
});
 if( window.location.href.indexOf('search?') >= 0){
  var dateStart = getParameterByName('dateStart');
  var dateEnd = getParameterByName('dateEnd');
  var status = getParameterByName('status');
  var search1 = getParameterByName('search1');
  var ContentSearch1 = getParameterByName('ContentSearch1');
  var search2 = getParameterByName('search2');
  var ContentSearch2 = getParameterByName('ContentSearch2');
  var search3 = getParameterByName('search3');
  var ContentSearch3 = getParameterByName('ContentSearch3');
  if(dateEnd) {DateSet(dateEnd,'dateEnd')}
    if(dateStart) {DateSet(dateStart,'dateStart')}
      if(status){
       $('.select2[name=status] option').each(function(){
        if($( this).val() == status) {
         $( this).attr('selected', 'selected')
       }
     });
     }
     if((search1 && ContentSearch1) && (search2 && ContentSearch2) && (search3 && ContentSearch3) ) {
       SearchOld('1','search1','ContentSearch1');
       SearchOld('2','search2','ContentSearch2');
       SearchOld('3','search3','ContentSearch3');
     }
     if((search1 && ContentSearch1) && !(search2 && ContentSearch2) && !(search3 && ContentSearch3) ) {
       SearchOld('1','search1','ContentSearch1');
     }
     if((search1 && ContentSearch1) && !(search2 && ContentSearch2) && (search3 && ContentSearch3) ) {
       SearchOld('1','search1','ContentSearch1');
       SearchOld('2','search2','ContentSearch2');
       SearchOld('3','search3','ContentSearch3');
     }
     if((search1 && ContentSearch1) && (search2 && ContentSearch2) && !(search3 && ContentSearch3) ) {
       SearchOld('1','search1','ContentSearch1');
       SearchOld('2','search2','ContentSearch2');
     }
     if(!(search1 && ContentSearch1) && !(search2 && ContentSearch2) && (search3 && ContentSearch3) ) {
       SearchOld('1','search1','ContentSearch1');
       SearchOld('2','search2','ContentSearch2');
       SearchOld('3','search3','ContentSearch3');
     }
     if(!(search1 && ContentSearch1) && (search2 && ContentSearch2) && !(search3 && ContentSearch3) ) {
       SearchOld('1','search1','ContentSearch1');
       SearchOld('2','search2','ContentSearch2');
       SearchOld('3','search3','ContentSearch3');
     }
   }

   function setDate(value){
    var date = new Date();
    date.setDate(date.getDate() + value);
    DateSet(date,'dateStart');
    DateSet(date,'dateEnd');
    $("#searchForm").submit();
  }

  function btnReload(){
    //  route('operating')
    window.location = "/operating/20";
  }
  // custom entries
  $('#selEntries').on('change', function(){
    // alert($('#selEntries').val());
    let entries = $('#selEntries').val();
    if (typeof(Storage) !== "undefined") {
     // var domain = 'freetuts.net';
     localStorage.setItem('operatingPagi', entries);
   } else {
    document.write('Trình duyệt của bạn không hỗ trợ local storage');
  }
  window.location = "/operating/"+entries;
});
  // set default entries
  $(document).ready(function(){
    if (typeof(Storage) !== "undefined") {

     
     let operatingPagi = localStorage.getItem('operatingPagi');
     // alert(xxx);
     if(operatingPagi){
      $('#selEntries').val(operatingPagi);
        // alert( operatingPagi);
      }
      else
        $('#selEntries').val(20);
    } else {
      document.write('Trình duyệt của bạn không hỗ trợ local storage');
    }
  })


  $(document).on('keyup', function(e) {
   if(e.keyCode === 13)  {
    if($('.select2').val() || $('input[name="dateStart"]') || $('input[name="dateEnd"]')){
     $('#searchForm').submit();
   }
 }
});

  $("#checkall").change(function(){
    $(".rfile").prop("checked", this.checked);
  });
  $(".rfile").change(function(){
  // if($(this).prop("checked") == false){
  //   $("#checkall").prop("checked",false);
  // }
  if($(".rfile:checked").length == $(".rfile").length){
    $("#checkall").prop("checked",true);
  } else {
    $('#checkall').prop('checked',false);
  }

});
</script>
<script type="text/javascript">
  $(document).ready(function(){
   let url_string_scroll =window.location.href;
   let url_scroll = new URL(url_string_scroll);
   let topScroll = url_scroll.searchParams.get("top");
   if(topScroll){
     let idScroll = "#editScroll_"+topScroll;
     $('html,body').animate({
      scrollTop: $(idScroll).offset().top - $('body').height() / 2},
      'slow');
   }
   // alert(topScroll);
   //
 })
</script>
@endsection
