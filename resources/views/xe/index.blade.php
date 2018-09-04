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
				$('#xe').submit();
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

?>
<section class="content-header">
      <div class="row">
        <div class="col-md-12 titleDieuXe">{{ App\TitleList::ListTitle('xe') }}</div>
      </div>
      <!-- ./ title -->
</section>
<section class="content">
  <div class="box box-primary">
    <div class="box-header container-fluid" >
     <form  action = "/xe/search" name="xe" id="xe" method="GET" class="row">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          <div class="col-md-1"></div>
          <div class="col-md-2">
            <select class=" select2 col-md-12 lxe" name = "selLoaixe"  id = "selLoaiXe" data-placeholder="-- Loại xe --">
                <option value=""></option>
              
              </select>
          </div>
          <div class="col-md-2">
            <select class=" select2 col-md-12 " name = "selxe" id = "selXe" data-placeholder="-- Số xe --">
                <option value=""></option>
              </select>
          </div>
          <div class="form-group col-md-2">
            <input type="text" class="form-control" id="txtGhichu" @if(isset($_GET['txtGhichu']))value="{{ $_GET['txtGhichu'] }}" @endif placeholder="Ghi chú " name="txtGhichu">
          </div>
          <button type="submit" id="btnSearch" class="btn btn-success" style="margin-left:1%" form="xe">Tìm kiếm</button>
          <a class="btn btn-success" style="margin-left:1%" href="/xe">Tất cả</a>
      </form>
    </div>
  <div class="row">
      <div class="container-fluid">
          <a id="createoperating" href="/xe/create"  class="btn btn-success" style="margin-left:1.5%"><i class="fa fa-plus"></i>&nbsp&nbspThêm mới</a>
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
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Loại xe</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Số xe</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Gợi ý tài xế</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Gợi ý phụ xe</th>
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
            <?php $stt =1; ?>
            @foreach($car as $ng)
            <tr>
              <td><?php echo $stt; $stt++;?></td>
              <td>{{$ng->name}}</td>
              <td>{{$ng->car_num}}</td>
              <td>@if(isset($ng->driver_suggestion)) 
                  <?php 
                      $user = DB::table('tbl_user')->where('user_id','=',$ng->driver_suggestion)->select('nick_name')->get()->toArray();
                      if(isset( ($user[0]))){
                      echo $user[0]->nick_name;
                      }
                  ?>
                @endif</td>
              <td>
                  <?php 
                      $phuxe = DB::table('tbl_user')->where('user_id','=',$ng->assistant_driver_suggestion)->select('nick_name')->get()->toArray();
                      if(isset( ($phuxe[0]))){
                      echo $phuxe[0]->nick_name;
                      }
                  ?>
                  
              </td>
              <td>{{$ng->note}}</td>
              <td style="width: 80px">
                <a class="edit" title="Sửa" href="/xe/detail/{{$ng->car_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                <a class="delete" href="#" type="button" onclick="btnDelete({{$ng->car_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
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
		title: "Xóa XE",
		text: "Bạn có chắc chắn muốn xóa XE này không ?",
		icon: "warning",
		buttons: {
			confirm: 'Có',
			cancel: 'Hủy'
		},
		dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        document.location.href="{{ url('delete/xe') }}/"+id;
      }

    });
  }
    $(document).ready(function(){
      $('#noigiao').DataTable({
        searching: false,
        "bStateSave": true,
      });
    });
</script>
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
  var chilArrayFilter =[];
  if(value){
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
  }else
    return arr;
  
}

</script>
<script>
  
  $(document).keypress(function(e) {
			if(e.which == 13) {
				if(!$('#selLoaiXe').val() && !$('#selXe').val()){
					location.reload();
				}
				else{
          $('#xe').submit();
				}
			}
		});
  //call ajax to xeController to get car data
  var resData;
  var operating ;


    $.ajax('{{url("xe/getCarData")}}', {
      type: 'GET',  
      data: {},
      dataType:"json",
      async: false,
      success: function (result) {
        if(result.success)
        {
          resData = result.success;

       }else{
        swal("Lỗi", "Không tìm thấy !", "error");
      } 
    }

  });
  //add options to selLoaiXe
  addOptionSelectBox('#selLoaiXe', resData['carTypes'], 'car_type_id', 'name');
  addOptionSelectBox('#selXe', resData['cars'], 'car_id', 'car_num');


@if(isset($type))
  $("#selLoaiXe").val({{ $type }});

  $("#selXe option[value!='']").each(function() {
      $(this).remove();
    });
  let carOptions = arrFilter({{$type}}, resData['cars'],'car_type_id');
  addOptionSelectBox('#selXe', carOptions, 'car_id', 'car_num');
@endif

@if(isset($type) && isset($type1))
  $("#selLoaiXe").val({{ $type }});
  $("#selXe").val({{ $type1 }});
@endif

@if(isset($type1))
  $("#selXe").val({{ $type1 }});
@endif

  $('#selLoaiXe').on('change', function() {
    $("#selXe option[value!='']").each(function() {
      $(this).remove();
    });

    // using arrFilter() to get car by car type
    let carOptions = arrFilter(this.value, resData['cars'],'car_type_id');
    addOptionSelectBox('#selXe', carOptions, 'car_id', 'car_num');

  });
</script>

@endsection
