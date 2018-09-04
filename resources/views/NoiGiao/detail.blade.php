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
        <div class="col-md-12 titleDieuXe">SỬA THÔNG TIN NƠI GIAO HÀNG</div>
      </div>
              <!-- back page -->
      <div class="row">
        <div class="col-md-12 prePage">
          <a href="/noigiao" class="">
            <span class="glyphicon glyphicon-step-backward">
              <span class="prePage">DANH SÁCH NƠI GIAO </span>
            </span>
          </a>
        </div>
      </div>
      <!-- ./ back page -->
    </section>

    <!-- Main content -->

    <section class="content">
        {{-- form start --}}
    <form role ="form" action="/noigiao/update/{{$getNoiGiaobyID->place_id}}" method="POST" id="place">
        {!! csrf_field() !!}
        <div class="col-md-12">
            <div class="row">
                <div class=" box box-primary">
                    <div class="box-body">
                    {{-- START DIV GIAO --}}
                    <div id="formgiao">
                        <div class="row">
                        <div class="col-md-6">
                        @if( $errors->has('txtTennoigiao'))
                        <div class="form-group ">
                            <label for="" class="control-label">Tên nơi giao (*)</label> <label style="color: red; font-size: 13px"><i>{{$errors->first('txtTennoigiao')}}</i></label>
                            <input type="text" class="form-control" id="txtTennoigiao" name="txtTennoigiao" placeholder="Nhập tên nơi giao" value="{{old('txtTennoigiao')}}" >
                           
                        </div>
                        @else
                        <div class="form-group">
                            <label for="" class="control-label">Tên nơi giao (*)</label>
                            <input type="text" class="form-control" id="txtTennoigiao" name="txtTennoigiao" placeholder="Nhập tên nơi giao" value="{{$getNoiGiaobyID->name}}" >
                        </div>
                        @endif
                        </div>
                        <div class="col-md-6">
                        @if( $errors->has('txtTennoigiao'))
                        <div class="form-group">
                            <label for="" class="control-label">Địa chỉ nơi giao</label>
                            <input type="text" class="form-control" id="txtDiachinoigiao" name="txtDiachinoigiao" placeholder="Nhập địa chỉ nơi giao" value="{{old('txtDiachinoigiao')}}">
                        </div>
                        @else
                        <div class="form-group">
                            <label for="" class="control-label">Địa chỉ nơi giao</label>
                            <input type="text" class="form-control" id="txtDiachinoigiao" name="txtDiachinoigiao" placeholder="Nhập địa chỉ nơi giao" value="{{$getNoiGiaobyID->address}}">
                        </div>
                        @endif
                        </div>
                        <div class="col-md-6">
                            <!-- ============================================== -->
                            <div class="form-group">
                            <label for="" class="control-label">Loại hàng (*)</label><label style="color: red; font-size: 13px"><i id="msg_goodType"> </i></label><br>
                                <input type="radio" class="radGoodType" name="radGoodType" value="0" {{($getNoiGiaobyID->goods_type==0)?"checked":""}}>&nbsp  Hàng bồn
                                <input type="radio" class="radGoodType" name="radGoodType" value="1" style="margin-left: 50px;" {{($getNoiGiaobyID->goods_type==1)?"checked":""}}>&nbsp  Hàng phi
                            </div>
                            <!-- ================================================= -->
                        </div>
                        </div>
                        @if( $errors->has('txtTennoigiao'))
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin người liên hệ </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin người liên hệ" name="txtInfonguoilh">{{old('txtInfonguoilh')}}</textarea>
                        </div>
                        @else
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin người liên hệ </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin người liên hệ" name="txtInfonguoilh">{{$getNoiGiaobyID->contact_note}}</textarea>
                        </div>
                        @endif
                        @if( $errors->has('txtTennoigiao'))
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin nơi giao hàng </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin nơi giao hàng" name="txtInfonoigiao">{{old('txtInfonoigiao')}}</textarea>
                        </div>
                        @else
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin nơi giao hàng </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin nơi giao hàng" name="txtInfonoigiao">{{$getNoiGiaobyID->warehouse_note}}</textarea>
                        </div>
                        @endif
                        <input type="hidden" name="url" value="" id="url">
                        <div class="box-footer" >
                                <div class="form-group">
                                   <button type="submit" name="btnOk" id="btnOk" class="btn btn-success btn-md" form="place">Lưu</button>    
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
        
    function back(){
        window.history.back();
       } 
    // @if(session()->has('success'))
    //     window.location.reload(history.back());
    // @endif   
    $('#url').val(document.referrer)
    @if (session('oki'))
        // if (typeof(Storage) !== "undefined") {
        //     var operatingCurentPage = localStorage.getItem('noigiao');
        //     if (operatingCurentPage.indexOf('?') > -1){
        //         window.location.href=operatingCurentPage;
        //     }else{
        //         window.location.href = operatingCurentPage;
        //     }
        // } else {
        //     document.write('Trình duyệt của bạn không hỗ trợ local storage');
        // }
        // console.log(document)
        // exit();
        // window.history.forward(-2)
                // alert(x);
        // window.location = document.referrer;
    @endif

    </script>

@endsection