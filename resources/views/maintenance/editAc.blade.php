@extends('blank')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="row">
        <div class="col-md-12 titleDieuXe"> SỬA THÔNG TIN PHỤ TÙNG </div>
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
                        {{csrf_field() }}
                        <div class="form-group col-md-4">
                            <label for="">Tên PT/VT:</label>
                        <input type="text" class="form-control" name="txtAcc" id="txtAcc" placeholder="Nhập tên công việc" value="{{ $Ac->accessary_name  }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Số lượng:</label>
                            <input type="number" class="form-control" name="txtAmount" id="txtAmount" placeholder="Nhập số lượng" value="{{ $Ac->num  }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Đ/V:</label>
                            <input type="text" class="form-control" name="txtUnit1" id="txtUnit1" placeholder="Nhập đơn vị" value="{{ $Ac->unit  }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Đơn giá:</label>
                            <input type="text" class="form-control number" name="txtUnitPrice1" id="txtUnitPrice1" placeholder="Nhập đơn giá" value="{{ $Ac->unitprice  }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Giảm giá:</label>
                            <input type="number" class="form-control" name="txtSale1" id="txtSale1" placeholder="Nhập số giảm giá " value="{{ $Ac->sale  }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Thành tiền:</label>
                            <input type="text" class="form-control number" name="txtPrice1" id="txtPrice1" placeholder="Nhập thành tiền" value="{{ $Ac->price  }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Thuế :</label>
                            <input type="number" class="form-control" name="txtTax1" id="txtTax1" placeholder="Nhập số thuế" value="{{ $Ac->tax  }}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="control-label">Ghi chú </label>
                            <textarea class="form-control" rows="5" placeholder="Nhập ghi chú nếu cần" name="txtGhichu1" id="txtGhichu1">{{ $Ac->note  }}</textarea>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12"> <label for="email"></label><button type="submit" name="btnOk" id="btnOk" class="btn btn-success btn-md">Lưu</button> 
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

$('#txtUnitPrice').val(formatNumber({{ $job->unitprice}}));
$('#txtPrice').val(formatNumber({{ $job->price}}));
  $('#txtUnitPrice1').focusout(function(){
        let Sale = $('#txtSale1').val();
        if(Sale){
            let unit = removeDot($('#txtUnitPrice1').val());
            let Sale =100 - $('#txtSale1').val();
            let num =$('#txtAmount').val();
            if(num)
            unit = unit * num;
            let price = unit * Sale/100;
            $("#txtPrice1").val(formatNumber(price))
        }else{
            let unit = removeDot($('#txtUnitPrice1').val()) * $('#txtAmount').val();
            $("#txtPrice1").val(formatNumber(unit))
        }

    })
    $('#txtAmount').focusout(function(){
        let Sale = $('#txtUnitPrice1').val();
        if(Sale){
            let unit = removeDot($('#txtUnitPrice1').val());
            let Sale =100 - $('#txtSale1').val();
            let num =$('#txtAmount').val();
            if(num){
                unit = unit * num;

            }
            let price = unit * Sale/100;
            $("#txtPrice1").val(formatNumber(price))
        }else{
            let unit = removeDot($('#txtUnitPrice1').val()) * $('#txtAmount').val();
            $("#txtPrice1").val(formatNumber(unit))
        }

    })
    $('#txtSale1').focusout(function(){
        let unit = $('#txtUnitPrice1').val()
        if( unit){
            let unit = removeDot($('#txtUnitPrice1').val());
            
            let Sale =100 - $('#txtSale1').val();
            let num =$('#txtAmount').val();
            if(num)
            unit = unit * num;
            let price = unit * Sale/100;
            $("#txtPrice1").val(formatNumber(price))
        }else{
            let unit = removeDot($('#txtUnitPrice1').val()) * $('#txtAmount').val();
            $("#txtPrice1").val(formatNumber(unit))
        }
    })
  $(document).ready(function (){

    $('#btnOk').click(function (e) {
        
        e.preventDefault(); // khong load lại nut submit

        var data = new FormData();

        
        data.append('txtAcc',$('#txtAcc').val());
        data.append('txtAmount',$('#txtAmount').val());
        data.append('txtUnit1',$('#txtUnit1').val());
        data.append('txtUnitPrice1',removeDot($('#txtUnitPrice1').val()));
        data.append('txtSale1',$('#txtSale1').val());
        data.append('txtPrice1',removeDot($('#txtPrice1').val()));
        data.append('txtTax1',$('#txtTax1').val());
        data.append('txtGhichu1',$('#txtGhichu1').val());
        data.append('ac_id',"{{$Ac->m_accessaty_id}}");
        // data.append('_token',$("input[name='_token']").val());
        // data = $('#txtAcc').val();
        console.log(data)
        $.ajax({
            
            url: "{{ url('/Deail/edit')}}",
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