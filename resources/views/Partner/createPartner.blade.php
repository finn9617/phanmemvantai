@extends('blank')
@section('content')
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-md-12 titleDieuXe">THÔNG TIN CHỦ HÀNG</div>
      </div>
              <!-- back page -->
      <div class="row">
        <div class="col-md-12 prePage">
          <a href="#" onclick="window.location.href='/partner'" class="">
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
                              <b>Công ty</b> <a class="pull-right"><i></i></a>
                            </li>
                            <li class="list-group-item">
                              <b>Mã số thuế</b><a class="pull-right"><i></i></a>                          
                            </li>
                            <li class="list-group-item">
                            <b>Số điện thoại</b> <a class="pull-right"><i></i></a>
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
                          <strong><i class="fa fa-book margin-r-5"></i> Thông tin liên hệ</strong>
            
                          <p class="text-muted">
                            
                          </p>
                          
                          <hr>
            
                          <strong><i class="fa fa-file-text-o margin-r-5"></i> Ghi chú</strong>
            
                          <p class="text-muted">
                              
                          </p>
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                      <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                          <li class="active"><a href="#thongtinnguoidung" data-toggle="tab">Thông tin chủ hàng</a></l>
                        </ul>
                        <div class="tab-content">
                          <form enctype="multipart/form-data" action="" >
                          {{ csrf_field() }}
                            <div class="form-group">
                              <div class="form-group">
                                <label for="ownername" class="control-label">Tên chủ hàng (*): <span style="color:red;" class="errortxtOwnerName" id="errortxtOwnerName"></span></label>
                                <input type="text" class="form-control" id="txtOwnerName" name="txtOwnerName" placeholder="Enter Owner Name" >
                              </div>
                              <div class="form-group">
                                <label for="shortname" class="control-label">Tên viết tắt (*): <span style="color:red;" class="errortxtShortName" id="errortxtShortName"></span></label>
                                <input type="text" class="form-control" id="txtShortName" name="txtShortName" placeholder="Enter Short Name" >
                              </div>
                              <div class="form-group">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="txtAddress" name="txtAddress" placeholder="Enter Address" >
                              </div>
                              <div class="form-group">
                                <label for="MST" class="control-label">Mã số thuế <span style="color:red;" class="errortxtMST" id="errortxtMST"></span></label>
                                <input type="text" class="form-control" id="txtMST" name="txtMST" placeholder="Enter Tax Number" v>
                              </div>
                              <div class="form-group">
                                <label for="phone" class="control-label">Số điện thoại <span style="color:red;" class="errortxtPhone" id="errortxtPhone"></span></label>
                                <input type="text" class="form-control" id="txtPhone" name="txtPhone" placeholder="Enter Phone Number" >
                              </div>
                              <div class="form-group">
                                <label for="email" class="form-label">Email đăng nhập<span style="color:red;" class="errortxtEmail" id="errortxtEmail"></span></label>
                                <input type="text" class="form-control" id="txtEmail" name="txtEmail" placeholder="Enter Email" >
                              </div>
                              <div class="form-group">
                                <label for="email" class="form-label">Email liên lạc<span style="color:red;" class="errortxtEmailContact" id="errortxtEmailContact"></span></label>
                                <textarea class="form-control" id="txtEmailContact" name="txtEmailContact" placeholder="Enter Email" ></textarea> 
                              </div>
                              <div class="form-group">
                                  <label for="suggestGoods" class="form-label"> Ảnh đại diện: <span style="color:red;" class="errorfileanh" id="errorfileanh"></span></label>
                                  <br>
                                  <img src="" alt="" class="output_image">
                                  <br><br>
                                  <input name="fileanh" id="fileanh" type="file" accept="image/*" onchange="preview_image(event)">
                                </div>
                              <div class="form-group">
                                <label for="contact" class="form-label">Thông tin liên hệ</label>
                                <textarea class="form-control" id="txtContact" name="txtContact" placeholder="Enter Contact"></textarea>
                              </div>
                              <div class="form-group">
                                <label for="note" class="form-label">Ghi chú</label>
                                <textarea class="form-control" id="txtNote" name="txtNote" placeholder="Enter Note"></textarea>
                              </div>
                              <div class="form-group">
                                <label for="note" class="form-label">Gợi ý số lượng <span style="color:red;" class="errortxtAmount" id="errortxtAmount"></span></label>
                                <input type="text" class="form-control" id="txtAmount" name="txtAmount" placeholder="Nhập số lượng" >
                              </div>
                              <div class="form-group">
                                <label for="note" class="form-label">Gợi ý chứng từ mang theo 1</label>
                                <input type="text" class="form-control" id="txtDocument1" name="txtDocument1" placeholder="Nhập chứng từ mang theo 1" >
                              </div>
                              <div class="form-group">
                                <label for="note" class="form-label">Gợi ý chứng từ mang theo 2</label>
                                <input type="text" class="form-control" id="txtDocument2" name="txtDocument2" placeholder="Nhập chứng từ mang theo 2" >
                              </div>
                              <div class="form-group">
                                <label for="note" class="form-label">Gợi ý ghi chú</label>
                                <textarea class="form-control" id="txtSgNote" name="txtSgNote" placeholder="Enter Suggest Note"></textarea>
                              </div>
                              <div class="form-group">
                                <label for="suggestGoods" class="form-label">Gợi ý loại hàng</label>
                                <select class="form-control select2" id="selGoods" name="selGoods" data-placeholder="Vui lòng chọn loại hàng">
                                  <option></option>
                                  @foreach($goods as $gds)
                                  <option value="{{ $gds->goods_id }}">{{ $gds->sort_name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="suggestGoods" class="form-label">Gợi ý nơi nhận</label>
                                <select class="form-control select2" id="selReceipt" name="selReceipt" data-placeholder="Vui lòng chọn nơi nhận">
                                  <option></option>
                                  @foreach($receipt as $receipts)
                                  <option value="{{ $receipts->place_id }}">{{ $receipts->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="suggestGoods" class="form-label">Gợi ý nơi giao</label>
                                <select class="form-control select2" id="selDeliver" name="selDeliver" data-placeholder="Vui lòng chọn nơi giao">
                                  <option></option>
                                  @foreach($delivery as $deliv)
                                  <option value="{{ $deliv->place_id }}">{{ $deliv->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="suggestGoods" class="form-label">Gợi ý người phụ trách</label>
                                <select class="form-control select2" id="selAssistant" name="selAssistant" data-placeholder="Vui lòng chọn người phụ trách">
                                 <option></option>
                                  @foreach($assistant as $ass)
                                    <option value="{{ $ass->user_id }}">{{ $ass->nick_name }}</option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                              {{-- END DROP DOW --}}
                              {{-- START FOOTER --}}
                          <div class="box-footer" >
                           <div class="form-group">
                              <label for="email"></label>
                  <!-- /.row -->
                              <button type="submit" class="btn btn-success btn-md postbutton">Lưu</button>
                              &nbsp;
                              {{-- <button type="submit" name="btnCancel" id="btnCancel" class="btn btn-danger btn-md pull-right">Quay lại</button>
                              &nbsp; --}}
                            </div>
                          </div>
                          {{-- END FOOTER --}}
                        </div>
                        </form>
                      </div>
                        <!-- /.tab-content -->
                      </div>
                      <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                  <!-- /.row -->
        {{-- end form --}}
      <script>

          var previewImage = function(input, block){
            var fileTypes = ['jpg', 'jpeg', 'png','svg','gif'];
            var extension = input.files[0].name.split('.').pop().toLowerCase();  
            var isSuccess = fileTypes.indexOf(extension) > -1;
            if(isSuccess){
              var reader = new FileReader();
              reader.onload = function (e) {
                block.attr('src', e.target.result);
              };
              reader.readAsDataURL(input.files[0]);
            }else{
              alert('Tệp tin không đúng định dạng');
            }
          };

          $(document).on('change', '#fileanh', function(){
            previewImage(this, $('.output_image'));
          });

          $(document).on('click','.postbutton',function(e){
            e.preventDefault();
            if($(".pError")[0] != undefined){
              $('.pError').remove();
              $('.is-invalid').removeClass('is-invalid');
            }
            let data = new FormData();
            let itemImage = $('#fileanh').prop('files')[0];
            
            data.append('txtOwnerName',$('#txtOwnerName').val());
            data.append('txtShortName',$('#txtShortName').val());
            data.append('txtMST',$('#txtMST').val());
            data.append('txtPhone',$('#txtPhone').val());
            data.append('txtEmail',$('#txtEmail').val());
            data.append('txtAddress',$('#txtAddress').val());
            data.append('txtContact',$('#txtContact').val());
            data.append('txtAmount',$('#txtAmount').val());
            data.append('txtDocument1',$('#txtDocument1').val());
            data.append('txtDocument2',$('#txtDocument2').val());
            data.append('txtNote',$('#txtNote').val());
            data.append('txtSgNote',$('#txtSgNote').val());
            data.append('selGoods',$('#selGoods').val());
            data.append('selReceipt',$('#selReceipt').val());
            data.append('selDeliver',$('#selDeliver').val());
            data.append('selAssistant',$('#selAssistant').val());
            data.append('txtEmailContact',$('#txtEmailContact').val());
            data.append('fileanh',itemImage);
            data.append('_token', "{{csrf_token()}}");

            $.ajax({
              type:'POST',
              url:'/partner/create',
              enctype:'multipart/form-data',
              processData: false, 
              contentType: false,
              data:data,
              success: function(data){
                if(data.success){
                  window.location.href="/partner";
                }
                else{
                  swal({
                        title: "Có lỗi xảy ra trong quá trình tạo mới chủ hàng",
                        icon: "error",
                        button: "OK",
                        timer: 1000,
                      });
                  getArrayErrorDetail(data);
                }
              }
            });
          })
    function getArrayErrorDetail(objError){
      let arrResult =[];
      let errors = Object.values(objError)[0]; // get element (type object) at first objError
      //convert object errors to array
      let arrError = $.map(errors, function(value, key) {
        return { [key]: value };
      });
      if( arrError.length >0 ){
        for(var iL = 0; iL < arrError.length; iL++){
          let key  = Object.keys(arrError[iL])[0];
          let value = Object.values(arrError[iL])[0];
          let tmpElement = {'key': key, 'value' : value};
          arrResult.push(tmpElement);
        }
      }
      //append error detail to err_inputName
      if(arrResult.length > 0){
        for(var xxx = 0; xxx <arrResult.length; xxx++){
          let arrErrorDetail = arrResult[xxx]['value'];
          let htmlErrorDetail = '';
          // for(var dt = 0; dt< arrErrorDetail.length; dt++){
          //  htmlErrorDetail += '<p class ="pError">'+ arrErrorDetail[dt] +'</p>'
          // }
          htmlErrorDetail += '<span class ="pError"><i>'+ arrErrorDetail[0] +'</i></span>';
          $('#error'+arrResult[xxx]['key']).append(htmlErrorDetail);
          $('.modal-body').find('.'+arrResult[xxx]['key']).addClass('is-invalid');
        }
      }
    }

      </script>

    </section>
@endsection