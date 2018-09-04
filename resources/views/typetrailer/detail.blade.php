@extends('blank')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe"> THÔNG TIN LOẠI RƠ MOOC </div>
  </div>
          <!-- back page -->
  <div class="row">
    <div class="col-md-12 prePage">
      <a href="/loairomooc" class="">
        <span class="glyphicon glyphicon-step-backward">
          <span class="prePage">DANH SÁCH LOẠI RƠ MOOC</span>
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
                            <form action="/loairomooc/detail/{{ $id }}" method="post" name="itemForm" id="acountForm">
                                {{csrf_field() }}
                                <?php
                                    $upData = DB::table('tbl_trailer_type')->where('trailer_type_id', '=', $id)->first();
                                    //dd($upData);
                                ?>
                                <div class="row">
                                    <div class="form-group col-md-6 ">
                                        <label for="email">Tên loại ro mooc(*) :</label> @if( $errors->has('txtTenloaimooc')) <label style="color: red; font-size: 13px"><i><b>{{$errors->first('txtTenloaimooc')}}</b></i></label> @endif
                                        <input type="text" class="form-control" name="txtTenloaimooc" id="txtTenloaimooc" placeholder="Nhập tên loại rơ mooc" value="@if($errors->has('txtTenloaimooc')){{old('txtTenloaimooc')}}@else{{$upData->trailer_type_name}}@endif ">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="comment">Thông tin loại rơ mooc :</label>
                                        <textarea class="form-control" rows="7" cols="10" id="txtThongtin" name="txtThongtin" placeholder="Thông tin loại rơ mooc">@if($errors->has('txtTenloaimooc')) {{old('txtThongtin')}} @else{{ $upData->note }} @endif</textarea>
                                    </div>
                                </div>
                                <input type="hidden" name="url" value="" id="url">
                                <div class="row">
                                    <div class="form-group col-md-12"> <label for="email"></label><button type="submit" name="btnOk" id="btnOk" class="btn btn-success btn-md">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
{{-- show/hide table --}}
    <script type="text/javascript">
        @if(session('success'))
            window.location.reload(history.back());
        @endif
        $('#url').val(document.referrer)

    </script>

@endsection