@extends('blank')
@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-md-12 titleDieuXe">THÊM THÔNG TIN NƠI NHẬN HÀNG</div>
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
    <form role ="form" action="/noinhan/create" method="POST" id="place">
        {!! csrf_field() !!}
        <div class="col-md-12">
            <div class="row">
                <div class=" box box-primary">
                    <div class="box-body">
                    {{-- START DIV nhận --}}
                    <div id="formgiao">
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
                            <input type="text" class="form-control" id="txtTennoinhan" name="txtTennoinhan" placeholder="Nhập tên nơi nhận" value="" >
                        </div>
                        @endif
                        
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Địa chỉ nơi nhận</label>
                            <input type="text" class="form-control" id="txtDiachinoinhan" name="txtDiachinoinhan" placeholder="Nhập địa chỉ nơi nhận" value="{{old('txtDiachinoinhan')}}" >
                        </div>
                        </div>

                        
                        
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin người liên hệ </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin người liên hệ" name="txtInfonguoilh">{{old('txtInfonguoilh')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin nơi nhận hàng </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin nơi nhận hàng" name="txtInfonoinhan">{{old('txtInfonoinhan')}}</textarea>
                        </div>
                        <div class="box-footer" >
                                <div class="form-group">
                                   <button type="submit" name="btnOk" id="btnOk" class="btn btn-success btn-md" form="place">Lưu</button>    
                        </div>
                    </div>
                    {{-- ./div nhận --}}
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
        
    </script>

@endsection