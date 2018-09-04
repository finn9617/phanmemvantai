@extends('blank')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="row">
        <div class="col-md-12 titleDieuXe"> SỬA THÔNG TIN CÔNG VIỆC  </div>
    </div>
    <div class="row">
        <div class="col-md-12 prePage">
        <a href="{{ route('showM') }}" onclick="back()" class="" id="back">
                <span class="glyphicon glyphicon-step-backward">
                    <span class="prePage">CHI TIẾT BẢO DƯỠNG XE</span>
                </span>
            </a>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning col-md-11">
                <div class="box-body">
                    <form action="" method="post" name="itemForm" id="acountForm">
                        {{csrf_field()}}
                        <div class="form-group col-md-4">
                            <label for="">Tên công việc:</label>
                            <input type="text" class="form-control" name="txtJob" id="txtJob" placeholder="Nhập tên công việc" value="{{ $job->job_name}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Đơn giá:</label>
                            <input type="text" class="form-control number" name="txtUnitPrice" id="txtUnitPrice" placeholder="Nhập đơn giá" value="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Giảm giá:</label>
                            <input type="number" class="form-control" name="txtSale" id="txtSale" min="0" max="100" placeholder="Nhập số giảm giá " value="{{ $job->sale}}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Thành tiền:</label>
                            <input type="text" class="form-control number" name="txtPrice" id="txtPrice" placeholder="Nhập thành tiền" value="">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Thuế :</label>
                            <input type="number" class="form-control" name="txtTax" id="txtTax" placeholder="Nhập số thuế" value="{{ $job->tax}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="control-label">Ghi chú </label>
                            <textarea class="form-control" rows="5" placeholder="Nhập ghi chú nếu cần" name="txtGhichu" id="txtGhichu">{{ $job->note}}</textarea>
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
<!-- /.content -->

<!-- /.content -->
<!-- ==================================================================  JAVASCRIPT ====================================================== -->

<script>
  $(function () {
    $('#tblDriver').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true
    })
  })

$(document).ready(function (){

 $('#txtUnitPrice').focusout(function(){
        let Sale = $('#txtSale').val();
        if(Sale){
            let unit = formatNumber($('#txtUnitPrice').val())
            let Sale =100 - $('#txtSale').val();
            let price = unit * Sale/100;
            $("#txtPrice").val(formatNumber(price))
        }else{
            $("#txtPrice").val(formatNumber($('#txtUnitPrice').val()))

        }

    })
    
    $('#txtSale').focusout(function(){
        let unit = $('#txtUnitPrice').val()
        if( unit){
            let unit = formatNumber($('#txtUnitPrice').val())
            let Sale =100 - $('#txtSale').val();
            let price = unit * Sale/100;
            $("#txtPrice").val(formatNumber(price))
        }else{
            $("#txtPrice").val(formatNumber($('#txtUnitPrice').val()))
        }
    })
    
$('#btnOk').click(function (e) {
    
    e.preventDefault(); // khong load lại nut submit

    var data = new FormData();

    
    data.append('txtJob',$('#txtJob').val());
    data.append('txtUnitPrice',removeDot($('#txtUnitPrice').val()));
    data.append('txtSale',$('#txtSale').val());
    data.append('txtPrice',removeDot($('#txtPrice').val()));
    data.append('txtTax',$('#txtTax').val());
    data.append('txtGhichu',$('#txtGhichu').val());
    data.append('job_id',"{{$job->job_id}}");

    // data = $('#txtAcc').val();
    $.ajax({
        url: "{{ url('/Deail1/edit')}}",
        type: "POST",
        headers: {
                'X-CSRF-TOKEN': $("input[name='_token']").val()
            },
        data:data,
        processData: false,
        contentType: false,
        success: function(data){
            if(data.success){
                if ('referrer' in document) {
                    let prePage = document.referrer;
                    window.location = prePage;
                    /* OR */
                    //location.replace(document.referrer);
                } else {
                    window.history.back();
                }
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
$('#txtUnitPrice').val(formatNumber({{ $job->unitprice}}));
$('#txtPrice').val(formatNumber({{ $job->price}}));


// format number auto
$(document).on('keyup','input.number',function(event) {
        // skip for arrow keys
        if(event.which >= 37 && event.which <= 40) return;

        // format number
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });

    function formatNumber(value) {

        var n= value.toString().split(".");
        n[0] = n[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return n.join(".");

    }

    function removeDot(number){
		if(number!=undefined){
			return number.replace(/\,/g, "");
		}
	}
</script>
@endsection