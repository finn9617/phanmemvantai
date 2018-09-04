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
</script>
<!-- data table -->
<script>
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
    //print_r($currentUser_type);
  }
?>
<section class="content-header">
      <div class="row">
        <div class="col-md-12 titleDieuXe">DANH MỤC QUẢN LÝ {{$title}}</div>
      </div>
      <!-- ./ title -->
    </section>
<section class="content">
  <div class="box box-primary">
  <div class="box-header">
    {{--  --}}
  <div class="row">
  <form  action = "/{{$url}}/search" method="GET">
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class = "row">
      {{--  --}}
      @for($j=0;$j<=$numfield-1;$j++)
      <?php $field = $searchfield[0][$j]; ?>
        <div class = "{{ $html['col'] }}">
          <div class="form-group">
            <div class="input-group" style = "width: {{ $html['width'] }}; margin-left: 15px;">
              <?php $postsearchname = $url.'_'.$searchfield[0][$j]; ?>
                <select class="form-control select2" name = "{{ $postsearchname }}" id = "{{ $postsearchname }}" style="width: 100%; " data-placeholder="-- Chọn {{ $searchfieldindex[0][$j] }} --">
                  <option></option>
                  @for($i=0;$i<$row_all;$i++)
                  <option value="{{$table_all[$i]->$field }}">{{$table_all[$i]->$field }}</option>
                  @endfor
                </select>
            </div>
          </div>
        </div>
      @endfor
      {{--  --}}
      <div class = "{{ $html['col'] }}">
          <div class="form-group">
            <div class="input-group" style = "width: {{ $html['width'] }}; margin-left: 15px;">
             <button type="submit" class="btn btn-success pull-left"><i class="fa fa-search"></i>&nbsp&nbspTìm kiếm </button>
            </div>
          </div>
        </div>
      </div>
    {{-- ./end row --}}
  </form>
</div>
  <div class="row">
      <div class = "{{ $html['col'] }}">
        <div class="form-group">
            <button type="button" onClick="window.location.href='../{{$url}}/create'" class="btn btn-success pull-left"><i class="fa fa-plus"></i>&nbsp&nbspThêm mới</button>
        </div>
      </div>
    </div>
            <!-- /.box-header -->
    <div class="box-body">
      {{-- <div><i style="color: blue">Tộng cộng có</i></div> --}}
      <div class="row">
      <div class="table-responsive">
      <table id="example2" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
        <thead style="background-color: #3C8DBC; color: #FFFFFF">
          <tr role="row">
            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
              @for($i=0;$i<$total_column;$i++)
            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">{{$column_show[0][$i]}}
            </th>
              @endfor
            <th style="width: 80px">Chức năng</th>
          </tr>
        </thead>
          <?php $i =0;?>
            <style type="text/css">
              tbody:nth-child(odd) {
              background: #E9F6FC;
                }
                tr.even{
                  background: #FFFFFF;
                }
            </style>
        <tbody> 
          @for($i;$i<$total_row;$i++)
            <tr>
              <td>{{ $i+1 }}</td>
              @foreach($columns[0] as $c)
              <td>@if(empty($table[$i]->$c) == true) {{""}}
              @else {{ $table[$i]->$c }}
              @endif
              </td>
              @endforeach
              <td style="width: 80px">
              <a class="edit" title="Sửa" href="/{{$url}}/detail/{{$table[$i]->$idtable}}"><i class="glyphicon glyphicon-edit"></i></a>
              &nbsp;&nbsp;
              <a class="delete" href="#" onClick = "btnDelete('{{$table[$i]->$idtable}}')" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>
              </td>
            </tr>
          @endfor
          </tbody>
      </table>
      {{  $table->appends(request()->input())->links() }}
      </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- page script -->
