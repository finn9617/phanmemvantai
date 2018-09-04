@extends('blank')
@section('content')

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
  /*Check Auth on view 
    - use lib CheckAuthController::checkAuth($routeName,$method,$currentUser_type)
    - $routeName : Tên route 
    - $method : Tên method của route 
    - $currentUser_type : User hiện đang đăng nhập
  */
?>
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe">THÊM THÔNG TIN {{ App\TitleList::ListTitle('importAccessary') }}</div>
  </div>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <div class="row">
                <div class="col-md-12 prePage">
                    <a href="{{ url('importAccessary') }}">
                    <span class="glyphicon glyphicon-step-backward">
                        <span class="prePage">Quay lại </span>
                    </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="box-body">
            <h1>Nhập mới phụ tùng xe</h1>
            <form><input type="hidden" id="_token" name="_token" value="{{csrf_token()}}"></form>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="fullname">Ngày nhập kho (*) <i><span style="color:red" id="errorImportDate"></span></i></label>
                    <?php $import=date_create($oA->order_accessary_date)?>
                    <input type="date" class="form-control" id="importDate" name="importDate" value="{{date_format($import,'Y-m-d')}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="fullname">Tên người nhập <i><span style="color:red" id="errorBuyer"></span></i></label>
                    <input type="text" class="form-control" id="buyer" name="buyer" placeholder="Nhập tên người mua" disabled value="{{$sess_users[0]->nick_name}}">
                </div>
                <div class="form-group col-md-12">
                    <label for="noteOrder">Ghi chú</label>
                    <textarea style = "height:100px;" class="form-control" id="noteOrder" name="noteOrder" placeholder="Nhập ghi chú">{{$oA->note}}</textarea> 
                </div>
            
            </div>
            <br>
            <hr>
            <div class="row">
                <div class = "col-md-2" style = "font-size:25px;margin-right:-100px !important;">Nhập phụ tùng</div>
                <div class="form-group col-md-10">
                    <button name="btnAdd" id="btnAdd" class="btn btn-success btn-md">Thêm</button>&nbsp;
                </div>
                <label><div class = "col-md-12"><i><span style="color:red" id="errorRow"></span></i></div></label>
            </div>                    
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="fullname">Tên phụ tùng (*) <i><span style="color:red" id="errorshortname"></span></i></label>
                    <select class="form-control select2" id="shortname" name="shortname" data-placeholder="Chọn tên phụ tùng">
                        <option></option>
                        @foreach($accessary as $acc)
                            <option data-unit="{{$acc->unit}}" value="{{$acc->accessary_id}}">{{$acc->accessary_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="partner">Tên nhà cung ứng </label>
                    <select class="form-control select2" id="partner" name="partner" data-placeholder="Chọn tên nhà cung ứng">
                        <option></option>
                        @foreach($partner as $pn)
                            <option value="{{$pn->partner_id}}">{{$pn->partner_short_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="amount">Số lượng (*) <i><span style="color:red" id="errorAmount"></span></i></i></label>
                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Nhập số lượng">
                </div>
                <div class="form-group col-md-2">
                    <label for="unit">Đơn vị tính </label>
                    <input type="text" disabled class="form-control" id="unit" name="unit" placeholder="Nhập đơn vị tính">
                </div>
                <div class="form-group col-md-2">
                    <label for="price">Giá tiền</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="Nhập giá tiền">
                </div>
                <div class="form-group col-md-2">
                    <label for="totalPrice">Thành tiền</label>
                    <input type="text" class="form-control" id="totalPrice" name="totalPrice" placeholder="Nhập đơn vị tính">
                </div>

                <div class="form-group col-md-12">
                    <label for="note">Ghi chú</label>
                    <textarea class="form-control" id="note" name="note" placeholder="Nhập ghi chú"></textarea> 
                </div>

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table acc_table" id="acc_table">
                            <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                <tr role="row">
                                    <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  style="width: 10px;"/>TT</th>
                                    <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt2" title="Vị trí 2" style="width: 15%">TÊN PHỤ TÙNG</th>
                                    <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt3"title="Vị trí 3" style="width: 15%">TÊN NHÀ CUNG ỨNG</th>
                                    <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt4"title="Vị trí 4" style="width: 10%">SỐ LƯỢNG</th>
                                    <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt4"title="Vị trí 4" style="width: 8%">ĐƠN VỊ TÍNH</th>
                                    <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt4"title="Vị trí 4" style="width: 10%">GIÁ CẢ</th>
                                    <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt4"title="Vị trí 4" style="width: 10%">THÀNH TIỀN</th>
                                    <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt8"title="Vị trí 8">GHI CHÚ</th>
                                    <th  tabindex="0" aria-controls="example2" rowspan="1" colspan="1"  id="vt9"title="Vị trí 9" style="width: 7%">CHỨC NĂNG</th>
                                </tr>
                            </thead>
                            <tbody id="accessary">
                                @foreach($oAD as $oad)
                                    <tr class='data'>
                                        <td></td>
                                        <td>{{$oad->accessary_name}}</td>
                                        <td>{{$oad->partner_short_name}}</td>
                                        <td>{{$oad->amount}}</td>
                                        <td>{{$oad->unit}}</td>
                                        <td>{{$oad->price}}</td>
                                        <td>{{$oad->total_price}}</td>
                                        <td>{{$oad->note}}</td>
                                        <td>
                                            <a class="delete" href="#" type="button" id="btnDelete" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>
                                        </td>
                                        <td style="display:none;">{{$oad->accessary_id}}</td>
                                        <td style="display:none;">{{$oad->import_partner_id}}</td>
                                        <td style="display:none;">{{$oad->accessary_order_detail_id}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group col-md-12">
                    <button name="btnChange" id="btnSave" class="btn btn-success btn-md">Lưu</button>&nbsp;
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $('#shortname').select2({
            placeholder: "Chọn tên phụ tùng"
        });

        $('#partner').select2({
            placeholder: "Chọn tên nhà cung ứng"
        });

        $('#shortname').change(function(){
            unit =  $(this).find(':selected').data("unit");
            $('#unit').val(unit);
        })

        $('#price').keyup(function(){
            if($('#price').val() && $('#amount').val()){
                $('#totalPrice').val( ($('#amount').val()) * ($('#price').val()) );
            }
        })
        $('#amount').keyup(function(){
            if($('#price').val() && $('#amount').val()){
                $('#totalPrice').val( ($('#amount').val()) * ($('#price').val()) );
            }
        })
        
        $('#btnAdd').click(function(e){
            e.preventDefault();
            
            name = $('#shortname').find(':selected').text();
            partner = $('#partner').find(':selected').text();
            amount = $('#amount').val();
            unit = $('#unit').val();
            price = $('#price').val();
            totalPrice = $('#totalPrice').val();
            if(totalPrice===0){
                totalPrice = "";
            }
            note = $('#note').val();

            accessary = `<tr class='data'>
                            <td></td>
                            <td>`+name+`</td>
                            <td>`+partner+`</td>
                            <td>`+amount+`</td>
                            <td>`+unit+`</td>
                            <td>`+price+`</td>
                            <td>`+totalPrice+`</td>
                            <td>`+note+`</td>
                            <td>
                                <a class="delete" href="#" type="button" id="btnDelete" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>
                            </td>
                            <td style="display:none;">`+$('#shortname').find(':selected').val()+`</td>
                            <td style="display:none;">`+$('#partner').find(':selected').val()+`</td>
                            <td style="display:none;">nodata</td>
                            </tr>`;
            if(name!=""&&amount!=""){
                $('#accessary').append(accessary);
                numberRows($("#acc_table tbody"));
            }
            else{
                if(name==""){
                    showNotify('#shortname','Vui lòng chọn tên phụ tùng',"warning","top");
                }
                if(amount==""){
                    showNotify('#amount','Vui lòng chọn nhập số lượng',"warning","top");
                }
            }
        })
        numberRows($("#acc_table tbody"));

        $(document).on('click','#btnDelete',function(e){
            e.preventDefault();
            var $row = $(this).parent().parent();
            $row.remove();
            numberRows($("#acc_table tbody"));
    
        })
        
        function numberRows($t) {
            var c = 0;
            $t.find("tr").each(function(ind, el) {
                $(el).find("td:eq(0)").html(c+=1);
            });
        }
        function showNotify(place, msg, type, position) {
            $.notify.defaults({ className: type });
            $(place).notify(
            msg,
            { position: position }
            );
        } 
        
        $('#btnSave').click(function(e){
            // $('#errorShortname').empty();
            $('#errorImportDate').empty();
            $('#errorRow').empty();
            // $('#errorAmount').empty();
            
            e.preventDefault();

            var data = new FormData();

            var ret = Array();
    
            $("#acc_table tr").each(function(i, v){
                ret[i] = Array();
                $(this).children('td').each(function(ii, vv){
                    ret[i][ii] = $(this).text();
                    data.append('row',i);
                    data.append('data'+i,ret[i]);
                }); 
            })

            data.append('_token', "{{csrf_token()}}");
            data.append('orderId',"{{$oA->order_accessary_id}}")
            data.append('importDate',$('#importDate').val());
            data.append('import_user',"{{$sess_users[0]->user_id}}");
            data.append('noteOrder',$('#noteOrder').val());
            
            $.ajax({
                url: "{{url('/importAccessary/edit')}}",
                type: "POST",
                data: data,
                processData: false,
                contentType: false,
                success: function(result){
                    if(result.success){
                        window.location.href="{{url('/importAccessary')}}";
                    }
                    else{
                        // $('#errorShortname').append(result.error.shortname);
                        $('#errorImportDate').append(result.error.importDate);
                        // $('#errorPartner').append(result.error.partner);
                        // $('#errorAmount').append(result.error.amount);
                        // $('#errorPrice').append(result.error.price);
                        // $('#errorTotalPrice').append(result.error.totalPrice);
                        $('#errorRow').append(result.error.row);
                    }
                }
            })
        })

        function getBody(element) {
            var divider = 2;
            var originalTable = element.clone();
            var tds = $(originalTable).children('tbody').children('tr').children('td').length;
            return tds;
        }

        
    })
    
</script>
@endsection