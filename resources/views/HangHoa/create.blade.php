@extends('blank')
@section('content')
<style type="text/css">
    input[type="radio"] {
    -ms-transform: scale(1.5); /* IE 9 */
    -webkit-transform: scale(1.5); /* Chrome, Safari, Opera */
    transform: scale(1.5);
}
</style>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-md-12 titleDieuXe">THÊM THÔNG TIN HÀNG HÓA</div>
      </div>
              <!-- back page -->
      <div class="row">
        <div class="col-md-12 prePage">
          <a href="/hanghoa" class="">
            <span class="glyphicon glyphicon-step-backward">
              <span class="prePage">DANH SÁCH HÀNG HÓA </span>
            </span>
          </a>
        </div>
      </div>
      <!-- ./ back page -->
    </section>
    <!-- Main content -->

    <section class="content">
        {{-- form start --}}
    <form role ="form" action="/hanghoa/create" method="POST" id="hanghoa">
        {!! csrf_field() !!}
        <div class="col-md-12">
            <div class="row">
                <div class=" box box-primary">
                    <div class="box-body">
                    {{-- START DIV GIAO --}}

                    <div id="formhanghoa">
                        <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Tên đầy đủ (*)</label><label style="color: red; font-size: 13px"><i id="msg_tendaydu"> </i></label><br>
                            <input type="text" class="form-control" id="txtTendaydu" name="txtTendaydu" placeholder="Nhập tên đầy đủ hàng hóa" value="{{old('txtTendaydu')}}" >
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Tên viết tắt (*)</label><label style="color: red; font-size: 13px"><i id="msg_tenviettat"> </i></label><br>
                            <input type="text" class="form-control" id="txtTenviettat" name="txtTenviettat" placeholder="Nhập tên viết tắt hàng hóa" value="{{old('txtTenviettat')}}" >
                        </div>
                        </div>
                         <div class="col-md-6">
                            <!-- ============================================== -->
                            <div class="form-group">
                            <label for="" class="control-label">Loại hàng (*)</label><label style="color: red; font-size: 13px"><i id="msg_goodType"> </i></label><br>
                                <input type="radio" class="radGoodType" name="radGoodType" value="0" checked>&nbsp  &nbsp Hàng bồn
                              <input type="radio" class="radGoodType" name="radGoodType" value="1" style="margin-left: 50px;">&nbsp  &nbsp Hàng phi
                          </div>
                            <!-- ================================================= -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="" class="control-label">Tỷ trọng</label><label style="color: red; font-size: 13px"><i id="msg_tytrong"> </i></label><br>
                            <input type="text" class="form-control" id="txtTytrong" name="txtTytrong" placeholder="Nhập tỷ trọng hàng hóa" value="{{old('txtTytrong')}}" >
                        </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Ghi chú </label><label style="color: red; font-size: 13px"><i id="msg_ghichu"> </i></label><br>
                            <textarea class="form-control" rows="5" placeholder="Nhập ghi chú hàng hóa" name="txtGhichu">{{old('txtGhichu')}}</textarea>
                        </div>
                        <div class="box-footer" >
                            <div class="form-group">
                            <button type="submit" name="btnOk" id="btnOk" onClick="return get_data()" class="btn btn-success btn-md pull-right" form="place">Lưu</button>    
                        </div>
                    </div>
                    {{-- ./div giao --}}
                    </div>
                    {{-- ./body --}}
                    </div>
                {{-- ./box --}}
                </div>
            {{-- ./row --}}
            </div>
        {{-- ./col --}}
        </div>
    {{-- ./form --}}
    </form>
    </section>
{{-- show/hide table --}}
    <script type="text/javascript">
    //     $(document).ready(function(){
    //     $("#txtTytrong").keyup(function(){
    //             console.log($("#txtTytrong").val());
    //     });
        

    // })
        function get_data(){
            $(".msg-item").html("");
            var data = $('#hanghoa').serializeArray().reduce(function(obj, item) {
            obj[item.name] = item.value;
            return obj;
            }, {});
            data['txtTytrong'] = data['txtTytrong'].replace(/,/g,'.');
            // console.log(data);
        //------------------------------
         $.ajax('{{url("/hanghoa/create")}}', {
                        type: 'POST',  
                        data: data,
                        async: false,
                        success: function (data, status, xhr) {
                             // console.log(data);
                            if(data.errors)
                            {
                                if(data.errors.txtTendaydu){
                                    $( '#msg_tendaydu' ).html( '&nbsp;'+data.errors.txtTendaydu[0] );
                                }
                                if(data.errors.txtTenviettat){
                                    $( '#msg_tenviettat' ).html( '&nbsp;'+data.errors.txtTenviettat[0] );
                                }
                                if(data.errors.txtTytrong){
                                    $( '#msg_tytrong' ).html( '&nbsp;'+data.errors.txtTytrong[0] );
                                }
                                if(data.errors.radGoodType){
                                    $( '#msg_goodType' ).html( '&nbsp;'+data.errors.radGoodType[0] );
                                }
                                console.log(data.errors);
                                //
                            }
                            if(data.success)
                            {
                        
                                  setTimeout(function(){ location = "{{url('/hanghoa')}}"; }, 100);
                            }
                        }
                    });
        }
    </script>
    <script >
        // $('.radGoodType').change(function(){
        //     alert($(this).val());
        // });
    </script>

@endsection