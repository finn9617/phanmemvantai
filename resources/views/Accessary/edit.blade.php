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
<style>
/* The container */
.container {
    display: block;
    position: absolute;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
    position: ;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    padding-bottom:10px;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
    background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
    display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
}
</style>
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe">THÊM THÔNG TIN {{ App\TitleList::ListTitle('accessary') }}</div>
  </div>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <div class="row">
                <div class="col-md-12 prePage">
                    <a href="{{ url('accessary') }}">
                    <span class="glyphicon glyphicon-step-backward">
                        <span class="prePage">Quay lại </span>
                    </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="box-body">
            <form id="createAccessary" name="createAccessary">
                <h1>Sửa phụ tùng xe</h1>
                <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="fullname">Tên đầy đủ phụ tùng (*) <i><span style="color:red" id="errorFullname"></span></i></label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nhập tên đầy đủ phụ tùng" value="{{$data->accessary_name}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fullname">Tên thay thế phụ tùng</label>
                        <input type="text" class="form-control" id="shortname" name="shortname" placeholder="Nhập tên viết tắt phụ tùng" value="{{$data->alternative_name}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fullname">Đơn vị tính</label>
                        <input type="text" class="form-control" id="unit" name="unit" placeholder="Nhập đơn vị tính phụ tùng" value="{{$data->unit}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fullname">Vị trí</label>
                        <input type="text" class="form-control" id="position" name="position" placeholder="Nhập vị trí phụ tùng" value="{{$data->position}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fullname">Tồn dưới</label>
                        <input type="text" class="form-control" id="remain" name="remain" placeholder="Nhập số lượng tồn dưới sẽ báo" value="{{$data->remain_alert}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fullname">Giá hiện tại</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Nhập giá hiện tại" value="{{$data->last_price}}">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="form-group container">Không nhập <i><span style="color:red">Lưu ý: Khi chọn vào đây thì phụ tùng trong kho hết sẽ không có thông báo</span></i>
                            <input type="checkbox" class="form-control" id="unimport" name="unimport" {{$data->need_import == 1 ? 'checked="checked"' : '' }}>
                            <span class="checkmark form-control"></span>
                        </label>
                    </div>
                    <div class="form-group col-md-12" style="padding-top:1%;">
                        <label for="note">Ghi chú</label>
                        <textarea class="form-control" id="note" name="note" placeholder="Nhập ghi chú">{{$data->note}}</textarea> 
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <button name="btnChange" id="btnSave" class="btn btn-success btn-md">Lưu</button>&nbsp;
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){
    $('#btnSave').click(function(e){
        $('#errorFullname').empty();
        $('#errorShortname').empty();
        $('#errorNum').empty();
        e.preventDefault();

        var formData = new FormData();
        formData.append('id',"{{$data->accessary_id}}");
        formData.append('_token',$('#_token').val());
        formData.append('fullname',$('#fullname').val());
        formData.append('shortname',$('#shortname').val());
        formData.append('unit',$('#unit').val());
        formData.append('note',$('#note').val());
        formData.append('price',$('#price').val());
        formData.append('remain',$('#remain').val());
        formData.append('position',$('#position').val());

        let uncheck = 0;
        if($('#unimport').prop( "checked"))
        {
            uncheck=1;
        }
        formData.append('unimport',uncheck);

        $.ajax({
            type: 'POST',
            url: "/accessary/edit",
            data: formData,
            processData: false,
			contentType: false,
            success: function(data){
                if(data.success){
                    window.location.href = "{{url('/accessary')}}";
                }
                else{
                    $('#errorFullname').append(data.error.fullname);
                    $('#errorShortname').append(data.error.shortname);
                    $('#errorNum').append(data.error.num);
                    $('#errorLastImport').append(data.error.last_import);
                    $('#errorLastExport').append(data.error.last_export);
                }
            }
        })
    })
});
</script>
@endsection