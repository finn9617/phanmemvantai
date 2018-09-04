
@extends('blank')
@section('content')
{{-- ----------------------------- --}}
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
  .notifyjs-wrapper {
  z-index: 1050;
  }
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
    <form  action = "/operatingPool/search" method="GET" id="searchForm">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-3" >
          <div class="form-group">
            <label for="" class="col-sm-3 control-label">Từ ngày</label>
            <div class="input-group date">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <input class="form-control" id="datepicker13" placeholder="Từ ngày" name="dateStart" value type="date" style="width:65%;">
            </div>
          </div>
        </div>
        {{-- ----------------------------------- --}}
        <div class="col-md-3">
          <div class="form-group">
              <label for="" class="col-sm-3 control-label">Đến ngày</label>
            <div class="input-group date">
            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
            <input class="form-control" id="datepicker13" placeholder="Đến ngày" name="dateEnd" value type="date" style="width:65%;">
            </div>
          </div>
        </div>
        {{-- ----------------------------------- --}}
        <div class="col-md-2">
          <div class="form-group">
            <select class="form-control select2 " name = "status" id = "status" data-placeholder="-- Chọn tình trạng --" style="width:70%;">
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
        <div class="col-md-3">
        <!-- <div class="dropdown"> -->
          <div class="form-group ">
            <a href="#" class="btn btn-success" id="addsearch"><i class="glyphicon glyphicon-plus"></i></a>
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
      <div class="pull-right">
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
  <!-- /.box-header -->
  <div class="box-body">
    <div class="row">
    <div class="table-responsive">
      <table class="table">
        <thead style="background-color: #3C8DBC; color: #FFFFFF">
          <tr role="row">
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  style="width: 10px;"/>TT</th>
            <th class="cb"style="width: 20px;" >
              <label class ="container-header">
                <input type="checkbox" onclick="for(c in document.getElementsByName('rfile')) document.getElementsByName('rfile').item(c).checked = this.checked"> 
                <span class="checkmark1"></span>
              </label>
            </th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  style="width: 20px;" id="vt1" title="Vị trí 1">NGÀY Đ.XE</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt2" title="Vị trí 2" style="width: 100px">SỐ XE</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt3"title="Vị trí 3" style="width: 100px">LOẠI HÀNG</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt4"title="Vị trí 4">NƠI NHẬN</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt5"title="Vị trí 5">NƠI GIAO</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt6"title="Vị trí 6" style="width: 200px">CHỦ HÀNG</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt7"title="Vị trí 7" style="width: 100px">S.LƯỢNG</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt8"title="Vị trí 8">TÀI XẾ</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt9"title="Vị trí 9">LƠ</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt10"title="Vị trí 10">VT</th>
            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  >TÌNH TRẠNG</th>
            <th style="width: 50px;">CHỨC NĂNG</th>
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
        @for($i=0;$i<count($table);$i++)

          <tbody style="border: none;">
            <tr>
              {{-- so thu tu --}}
            <td rowspan="2">{{$i+1}}</td>
            {{-- checkbox --}}
            <td class = "cb" rowspan="2" style="max-width: 42px" >
              <label class="container">
                <input type="checkbox" name="rfile" value="{{$tbl[$i]->id}}" style="height: auto;">
                <span class="checkmark"></span>
              </label>
              {{-- <input type="checkbox" name="rfile" value="{{$tbl[$i]->id}}" style="height: auto;"> --}}
            </td>
            {{-- ngay dieu xe --}}
            <td  style="text-align: center;"><div>{{$tbl[$i]->ngaydieuxe}}</div>
            </td>
            {{-- so xe --}}
            <td  style="text-align: center;">
              @if(empty($tbl[$i]->soxe[0]) == true)
              {{""}}
              @else
              <?php $carid = 'car_'.$i.'id_'.$tbl[$i]->soxe[0]->car_id;
              $caridshow = 'scar_'.$i.'id_'.$tbl[$i]->soxe[0]->car_id;
              ?>
              <div class="notifyjs-wrapper notifyjs-hidable" id="{{$caridshow}}"></div>
              <span id="{{$carid}}" class=" car" onmouseout="CLOSE(this)">{{mb_strtoupper($tbl[$i]->soxe[0]->car_num,'UTF-8')}}</span>
              @endif
            </td>
            {{-- loai hang --}}
            <td  style="text-align: center;">
              @if(empty($tbl[$i]->loaihang[0]) == true)
              {{""}}
              @else
              <?php $lhid = 'lh_'.$i.'id_'.$tbl[$i]->loaihang[0]->goods_id;
              $lhidshow = 'slh_'.$i.'id_'.$tbl[$i]->loaihang[0]->goods_id;
             ?>
              <div class="notifyjs-wrapper notifyjs-hidable" id="{{$lhidshow}}"></div>
              <span id="{{$lhid}}" class=" lh"onmouseout="CLOSE(this)">{{mb_strtoupper($tbl[$i]->loaihang[0]->sort_name,'UTF-8')}}</span>
              @endif
            </td>
            {{-- noi nhan --}}
            <td  style="text-align: center;">
              @if(empty($tbl[$i]->noinhan[0]) == true)
              {{""}}
              @else
              <?php $noinhanid = 'nn_'.$i.'id_'.$tbl[$i]->noinhan[0]->place_id;
              $noinhanidshow = 'snn_'.$i.'id_'.$tbl[$i]->noinhan[0]->place_id;
             ?>
              <div class="notifyjs-wrapper notifyjs-hidable" id="{{$noinhanidshow}}"></div>
              <span id="{{$noinhanid}}" class=" nn"onmouseout="CLOSE(this)"><?php echo mb_strtoupper($tbl[$i]->ndTNN,'UTF-8').' '.mb_strtoupper($tbl[$i]->noinhan[0]->name,'UTF-8').' '.mb_strtoupper($tbl[$i]->ndSNN,'UTF-8'); ?></span>
              @endif
            </td >
            {{-- noi giao --}}
            <td  style="text-align: center;">
             @if(empty($tbl[$i]->noigiao[0]) == true)
             {{""}}
             @else
             <?php $noigiaoid = 'ng_'.$i.'id_'.$tbl[$i]->noigiao[0]->place_id;
              $noigiaoidshow = 'sng_'.$i.'id_'.$tbl[$i]->noigiao[0]->place_id;
             ?>
            <div class="notifyjs-wrapper notifyjs-hidable" id="{{$noigiaoidshow}}"></div>
            <span id="{{$noigiaoid}}" class=" ng"onmouseout="CLOSE(this)"><?php echo mb_strtoupper($tbl[$i]->ndTNG,'UTF-8').' '.mb_strtoupper($tbl[$i]->noigiao[0]->name,'UTF-8').' '.mb_strtoupper($tbl[$i]->ndSNG,'UTF-8') ?></span>
             @endif
           </td>
           {{-- chu hang --}}
           <td  style="text-align: center;">
            @if(empty($tbl[$i]->chuhang[0]) == true)
            {{""}}
            @else
             <?php $chuhangid = 'ch_'.$i.'id_'.$tbl[$i]->chuhang[0]->partner_id;
              $chuhangidshow = 'sch_'.$i.'id_'.$tbl[$i]->chuhang[0]->partner_id;
             ?>
            <div class="notifyjs-wrapper notifyjs-hidable" id="{{$chuhangidshow}}"></div>
            <span id="{{$chuhangid}}" class=" ch"onmouseout="CLOSE(this)"><?php echo mb_strtoupper($tbl[$i]->ndTCH,'UTF-8').' '.mb_strtoupper($tbl[$i]->chuhang[0]->partner_short_name,'UTF-8').' '.mb_strtoupper($tbl[$i]->ndSCH,'UTF-8') ?></span>
            @endif
            </td>
            {{-- so luong --}}
          <td  style="text-align: center;">
            {{mb_strtoupper($tbl[$i]->soluong,'UTF-8')}}
          </td>
          {{-- tai xe --}}
          <td  style="text-align: center;">
            @if(empty($tbl[$i]->taixe[0]) == true)
            {{""}}
            @else
             <?php $taixeid = 'tx_'.$i.'id_'.$tbl[$i]->taixe[0]->user_id;
              $taixeidshow = 'stx_'.$i.'id_'.$tbl[$i]->taixe[0]->user_id;
             ?>
             <div class="notifyjs-wrapper notifyjs-hidable" id="{{$taixeidshow}}"></div>
            <span id="{{$taixeid}}" class=" tx"onmouseout="CLOSE(this)"><?php echo mb_strtoupper($tbl[$i]->ndTTX).' '.mb_strtoupper($tbl[$i]->taixe[0]->nick_name,'UTF-8').' '.mb_strtoupper($tbl[$i]->ndSTX)?></span>
            @endif
          </td>
          {{-- lo xe --}}
          <td  style="text-align: center;">
            @if(empty($tbl[$i]->lo[0]) == true)
            {{""}}
            @else
             <?php $loid = 'lx_'.$i.'id_'.$tbl[$i]->lo[0]->user_id;
              $loidshow = 'slx_'.$i.'id_'.$tbl[$i]->lo[0]->user_id;
             ?>
            <div class="notifyjs-wrapper notifyjs-hidable" id="{{$loidshow}}"></div>
            <span id="{{$loid}}" class=" lx"onmouseout="CLOSE(this)"><?php echo mb_strtoupper($tbl[$i]->ndTLX).' '.mb_strtoupper($tbl[$i]->lo[0]->nick_name, 'UTF-8').' '. mb_strtoupper($tbl[$i]->ndSLX) ?></span>
            @endif
          </td>
          {{-- vi tri --}}
          <td rowspan="2"  style="text-align: center;">
            {{$tbl[$i]->vt}}
          </td>
          {{-- tinh trang --}}
          <td rowspan="2"  style="text-align: center;">
			Hoàn thành
            
          </td>
          {{-- chuc nang --}}
          <td style="width: 50px" rowspan="2"  >
			@if(App\Role::hasAuth($currentUser_type,'operating-edit','get'))
				<a class="edit" title="Sửa" href="#" onClick="btnEdit('{{$tbl[$i]->id}}')">
					<i class="glyphicon glyphicon-edit"></i>
				</a>&nbsp;&nbsp;&nbsp; 
			@else 
				<a class="edit" title="Sửa" href="#" style="color: #545b62; cursor: not-allowed;" ><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
			@endif
          </td>
        <tr >
          {{-- gio di --}}
          <td style="text-align: center;">{{mb_strtoupper($tbl[$i]->giodi,'UTF-8')}}</td>
          {{-- so romooc --}}
          <td  style="text-align: center;"> 
            @if(empty($tbl[$i]->romooc[0]) == true)
            {{""}}
            @else
             <?php $roid = 'ro_'.$i.'id_'.$tbl[$i]->romooc[0]->trailer_id;
              $roidshow = 'sro_'.$i.'id_'.$tbl[$i]->romooc[0]->trailer_id;
             ?>
            <div class="notifyjs-wrapper notifyjs-hidable" id="{{$roidshow}}"></div>
            <span id="{{$roid}}" class="ro"onmouseout="CLOSE(this)">{{mb_strtoupper($tbl[$i]->romooc[0]->trailer_num,'UTF-8')}}</span>
            @endif
          </td>
          {{-- xit bon --}}
          <td  style="text-align: center;">
            @if(empty($tbl[$i]->xitbon[0]) == true)
            {{""}}
            @else
            {{mb_strtoupper($tbl[$i]->xitbon[0]->clear_tank_name,'UTF-8')}}
            @endif
          </td>
          {{-- chung tu mang theo 1 --}}
          <td>{{mb_strtoupper($tbl[$i]->ct1,'UTF-8')}}</td>
          {{-- chung tu mang theo 2 --}}
          <td>{{mb_strtoupper($tbl[$i]->ct2,'UTF-8')}}</td>
          {{-- dung cu 1 --}}
          <td>
            @if(empty($tbl[$i]->dungcu1[0]) == true)
            {{""}}
            @else
              <?php
              if(count($tbl[$i]->dungcu1) == 1)
                echo $tbl[$i]->dungcu1[0]->name;
                else{
                  echo $tbl[$i]->dungcu1[0]->name;
                  for($j =1 ; $j < count($tbl[$i]->dungcu1) ; $j++){
                   echo ', '.$tbl[$i]->dungcu1[$j]->name;
                  }
                }
              ?>
            @endif
          </td>
          {{-- dung cu 2 --}}
          <td>
            @if(empty($tbl[$i]->dungcu2[0]) == true)
            {{""}}
            @else
            <?php
            // if(count($tbl[$i]->dungcu2) == 1)
            //   {
            //     echo $tbl[$i]->dungcu2[0]->name;
            //     if($tbl[$i]->dungcu2[0]->num > 1 ) echo ' (SL: '.$tbl[$i]->dungcu2[0]->num.')';

            //   }
            //   else{

            //     echo $tbl[$i]->dungcu2[0]->name;
            //     if($tbl[$i]->dungcu2[0]->num > 1 ) echo ' (SL: '.$tbl[$i]->dungcu2[0]->num.')';
            //     for($j =1 ; $j < count($tbl[$i]->dungcu2) ; $j++){

            //       echo ', '.$tbl[$i]->dungcu2[$j]->name;
            //       if($tbl[$i]->dungcu2[$j]->num > 1 ) echo ' (SL: '.$tbl[$i]->dungcu2[$j]->num.')';
                  
            //     }
            //   }
              // mới
              if(count($tbl[$i]->dungcu2) == 1)
              {
                if($tbl[$i]->dungcu2[0]->num > 1 ) 
                  if($tbl[$i]->dungcu2[0]->num < 10){
                    echo ' 0'.$tbl[$i]->dungcu2[0]->num;
                  } 
                echo $tbl[$i]->dungcu2[0]->name;

              }
              else{

                if($tbl[$i]->dungcu2[0]->num > 1 ){
                  if($tbl[$i]->dungcu2[0]->num < 10 ){
                    echo ' 0'.$tbl[$i]->dungcu2[0]->num.' ';
                  }else echo $tbl[$i]->dungcu2[0]->num.' ';
                } 
                echo $tbl[$i]->dungcu2[0]->name;
                for($j =1 ; $j < count($tbl[$i]->dungcu2) ; $j++){
                  echo ', ';
                  if($tbl[$i]->dungcu2[$j]->num > 1 ) 
                  {
                    if($tbl[$i]->dungcu2[$j]->num < 10 ) 
                      echo ' 0'.$tbl[$i]->dungcu2[$j]->num.' ';
                    else  echo $tbl[$i]->dungcu2[0]->num.' ';
                  }
                  echo $tbl[$i]->dungcu2[$j]->name;

                }
              }
            ?>
            @endif
          </td>
          {{-- ghi chu --}}
          <td>{{mb_strtoupper($tbl[$i]->ghichu,'UTF-8')}}</td>
          {{-- nguoi phu trach --}}
          <td  style="text-align: center;">
            @if(empty($tbl[$i]->nguoiphutrach[0]) == true)
            {{""}}
            @else
            {{mb_strtoupper($tbl[$i]->nguoiphutrach[0]->nick_name,'UTF-8')}}
            @endif
          </td>
        </tr>
        </tr>
      </tbody>
     @endfor
    </table>
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
</section>
<!-- page script -->
<script>
  
  /*======================================================================*/
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
              var customWindow = window.open('{{url("/excelPool")}}'+strType, '_blank', '');
              // customWindow.close();
              console.log(strType);
       });
  }
  function checkComplete(id){
      var type = [];
      type = id;
      console.log(type);
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
                      {
                        console.log(result.x);
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
      console.log(type);
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
          var customWindow = window.open('{{url("/printPool")}}?id='+idPrint, '_blank', '');
          // if(c == type.length -1)
          // idPrint += type[c];
        }
      }
      console.log(idPrint);
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
                        console.log(result.x);
                        swal("Thành công","Cập nhật lệnh điều xe thành công" ,"success")
                        .then((value) => {
                          window.location.href = "/operating";
                        });
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

      document.location.href="/operatingPool/detail/"+id;
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
      { position: position }
      );
  } 
   $('.car').on('mouseover', function() {
    let pos = ($(this).attr('id'));
    let carid = pos.split("_",3);
	let car = arrSearch(carid[2],resData['car'],'car_id');
    let msg = 'Ghi chú: '+((car['note'] != null) ? car['note'] : '');
    showNotify('#s'+pos, msg, "info", "top");
})
    $('.lh').on('mouseover', function() {
    let pos = ($(this).attr('id'));
    let lhid = pos.split("_",3);
    let lh = arrSearch(lhid[2],resData['goods'],'goods_id');
	let msg = 'T.Tin TỶ TRỌNG: '
		+((lh['rate'] != null) ? lh['rate'] : '')+'\r\nGhi chú: '
		+((lh['note'] != null) ? lh['note'] : '');
    showNotify('#s'+pos, msg, "info", "top");
})
    $('.nn').on('mouseover', function() {
    let pos = ($(this).attr('id'));
    let nnid = pos.split("_",3);
    let nn = arrSearch(nnid[2],resData['nng'],'place_id');
	let msg = 'Thông tin người liên hệ: '
		+((nn['contact_note'] != null) ? nn['contact_note'] : '')
		+'\r\nThông tin nơi nhận: '+((nn['warehouse_note'] != null) ? nn['warehouse_note'] : '');
    showNotify('#s'+pos, msg, "info", "top");
})
    $('.ng').on('mouseover', function() {
    let pos = ($(this).attr('id'));
    let ngid = pos.split("_",3);
    let ng = arrSearch(ngid[2],resData['nng'],'place_id');
    console.log(JSON.stringify(ng));
	let msg = 'Thông tin người liên hệ: '
		+((ng['contact_note'] != null) ? ng['contact_note'] : '')
		+'\r\nThông tin nơi giao: '+((ng['warehouse_note'] != null) ? ng['warehouse_note'] : '')
    +'\r\nXe gần nhất: '+((ng['carNote'][0] != null) ? ng['carNote'][0]: "")
    +'\r\n'+((ng['carNote'][1] != null) ? ng['carNote'][1]: "")
    +'\r\n'+((ng['carNote'][2] != null) ? ng['carNote'][2]: "");
    showNotify('#s'+pos, msg, "info", "top");

})
    $('.ch').on('mouseover', function() {
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
    showNotify('#s'+pos, msg, "info", "top");
})
    $('.tx').on('mouseover', function() {
    let pos = ($(this).attr('id'));
    let txid = pos.split("_",3);
    let tx = arrSearch(txid[2],resData['user'],'user_id');
	let msg = 'Tên đầy đủ: '
		+((tx['full_name'] != null) ? tx['full_name'] : '')
		+'\r\n SĐT: '+((tx['phone'] != null) ? tx['phone'] : '')
		+'\r\n CMND: '+((tx['identity_id'] != null) ? tx['identity_id'] : '')
		+'\r\nGhi chú: '+((tx['note'] != null) ? tx['note'] : '')
    showNotify('#s'+pos, msg, "info", "top");
})
    $('.lx').on('mouseover', function() {
    let pos = ($(this).attr('id'));
    let lxid = pos.split("_",3);
    let lx = arrSearch(lxid[2],resData['user'],'user_id');
	let msg = 'Tên đầy đủ: '
		+((lx['full_name'] != null) ? lx['full_name'] : '')
		+'\r\n SĐT: '+((lx['phone'] != null) ? lx['phone'] : '')
		+'\r\n CMND: '+((lx['identity_id'] != null) ? lx['identity_id'] : '')
		+'\r\nGhi chú: '+((lx['note'] != null) ? lx['note'] : '')
    showNotify('#s'+pos, msg, "info", "top");
})
    $('.ro').on('mouseover', function() {
    let pos = ($(this).attr('id'));
    let roid = pos.split("_",3);
    let ro = arrSearch(roid[2],resData['romooc'],'trailer_id');
    let msg = 'Ghi chú: '+((ro['note'] != null) ? ro['note'] : '');
    showNotify('#s'+pos, msg, "info", "top");
})
//--------------------------------------HIDE NOTIFY------------------------------------------
function CLOSE() {
  $('.notifyjs-wrapper').trigger('notify-hide');
}
<?php
$str = str_replace('\r\n', '\\\n',  json_encode($data)) ;
$str = str_replace("'", '\\\'',  $str) ;
 ?>
    //------------------------------------ajax get data--------------------------------------


    var url_string =window.location.href;
    var resData;
    //var operating ;
    $(document).ready(function () {
      // alert('dđ');

      $.ajax('{{url("/operatingPool2")}}', {
        type: 'GET',  
        data: {},
        dataType:"json",
        async: false,
        success: function (result) {
          if(result.success)
          {
           resData = result.success;
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
						<div class="col-sm-1"></div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="" class="col-sm-4 control-label danhmuc">Danh mục tìm `+stt+` :</label>
								<div class="col-md-8">
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
								<label for="" class="col-sm-4 control-label">Nội dung tìm :</label>
								<div class="col-md-8">
									<input type="text" class="form-control inputsearch`+stt+` search-right" name="ContentSearch`+stt+`">
								</div>
							</div>
						</div>
					<div class="col-md-1"><a href="#" class="btn btn-danger remove-btn"><i class="glyphicon glyphicon-remove"></i></a></div>
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
    window.location = "{{ route('operating') }}";
  }
  $(document).on('keyup', function(e) {
	if(e.keyCode === 13)  {
		if($('.select2').val() || $('input[name="dateStart"]') || $('input[name="dateEnd"]')){
			$('#searchForm').submit();
		}
	}
});
</script>
@endsection
