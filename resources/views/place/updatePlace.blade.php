@extends('blank')
@section('content')


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="row">
        <div class="col-md-12 titleDieuXe">THÔNG TIN NƠI GIAO - NƠI NHẬN</div>
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
        @if ($errors->any())
        <div class="callout callout-danger">
            <h4><i class="glyphicon glyphicon-warning-sign"></i>&nbsp&nbspCó lỗi xảy ra</h4>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    	{{-- form start --}}
	<form role ="form" action="/noigiaonhan/detail/{{$loadplace[0]->place_id}}" method="POST" id="place">
		{!! csrf_field() !!}
        <div class="col-md-12">
            <div class="row">
                <div class=" box box-primary">
                    <div class="box-body">
                    <div class="form-group">
                        <label for="" class="control-label">Loại hình (*)</label>
                        <select name="selLoaihinh" id="selLoaihinh" class="form-control" onchange="showhide(this)">
                        	@if($loadplace[0]->place_type == 1)
                            <option value="1" id="1" selected="selected">Nơi giao</option>
                            <option value="0" id="0">Nơi nhận</option>
                            @elseif($loadplace[0]->place_type == 0)
                            <option value="1" id="1">Nơi giao</option>
                            <option value="0" id="0" selected="selected">Nơi nhận</option>
                            @endif
                        </select>
                    </div>
                    {{-- START DIV GIAO --}}
                    <div id="formgiao">
                        <div class="row">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Tên địa điểm (*)</label>
                            <input type="text" class="form-control" id="txtTenkho" name="txtTenkho" placeholder="Nhập tên nơi giao" value="{{$loadplace[0]->name}}">
                        </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="control-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="txtDiachi" name="txtDiachi" placeholder="Nhập địa chỉ nơi giao" value="{{$loadplace[0]->address}}">
                        </div>
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin người liên hệ </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin người liên hệ" name="txtInfonguoilh">{{$loadplace[0]->contact_note}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Thông tin kho </label>
                            <textarea class="form-control" rows="3" placeholder="Nhập thông tin kho giao hàng" name="txtInfokho">{{$loadplace[0]->warehouse_note}}</textarea>
                        </div>
                        <div class="box-footer" >
                                <div class="form-group">
                                   <label for="email"></label>
                                   <button type="submit" name="btnOk" id="btnOk" class="btn btn-success btn-md" form="place">Lưu</button>
                                   &nbsp;
                                   <button type="button" name="btnCancel" id="btnCancel" class="btn btn-danger btn-md">Quay lại</button>
                                   &nbsp;
                                 </div>
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
    </script>

@endsection