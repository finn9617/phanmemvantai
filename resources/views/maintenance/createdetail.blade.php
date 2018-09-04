@extends('blank')
@section('content')
<style>
        .container_1 {
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 13px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;

        }

        /* Hide the browser's default radio button */
        .container_1 input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        /* Create a custom radio button */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 17px;
            width: 17px;
            background-color: #eee;
            border-radius: 50%;
            margin-left:10px;
        }

        /* On mouse-over, add a grey background color */
        .container_1:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .container_1 input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .container_1 input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .container_1 .checkmark:after {
            top: 5px;
            left: 5px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: white;
        }
    </style>
<!-- Content Header (Page header) -->

<script>
$(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false,
      "bStateSave": true,
    })
  })
</script>

<?php
//Check login
if(!session()->has('email')){
  echo "Chưa đăng nhập";
  exit();

}
$currentUser = null;
if(session()->has('email'))
{
  $tmpemail = Session::get('email');
  $sess_email = end($tmpemail);
  $sess_users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $sess_email)->get();
  $currentUser_type =$sess_users[0]->user_type;
  
}
?>
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe"> THÊM CHI TIẾT BẢO DƯỠNG XE </div>
  </div>
          <!-- back page -->
  <div class="row">
    <div class="col-md-12 prePage">
      <a href="/sumMaintenance" class="">
        <span class="glyphicon glyphicon-step-backward">
          <span class="prePage">BẢO DƯỠNG TỔNG HỢP</span>
        </span>
      </a>
    </div>
  </div>
  <!-- ./ back page -->
  <style type="text/css">
    tbody:nth-child(odd) {
    background: #E9F6FC;
      }
      tr.even{
        background: #FFFFFF;
      }
