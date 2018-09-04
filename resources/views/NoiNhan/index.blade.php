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
   $(function () {
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging'      : false,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : false,
        'autoWidth'   : false,
        "bStateSave": true,
      })
    })
</script>

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
        <div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('noinhan') }}</div>
      </div>
      <!-- ./ title -->
</section>
<section class="content">
  <div class="box box-primary">
    <div class="box-header container-fluid">
      <form  action = "/noinhan/search" name="searchNoiNhan" id="searchNoiNhan" method="GET">
        <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="col-sm-3"></div>
            <select class=" select2 col-md-3 " name = "tennoinhan" id = "tennoinhan" data-placeholder="-- Tên nơi nhận --">
              <option></option>
                  @foreach($noinhan_all as $nn)
                  <option id="{{$nn->place_id}}" value="{{$nn->place_id}}" @if(request()->get('tennoinhan') == $nn->place_id) selected @endif>{{$nn->name}}</option>
                  @endforeach
              </select>
              <button type="submit" style="margin-left:1%" class="btn btn-success" form="searchNoiNhan">Tìm kiếm</button>
                <a class="btn btn-success" style="margin-left:1%" href="/noinhan">Tất cả</a>
    </form>
    <div class="row">
    <div class="col-md-12">
      <a id="createoperating" href="/noinhan/create"  class="btn btn-success pull-left"><i class="fa fa-plus"></i>&nbsp&nbspThêm mới</a>
      {{-- <div class="pull-right">
        <button type="submit" class="btn btn-success" form="searchNoiNhan">Tìm kiếm</button>
        <a class="btn btn-success" href="/noinhan">Tất cả</a>
      </div> --}}
    </div>
    </div>
  </div>
  <!-- /.box-header -->
  {{-- /.box body --}}
  <div class="box-body">
      <div class="table-responsive">
        <table id="noinhan" class="table table-bordered  dataTable table-hover display" role="grid" aria-describedby="example2_info" style="width: 100%">
          <thead style="background-color: #3C8DBC; color: #FFFFFF">
            <tr role="row">
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tên nơi nhận</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Địa chỉ</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Người liên hệ</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Thông tin nơi giao</th>
              <th style="width: 80px">Chức năng</th>
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
          <tbody>
            <?php $stt = 1; ?>
            @foreach($noinhan as $nn)
            <tr>
              <td><?php echo $stt; $stt++;?></td>
              <td>{{$nn->name}}</td>
              <td>{{$nn->address}}</td>
              <td>{{$nn->contact_note}}</td>
              <td>{{$nn->warehouse_note}}</td>
              <td style="width: 80px">
                <a class="edit" title="Sửa" type="button" href="#" onclick="btnEdit({{$nn->place_id}})"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                <a class="delete" href="#" type="button" onclick="btnDelete({{$nn->place_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
  </div>
  <!-- /.box-body -->
  </div>
  <!-- /.box -->
</section>
<!-- page script -->
<script>
  function btnEdit(id){
    var operatingCurentPage  = window.location.href;
    if (typeof(Storage) !== "undefined") {
        localStorage.setItem('noinhan', operatingCurentPage);
    } else {
        document.write('Trình duyệt của bạn không hỗ trợ local storage');
    }
    document.location.href="/noinhan/"+id+"/edit";  
}


  function btnDelete(id){
    swal({
		title: "Xóa nơi nhận hàng",
		text: "Bạn có chắc chắn muốn xóa nơi nhận hàng này không ?",
		icon: "warning",
		buttons: {
			confirm: 'Có',
			cancel: 'Hủy'
		},
		dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        document.location.href="/noinhan/delete/"+id;
      }

    });
  }
  $(document).ready(function(){
    $('#noinhan').DataTable({
      searching: false,
      "bStateSave": true,
	});

//   function btnEdit(id){
//     var operatingCurentPage  = window.location.href;
//     if (typeof(Storage) !== "undefined") {
//         localStorage.setItem('operatingCurentPage', operatingCurentPage);
//     } else {
//         document.write('Trình duyệt của bạn không hỗ trợ local storage');
//     }
//     document.location.href="/noinhan/"+id+"/edit";
// }

	$(document).on('keyup', function(e) {
		if(e.keyCode === 13)  {
			if($('.select2').val()){
				$('#searchNoiNhan').submit();
			}
		}
	 });
  });
</script>

@endsection
