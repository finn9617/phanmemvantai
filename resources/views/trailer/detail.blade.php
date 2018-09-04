@extends('blank')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe"> THÔNG TIN RƠ MOOC </div>
  </div>
          <!-- back page -->
  <div class="row">
    <div class="col-md-12 prePage">
      <a href="/romooc" class="">
        <span class="glyphicon glyphicon-step-backward">
          <span class="prePage">DANH SÁCH RƠ MOOC</span>
        </span>
      </a>
    </div>
  </div>
  <!-- ./ back page -->
</section>
    <?php
        $trailer = DB::table('tbl_trailer')->join('tbl_trailer_type', 'tbl_trailer_type.trailer_type_id', '=', 'tbl_trailer.trailer_type_id')->select('tbl_trailer.*', 'tbl_trailer_type.trailer_type_name')->where('tbl_trailer.trailer_id','=',$id)->orderBy('trailer_num')->orderBy('trailer_type_name')->first();
    ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning col-md-11">
                    <div class="box-body">
                        <form action="/romooc/detail/{{ $id }}" method="post" name="itemForm" id="acountForm">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class=" col-md-6">
                                    <div class="form-group ">
                                        <label for="email">Số rơ mooc (*):</label>@if( $errors->has('txtSoromooc')) <label style="color: red; font-size: 13px"><i><b>{{$errors->first('txtSoromooc')}}</b></i></label>@endif
                                        <input type="text" class="form-control" name="txtSoromooc" id="txtSoromooc" placeholder="Nhập số rơ mooc" value="@if($errors->has('txtSoromooc')){{old('txtSoromooc')}}@else{{$trailer->trailer_num}}@endif">
                                    </div>
                                </div>
                                <?php 
                                    $trailer_type = DB::table('tbl_trailer_type')->orderBy('trailer_type_name')->get();
                                ?>
                                <div class="form-group col-md-6"> 
                                    <label for="email">Loại rơ mooc (*):</label>@if( $errors->has('selLoairomooc')) <label style="color: red; font-size: 13px"><i><b>{{$errors->first('selLoairomooc')}}</b></i></label>@endif <br>
                                        <select class="select2" style="width:100%" name = "selLoairomooc" id = "selLoairomooc" data-placeholder="-- Chọn loại xe --">
                                            <option></option>
                                        @foreach ($trailer_type as $c )
                                            <option @if($trailer->trailer_type_id == $c->trailer_type_id ) selected @endif @if( old('selLoairomooc') == $c->trailer_type_id ) selected @endif value="{{ $c->trailer_type_id }}">{{ $c ->trailer_type_name }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="comment">Ghi chú:</label>
                                    <textarea class="form-control" rows="7" cols="10" id="txtGhichu" name="txtGhichu" placeholder="Note">@if ($errors->has('txtSoromooc') || $errors->has('selLoairomooc') )  {{ old('txtGhichu')}} @else{{ $trailer->note }} @endif</textarea>
                                </div>
                            </div>
                            <input type="hidden" name="url" value="" id="url">
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
        @if( $errors->has('selLoairomooc')) 
            $('#selLoairomooc').val(null)
        @endif
        @if(session('success'))
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