</style>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <div class="row">
                <div class="container-fluid">
                    <div class="text-lg" style="margin-top:3%;">
                        <label class="container_1">TẠI KHO
                            <input id="taikho" type="radio" checked="checked" name="radio">
                            <span  class="checkmark"></span>
                        </label>
                        <label class="container_1">BÊN NGOÀI
                            <input id="benngoai" type="radio" checked="checked" name="radio">
                            <span  class="checkmark"></span>
                        </label> 
                    </div>
                    <!-- bên ngoài -->
                    <div class="div_benngoai" style="display: block;">
                        <div class="" style="margin-top:1%; margin-left:0;">
                            <div class="form-group col-md-4">
                                <label for="">Công ty bảo dưỡng:</label>
                                <input type="text" class="form-control" style="display: inline-flex; width:76%;" name="txtCty" id="txtCty" placeholder="Nhập tên công ty" value="">
                                <button id="add_company" class="btn btn-success btn-md" style="margin-bottom: 3px;">Thêm</button>
                                <button class="btn btn-danger btn-md" id="edit_company" style="margin-bottom: 3px;display: none;">Edit</button>
                            </div>
                        </div>
                        <div class="col-md-12 job box-body" >
                            <button class="btn btn-secondary " id="btn-job">CÔNG VIỆC</button>
                            <button class="btn btn-success" id="btn-pt">VẬT TƯ/ PHỤ TÙNG</button>
                        </div>
                        <div class="" id="job_c" >
                            <div class="col-md-12 table_job" style="padding-top: 2%;">
                                <div class="box-body"  style="background-color:#eee;">
                                    <div class="table-responsive"  style="padding-top:2rem;">
                                        <table id="tbl_job" style="border: 1px solid #d5d5d5;" class="table table-bordered" >
                                            <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                                <tr role="row">
                                                    <th class="sorting_desc" style="border-bottom-width: 0;">STT</th>
                                                    <th class="sorting" style="border-bottom-width: 0;">TÊN CÔNG VIỆC
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">ĐƠN GIÁ
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">GIẢM GIÁ
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">THÀNH TIỀN
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">THUẾ (VAT)
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">GHI CHÚ
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">XÓA
                                                    </th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                                <div class="box-body"  style="background-color:#eee; padding-top:30px;">
                                    <div class="col-md-12">
                                        <button class="btn btn-success" id="btn_job" style="float:right; margin-bottom: 3px;" disabled="disabled">Thêm</button>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Tên công việc:</label>
                                        <input type="text" class="form-control" name="txtJob" id="txtJob" placeholder="Nhập tên công việc" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Đơn giá:</label>
                                        <input type="text" class="form-control number" name="txtUnitPrice" id="txtUnitPrice" placeholder="Nhập đơn giá" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Giảm giá:</label>
                                        <input type="number" class="form-control" name="txtSale" id="txtSale" min="0" max="100" placeholder="Nhập số giảm giá " value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Thuế :</label>
                                        <input type="number" class="form-control" name="txtTax" id="txtTax" placeholder="Nhập số thuế" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Thành tiền:</label>
                                        <input type="text" class="form-control number" name="txtPrice" id="txtPrice"  placeholder="Nhập thành tiền" value="">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="control-label">Ghi chú </label>
                                        <textarea class="form-control" rows="5" placeholder="Nhập ghi chú nếu cần" name="txtGhichu" id="txtGhichu"></textarea>
                                    </div>

                                    <div class="col-md-12" style="margin:3rem;"><strong style="">Lưu ý: Cần bấm lưu để thêm thành công tất cả công việc bảo dưỡng xe !</strong></div>

                                </div>
                            </div>   
                            <div class="col-md-12" style="margin-top:30px;">
                                <form action="">
                                    {{csrf_field() }}
                                    <button  class="btn btn-danger" id="btl_Sjob">Lưu</button>
                                </form>
                            </div>
                        </div>
                        <div class="" id="PT" style="display: none;">
                            <div class="col-md-12 table_job" style="margin-top: 2%;">
                                <div class="box-body" style="background-color:#eee;">
                                    <div class="table-responsive"  style="padding-top:2rem;">
                                        <table id="tbl_acc" style="border: 1px solid #d5d5d5;" class="table table-bordered" >
                                            <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                                <tr role="row">
                                                    <th class="sorting_desc" style="border-bottom-width: 0;">STT</th>
                                                    <th class="sorting" style="border-bottom-width: 0;">TÊN PHỤ TÙNG
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">SỐ LƯỢNG
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">ĐƠN VỊ
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">ĐƠN GIÁ
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">GIẢM GIÁ
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">THÀNH TIỀN
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">THUẾ (VAT)
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">GHI CHÚ
                                                    </th>
                                                    <th class="sorting" style="border-bottom-width: 0;">XÓA
                                                    </th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                                <div class="box-body" style="background-color:#eee; padding-top:30px;">
                                    <div class="col-md-12">
                                        <button class="btn btn-success" id="btn_accessary" style="float:right; margin-bottom: 3px;" disabled="disabled">Thêm</button>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Tên PT/VT:</label>
                                        <input type="text" class="form-control" name="txtAcc" id="txtAcc" placeholder="Nhập tên công việc" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Số lượng:</label>
                                        <input type="text" class="form-control" name="txtAmount" id="txtAmount" placeholder="Nhập số lượng" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Đ/V:</label>
                                        <input type="text" class="form-control" name="txtUnit1" id="txtUnit1" placeholder="Nhập đơn vị" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Đơn giá:</label>
                                        <input type="text" class="form-control number" name="txtUnitPrice1" id="txtUnitPrice1" placeholder="Nhập đơn giá" value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Giảm giá:</label>
                                        <input type="number" class="form-control" name="txtSale1" id="txtSale1" placeholder="Nhập số giảm giá " value="">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Thuế :</label>
                                        <input type="number" class="form-control" name="txtTax1" id="txtTax1" placeholder="Nhập số thuế" value="">
                                    </div>
                                       <div class="form-group col-md-4">
                                        <label for="">Thành tiền:</label>
                                        <input type="text" class="form-control number" name="txtPrice1" id="txtPrice1"  placeholder="Nhập thành tiền" value="">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="" class="control-label">Ghi chú </label>
                                        <textarea class="form-control" rows="5" placeholder="Nhập ghi chú nếu cần" name="txtGhichu1" id="txtGhichu1"></textarea>
                                    </div>
                                    <div class="col-md-12" style="margin:3rem;"><strong >Lưu ý: Cần bấm lưu để thêm thành công tất cả phụ tùng bảo dưỡng xe !</strong></div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top:30px;">
                                <form action="">
                                        {{csrf_field() }}
                                    <button  class="btn btn-danger" id="btn_luu_accessary">Lưu</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-7"></div>
                </div>
            </div>

        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</section>
    {{-- show/hide table --}}
    <script type="text/javascript">
        /*
        place: where display message
        msg: message
        type: type of message box - info , warn, error
        position: top, left, right, bottom
        */
        function showNotify(place, msg, type, position) {
            $.notify.defaults({ className: type });
            $(place).notify(
            msg,
            { position: position }
            );
        }

        $( "#btn-job" ).click(function() {
            $("#job_c").show( "slow" );
            $("#PT").hide("slow");

        });

        $( "#btn-pt" ).click(function() {
            $("#PT").show( "slow" );
            $("#job_c").hide("slow");
        });

        $( "#benngoai" ).click(function() {
            $(".div_benngoai").show( "slow" );
            $(".div_taikho").hide("slow");

        });

        $( "#taikho" ).click(function() {
            $(".div_taikho").show( "slow" );
            $(".div_benngoai").hide("slow");

        });
        
        $( "#add_company" ).click(function() {
            if($('#txtCty').val()){
                $("#add_company").attr('disabled','disabled');
                $("#txtCty").attr('disabled','disabled');
                $("#btn_job").removeAttr('disabled','disabled');
                $("#btn_accessary").removeAttr('disabled','disabled');
                $('#add_company').hide('slow');
                $('.job').show('slow');
                $('#edit_company').show('slow');
            }
        });

        $( "#edit_company" ).click(function() {
            $("#add_company").removeAttr('disabled','disabled');
            $("#txtCty").removeAttr('disabled','disabled');
            $("#btn_job").attr('disabled','disabled');
            $("#btn_accessary").attr('disabled','disabled');
            $('#edit_company').hide('slow');
            $('#add_company').show('slow');
            $('.job').show('slow');
        });
        

          //get data from tool table
        function getDataTable(){
            let dataTable = [];
            let numRow =  $('#tbl_job tr').length;
            let table = document.getElementById("tbl_job")
            if(numRow > 1){
                for(var i =1 ; i< numRow; i++){
                let element = {};
                let row = table.rows[i];
                let job = row.cells[1].innerHTML;
                let unit = row.cells[2].innerHTML;
                let sale = row.cells[3].innerHTML;
                let price = row.cells[4].innerHTML;
                let tax = row.cells[5].innerHTML;
                let note = row.cells[6].innerHTML;
                // quantity = parseInt(quantity);
                element.job =  removeDot(job);
                element.unit = removeDot(unit);
                element.sale = removeDot(sale);
                element.price = removeDot(price);
                element.tax = removeDot(tax);
                element.note = removeDot(note);
                dataTable.push(element);
                }
            }
        return dataTable;
        }

        $('#txtUnitPrice').focusout(function(){
            let Sale = $('#txtSale').val();
            if(Sale){
                let unit = removeDot($('#txtUnitPrice').val())
                let Sale =100 - $('#txtSale').val();
                let price = unit * Sale/100;
                $("#txtPrice").val(formatNumber(price))
            }else{
                $("#txtPrice").val(formatNumber($('#txtUnitPrice').val()))

            }

        })
        
        $('#txtSale').focusout(function(){
            let unit = $('#txtUnitPrice').val()
            if(unit){
                let unit = removeDot($('#txtUnitPrice').val());
                let Sale =100 - $('#txtSale').val();
                let price = unit * Sale/100;
                $("#txtPrice").val(formatNumber(price))
            }else{
                $("#txtPrice").val(formatNumber($('#txtUnitPrice').val()))
            }
        })

        var stt = $('#tbl_job tr').length -1;
        $('#btn_job').click(function () {
                let txtJob = $('#txtJob').val();
                let txtUnitPrice = removeDot($('#txtUnitPrice').val());
                let txtSale = $('#txtSale').val();
                let txtPrice = removeDot($('#txtPrice').val());
                let txtTax = $('#txtTax').val();
                let txtGhichu = $('#txtGhichu').val();
                
                if(!txtJob){
                    showNotify("#txtJob", "Không được bỏ trống", "error", "top");
                }

                if(!txtTax){
                    showNotify("#txtTax", "Không được bỏ trống", "error", "top");
                }

                if(!txtPrice){
                    showNotify("#txtPrice", "Không được bỏ trống", "error", "top");
                }

                if(!txtUnitPrice){
                    showNotify("#txtUnitPrice", "Không được bỏ trống", "error", "top");
                }
                if (txtJob && txtTax && txtPrice && txtUnitPrice) {
                    console.log($('#row_'+txtUnitPrice).length)
                    if($('#row_'+txtUnitPrice).length == 0){
                        stt++;

                        let rowHTML = `
                        <tr style="background-color: #b0daff;" class="trTool" id="row_`+txtUnitPrice+`">
                            <td rowspan="1" style="vertical-align: inherit;" id="td_1_">` + stt + `</td>
                            <td id = "">` + txtJob + `</td>
                            <td rowspan="1" style="vertical-align: inherit;" id="">` +formatNumber(txtUnitPrice) + `</td>
                            <td id = ""> ` + txtSale + `</td>
                            <td id = "toolQuantityCell_">` + formatNumber(txtPrice) + `</td>
                            <td id = "toolQuantityCell_">` + txtTax + `</td>
                            <td id = "toolQuantityCell_">` + txtGhichu + `</td>
                            <td style="vertical-align: inherit;"><div class="iconRemoveRowTable"><span class="glyphicon glyphicon-remove-sign"></span></div></td>
                        </tr>`;
                        
                        $('#tbl_job').append(rowHTML);
                        $('#txtJob').val('');
                        $('#txtUnitPrice').val('');
                        $('#txtSale').val('');
                        $('#txtPrice').val('');
                        $('#txtTax').val('');
                        $('#txtGhichu').val('');
                    }
                }
        })

        $('#tbl_job').on('click', '.iconRemoveRowTable', function () {
            let indexRow = this.parentNode.parentNode.rowIndex;
            document.getElementById("tbl_job").deleteRow(indexRow);
            let table = document.getElementById("tbl_job");
            //  set số thư tự
            let numRow =  $('#tbl_job tr').length;
            console.log(numRow)

            for(var i = 1; i< numRow; i++ ){
             stt =i;
             table.rows[i].cells[0].innerHTML = stt;
            }

            // alert(1)
        })


        $('#btl_Sjob').click(function (e) {
            e.preventDefault();
            table = getDataTable();
            let isDisabled = $('#txtCty').prop('disabled');
            if( isDisabled && table.length != 0 ){
                txtCty = $('#txtCty').val();
                  $.ajax({
                    type:'post',
                    url: "{{ url('/maintenance/createItemDeail/'.$id) }}",
                    headers: {
                                'X-CSRF-TOKEN': $("input[name='_token']").val()
                            },
                    data: {'table':table, 'txtCty':txtCty },
                    dataType:"json",
                    async: false,
                    success: function (result) {
                        if(result.success){
                            swal("Thành công", "Đã thêm mới thành công!", "success")
                            .then((value) => {
                                window.location.href = "{{ url('/maintenance/itemDetail/'.$id) }}";
                            });
                            setTimeout(function(){ window.location.href = "{{ url('/maintenance/itemDetail/'.$id) }}"; }, 3000);
                        }
                        if(result.errors){
                            swal("Thất bại", "Quá trình xử lý có lỗi", "error")
                        }
                        if(result.error){
                            swal("Thất bại", "Quá trình xử lý có lỗi", "error")
                            showNotify("#txtCty", "Không được bỏ trống", "error", "top");
                        }
                    }
                })
            }else{
                swal("Thất bại", "Quá trình xử lý có lỗi", "error")
            }
          
        })

        // ACCESSARY
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

        function getDataTable1(){
            let dataTable = [];
            let numRow =  $('#tbl_acc tr').length;
            let table = document.getElementById("tbl_acc")
            if(numRow > 1){
                for(var i =1 ; i< numRow; i++){
                let element = {};
                let row = table.rows[i];
                let txtAcc = row.cells[1].innerHTML;
                let txtAmount = row.cells[2].innerHTML;
                let txtUnit1 = row.cells[3].innerHTML;
                let txtUnitPrice1 = row.cells[4].innerHTML;
                let txtSale1 = row.cells[5].innerHTML;
                let txtPrice1 = row.cells[6].innerHTML;
                let txtTax1 = row.cells[7].innerHTML;
                let txtGhichu1 = row.cells[8].innerHTML;
                // quantity = parseInt(quantity);
                element.txtAcc = removeDot(txtAcc);
                element.txtAmount = removeDot(txtAmount);
                element.txtUnit1 = removeDot(txtUnit1);
                element.txtUnitPrice1 = removeDot(txtUnitPrice1);
                element.txtSale1 = removeDot(txtSale1);
                element.txtPrice1 = removeDot(txtPrice1);
                element.txtTax1 = removeDot(txtTax1);
                element.txtGhichu1 = removeDot(txtGhichu1);
                dataTable.push(element);
                }
            }
            return dataTable;
        }

         var stt = $('#tbl_acc tr').length -1;
        $('#btn_accessary').click(function () {
            let txtAcc = $('#txtAcc').val();
            let txtAmount = $('#txtAmount').val();
            let txtUnit1 = $('#txtUnit1').val();
            let txtUnitPrice1 = removeDot(('#txtUnitPrice1').val());
            let txtSale1 = $('#txtSale1').val();
            let txtPrice1 = remove($('#txtPrice1').val());
            let txtTax1 = $('#txtTax1').val();
            let txtGhichu1 = $('#txtGhichu1').val();
            
            if(!txtUnitPrice1){
                showNotify("#txtJob", "Không được bỏ trống", "error", "top");
            }

            if(!txtAcc){
                showNotify("#txtAcc", "Không được bỏ trống", "error", "top");
            }

            if(!txtAmount){
                showNotify("#txtAmount", "Không được bỏ trống", "error", "top");
            }

            if(!txtUnit1){
                showNotify("#txtUnit1", "Không được bỏ trống", "error", "top");
            }
            if (txtUnitPrice1 && txtAcc && txtAmount && txtUnit1) {
                // console.log($('#row_'+txtUnitPrice1).length)
                if($('#row_'+txtUnitPrice1).length == 0){
                    stt++;

                    let rowHTML = `
                    <tr style="background-color: #b0daff;" class="trTool" id="row_`+txtUnitPrice+`">
                        <td rowspan="1" style="vertical-align: inherit;" id="td_1_">` + stt + `</td>
                        <td id = "">` + txtAcc + `</td>
                        <td rowspan="1" style="vertical-align: inherit;" id="">` + txtAmount + `</td>
                        <td id = ""> ` + txtUnit1 + `</td>
                        <td id = "">` + formatNumber(txtUnitPrice1) + `</td>
                        <td id = "">` + txtSale1 + `</td>
                        <td id = "">` + formatNumber(txtPrice1) + `</td>
                        <td id = "">` + txtTax1 + `</td>
                        <td id = "">` + txtGhichu1 + `</td>
                        <td style="vertical-align: inherit;"><div class="iconRemoveRowTable accessary"><span class="glyphicon glyphicon-remove-sign"></span></div></td>
                    </tr>`;
                    
                    $('#tbl_acc').append(rowHTML);
                    $('#txtAcc').val('');
                    $('#txtAmount').val('');
                    $('#txtUnit1').val('');
                    $('#txtUnitPrice1').val('');
                    $('#txtSale1').val('');
                    $('#txtPrice1').val('');
                    $('#txtTax1').val('');
                    $('#txtGhichu').val('');
                }
            }
        })
        
        $('#tbl_acc').on('click', '.accessary', function () {
            let indexRow = this.parentNode.parentNode.rowIndex;
            document.getElementById("tbl_acc").deleteRow(indexRow);
            let table = document.getElementById("tbl_acc");
            //  set số thư tự
            let numRow =  $('#tbl_acc tr').length;
            console.log(numRow)

            for(var i = 1; i< numRow; i++ ){
             stt =i;
             table.rows[i].cells[0].innerHTML = stt;
            }

            // alert(1)
        })

        $('#btn_luu_accessary').click(function (e) {
            e.preventDefault();
            txtCty = $('#txtCty').val();
            table = getDataTable1();
            // console.log(table);
            $.ajax({
                type:'post',
                url: "{{ url('/maintenance/createItemDeail1/'.$id) }}",
                headers: {
							'X-CSRF-TOKEN': $("input[name='_token']").val()
						},
                data: {'table':table, 'txtCty':txtCty },
                dataType:"json",
                async: true,
                success: function (result) {
                    if(result.success){
                        swal("Thành công", "Đã thêm mới thành công!", "success")
                        .then((value) => {
                             window.location.href = "{{ url('/maintenance/itemDetail/'.$id) }}";
                        });
                        setTimeout(function(){ window.location.href = "{{ url('/maintenance/itemDetail/'.$id) }}"; }, 3000);
                    }
                    if(result.errors){
                        swal("Thất bại", "Quá trình xử lý có lỗi", "error")
                    }
                    if(result.error){
                        swal("Thất bại", "Quá trình xử lý có lỗi", "error")
                        showNotify("#txtCty", "Không được bỏ trống", "error", "top");
                    }
                }
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