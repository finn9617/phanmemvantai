@extends('blank')
@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-md-12 titleDieuXe">SỬA THÔNG TIN NƠI NHẬN HÀNG</div>
      </div>
              <!-- back page -->
      <div class="row">
        <div class="col-md-12 prePage">
          <a href="/noinhan" class="">
            <span class="glyphicon glyphicon-step-backward">
              <span class="prePage">DANH SÁCH NƠI NHẬN </span>
            </span>
          </a>
        </div>
      </div>
      <!-- ./ back page -->
    </section>

    <!-- Main content -->

    <section class="content">
        {{-- form start --}}
    <form role ="form" action="/noinhan/update/{{$getNoiNhanbyID->place_id}}" method="POST" id="place">
        {!! csrf_field() !!}
        <div class="col-md-12">
            <div class="row">
                <div class=" box box-primary">
                    <div class="box-body">
                    {{-- START DIV nhan --}}
                    <div id="formnhan">
                        <div class="row">
                        <div class="col-md-6">
                        @if( $errors->has('txtTennoinhan'))
                        <div class="form-group ">
                            <label for="" class="control-label">Tên nơi nhận (*)</label> <label style="color: red; font-size: 13px"><i>{{$errors->first('txtTennoinhan')}}</i></label>
                            <input type="text" class="form-control" id="txtTennoinhan" name="txtTennoinhan" placeholder="Nhập tên nơi nhận" value="{{old('txtTennoinhan')}}" >
                           
                        </div>
                        @else
                        <div class="form-group">
                            <label for="" class="control-label">Tên nơi nhận (*)</label>
                            <input type="text" class="form-control" id="txtTennoinhan" name="txtTennoinhan" placeholder="Nhập tên nơi nhận" value="{{$getNoiNhanbyID->name}}" >
                        </div>
                        @endif
                        </div>
                        <div class="col-md-6">
                        @if( $errors->has('txtTennoinhan'))
                        <div class="form-group">
                            <label for="" class="control-label">Địa chỉ nơi nhận</label>
                            <input type="text" class="form-control" id="txtDiachinoinhan" name="txtDiachinoinhan" placeholder="Nhập địa chỉ nơi nhận" value="{{old('txtDiachinoinhan')}}">
                        </div>
                        @else
                        <div class="form-group">
                            <label for="" class="control-label">Địa chỉ nơi nhận</label>
                            <input type="text" class="form-control" id="txtDiachinoinhan" name="txtDiachinoinhan" placeholder="Nhập địa chỉ nơi nhận" value="{{$getNoiNhanbyID->address}}">
                        </div>
                        @endif
                        </div>

                        </div>
                        @if( $errors->has('txtTennoinhan'))
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin người liên hệ </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin người liên hệ" name="txtInfonguoilh">{{old('txtInfonguoilh')}}</textarea>
                        </div>
                        @else
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin người liên hệ </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin người liên hệ" name="txtInfonguoilh">{{$getNoiNhanbyID->contact_note}}</textarea>
                        </div>
                        @endif
                        @if( $errors->has('txtTennoinhan'))
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin nơi nhận hàng </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin nơi nhận hàng" name="txtInfonoinhan">{{old('txtInfonoinhan')}}</textarea>
                        </div>
                        @else
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin nơi nhận hàng </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin nơi nhận hàng" name="txtInfonoinhan">{{$getNoiNhanbyID->warehouse_note}}</textarea>
                        </div>
                        @endif
                        <input type="hidden" name="url" value="" id="url">
                        <div class="box-footer" >
                                <div class="form-group">
                                   <button type="submit" name="btnOk" id="btnOk" class="btn btn-success btn-md " form="place">Lưu</button>    
                        </div>
                    </div>
                    {{-- ./div nhan --}}
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
    $('#url').val(document.referrer)
    function back(){
        window.history.back();
       } 
    // @if(session('success'))
    //     window.location.reload(history.back());
    // @endif

    </script>

@endsection