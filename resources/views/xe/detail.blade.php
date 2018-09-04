@extends('blank')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe"> THÔNG TIN XE </div>
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
                        <form action="/xe/detail/{{ $id }}" method="post" name="itemForm" id="acountForm">
                           {{ csrf_field() }}
                           <input type="hidden" name="url" value="" id="url">
                            <div class="row">
                                <div class=" col-md-6">
                                    <div class="form-group">
                                        <label for="email">Số xe (*):</label>@if( $errors->has('txtSoxe')) <label style="color: red; font-size: 13px"><i><b>{{$errors->first('txtSoxe')}}</b></i></label>@endif
                                        <input type="text" class="form-control" name="txtSoxe" id="txtSoxe" placeholder="Nhập số xe" value="@if ($errors->has('txtSoxe')) {{old('txtSoxe')}} @else{{ $car->car_num }} @endif" >
                                    </div>
                                </div>
                                <?php 
                                $car_type = DB::table('tbl_car_type')->orderBy('name','ASC')->get();
                                ?>
                                <div class="form-group col-md-6"> 
                                    <label for="email">Loại xe (*):</label>@if( $errors->has('selLoaixe')) <label style="color: red; font-size: 13px"><i><b>{{$errors->first('selLoaixe')}}</b></i></label>@endif <br>
                                    <select class="select2" style="width:100%" name = "selLoaixe" id = "selLoaixe" data-placeholder="-- Chọn loại xe --">
                                        <option></option>
                                        @foreach ($car_type as $c )
                                            <option @if($car->car_type_id == $c->car_type_id ) selected @endif @if( old('selLoaixe') == $c->car_type_id ) selected @endif value="{{ $c->car_type_id }}">{{ $c -> name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                    <?php 
                                    $type_user = DB::table('tbl_user')->where('user_type','=',12)->where('work_status','=',0)->orderBy('nick_name','ASC')->get();
                                ?>
                                <div class="form-group col-md-6"> 
                                    <label for="email">Gợi ý tài xế:</label><br>
                                    <select class="select2" style="width:100%" name = "taixe" id = "taixe" data-placeholder="-- Chọn tài xế --">
                                        <option></option>
                                        @foreach ($type_user as $c )
                                            <option @if($car->driver_suggestion == $c->user_id ) selected @endif @if( old('taixe') == $c->user_id ) selected @endif value="{{ $c->user_id }}">{{ $c -> nick_name }}</option>
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
                                            <option @if($car->assistant_driver_suggestion == $c->user_id ) selected @endif @if( old('slphuxe') == $c->user_id ) selected @endif value="{{ $c->user_id }}" >{{ $c -> nick_name }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="comment">Ghi chú:</label>
                                    <textarea class="form-control" rows="7" cols="10" id="txtGhichu" name="txtGhichu" placeholder="Note">@if ($errors->has('txtSoxe')|| $errors->has('selLoaixe')) {{old('txtGhichu')}} @else{{ $car->note }} @endif</textarea>
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
        @if( $errors->has('selLoaixe')) 
            $('#selLoaixe').val(null)
            @if( !old('slphuxe')) 
            $('#slphuxe').val(null)
            @endif
            @if( !old('taixe')) 
            $('#taixe').val(null)
            @endif
        @endif
        
        @if( $errors->has('txtSoxe')) 
            @if( !old('slphuxe')) 
            $('#slphuxe').val(null)
            @endif
            @if( !old('taixe')) 
            $('#taixe').val(null)
            @endif
        @endif
        @if(session()->has('success'))
            window.location.reload(history.back());
        @endif

        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2(
            {
                // placeholder: "Assign to:",
                allowClear: true
              }
              )
          
          })
          $('#url').val(document.referrer)

    </script>

@endsection