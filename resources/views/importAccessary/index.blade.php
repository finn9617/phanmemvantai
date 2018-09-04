@extends('blank')
@section('content')
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
?>
@if (session('status'))
    <script>
        swal({
            title: "Xuất báo cáo",
            text: "Không có dữ liệu",
            icon: "warning",
            dangerMode: true,
        })
    </script>
@endif
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe">QUẢN LÝ {{ App\TitleList::ListTitle('importAccessary') }}</div>
  </div>
</section>
<!-- Search -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header container-fluid" >
            <form action = "/importAccessary/search" name="SorderAccessary" id="SorderAccessary" method="GET" class="row">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="form-group col-md-1"></div>
                <div class="form-group col-md-2">
                    <input type="text" id="aShortname" name="aShortname" class="form-control col-md-2" placeholder="Nhập tên phụ tùng" value="">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" id="pShortname" name="pShortname" class="form-control col-md-2" placeholder="Nhập tên nhà cung ứng" value="">
                </div>
                <div class="form-group col-md-2">
                    <input placeholder="Nhập từ ngày" class="form-control" type="text" onfocus="(this.type='date')"  id="ioStart" name="ioStart"> 
                </div>
                <div class="form-group col-md-2">
                    <input placeholder="Nhập đến ngày" class="form-control" type="text" onfocus="(this.type='date')"  id="ioEnd" name="ioEnd"> 
                </div>
                <button type="submit" id="btnSearch" class="btn btn-success" style="margin-left:1%" form="SorderAccessary">Tìm kiếm</button>
                <a class="btn btn-success" style="margin-left:1%" href="/importAccessary">Tất cả</a>
            </form>
            <div class="row">
                <div class="col-md-12">
                <a id="createoperating" href="/importAccessary/create"  class="btn btn-success pull-left" ><i class="fa fa-plus"></i>&nbsp&nbspThêm mới</a>
                <a id="excel" href="/importAccessary/report"  class="btn btn-success pull-left" style="margin-left:1%"><i class="fa fa-file-excel-o"></i>&nbsp&nbspXuất excel</a>
                <!-- <div class="pull-right"> -->
                </div>
            </div>
        </div>
    <!-- End Search -->
        <div class="box-body">
            <div class="table-responsive">
                <table class="table">
                    <thead style="background-color: #3C8DBC; color: #FFFFFF">
                        <tr role="row">
                            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  style="width: 10px;"/>TT</th>
                            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt1" title="Vị trí 1" style="width:9%">NGÀY NHẬP KHO</th>
                            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt2" title="Vị trí 2" style="width: 25%">TÊN PHỤ TÙNG</th>
                            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt3"title="Vị trí 3" style="width: 25%">TÊN NHÀ CUNG ỨNG</th>
                            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt4"title="Vị trí 4" style="width: 10%">TÊN NGƯỜI MUA</th>
                            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt8"title="Vị trí 8">GHI CHÚ</th>
                            <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt9"title="Vị trí 9" style="width: 7%">CHỨC NĂNG</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $stt=1; ?>
                        @foreach($data as $dt)
                        <tr>
                            <td><?php echo $stt; $stt++; ?></td>
                            <?php $import=date_create($dt->order_accessary_date)?>
                            <td>{{date_format($import,'d-m-Y')}}</td>
                            <td>{{$dt->accessaryNames}}</td>
                            <td>{{$dt->partnerNames}}</td>
                            <td>{{$dt->nick_name}}</td>
                            <td>{{$dt->note}}</td>
                            <td style="width: 80px">
                                <a class="edit" title="Sửa" href="/importAccessary/edit/{{$dt->order_accessary_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                <a class="delete" href="#" type="button" onclick="btnDelete({{$dt->order_accessary_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$data->links()}}
            </div>
    </div>
</section>
<script>

function search(){
    $('#SorderAccessary').submit();
}

$(document).ready(function(){
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1].replace(/\+/g,' ');
            }
        }
    };
    $('#aShortname').val(getUrlParameter('aShortname'));
    $('#pShortname').val(getUrlParameter('pShortname'));
    $('#ioStart').val(convertDate(getUrlParameter('ioStart')));
    $('#ioEnd').val(convertDate(getUrlParameter('ioEnd')));

    $('#excel').click(function(e){
        e.preventDefault();
        let start = $('#ioStart').val();
        let end = $('#ioEnd').val();
        if(start=='' || end==''){
           swal({
            title: "Xuất excel",
            text: "Bạn chưa chọn ngày",
            icon: "warning"
           })
        }
        else{
            window.open("{{url('/importAccessary/report')}}?start="+start+"&end="+end,"_blank","");
        }
    })
});

function convertDate(dateString){
    if(dateString!=undefined){
        if(dateString!==''){
            var p = dateString.split(/\D/g)
            return [p[2],p[1],p[0]].join("-")
        }
    }
}

function btnDelete(id){
    swal({
        title: "Xóa dữ liệu",
        text: "Bạn có chắc chắn muốn xóa dữ liệu này không?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if(willDelete){
            $.ajax({
                url:"{{url('/importAccessary/delete')}}",
                type:"POST",
                data: {
                    '_token':'{{csrf_token()}}',
                    'id':id
                },
                success: function (result) {
                    if(result.success)
                    {
                    swal("Xóa thành công!", {
                        icon: "success",
                    }).then(location.reload());
                    }else{
                    swal("Lỗi", "Không tìm thấy dữ liệu!", "error");
                    } 
                }
            })
        }
    })
}
    
</script>
@endsection