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
	$(document).on('keyup', function(e) {
		if(e.keyCode === 13)  {
			if($('.select2').val()){
				$('#loaixe').submit();
			}
		}
	});
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
        <div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('sumMaintenance') }}</div>
      </div>
      <!-- ./ title -->
</section>
<section class="content">
  <div class="box box-primary">
    <div class="box-header container-fluid">
    <form  action = "{{ route('searchsum')}}" name="sumMaintenance" id="sumMaintenance" method="GET">
        <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="col-sm-3"></div>
                <select class="select2 col-md-3  " name = "selsoxe" id = "selsoxe" data-placeholder="-- Chọn số xe --">
                        <option value=""></option>
                        @foreach($car as $bd)
                          <option @if(isset($car_id)) @if($car_id ==$bd->car_id ) selected @endif @endif value="{{$bd->car_id}}">{{ $bd->car_num}}</option>
                        @endforeach
                </select>

              <button type="submit" class="btn btn-success" style="margin-left:1%" form="sumMaintenance">Tìm kiếm</button>
              <a class="btn btn-success" style="margin-left:1%" href="/sumMaintenance">Tất cả</a>
    </form>
  </div>

  <!-- /.box-header -->
  {{-- /.box body --}}
    <style type="text/css">
      tr.odd {
      background: #E9F6FC;
    }
    tr.even{
      background: #FFFFFF;
    }
    table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable td:last-child, table.table-bordered.dataTable td:last-child {
        border-right-width: 1px;
    }
  </style>
  <div class="box-body">
      <div class="table-responsive">
        <table id="verify" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
          <thead style="background-color: #3C8DBC; color: #FFFFFF">
                <tr role="row">
                    <th  style="border-bottom-width: 0; ;" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="2" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
                    <th  style="border-bottom-width: 0; ;" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="2" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ XE </th>
                    <th  style="border-bottom-width: 0;" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="2" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >NGÀY BẢO DƯỠNG</th>
                    <th  style="border-bottom-width: 0; text-align:center; background-color: #598ca9;" colspan="3">NGÀY HẾT HẠN </th>
                    <th  style="border-bottom-width: 0; text-align:center; background-color: #6c9ebb;" colspan="2" >BÁO</th>
                    <th  style="border-bottom-width: 0px; border-right-width: 1px; background-color: #6c9ebb;" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="2" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >CHI TIẾT</th>
                </tr>
                <tr >
                  <th style="border-bottom-width: 0; background-color: #598ca9"  class="sorting_asc"  aria-controls="example2" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >BẢO HIỂM</th>
                  <th style="border-bottom-width: 0; background-color: #598ca9;"  class="sorting_asc"  aria-controls="example2" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >KIỂM ĐỊNH</th>
                  <th style="border-bottom-width: 0; background-color: #598ca9;"  class="sorting_asc"  aria-controls="example2" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >CN PCCC</th>
                  <th style="border-bottom-width: 0; background-color: #6c9ebb;"  class="sorting_asc"  aria-controls="example2" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >THAY NHỚT</th>
                  <th style="border-bottom-width: 0; background-color: #6c9ebb;"  class="sorting_asc"  aria-controls="example2" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >THAY VỎ</th>
                </tr>
          </thead>
          <tbody>
              <?php $stt = 1;?>
            @for($i=0 ; $i < count($sum); $i++)
            <tr  style="text-align:center;">
                <td><?php echo $stt; $stt++;?></td>
                <td>{{ $sum[$i]->car_num }}</td>
                <td> <?php   if($sum[$i]->date_bd) echo date_format(  date_create($sum[$i]->date_bd) , 'd/m/Y'); ?></td> 
                <td> <?php   if($sum[$i]->date_bh) echo date_format(  date_create($sum[$i]->date_bh) , 'd/m/Y'); ?></td> 
                <td> <?php   if($sum[$i]->date_kd) echo date_format(  date_create($sum[$i]->date_kd ) , 'd/m/Y'); ?></td> 
                <td> <?php   if($sum[$i]->date_cn) echo date_format(  date_create($sum[$i]->date_cn) , 'd/m/Y'); ?></td> 
                <td></td>
                <td></td> 
                <td>
                    <a class="edit" title="Sửa" href="/sumMaintenance/viewItemdetail/{{ $sum[$i]->car_id }}"><i class="glyphicon glyphicon-edit"></i></a>
                </td> 
            </tr>
            @endfor
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
    $(document).ready(function(){
    $('#verify').DataTable({
      searching: false,
      "bStateSave": true,
    });
  });


</script>

@endsection
