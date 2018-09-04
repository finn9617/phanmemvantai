@extends('blank')
@section('content')
<?php
  //Check login
  if(!session()->has('email')){
    echo "Chưa đăng nhập";
    exit();

  }
  $currentUser = "";
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
?>
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe">{{ App\TitleList::ListTitle('remainReport') }}</div>
  </div>
</section>
<!-- Search -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header container-fluid" >
            <form>
                <div class="form-group col-md-3"></div>
                <div class="form-group col-md-2">
                    <input placeholder="Nhập/xuất từ ngày" class="form-control" type="text" onfocus="(this.type='date')"  id="ioStart" name="ioStart"> 
                </div>
                <div class="form-group col-md-2">
                    <input placeholder="Nhập/xuất đến ngày" class="form-control" type="text" onfocus="(this.type='date')"  id="ioEnd" name="ioEnd"> 
                </div>
                <button type="submit" id="btnSearch" class="btn btn-success" style="margin-left:1%" form="searchAccessary">Xuất báo cáo</button>
            </form>
        </div>
    <!-- End Search -->
        <div class="box-body">
        <div class="table-responsive">
            <table id="noigiao" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
            <thead style="background-color: #3C8DBC; color: #FFFFFF">
                <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >TÊN PHỤ TÙNG</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >ĐƠN VỊ TÍNH</th> 
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >VỊ TRÍ</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >TỒN ĐẦU KÌ</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >TỔNG NHẬP</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >TỔNG XUẤT</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >TỒN CUỐI KÌ</th>                
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >TỒN DƯỚI</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >KHÔNG NHẬP</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >GHI CHÚ</th>
                <!-- <th style="width: 80px">Chức năng</th> -->
                </tr>
            </thead>
            <style type="text/css">
                #noigiao tbody tr:nth-child(odd) {
                    background: #E9F6FC;
                }
                #noigiao tbody tr:nth-child(even) {
                    background: #FFFFFF;
                }
            </style>
            <tbody>
            <?php $stt = 1; ?>
                @foreach($accessary as $r)
                <tr>
                    <td><?php echo $stt; $stt++; ?></td>
                    <td>{{$r['accessary_name']}}</td>
                    <td>{{$r['unit']}}</td>
                    <td>{{$r['position']}}</td>
                    <td>{{$r['tondauky']}}</td>
                    <td>{{$r['tongnhap']}}</td>
                    <td>{{$r['tongxuat']}}</td>
                    <td>{{$r['toncuoiki']}}</td>
                    <td>{{$r['remain_alert']}}</td>
                    <td>{{$r['need_import'] == 1 ? 'KHÔNG NHẬP' : ''}}</td>
                    <td>{{$r['note']}}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $('#btnSearch').click(function(e){
            e.preventDefault();
            let start = $('#ioStart').val();
            let end = $('#ioEnd').val();

            if(start!="" && end==""){
                swal({
                    title: "Xuất báo cáo",
                    text: "Bạn không chọn ngày kết thúc, báo cáo sẽ bắt đầu từ ngày "+start+" đến ngày hiện tại",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((report) => {
                    if(report){
                        window.open("{{url('/remainReport/report')}}?start="+start+"&end="+end,"_blank","");
                    }
                })
            }

            if(start!="" && end!=""){
                swal({
                    title: "Xuất báo cáo",
                    text: "Báo cáo sẽ bắt đầu từ ngày "+start+" đến ngày "+end,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((report) => {
                    if(report){
                        window.open("{{url('/remainReport/report')}}?start="+start+"&end="+end,"_blank","");
                    }
                })
            }
            if(start=="" && end=="" || start=="" && end!="")
            swal({
                    title: "Xuất báo cáo",
                    text: "Không thể xuất báo cáo vì chưa đầy đủ thông tin",
                    icon: "error",
                    buttons: true,
                    dangerMode: true,
                })


        })
    })
</script>
@endsection