<script>
function btnDelete(id){
    swal({
		title: "Xóa thông tin {{$title}}",
		text: "Bạn chắc chắn xóa {{$title}} này chứ?",
		icon: "warning",
		buttons: {
			confirm: 'Có',
			cancel: 'Hủy'
		},
		dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
        document.location.href="/delete/{{$url}}/"+id;
      } else {
        }
    });
  }
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

  //form user
  // console.log(window.location.href);
    $('#user_user_type').on('change', function(){ 
      let type ="";
      if($('#user_user_type').val() == "Admin"){
        type = 1;
      }else if($('#user_user_type').val() == "NVVP"){
        type = 10;
      }else if($('#user_user_type').val() == "Người liên lạc"){
        type = 11;
      }else if($('#user_user_type').val() == "Tài xế"){
        type = 12;
      }else if($('#user_user_type').val() == "Lơ xe"){
        type = 13;
      }else if($('#user_user_type').val() == "Chủ hàng"){
        type = 14;
      }else if($('#user_user_type').val() == "Người phụ trách"){
        type = 15;
      }else if($('#user_user_type').val() == "Điều phối 1"){
        type = 16;
      }else if($('#user_user_type').val() == "Điều phối 2"){
        type = 17;
      }else if($('#user_user_type').val() == "Văn phòng bãi xe"){
        type = 18;
      }
      // console.log(type);
      let user_type_option = arrFilter(type,resData['user'],'user_type');
      // console.log(user_name_option);
      let optionFullname ="";
      for(var i = 0; i < user_type_option.length; i++) {
        optionFullname += "<option></option><option value='" + user_type_option[i]['full_name'] + "'id = '" + user_type_option[i]['user_id'] + "'>" +user_type_option[i]['full_name']+ "</option>";
      }
      $("select[name='user_full_name']").find('option').remove().end().append($(optionFullname));
      let optionUsername ="";
      for(var i = 0; i < user_type_option.length; i++) {
        optionUsername += "<option></option><option value='" + user_type_option[i]['user_name'] + "'id = '" + user_type_option[i]['user_id'] + "'>" +user_type_option[i]['user_name']+ "</option>";
      }
      $("select[name='user_user_name']").find('option').remove().end().append($(optionUsername));
    });
    $('#user_full_name').on('change', function(){ 
      let user_name_option = arrFilter($('#user_full_name').val(),resData['user'],'full_name');
      // console.log(user_name_option);
      let optionUsername ="";
      for(var i = 0; i < user_name_option.length; i++) {
        optionUsername += "<option></option><option value='" + user_name_option[i]['user_name'] + "'id = '" + user_name_option[i]['user_id'] + "'>" +user_name_option[i]['user_name']+ "</option>";
      }
      $("select[name='user_user_name']").find('option').remove().end().append($(optionUsername));
      // console.log(optionUsername);
    });
  //./end form user

  //Start form nơi giao nhận
  $('#noigiaonhan_name').on('change',function(){
    let address_option = arrFilter($('#noigiaonhan_name').val(),resData['place'],'name');
    console.log(address_option);
    let optionAddress ="";
    for(var i = 0; i < address_option.length; i++) {
      optionAddress += "<option></option><option value='" + address_option[i]['address'] + "'id = '" + address_option[i]['place_id'] + "'>" +address_option[i]['address']+ "</option>";
    }
    $("select[name='noigiaonhan_address']").find('option').remove().end().append($(optionAddress));

    let contact_option = arrFilter($('#noigiaonhan_name').val(),resData['place'],'name');
    let optionContact ="";
    for(var i = 0; i < contact_option.length; i++) {
      optionContact += "<option></option><option value='" + contact_option[i]['contact_note'] + "'id = '" + contact_option[i]['place_id'] + "'>" +contact_option[i]['contact_note']+ "</option>";
    }
    $("select[name='noigiaonhan_contact_note']").find('option').remove().end().append($(optionContact));
  });
    
  $('#noigiaonhan_address').on('change',function(){
    let contact_option = arrFilter($('#noigiaonhan_address').val(),resData['place'],'address');
    // console.log(address_option);
    let optionContact ="";
    for(var i = 0; i < contact_option.length; i++) {
      optionContact += "<option></option><option value='" + contact_option[i]['contact_note'] + "'id = '" + contact_option[i]['place_id'] + "'>" +contact_option[i]['contact_note']+ "</option>";
    }
    $("select[name='noigiaonhan_contact_note']").find('option').remove().end().append($(optionContact));
  });
    

  //.end form nơi giao nhận
  //start form car
  
  //./end form car

  //start form hàng hóa
  $('#hanghoa_rate').on('change',function(){
      let rate_option = arrFilter($('#hanghoa_rate').val(),resData['goods'],'rate');
      // console.log(user_name_option);
      let optionFullname ="";
      for(var i = 0; i < rate_option.length; i++) {
        optionFullname += "<option></option><option value='" + rate_option[i]['full_name'] + "'id = '" + rate_option[i]['goods_id'] + "'>" +rate_option[i]['full_name']+ "</option>";
      }
      $("select[name='hanghoa_full_name']").find('option').remove().end().append($(optionFullname));
      // console.log(optionUsername);
      let optionSortname ="";
      for(var i = 0; i < rate_option.length; i++) {
        optionSortname += "<option></option><option value='" + rate_option[i]['sort_name'] + "'id = '" + rate_option[i]['goods_id'] + "'>" +rate_option[i]['sort_name']+ "</option>";
      }
      $("select[name='hanghoa_sort_name']").find('option').remove().end().append($(optionSortname));
  });
      
  $('#hanghoa_full_name').on('change',function(){
    let fullname_option = arrFilter($('#hanghoa_full_name').val(),resData['goods'],'full_name');
      let optionSortname ="";
      for(var i = 0; i < fullname_option.length; i++) {
        optionSortname += "<option></option><option value='" + fullname_option[i]['sort_name'] + "'id = '" + fullname_option[i]['goods_id'] + "'>" +fullname_option[i]['sort_name']+ "</option>";
      }
      $("select[name='hanghoa_sort_name']").find('option').remove().end().append($(optionSortname));
  })    
  //.end 
  // start form loại dụng cụ
  $('#loaidungcu_tool_type').on('change',function(){
     let loaidungcu_name_option = arrFilter($('#loaidungcu_tool_type').val().charAt($('#loaidungcu_tool_type').val().length-1),resData['toolcategory'],'tool_type');
      // console.log($('#loaidungcu_tool_type').val().charAt($('#loaidungcu_tool_type').val().length-1));
      let optionNametool ="";
      for(var i = 0; i < loaidungcu_name_option.length; i++) {
        optionNametool += "<option></option><option value='" + loaidungcu_name_option[i]['name'] + "'id = '" + loaidungcu_name_option[i]['tool_category_id'] + "'>" +loaidungcu_name_option[i]['name']+ "</option>";
      }
      $("select[name='loaidungcu_name']").find('option').remove().end().append($(optionNametool));
  });
  //.end form loại dụng cụ

  //start form dụng cụ
  $('#dungcu_tenloai').on('change',function(){
    // console.log($('#dungcu_tenloai').val());
    let toolcategoryName_option = arrFilter($('#dungcu_tenloai').val(),resData['tool'],'tenloai');
    // console.log(toolName_option)
    let optionNametool ="";
      for(var i = 0; i < toolcategoryName_option.length; i++) {
        optionNametool += "<option></option><option value='" + toolcategoryName_option[i]['name'] + "'id = '" + toolcategoryName_option[i]['tool_id'] + "'>" +toolcategoryName_option[i]['name']+ "</option>";
      }
      $("select[name='dungcu_name']").find('option').remove().end().append($(optionNametool));
  });
  //./end form dụng cụ
  /*========================================*/

    var tmpStr  ='<?php if(isset($data)) echo str_replace('\r\n', '\\\n',  json_encode($data)); else echo (json_encode([])) ?>';

    var resData = JSON.parse(tmpStr);
    console.log(resData);
  </script>
@endsection
