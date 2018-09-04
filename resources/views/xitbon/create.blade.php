@extends('blank')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe"> THÊM THÔNG TIN XỊT BỒN</div>
  </div>
          <!-- back page -->
  <div class="row">
    <div class="col-md-12 prePage">
      <a href="/xitbon" class="">
        <span class="glyphicon glyphicon-step-backward">
          <span class="prePage">DANH SÁCH XỊT BỒN</span>
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
                            <form action="/xitbon/create" method="post" name="itemForm" id="acountForm">
                                {{csrf_field() }}
                                <div class="row">
                                    <div class="form-group col-md-6" >
                                        <label for="email">Tên xịt bồn(*) :</label> <label style="color: red; font-size: 13px"><i id="tenxitbon"></i></label>
                                        <input type="text" class="form-control" name="txtTen" id="txtTen" placeholder="Nhập tên xịt bồn" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="comment">Thông tin xịt bồn :</label>
                                        <textarea class="form-control" rows="7" cols="10" id="txtThongtin" name="txtThongtin" placeholder="Thông tin loại rơ mooc">{{old('txtThongtin')}}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12"> <label for="email"></label><button type="button" name="btnOk" id="btnOk" class="btn btn-success btn-md">Lưu</button> 
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
        $(document).ready(function (){
            $('#btnOk').click(function(e){
                e.preventDefault(); // khong load lại nut submit

                data = new FormData();

                data.append('tenxitbon', $("input[name='txtTen']").val());
                
                if($("input[name='txtThongtin']").val()) {
                data.append('note', $("input[name='txtThongtin']").val());
                }

                $.ajax({
                    data:data,
                    url: "{{ url('/xitbon/create')}}",
                    type: "POST",
                    headers: {
							'X-CSRF-TOKEN': $("input[name='_token']").val()
						},
                    processData: false,
					contentType: false,
                    success: function(data){
                        console.log(data)
                        if(data.success){
                            window.location = "{{ url('/xitbon')}}"
                        }
                        if(data.errors){
                            if(data.errors.tenxitbon) {
                                $('#tenxitbon').text(''+data.errors.tenxitbon)
                            }else $('#tenxitbon').text('')
                        }
                    }
                })
            })
        })
    </script>

@endsection