@extends('blank')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-md-12 titleDieuXe">THÊM MỚI NGƯỜI DÙNG</div>
      </div>
              <!-- back page -->
      <div class="row">
        <div class="col-md-12 prePage">
          <a href="#" onclick="back()" class="">
            <span class="glyphicon glyphicon-step-backward">
              <span class="prePage">Quay lại </span>
            </span>
          </a>
        </div>
      </div>
      <!-- ./ back page -->
    </section>
    <!-- Main content -->
    <section class="content">
    	{{-- form start --}}
    <form id="user" name="user">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
                <!-- Main content -->
            
                  <div class="row">
                    <div class="col-md-3">
            
                      <!-- Profile Image -->
                      <div class="box box-primary">
                        <div class="box-body box-profile">
                          <img class="profile-user-img img-responsive img-circle" src="../../img/user.png" alt="User profile picture">
            
                          <h3 class="profile-username text-center"></h3>
            
                          <p class="text-muted text-center"></p>
            
                          <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                              <b>Công ty</b> <a class="pull-right"></a>
                            </li>
                            <li class="list-group-item">
                              <b>Phòng ban</b> <a class="pull-right"></a>
                            </li>
                            <li class="list-group-item">
                              <b>Số điện thoại</b> <a class="pull-right"></a>
                            </li>
                          </ul>
            
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.box -->
            
                      <!-- About Me Box -->
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title"><b>THÔNG TIN</b></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <strong><i class="fa fa-book margin-r-5"></i> Địa chỉ</strong>
            
                          <p class="text-muted">
                            
                          </p>
            
                          <hr>
            
                          <strong><i class="fa fa-file-text-o margin-r-5"></i> Ghi chú</strong>
            
                          <p></p>
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#thongtinnguoidung" data-toggle="tab">Thông tin người dùng</a></l>
                        </ul>
                        <div class="tab-content">
                            <div><h4><b>Thông tin đăng nhập</b></h4></div>
                            <div class="form-group">
                                <label for="username" class="control-label">Tên đăng nhập (*):</label>
                                <input type="text" class="form-control" id="txtUsername" name="txtUsername" placeholder="Enter Username" >
                            </div>
                            <div class="form-group">
                                <label for="email" class="control-label">Email :</label>
                                <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="Enter Email">
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Mật khẩu (*):</label>
                                <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Enter password" >
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Nhập lại mật khẩu (*):</label>
                                <input type="password" class="form-control" id="txtConfirm_password" name="txtConfirm" placeholder="Enter confirm password" >
                            </div>
                            <hr>
                            <div><h4><b>Thông tin người dùng</b></h4></div>

                            <div class="form-group">
                                <label for="selDanhxung" class="control-label">Danh xưng :</label>
                                <select class="form-control" id="selDanhxung" name="selDanhxung">
                                    <option value="1">Anh</option>
                                    <option value="0">Chị</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="txtHoten" class="control-label">Họ tên :</label>
                                <input type="text" class="form-control" id="txtHoten" name="txtHoten" placeholder="Nhập họ tên" >
                            </div>
                            <div class="form-group">
                                <label for="txtTenthuonggoi" class="control-label"class="col-sm-2 control-label">Tên thường gọi :</label>
                                <input type="text" class="form-control" id="txtTenthuonggoi" name="txtHotenthuonggoi" placeholder="Nhập tên thường gọi">
                            </div>
                            <div class="form-group">
                                <label for="selChucvu" class="control-label">Chức vụ :</label>
                                <select class="form-control" id="selChucvu" name="selChucvu" onchange="showhide(this)" >
                                    <option id="1" value="1" >Admin</option>
                                    <option id="10" value="10" >Nhân viên văn phòng</option>
                                    <option id="11" value="11">Người liên lạc</option>
                                    <option id="12" value="12">Tài xế</option>
                                    <option id="13" value="13">Lơ xe</option>
                                    <option id="14" value="14">Chủ hàng</option>
                                    <option id="15" value="15">Người phụ trách</option>
                                    <option id="16" value="16">Điều phối 1</option>
                                    <option id="17" value="17">Điều phối 2</option>
                                    <option id="18" value="18">Văn phòng bãi xe</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="diachi" class="control-label">CMND :</label>
                               <input type="text" class="form-control" id="txtCNND" name="txtCNND" placeholder="Nhập chứng minh nhân dân">
                            </div>
                            <div class="form-group">
                                <label for="diachi" class="control-label">Địa chỉ :</label>
                                <textarea class="form-control" rows="3" placeholder="Nhập địa chỉ người dùng" id="txtDiachi" name="txtDiachi"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="sdt" class="control-label">Số điện thoại :</label>
                                <input type="text" class="form-control" id="txtSDT" name="txtSDT" placeholder="Nhập số điện thoại người dùng">
                            </div>
                            <div class="form-group">
                                <label for="note" >Ghi chú :</label>
                                <textarea class="form-control" rows="3" placeholder="Nhập ghi chú" id ="txtGhichu" name="txtGhichu"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="selTrangthai">Trạng thái :</label>
                                <select class="form-control" id="selTrangthai" name="selTrangthai">
                                    <option value="0">Đang làm</option>
                                    <option value="1">Đã nghỉ</option>
                                </select>
                            </div>
                            {{-- START DROP DOW --}}
                            
                            
                              <div id="gplx" style="display: none">
                                  <div><h4><b>Giấy phép lái xe</b></h4><i style="color: red">(*) Hạng mục dành riêng cho user là tài xế</i></div>
                                  <div class="form-group">
                                      <div id="addgplx" style="display: none">
                                        <div class="col-md-3">
                                          <div class="form-group">
                                          <label for="sogplx">Số GPLX (*):</label>
                                          <input type="text" class="form-control" id="txtsogplx" name="txtSogplx" placeholder="Nhập số GPLX">
                                        </div>
                                        </div>
                                        <div class="col-md-3">
                                        <div class="form-group">
                                          <label for="hanggplx">Hạng (*):</label>
                                          <input type="text" class="form-control" id="txthanggplx" name="txtHanggplx" placeholder="Hạng" >
                                        </div>
                                        </div>
                                        <div class="col-md-3">
                                        <div class="form-group">
                                          <label for="ngayhethan">Ngày hết hạn :</label>
                                          <div class="input-group date">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input class="form-control" id="datengayhethan" name="dateNgayhethan" value type="date">
                                           </div>
                                        </div>
                                        </div>
                                        <div class="col-md-3">
                                        <div class="btn-group">
                                        <div style="margin-bottom: 25px"></div>
                                        <button type="button" class="btn btn-success pull-left" style="height: 32px; " id="btnAddGPLX">Thêm GPLX</button>
                                        </div>
                                        </div>
                                      </div>
                                  <button type="button" onClick="showrowaddgplx()" class="btn btn-success pull-right" style="height: 32px; "><i class="fa fa-plus"></i></button>

                                  <table class="table table-bordered table-striped" id="tblGPLX">
                                          <!-- <tbody> -->
                                            <tr id="tr_th" style="background: #3C8DBC; color: #ffffff; font-family: Arial, Helvetica, sans-serif; ">
                                              <th class="th" style="text-align: center;">
                                                Số giấy phép LX
                                              </th>
                                              <th class="th" style="text-align: center;">
                                                Hạng
                                              </th>
                          
                                              <th class="th" style="text-align: center;">
                                                Ngày hết hạn
                                              </th>
                          
                                              <th class="th" style="width:110px; text-align: center;">
                                                Chức năng
                                              </th>
                                            </tr>
                                            <!-- append tr here -->
                                            <!-- </tbody> -->
                                          </table>
                              </div>
                              </div>
                            <div class="form-group">
                                <div id="chuhang" style="display: none">
                                  <div><h4><b>Thông tin chủ hàng</b></h4><i style="color: red">(*) Hạng mục dành riêng cho user là chủ hàng</i></div>
                                  <div class="form-group">
                                    <label for="selNoinhan">Nơi nhận :</label>
                                      <select class="form-control" id="selNoinhan" name="selNoinhan">
                                          <option ></option>
                                        @foreach($noinhan as $nn)
                                        <option value="{{$nn->place_id}}">{{$nn->name}}</option>
                                        @endforeach
                                      </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="selNguoiphutrach">Người phụ trách :</label>
                                      <select class="form-control" id="selNPT" name="selNPT">
                                        <option ></option>
                                        @foreach($nguoiphutrach as $npt)
                                        <option value="{{$npt->user_id}}">{{$npt->full_name}}</option>
                                        @endforeach
                                      </select>
                                  </div>
                                </div>
                              </div>
                              </div>
                              </div>
                              {{-- END DROP DOW --}}
                              {{-- START FOOTER --}}
                          <div class="box-footer" >
                           <div class="form-group">
                              <label for=""></label>
                              <button type="button" onclick="postdata()" class="btn btn-success btn-md postbutton" >Lưu</button>
                              &nbsp;
                              {{-- <button type="button" name="btnCancel" id="btnCancel" onclick="location.href='/user'" class="btn btn-danger btn-md pull-right">Quay lại</button>
                              &nbsp; --}}
                              
                            </div>
                          </div>
                          {{-- END FOOTER --}}
                        </div>
                        </div>

                      </div>
                        <!-- /.tab-content -->
                      </div>
                      <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                  <!-- /.row -->
    </form>

  	  	{{-- end form --}}

    </section>
{{-- show/hide table --}}
    <script type="text/javascript">
    	function showhide(){
    		var selChucvu = document.getElementById("selChucvu").value;
    		if(selChucvu ==1){
    			$("#gplx").hide("slow");
    			$("#hangxe").hide("slow");
    			$("#chuhang").hide("slow");
          $("#addgplx").hide("slow");
          $("#addhx").hide("slow");
    		}
    		if(selChucvu ==11){
    			$("#gplx").hide("slow");
    			$("#hangxe").hide("slow");
    			$("#chuhang").hide("slow");
          $("#addgplx").hide("slow");
          $("#addhx").hide("slow");
    		}
    		if(selChucvu ==13){
    			$("#gplx").hide("slow");
    			$("#hangxe").hide("slow");
    			$("#chuhang").hide("slow");
          $("#addgplx").hide("slow");
          $("#addhx").hide("slow");
    		}
    		if(selChucvu ==15){
    			$("#gplx").hide("slow");
    			$("#hangxe").hide("slow");
    			$("#chuhang").hide("slow");
          $("#addgplx").hide("slow");
          $("#addhx").hide("slow");
    		}
        if(selChucvu ==16){
          $("#gplx").hide("slow");
          $("#hangxe").hide("slow");
          $("#chuhang").hide("slow");
          $("#addgplx").hide("slow");
          $("#addhx").hide("slow");
        }
        if(selChucvu ==17){
          $("#gplx").hide("slow");
          $("#hangxe").hide("slow");
          $("#chuhang").hide("slow");
          $("#addgplx").hide("slow");
          $("#addhx").hide("slow");
        }
    		
    		if(selChucvu ==12){
    			$("#gplx").show("slow");
    			$("#hangxe").show("slow");
    			$("#chuhang").hide("slow");
    		}
    		if(selChucvu ==14){
    			$("#chuhang").show("slow");
    			$("#gplx").hide("slow");
    			$("#hangxe").hide("slow");
          $("#addgplx").hide("slow");
          $("#addhx").hide("slow");
    		}
    	}
      function showrowaddgplx(){
        $("#addgplx").show("slow");
      }
      function showrowaddhx(){
        $("#addhx").show("slow");
      }
      //==============================add GPLX====================
    function xoa_dau(str) {
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "a");
        str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "e");
        str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "i");
        str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "o");
        str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "u");
        str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "y");
        str = str.replace(/Đ/g, "d");
        str = str.replace(/[^0-9a-zàáạảãâầấậẩẫăằắặẳẵèéẹẻẽêềếệểễìíịỉĩòóọỏõôồốộổỗơờớợởỡùúụủũưừứựửữỳýỵỷỹđ\s]/gi, '');
        str = str.replace(/ /g,'');
        str = str.toLowerCase()
        return str;
      }
      $('#txtHoten').on('change',function(){
        if(!$('#txtUsername').val()){
              let curr_name = $('#txtHoten').val();
              let autoUsername = xoa_dau(curr_name);
              $('#txtUsername').val(autoUsername+'_tnk');
              // swal("Username tự dộng:+" autoUsername+"_tnk");
              };

      });
      //===================
    var dataTable = [];
    let element = {};
    var data_license = [];
    var stt = 1;
    $('#btnAddGPLX').click(function () {
      let sogplx = $('#txtsogplx').val();
      let hanggplx = $('#txthanggplx').val();
      let ngayhethan = $('#datengayhethan').val();
      if(sogplx == null &&  hanggplx == null && ngayhethan == null){
        alert('Error !');
      } else {
      let rowID = 'row_'+sogplx;
      let celsosplx = 'cel_'+sogplx;
      let celhanggplx = 'cel2_'+hanggplx;
      let celngayhethan = 'cel3_'+ngayhethan;
      let rowHTML = '<tr class="trGP" id="'+rowID+'"><td id="'+celsosplx+'" >'+sogplx+'</td><td id="'+celhanggplx+'" >'+hanggplx+'</td><td id="'+hanggplx+'">'+ngayhethan+'</td><td style="vertical-align: inherit;"><div class=" iconRemoveRowTable"><span class="glyphicon glyphicon-remove-sign"></span></div></td></tr>';
      stt++;  
      let celsosplx_val = celsosplx.split("_")[1];
      let celhanggplx_val = celhanggplx.split("_")[1];
      let celngayhethan_val = celngayhethan.split("_")[1];
      data_license.push([celsosplx_val,celhanggplx_val,celngayhethan_val]);
      element.data_license = data_license;
      // console.log(data_license[0][0]);
      $('#tblGPLX').append(rowHTML);
      }
    });
    $('#tblGPLX').on('click', '.iconRemoveRowTable', function () {
        let indexRow = this.parentNode.parentNode.rowIndex;
        let table = document.getElementById("tblGPLX");
        let row = table.rows[indexRow];
        let gpIDSearch = (row.id.split("_")[1]); 
        element.data_license.splice(gpIDSearch,1);
        document.getElementById("tblGPLX").deleteRow(indexRow);
      });
  //========================SET VALUE DATATABLE=================

    //console.log(dataTable);

    function postdata(){
      var user_name = "";
      element.user_name = $('#txtUsername').val();

      var email = "";
      element.email = $('#txtEmail').val();

      var password ="";
      element.password = $('#txtPassword').val();

      var confirm_password ="";
      element.confirm_password = $('#txtConfirm_password').val();

      var gender_id ="";
      element.gender_id = $('#selDanhxung').val();

      var full_name = "";
      element.full_name = $('#txtHoten').val();

      var nick_name = "";
      element.nick_name = $('#txtTenthuonggoi').val();

      var user_type = "";
      element.user_type = $('#selChucvu').val();

      var identity_id = "";
      element.identity_id = $('#txtCNND').val();

      var address = "";
      element.address = $('#txtDiachi').val();

      var phone ="";
      element.phone = $('#txtSDT').val();

      var note ="";
      element.note = $('#txtGhichu').val();

      var status ="";
      element.status = $('#selTrangthai').val();

      var receipt_place_id ="";
      element.receipt_place_id = $('#selNoinhan').val();

      var curator_id ="";
      element.curator_id = $('#selNPT').val();
      dataTable.push(element);
      console.log(dataTable);
    }

     $(document).ready(function(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(".postbutton").click(function(){
                  
                  $.ajax({
                      /* the route pointing to the post function */
                      url: '/createuser',
                      type: 'POST',
                      
                      /* send the csrf-token and the input to the controller */
                      data: {_token: CSRF_TOKEN, data : dataTable},
                      dataType: 'JSON',
                      /* remind that 'data' is the response of the AjaxController */
                      success: function (result) {
                      if(result.success)
                      {
                        console.log(result.x);
                        swal("Thành công", "Đã thêm mới 01 người dùng!", "success")
                        .then((value) => {
                          window.location.href = "/user";
                        });
                      }
                      if(result.error)
                      {
                        swal("Thất bại", "Có lỗi trong quá trình xử lý", "error");
                      }
                      if(result.password_error)
                      {
                        swal("Thất bại", "Nhập lại mật khẩu chưa chính xác", "error");
                      }
                      if(result.name_error)
                      {
                        swal("Thất bại", "Họ và tên không được bỏ trống", "error");
                      }
                      if(result.email_error)
                      {
                        swal("Thất bại", "Email chưa đúng định dạng", "error");
                      } 
                      if(result.identity_error)
                      {
                        swal("Thất bại", "CMND chưa đúng", "error");
                      }
                      if(result.repmail_error)
                      {
                        swal("Thất bại", "Email đã tồn tại", "error");
                      }
                      if(result.repname_error)
                      {
                        swal("Thất bại", "Tên đăng nhập đã tồn tại", "error");
                      }
                      if(result.username_error)
                      {
                        swal("Thất bại", "Tên đăng nhập không hợp lệ", "error");
                      }
                                  
                    }
                }); 
            });
       });
      function back(){
        window.history.back();
       } 
       //------------------

       
    </script>

@endsection