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
        <div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('partner') }}</div>
      </div>
      <!-- ./ title -->
</section>
<section class="content">
  <div class="box box-primary">
      <div class="box-header container-fluid" >
          <form  action = "/partner/search" name="searchPartner" id="searchPartner" method="GET" class="row">
               <meta name="csrf-token" content="{{ csrf_token() }}">
               <div class="col-md-3"></div>
               <select class=" select2 col-md-2 tenpartner" name = "tenpartner"  id = "tenpartner" data-placeholder="-- Tên chủ hàng --">
               <option value=""></option>
             
             </select>
             <select class=" select2 col-md-2 shortpartner" name = "shortpartner" id = "shortpartner" data-placeholder="-- Tên viết tắt chủ hàng --">
                 <option value=""></option>
               </select>
               <button type="submit" id="btnSearch" class="btn btn-success" style="margin-left:1%" form="searchPartner">Tìm kiếm</button>
               <a class="btn btn-success" style="margin-left:1%" href="/partner">Tất cả</a>
           </form>
    <div class="row">
    <div class="col-md-12">
      <a id="createoperating" href="/partner/create"  class="btn btn-success pull-left"><i class="fa fa-plus"></i>&nbsp&nbspThêm mới</a>
      <div class="pull-right">
      </div>
    </div>
    </div>
  </div>
  <!-- /.box-header -->
  {{-- /.box body --}}
  <div class="box-body">
      <div class="table-responsive">
        <table id="partner" class="table table-bordered  dataTable table-hover display" role="grid" aria-describedby="example2_info" style="width: 100%">
          <thead style="background-color: #3C8DBC; color: #FFFFFF">
            <tr role="row">
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tên chủ hàng</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tên viết tắt</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Địa chỉ</th>
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
            <?php $stt = 1; ?>
            <!-- Đổ dữ liệu -->
            @foreach($partner as $pn)
            <tr>
              <td><?php echo $stt; $stt++;?></td>
              <td>{{ $pn->partner_full_name }}</td>
              <td>{{ $pn->partner_short_name }}</td>
              <td>{{ $pn->address }}</td>
              <td>{{ $pn->note }}</td>
              <td style="width: 80px">
                <a class="edit" title="Sửa" href="/partner/{{$pn->partner_id}}/edit"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                <a class="delete" href="#" type="button" onclick="btnDelete({{$pn->partner_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
              </td>
            </tr>
            @endforeach
            <!-- Dừng -->
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

//call ajax to xeController to get car data
var resData;
var operating ;


  $.ajax('{{url("partner/getData")}}', {
    type: 'GET',  
    data: {},
    dataType:"json",
    async: false,
    success: function (result) {
      if(result.success)
      {
        resData = result.success;

     }else{
      swal("Lỗi", "Không tìm thấy!", "error");
    } 
  }

});
//add options to selLoaiXe
addOptionSelectBox('#tenpartner', resData['partners'], 'partner_id', 'partner_full_name');
addOptionSelectBox('#shortpartner', resData['partners'], 'partner_id', 'partner_short_name');

$('#tenpartner').on('change', function() {
  $("#shortpartner option[value!='']").each(function() {
    $(this).remove();
  });

  // using arrFilter() to get car by car type
  let carOptions = arrFilter(this.value, resData['partners'],'partner_id');
  addOptionSelectBox('#shortpartner', carOptions, 'partner_id', 'partner_short_name');

});



@if(isset($partner_s))
  $("#tenpartner").val({{ $partner_s }});
@endif

@if(isset($partner_s) && isset($partner_sh))
  $("#tenpartner").val({{ $partner_s }});
  $("#shortpartner").val({{ $partner_sh }});
@endif

@if(isset($partner_sh))
  $("#shortpartner").val({{ $partner_sh }});
@endif


  function btnDelete(id){
    swal({
        title: "Xóa nơi nhận hàng",
        text: "Bạn có chắc chắn muốn xóa nơi nhận hàng này không ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        document.location.href="/partner/delete/"+id;
      }

    });
  }
  $(document).ready(function(){
    $('#partner').DataTable({
        searching: false,
        //"bInfo":false,
     // "bLengthChange":false
        "bStateSave": true,

	});
	$(document).on('keyup', function(e) {
		if(e.keyCode === 13)  {
			if($('.select2').val()){
				$('#searchPartner').submit();
			}
		}
	 });
  });
</script>

@endsection
