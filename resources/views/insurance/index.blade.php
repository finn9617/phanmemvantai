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
        <div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('insurance') }}</div>
      </div>
      <!-- ./ title -->
</section>
<section class="content">
  <div class="box box-primary">
    <div class="box-header container-fluid">
     <form  action = "/insurance/search" name="insuranceform" id="insuranceform" method="GET">
        <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="col-sm-3"></div>
                <select class="select2 col-md-3  " name = "selinsurance" id = "selinsurance" data-placeholder="-- Chọn số xe --">
                        <option value=""></option>
                    @for($i=0 ; $i < count($insurance_car); $i++)
                        <option @if(isset($insurance_id)) @if($insurance_id == $insurance_car[$i]->car_id) selected @endif @endif value="{{ $insurance_car[$i]->car_id }}">{{ $insurance_car[$i] ->car_num }}</option>
                    @endfor
                </select>

              <button type="submit" class="btn btn-success" style="margin-left:1%" form="insuranceform">Tìm kiếm</button>
              <a class="btn btn-success" style="margin-left:1%" href="/insurance">Tất cả</a>
    </form>
  </div>
  <div class="row">
        <div class="container-fluid">
            <div class="col-md-1">
                <div class="form-group">
                    <a href="/insurance/create" class="btn btn-success pull-left"><i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới</a>
                </div>
            </div>
            <div class="col-md-2">
                <a class="btn btn-info pull-left" data-toggle="modal" data-target="#modal-default" style="margin-left: 3px; background: #3c8dbc;">
                        <?php $n = 0; ?>
                        @foreach( (isset($insurance_hh)) ? $insurance_hh : $insurance as $bh)
                            <?php
                            $date1=date_create(date('Y-m-d'));
                            $date2=date_create($bh->expiration_date);
                            $diff=date_diff($date1,$date2);
                            if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7) $n++;
                            ?>
                        @endforeach
                <span class="badge ">{{ $n }}</span> Xe gần hết hạn
                </a>
            </div>
        </div>
  </div>
    <!-- modal -->
     <div class="modal fade in" id="modal-default" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="height:780px;">
                    <h2 style="text-align: center;color:#0528a9;">DANH SÁCH XE GẦN HẾT HẠN</h2>
                    <section class="content">
                        <div class="box box-primary">
                            <!-- /.box-header -->
                            <div class="box-body">

                                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                                    <div class="row">
                                        <div class="col-sm-6"></div>
                                        <div class="col-sm-6"></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="example2" class="table table-bordered dataTable table-hover no-footer" role="grid" aria-describedby="example2_info">
                                                <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                                    <tr role="row">
                                                        <th class="sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="STT: activate to sort column ascending" style="width: 10px;" aria-sort="descending">STT</th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Bộ dụng cụ
                                            : activate to sort column ascending">Số xe
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Loại dụng cụ
                                            : activate to sort column ascending">Loại xe
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                            : activate to sort column ascending">Số phiếu bảo hiểm
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                                : activate to sort column ascending">Ngày hết hạn 
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                                : activate to sort column ascending">Số ngày còn lại
                                                        </th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >GHI CHÚ</th>

                                                    </tr>
                                                </thead>
                                                <style type="text/css">
                                                    tbody:nth-child(odd) {
                                                        background: #E9F6FC;
                                                    }
                                                    
                                                    tr.even {
                                                        background: #FFFFFF;
                                                    }
                                                </style>
                                                <tbody>
                                                        <?php $stt = 1;?>
                                                       
                                                        @foreach( (isset($insurance_hh)) ? $insurance_hh : $insurance  as $bh)
                                                            <?php
                                                                $date1=date_create(date('Y-m-d'));
                                                                $date2=date_create($bh->expiration_date);
                                                                $diff=date_diff($date1,$date2);
                                                            ?>
                                                        @if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7)
                                                            <tr>
                                                            <td><?php echo $stt; $stt++;?></td>
                                                            <td>{{$bh->car_num}}</td>
                                                            <td>{{$bh->name}}</td> 
                                                            <td>{{$bh->votes}}</td> 
                                                            <td> <?php   echo date_format(  date_create($bh->expiration_date) , 'd/m/Y'); ?> </td> 
                                                            <td>

                                                                <?php
                                                                    if($diff->format("%R") === '-')
                                                                        echo '<span style="color:red;">ĐÃ HẾT HẠN </span>';
                                                                    else if(intval($diff->format("%a")) <= 7)
                                                                        echo '<span style="color:#f39c12;">CÒN '.$diff->format("%d").' NGÀY NỮA HẾT HẠN</span>';
                                                                    else
                                                                        echo $diff->format("%d ngày %m tháng %y năm");
                                                                    ?>
                                                                </td> 
                                                                <td>{{ $bh->note}}</td> 

                                                            </tr>
                                                        @endif
                                                        @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-5"></div>
                                        <div class="col-sm-7"></div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </section>
                <a class="btn btn-success" style="float:right;" target="framename" href="{{ route('printInsu') }}"> IN DANH SÁCH </a>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- end modal  -->
  <!-- /.box-header -->
  {{-- /.box body --}}
  <div class="box-body">
      <div class="table-responsive">
        <table id="insurance" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
          <thead style="background-color: #3C8DBC; color: #FFFFFF">
            <tr role="row">
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ XE</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >LOẠI XE</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ PHIẾU BẢO HIỂM</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >NGÀY HẾT HẠN</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ NGÀY CÒN LẠI</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >GHI CHÚ</th>
              <th style="width: 80px">CHỨC NĂNG</th>
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
              <?php $stt = 1;?>
            @foreach($insurance as $bh)
            <?php
                $date1=date_create(date('Y-m-d'));
                $date2=date_create($bh->expiration_date);
                $diff=date_diff($date1,$date2); 
            ?>
            <tr <?php if( intval($diff->format("%a")) <= 7 || $diff->format("%R") === '-' ) echo 'style="background:#1296f345;color:blue;"'; ?> >
              <td><?php echo $stt; $stt++;?></td>
              <td>{{$bh->car_num}}</td>
              <td>{{$bh->name}}</td> 
              <td>{{$bh->votes}}</td> 
              <td> <?php   echo date_format(  date_create($bh->expiration_date) , 'd/m/Y'); ?> </td> 
              <td>
                  <?php
                    $date1=date_create(date('Y-m-d'));
                    $date2=date_create($bh->expiration_date);
                    $diff=date_diff($date1,$date2);
                    if($diff->format("%R") === '-')
                        echo '<span s>ĐÃ HẾT HẠN</span>';
                    else if( intval($diff->format("%a")) <= 7 )
                        echo '<span >CÒN '.$diff->format("%d").' NGÀY NỮA HẾT HẠN</span>';
                    else
                        echo $diff->format("%d ngày %m tháng %y năm");
                    ?>
                </td> 
                <td>{{ $bh->note}}</td> 

              <td style="width: 80px">
                <a class="edit" title="Sửa" href="/insurance/detail/{{$bh->insurance_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                <a class="delete" href="#" type="button" onclick="btnDelete({{$bh->insurance_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
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
  function btnDelete($id){
    swal({
			title: "Xóa hiểm xe",
            text: "Bạn có chắc chắn muốn xóa Bảo Hiểm này không ?",
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
					url : "{{ url('/delete/insurance') }}",
					data: {
						'_token': "{{ csrf_token() }}",
						'id': $id,
					},
					success : function(data)
					{
						if(data.success){
                            window.location = "{{ url('/insurance')}}"
						}
						if(data.errors){
							swal({
								title: "Loại xe này đang được sử dụng.",
								icon: "warning",
								button: "OK"
							})
						}
						
					}

				});
			}
		});
  }
    $(document).ready(function(){
    $('#insurance').DataTable({
      searching: false,
      "bStateSave": true,
    });
  });


</script>

@endsection
