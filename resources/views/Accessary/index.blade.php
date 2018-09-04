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
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe">QUẢN LÝ {{ App\TitleList::ListTitle('accessary') }}</div>
  </div>
</section>
<!-- Search -->
<section class="content">
    <div class="box box-primary">
        <div class="box-header container-fluid" >
            <form action = "/accessary/search" name="searchAccessary" id="searchAccessary" method="GET" class="row">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="form-group col-md-3"></div>
                <div class="form-group col-md-2">
                    <input type="text" id="fullname" name="fullname" class="form-control col-md-2" placeholder="Nhập tên đầy đủ phụ tùng" value="">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" id="shortname" name="shortname" class="form-control col-md-2" placeholder="Nhập tên thay thế phụ tùng" value="">
                </div>
                <button type="submit" id="btnSearch" class="btn btn-success" style="margin-left:1%" form="searchAccessary">Tìm kiếm</button>
                <a class="btn btn-success" style="margin-left:1%" href="/accessary">Tất cả</a> 
            </form>

            <div class="row">
                <div class="col-md-12">
                <a id="createoperating" href="/accessary/create"  class="btn btn-success pull-left"><i class="fa fa-plus"></i>&nbsp&nbspThêm mới</a>

                <form action = "/accessary/outStockSearch" name="outStock" id="outStock" metho="GET">
                    <?php $alert = DB::select("SELECT COUNT(*) AS count FROM tbl_accessary WHERE amount <= remain_alert AND need_import = 0");
                        $count = $alert[0]->count; 
                    ?>
                    @if($count>0)
                        <button type="submit" id="btnSearch" class="btn btn-warning pull-left" style="margin-left:1%" form="outStock"><span class="badge ">{{$count}}</span> phụ tùng sắp hết </button>
                    @endif
                </form>
                <a href="/exportAccessary/create" class="btn btn-success pull-right" style="margin-left:1%">Xuất phụ tùng</a>
                <a href="/importAccessary/create" class="btn btn-success pull-right" style="margin-left:1%">Nhập phụ tùng</a>
                <!-- <div class="pull-right"> -->
                </div>
            </div>
        </div>
    <!-- End Search -->
        <div class="box-body">
        <div class="table-responsive">
            <table id="noigiao" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
            <thead style="background-color: #3C8DBC; color: #FFFFFF">
                <tr role="row">
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tên phụ tùng</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tên thay thế</th> 
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Đơn vị</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Vị trí</th>
                <!-- <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tổng nhập</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tổng xuất</th> -->
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Còn lại</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tồn dưới</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Không nhập</th>
                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Ghi chú</th>
                <th style="width: 80px">Chức năng</th>
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
                @foreach($accessary as $acc)
                <tr>
                <td><?php echo $stt; $stt++;?></td>
                <td>{{$acc->accessary_name}}</td>
                <td>{{$acc->alternative_name}}</td>
                <td>{{$acc->unit}}</td>
                <td>{{$acc->position}}</td>
                <!-- <td>{{$acc->total_import}}</td>
                <td>{{$acc->total_export}}</td> -->
                <td>{{$acc->amount}}</td>
                <td>{{$acc->remain_alert}}</td>
                <td style="text-align:center" disabled><input disabled type="checkbox"  {{$acc->need_import == 1 ? 'checked="checked"' : '' }}></td>
                <td>{{$acc->note}}</td>

                <td style="width: 80px">
                    <a class="edit" title="Sửa" href="/accessary/edit/{{$acc->accessary_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                    <a class="delete" href="#" type="button" onclick="btnDelete({{$acc->accessary_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
                </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        </div>
    </div>
</section>
<script>
    $(document).keypress(function(e) {
        if(e.which == 13) {
            if(!$('#tendaydu').val() && !$('#tendixe').val()){
                location.reload();
            }
            else{
                search();
            }
        }
    });

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
        $('#fullname').val(getUrlParameter('fullname'));
        $('#shortname').val(getUrlParameter('shortname'));
    });

    function btnDelete(id){
        swal({
            title: "Xóa phụ tùng",
            text: "Bạn có chắc chắn muốn xóa phụ tùng này không?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if(willDelete){
                $.ajax({
                    url:"{{url('/accessary/delete')}}",
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
                        swal("Lỗi", "Không tìm thấy phụ tùng!", "error");
                        } 
                    }
                })
            }
        })
    }
</script>
@endsection