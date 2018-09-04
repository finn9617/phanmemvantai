@extends('blank')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe"> THÊM THÔNG TIN XE </div>
  </div>
          <!-- back page -->
  <div class="row">
    <div class="col-md-12 prePage">
      <a href="/xe" class="">
        <span class="glyphicon glyphicon-step-backward">
          <span class="prePage">DANH SÁCH XE</span>
        </span>
      </a>
    </div>
  </div>
  <!-- ./ back page -->
</section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning col-md-11">
                    <div class="box-body">
                        <form action="/xe/create" method="post" name="itemForm" id="acountForm">
                           {{ csrf_field() }}
                            <div class="row">
                                <div class=" col-md-6">
                                    <div class="form-group ">
                                        <label for="email">Số xe (*):</label>@if( $errors->has('txtSoxe')) <label style="color: red; font-size: 13px"><i><b>{{$errors->first('txtSoxe')}}</i></b></label>@endif
                                        <input type="text" class="form-control" name="txtSoxe" id="txtSoxe" placeholder="Nhập số xe" value="{{ old('txtSoxe') }}">
                                    </div>
                                </div>

                                <?php 
                                    $car_type = DB::table('tbl_car_type')->orderBy('name','ASC')->get();
                                ?>
                                <div class="form-group col-md-6 "> 
                                        <label for="email">Loại xe (*):</label>@if( $errors->has('selLoaixe')) <label style="color: red; font-size: 13px"><i><b>{{$errors->first('selLoaixe')}}</b></i></label>@endif <br>
                                        <select class="select2" style="width:100%" name = "selLoaixe" id = "selLoaixe" data-placeholder="-- Chọn loại xe --">
                                            <option></option>
                                        @foreach ($car_type as $c )
                                            <option @if( old('selLoaixe') == $c->car_type_id ) selected @endif value="{{ $c->car_type_id }}" >{{ $c -> name }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div> 
                            </div>
                            <div class="row">
                                <?php 
                                    $type_user = DB::table('tbl_user')->where('user_type','=',12)->where('work_status','=',0)->orderBy('nick_name','ASC')->get();
                                ?>
                                <div class="form-group col-md-6 "> 
                                    <label for="email">Gợi ý tài xế:</label><br>
                                    <select class="select2" style="width:100%" name = "taixe" id = "taixe" data-placeholder="-- Chọn tài xế --">
                                            <option></option>
                                        @foreach ($type_user as $c )
                                            <option @if( old('taixe') == $c->user_id ) selected @endif value="{{ $c->user_id }}">{{ $c -> nick_name }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                <?php 
                                $type_user = DB::table('tbl_user')->where('user_type','=',13)->where('work_status','=',0)->orderBy('nick_name','ASC')->get();
                                ?>
                                <div class="form-group col-md-6"> 
                                        <label for="email">Gợi ý phụ xe:</label><br>
                                        <select class="select2" style="width:100%" name = "slphuxe" id = "slphuxe" data-placeholder="-- Chọn phụ xe --">
                                        <option></option>
                                        @foreach ($type_user as $c )
                                            <option @if( old('slphuxe') == $c->user_id ) selected @endif value="{{ $c->user_id }}">{{ $c -> nick_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="comment">Ghi chú:</label>
                                    <textarea class="form-control" rows="7" cols="10" id="txtGhichu" name="txtGhichu" placeholder="Note">{{ old('txtGhichu') }} </textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12"> <label for="email"></label>
                                <button type="submit" name="btnOk" id="btnOk" class="btn btn-success btn-md">Lưu</button> &nbsp;
                                 &nbsp;
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- show/hide table --}}
    <script type="text/javascript">
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

@endsection