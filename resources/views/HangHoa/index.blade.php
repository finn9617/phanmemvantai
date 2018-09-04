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
        <div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('hanghoa') }}</div>
      </div>
      <!-- ./ title -->
</section>
<section class="content">
  <div class="box box-primary">
      <div class="box-header container-fluid" >
          <form  action = "/hanghoa/search" name="searchHangHoa" id="searchHangHoa" method="GET">
            <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="col-md-3"></div>
                <select class=" select2 col-md-2 lxe" name = "tenviettat" id = "tenviettat" data-placeholder="-- Tên viết tắt --">
                <option value=""></option>
                  @foreach($sort_name as $sn)
                  <option id="{{$sn->goods_id}}" value="{{$sn->sort_name}}"@if(request()->get('tenviettat') == $sn->sort_name) selected @endif>
                    {{$sn->sort_name}}
                  </option>
                  @endforeach
              </select>
              <select class=" select2 col-md-2 "  name = "tendaydu" id = "tendaydu" data-placeholder="-- Tên đầy đủ --">
                  <option value=""></option>
                  @foreach($full_name as $fn)
                  <option id="{{$fn->goods_id}}" value="{{$fn->full_name}}"@if(request()->get('tendaydu') == $fn->full_name) selected @endif>{{$fn->full_name}}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-success" form="searchHangHoa" style="margin-left:1%" >Tìm kiếm</button>
                <a class="btn btn-success" style="margin-left:1%" href="/hanghoa">Tất cả</a>
            </form>
          </div>
        <div class="row">
            <div class="container-fluid">
                <a id="createoperating" href="/hanghoa/create"  class="btn btn-success " style="margin-left:1.5%"><i class="fa fa-plus"></i>&nbsp&nbspThêm mới</a>
            </div>
        </div>
  <!-- /.box-header -->
  {{-- /.box body --}}
  <div class="box-body">
      <div class="table-responsive">
        <table id="hanghoa" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
          <thead style="background-color: #3C8DBC; color: #FFFFFF">
            <tr role="row">
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tên đầy đủ</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tên viết tắt</th>
              <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >Tỷ trọng</th>
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
            <?php $stt = 1;?>
            @foreach($hanghoa as $hh)
            <tr>
              <td><?php echo $stt; $stt++;?></td>
              <td>{{$hh->full_name}}</td>
              <td>{{$hh->sort_name}}</td>
              <td><?php echo  str_replace(".", ",", $hh->rate); ?></td>
              <td>{{$hh->note}}</td>
              <td style="width: 80px">
                <a class="edit" title="Sửa" onclick="btnEdit({{$hh->goods_id}})" href="#"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                <a class="delete" href="#" type="button" onclick="btnDelete({{$hh->goods_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
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
  //---------------------------------------------------------------
  function btnEdit(id){
    document.location.href="/hanghoa/"+id+"/edit";  
}

  function btnDelete(id){
    swal({
		title: "Xóa hàng hóa",
		text: "Bạn có chắc chắn muốn xóa hàng hóa này không ?",
		icon: "warning",
		buttons: {
			confirm: 'Có',
			cancel: 'Hủy'
		},
		dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        swal("Thành công", "Đã xóa 01 hàng hóa", "success")
          .then((value) => {
            document.location.href="/hanghoa/delete/"+id;
          });
          setTimeout(function(){ document.location.href="/hanghoa/delete/"+id; }, 3000);
      }
    });
  }
$(document).ready(function(){
    $('#hanghoa').DataTable({
      searching: false,
      "bStateSave": true,
    });
  });
/*=======================================================================*/
function arrFilter(value, arr, filterCol){
  var chilArrayFilter =[];
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
  }
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
/*=======================================================================*/
//-----------------------------------------------------
$('#tenviettat').on('change',function(){
      let tenviettat_option = arrFilter($('#tenviettat').val(),resData['hanghoa'],'sort_name');
      console.table(tenviettat_option)
      let optionFullname ="";
      if(tenviettat_option && tenviettat_option.length >0){
        for(var i = 0; i < tenviettat_option.length; i++) {
          optionFullname += "<option></option><option value='" + tenviettat_option[i]['full_name'] + "'id = '" + tenviettat_option[i]['goods_id'] + "'>" +tenviettat_option[i]['full_name']+ "</option>";
        }
      }
      $("select[name='tendaydu']").find('option').remove().end().append($(optionFullname));
      
  }); 
    
  //.end 
//-----------------------------------------------------
var url_string =window.location.href;
    
    var resData;
    //var operating ;
    $(document).ready(function () {
      // alert('dđ');

      $.ajax('{{url("/hanghoa2")}}', {
        type: 'GET',  
        data: {},
        dataType:"json",
        async: false,
        success: function (result) {
          if(result.success)
          {
           resData = result.success;
           console.log('okeeeeee');
           
           // swal("Thành công", "ok!", "success");
         }else{
          swal("Lỗi", "Không tìm thấy hàng hóa!", "error");
        } 
      }

	});
	$(document).on('keyup', function(e) {
		if(e.keyCode === 13)  {
			if($('.select2').val()){
				$('#searchHangHoa').submit();
			}
		}
	 });
    })
</script>

@endsection
