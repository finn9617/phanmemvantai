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
        <div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('xitbon') }}</div>
      </div>
      <!-- ./ title -->
</section>
<section class="content">
  <div class="box box-primary">
    <div class="box-header container-fluid">
     <form  action = "/xitbon/search" name="xitbon" id="xitbon" method="GET">
        <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="col-sm-3"></div>
               <select class="select2 col-md-3  " name = "selxitbon" id = "selxitbon" data-placeholder="-- Chọn tên xịt --">
                <option></option>
                <?php
                  $tank_clear = DB::table('tbl_clear_tank')->orderBy('clear_tank_name')->get();

                    $stt = 1; 
                ?>
                @foreach($tank_clear as $ng)
                  <option @if(isset($searchold)) @if($searchold == $ng->clear_tank_id) selected @endif @endif id="{{$ng->clear_tank_id}}" value="{{$ng->clear_tank_id}}">{{  $ng->clear_tank_name }}</option>
                @endforeach
              </select>

              <button type="submit" class="btn btn-success" style="margin-left:1%" form="xitbon">Tìm kiếm</button>
              <a class="btn btn-success" style="margin-left:1%" href="/xitbon">Tất cả</a>
    </form>
  </div>
  <div class="row">
      <div class="container-fluid">
          <a id="createoperating" href="/xitbon/create" style="margin-left:1.5%"  class="btn btn-success pull-left"><i class="fa fa-plus"></i>&nbsp&nbspThêm mới</a>
        </div>
  </div>
  <!-- /.box-header -->
  {{-- /.box body --}}
  <div class="box-body">
      <div class="table-responsive">
        <table id="noigiao" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
          <thead style="background-color: #3C8DBC; color: #FFFFFF">
            <tr role="row">
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tên xịt bồn romooc</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Ghi chú</th>
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
            @foreach($clear as $ng)
            <tr>
              <td><?php echo $stt; $stt++;?></td>
              <td>{{$ng->clear_tank_name}}</td>
              <td>{{$ng->note}}</td> 
              <td style="width: 80px">
                <a class="edit" title="Sửa" href="/xitbon/detail/{{$ng->clear_tank_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                <a class="delete" href="#" type="button" onclick="btnDelete({{$ng->clear_tank_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
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
  function btnDelete(id){
			swal({
				title: "Xóa xịt bồn",
				text: "Bạn có chắc chắn muốn xóa XỊT BỒN này không ?",
				icon: "warning",
				buttons: {
					confirm: 'Có',
					cancel: 'Hủy'
				},
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.ajax({
						type : "POST",
						url : "{{ url('/delete/xitbon') }}",
						data: {
							'_token': "{{ csrf_token() }}",
							'id': id,
						},
						success : function(data)
						{
              if(data.success){
                  window.location = "{{ url('/xitbon')}}"
                }
						}
					});
				}
			});
  		}
    $(document).ready(function(){
    $('#noigiao').DataTable({
      searching: false,
      "bStateSave": true,
	});
	$(document).on('keyup', function(e) {
		if(e.keyCode === 13)  {
			if($('.select2').val()){
				$('#xitbon').submit();
			}
		}
	 });
  });
</script>

@endsection
