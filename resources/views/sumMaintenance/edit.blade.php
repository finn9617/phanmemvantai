@extends('blank')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="row">
    <div class="col-md-12 titleDieuXe"> THÔNG TIN XE {{ $car->car_num }} </div>
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
</section>
    <section class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-warning col-md-11">
                    <div class="box-body">
                        <div class="row">
                            <div class=" col-md-6">
                                <div class="form-group">
                                    <label for="email">Số xe (*):</label>
                                    <input type="text" class="form-control" disabled name="txtSoxe" id="txtSoxe" placeholder="Nhập số xe" value="{{ $car->car_num }}" >
                                </div>
                            </div>
                            <?php 
                            $car_type = DB::table('tbl_car_type')->orderBy('name','ASC')->get();
                            ?>
                            <div class="form-group col-md-6"> 
                                <label for="email">Loại xe (*):</label>
                                <input type="text" class="form-control" disabled name="selLoaixe" id="selLoaixe"
                                @foreach ($car_type as $c )
                                    @if($car->car_type_id == $c->car_type_id ) 
                                        value="{{ $c->name }}"
                                    @endif
                                @endforeach >
                            </div>
                        </div>
                        <div class="row">
                                <?php 
                                $type_user = DB::table('tbl_user')->where('user_type','=',12)->where('status','=',0)->orderBy('nick_name','ASC')->get();
                            ?>
                            <div class="form-group col-md-6"> 
                                <label for="email">Gợi ý tài xế:</label><br>
                                <input type="text" class="form-control" disabled name="taixe" id="taixe"
                                @foreach ($type_user as $c )
                                    @if($car->driver_suggestion == $c->user_id )
                                        value="{{ $c->nick_name }}"
                                    @endif
                                @endforeach >
                            </div>
                            <?php 
                            $type_user = DB::table('tbl_user')->where('user_type','=',13)->where('status','=',0)->orderBy('nick_name','ASC')->get();
                            ?>
                            <div class="form-group col-md-6"> 
                                <label for="email">Gợi ý phụ xe:</label><br>
                                <input type="text" class="form-control" disabled name="slphuxe" id="slphuxe" 
                                @foreach ($type_user as $c )
                                    @if($car->assistant_driver_suggestion == $c->user_id )
                                        value="{{ $c->nick_name }}"
                                    @endif
                                @endforeach >
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="comment">Ghi chú:</label>
                                <textarea class="form-control" rows="7" disabled cols="10" id="txtGhichu" name="txtGhichu" placeholder="Note">@if ($errors->has('txtSoxe')|| $errors->has('selLoaixe')) {{old('txtGhichu')}} @else{{ $car->note }} @endif</textarea>
                            </div>
                        </div>
                        {{-- BẢO DƯỠNG --}}
                        <div class="row">
                            <div class="col-md-12" style="color: #337ab7;font-family: Arial, Helvetica, sans-serif;font-size: 20px; margin-top:30px; margin-bottom:30px;"> BÁO BẢO DƯỠNG </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="container-fluid" style="float: right;margin-bottom: -50px;">
                                        <div class="form-group">
                                            <a href="/maintenance/create/{{$id}}" class="btn btn-success push"><i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới</a>
                                        </div>
                                    </div>
                                </div>
                                <table id="maintenance" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
                                    <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                        <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ XE </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >LOẠI XE </th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ PHIẾU BẢO DƯỠNG</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >NGÀY HẾT HẠN</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ NGÀY CÒN LẠI</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >GHI CHÚ</th>
                                        <th style="width: 80px">CHỨC NĂNG</th>
                                        </tr>
                                    </thead>
                                    <style type="text/css">
                                        tbody:nth-child(odd) {
                                        background: #E9F6FC;
                                            }
                                            tr.even{
                                            background: #FFFFFF;
                                            }
                                    </style>
                                    <tbody>
                                        <?php $stt = 1;?>
                                        @foreach($maintenance as $bd)
                                        <?php
                                            $date1=date_create(date('Y-m-d'));
                                            $date2=date_create($bd->expiration_date);
                                            $diff=date_diff($date1,$date2);
                                        ?>
                                        <tr id = "<?php echo 'maintenance_'.$bd->maintenance_id ?>" <?php if( intval($diff->format("%a")) <= 7 || $diff->format("%R") === '-' ) echo 'style="background:#1296f345;color:blue;"'; ?> >
                                        <td><?php echo $stt; $stt++;
                                            
                                        ?></td>
                                        <td>{{$bd->car_num}}</td>
                                        <td>{{$bd->name}}</td> 
                                        <td>{{$bd->votes}}</td> 
                                        
                                        <td> <?php   echo date_format(  date_create($bd->expiration_date) , 'd/m/Y'); ?></td> 
                                        <td>
                                            <?php
                                                $date1=date_create(date('Y-m-d'));
                                                $date2=date_create($bd->expiration_date);
                                                $diff=date_diff($date1,$date2);
                                                if($diff->format("%R") === '-')
                                                    echo '<span >ĐÃ HẾT HẠN </span>';
                                                else if( intval($diff->format("%a")) <= 7 )
                                                    echo '<span >CÒN '.$diff->format("%d").' NGÀY NỮA HẾT HẠN</span>';
                                                else
                                                    echo $diff->format("%d ngày %m tháng %y năm");
                                                ?>
                                            </td> 
                                            <td>{{ $bd->note}}</td> 
                                        <td style="width: 80px">
                                            <a class="edit" title="Sửa" href="/maintenance/detail/{{$bd->maintenance_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a class="delete" style="cursor:pointer;"  type="button" onclick="btnDeleteBD({{$bd->maintenance_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- BẢO HIỂM --}}
                        <div class="row">
                            <div class="col-md-12" style="color: #337ab7;font-family: Arial, Helvetica, sans-serif;font-size: 20px; margin-top:30px; margin-bottom:30px;"> DS BẢO HIỂM </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="container-fluid" style="float: right;margin-bottom: -50px;">
                                        <div class="form-group">
                                            <a href="/insurance/create/{{$id}}" class="btn btn-success push"><i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới</a>
                                        </div>
                                    </div>
                                </div>
                                <table id="insurance" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
                                    <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                        <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ XE</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >LOẠI XE</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ PHIẾU BẢO HIỂM</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >NGÀY HẾT HẠN</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ NGÀY CÒN LẠI</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >GHI CHÚ</th>
                                        <th style="width: 80px">CHỨC NĂNG</th>
                                        </tr>
                                    </thead>
                                    <style type="text/css">
                                        tbody:nth-child(odd) {
                                        background: #E9F6FC;
                                            }
                                            tr.even{
                                            background: #FFFFFF;
                                            }
                                    </style>
                                    <tbody>
                                        <?php $stt = 1;?>
                                        @foreach($insurance as $bh)
                                        <?php
                                            $date1=date_create(date('Y-m-d'));
                                            $date2=date_create($bh->expiration_date);
                                            $diff=date_diff($date1,$date2); 
                                        ?>
                                        <tr id = "<?php echo 'insurance_'.$bh->insurance_id ?>" <?php if( intval($diff->format("%a")) <= 7 || $diff->format("%R") === '-' ) echo 'style="background:#1296f345;color:blue;"'; ?> >
                                        <td><?php echo $stt; $stt++;?></td>
                                        <td>{{$bh->car_num}}</td>
                                        <td>{{$bh->name}}</td> 
                                        <td>{{$bh->votes}}</td> 
                                        <td> <?php   echo date_format(  date_create($bh->expiration_date) , 'd/m/Y'); ?> </td> 
                                        <td>
                                            <?php
                                                $date1=date_create(date('Y-m-d'));
                                                $date2=date_create($bh->expiration_date);
                                                $diff=date_diff($date1,$date2);
                                                if($diff->format("%R") === '-')
                                                    echo '<span s>ĐÃ HẾT HẠN</span>';
                                                else if( intval($diff->format("%a")) <= 7 )
                                                    echo '<span >CÒN '.$diff->format("%d").' NGÀY NỮA HẾT HẠN</span>';
                                                else
                                                    echo $diff->format("%d ngày %m tháng %y năm");
                                                ?>
                                            </td> 
                                            <td>{{ $bh->note}}</td> 
                            
                                        <td style="width: 80px">
                                            <a class="edit" title="Sửa" href="/insurance/detail/{{$bh->insurance_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a class="delete" style="cursor: pointer;"  type="button" onclick="btnDeleteBH({{$bh->insurance_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- CHÚNG NHẬN --}}
                        <div class="row">
                            <div class="col-md-12" style="color: #337ab7;font-family: Arial, Helvetica, sans-serif;font-size: 20px; margin-top:30px; margin-bottom:30px;"> DS CN PCCC </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="container-fluid" style="float: right;margin-bottom: -50px;">
                                        <div class="form-group">
                                            <a href="/fire-certificate/create/{{$id}}" class="btn btn-success push"><i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới</a>
                                        </div>
                                    </div>
                                </div>
                                <table id="fireCertificate" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
                                    <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                        <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ XE</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >LOẠI XE</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ PHIẾU PCCC</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >NGÀY ĐĂNG KÝ</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >NGÀY HẾT HẠN</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ NGÀY CÒN LẠI</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >GHI CHÚ</th>
                                        <th style="width: 80px">CHỨC NĂNG</th>
                                        </tr>
                                    </thead>
                                    <style type="text/css">
                                        tbody:nth-child(odd) {
                                        background: #E9F6FC;
                                            }
                                            tr.even{
                                            background: #FFFFFF;
                                            }
                                    </style>
                                    <tbody>
                                        <?php $stt = 1;?>
                                        @foreach($fireCertificate as $cn)
                                        <?php
                                                $date1=date_create(date('Y-m-d'));
                                                $date2=date_create($cn->expiration_date);
                                                $diff=date_diff($date1,$date2);
                                        ?>
                                        <tr id = "<?php echo 'fireCertificate_'.$cn->fire_certificate_id ?>" <?php if( intval($diff->format("%a")) <= 7 || $diff->format("%R") === '-' ) echo 'style="background:#1296f345;color:blue;"'; ?> >
                                        <td><?php echo $stt; $stt++;?></td>
                                        <td>{{$cn->car_num}}</td>
                                        <td>{{$cn->name}}</td> 
                                        <td>{{$cn->votes}}</td> 
                                        <td> <?php   echo date_format(  date_create($cn->register_date) , 'd/m/Y'); ?></td> 
                                        <td> <?php   echo date_format(  date_create($cn->expiration_date) , 'd/m/Y'); ?></td> 
                                        <td>
                                            <?php
                                                if($diff->format("%R") === '-')
                                                    echo '<span >ĐÃ HẾT HẠN </span>';
                                                else if( intval($diff->format("%a")) <= 7 )
                                                    echo '<span>CÒN '.$diff->format("%d").' NGÀY NỮA HẾT HẠN</span>';
                                                else
                                                    echo $diff->format("%d ngày %m tháng %y năm");
                                                ?>
                                            </td>
                                            <td> {{ $cn->note}}</td> 
                                        <td style="width: 80px">
                                            <a class="edit" title="Sửa" href="/fire-certificate/detail/{{$cn->fire_certificate_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a style="cursor: pointer;"  class="delete" type="button" onclick="btnDeleteCN({{$cn->fire_certificate_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- KIỂM ĐỊNH --}}
                        <div class="row">
                            <div class="col-md-12" style="color: #337ab7;font-family: Arial, Helvetica, sans-serif;font-size: 20px; margin-top:30px; margin-bottom:30px;"> DS KIỂM ĐỊNH </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="container-fluid" style="float: right;margin-bottom: -50px;">
                                        <div class="form-group">
                                            <a href="/verify/create/{{$id}}" class="btn btn-success push"><i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới</a>
                                        </div>
                                    </div>
                                </div>
                                <table id="verify" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
                                    <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                        <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ XE</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >LOẠI XE</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ PHIẾU KIỂM ĐỊNH</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >NGÀY ĐĂNG KÝ</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >NGÀY HẾT HẠN</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ NGÀY CÒN LẠI</th>
                                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >GHI CHÚ</th>
                                        <th style="width: 80px">CHỨC NĂNG</th>
                                        </tr>
                                    </thead>
                                    <style type="text/css">
                                        tbody:nth-child(odd) {
                                        background: #E9F6FC;
                                            }
                                            tr.even{
                                            background: #FFFFFF;
                                            }
                                    </style>
                                    <tbody>
                                        <?php $stt = 1;?>
                                        @foreach($verify as $kd)
                                        <?php
                                            $date1=date_create(date('Y-m-d'));
                                            $date2=date_create($kd->expiration_date);
                                            $diff=date_diff($date1,$date2); 
                                        ?>
                                        <tr id = "<?php echo 'verify_'.$kd->verify_id ?>" <?php if( intval($diff->format("%a")) <= 7 || $diff->format("%R") === '-' ) echo 'style="background:#1296f345;color:blue;"'; ?> >
                                        <td><?php echo $stt; $stt++;?></td>
                                        <td>{{$kd->car_num}}</td>
                                        <td>{{$kd->name}}</td> 
                                        <td>{{$kd->votes}}</td> 
                                        <td> <?php   echo date_format(  date_create($kd->register_date) , 'd/m/Y'); ?></td> 
                                        <td> <?php   echo date_format(  date_create($kd->expiration_date) , 'd/m/Y'); ?></td> 
                                        <td>
                                            <?php
                                                if($diff->format("%R") === '-')
                                                    echo '<span >ĐÃ HẾT HẠN </span>';
                                                else if( intval($diff->format("%a")) <= 7 )
                                                    echo '<span>CÒN '.$diff->format("%d").' NGÀY NỮA HẾT HẠN</span>';
                                                else
                                                    echo $diff->format("%d ngày %m tháng %y năm");
                                                ?>
                                            </td>
                                            <td> {{ $kd->note}}</td> 
                                        <td style="width: 80px">
                                            <a class="edit" title="Sửa" href="/verify/detail/{{$kd->verify_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a style="cursor: pointer;" class="delete" id="btnkd"  type="button" onclick="btnDeleteKD({{$kd->verify_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- THAY NHỚT --}}
                        <div class="row">
                            <div class="col-md-12" style="color: #337ab7;font-family: Arial, Helvetica, sans-serif;font-size: 20px; margin-top:30px; margin-bottom:30px;"> DS THAY NHỚT</div>
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="container-fluid" style="float: right;margin-bottom: -50px;">
                                        <div class="form-group">
                                            <a href="" class="btn btn-success push"><i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới</a>
                                        </div>
                                    </div>
                                </div>
                                <table id="thaynhot" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
                                    <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ XE </th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >LOẠI XE </th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ KM CÔNG TƠ CỦ</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ KM CÔNG TƠ MỚI</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ KM THAY NHỚT</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >GHI CHÚ</th>
                                            <th style="width: 80px">CHỨC NĂNG</th>
                                        </tr>
                                    </thead>
                                    <style type="text/css">
                                        tbody:nth-child(odd) {
                                        background: #E9F6FC;
                                            }
                                            tr.even{
                                            background: #FFFFFF;
                                            }
                                    </style>
                                  
                                </table>
                            </div>
                        </div>
                        {{-- THAY VỎ --}}
                        <div class="row">
                            <div class="col-md-12" style="color: #337ab7;font-family: Arial, Helvetica, sans-serif;font-size: 20px; margin-top:30px; margin-bottom:30px;"> DS THAY VỎ </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="container-fluid" style="float: right;margin-bottom: -50px;">
                                        <div class="form-group">
                                            <a href="/tires/create" class="btn btn-success push"><i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới</a>
                                        </div>
                                    </div>
                                </div>
                                <table id="thayvo" class="table table-bordered  dataTable table-hover" role="grid" aria-describedby="example2_info">
                                    <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="width: 10px;">STT</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ XE </th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >LOẠI XE </th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ KM CÔNG TƠ CỦ</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ KM CÔNG TƠ MỚI</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >SỐ KM THAY NHỚT</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" >GHI CHÚ</th>
                                                <th style="width: 80px">CHỨC NĂNG</th>
                                            </tr>
                                    </thead>
                                    <style type="text/css">
                                        tbody:nth-child(odd) {
                                        background: #E9F6FC;
                                            }
                                            tr.even{
                                            background: #FFFFFF;
                                            }
                                    </style>
                                </table>
                            </div>
                        </div>
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
        $(document).ready(function(){
            $('#maintenance').DataTable({
            searching: false,
            "bStateSave": true,
            });
            $('#insurance').DataTable({
            searching: false,
            "bStateSave": true,
            });
            $('#verify').DataTable({
            searching: false,
            "bStateSave": true,
            });
            $('#thaynhot').DataTable({
            searching: false,
            "bStateSave": true,
            });
            $('#thayvo').DataTable({
            searching: false,
            "bStateSave": true,
            });
            $('#fireCertificate').DataTable({
            searching: false,
            "bStateSave": true,
            });
        });
    // DELETE 

    function btnDeleteBD($id){
        swal({
                title: "Xóa bảo dưỡng xe",
                text: "Bạn có chắc chắn muốn xóa Bảo Dưỡng này không ?",
                icon: "warning",
                buttons: {
                    confirm: 'Có',
                    cancel: 'Hủy'
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type : "POST",
                        url : "{{ url('/delete/maintenance') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': $id,
                        },
                        success : function(data)
                        {
                            if(data.success){
                                location.reload();
                            }
                            if(data.errors){
                                swal({
                                    title: "Loại xe này đang được sử dụng.",
                                    icon: "warning",
                                    button: "OK"
                                })
                            }
                            
                        }

                    });
                }
            });
    }
    function btnDeleteBH($id){
        swal({
                title: "Xóa hiểm xe",
                text: "Bạn có chắc chắn muốn xóa Bảo Hiểm này không ?",
                icon: "warning",
                buttons: {
                    confirm: 'Có',
                    cancel: 'Hủy'
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type : "POST",
                        url : "{{ url('/delete/insurance') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': $id,
                        },
                        success : function(data)
                        {
                            if(data.success){
                                location.reload();
                            }
                            if(data.errors){
                                swal({
                                    title: "Loại xe này đang được sử dụng.",
                                    icon: "warning",
                                    button: "OK"
                                })
                            }
                            
                        }

                    });
                }
            });
    }
    function btnDeleteCN($id){
        swal({
                title: "Xóa CN PCCC",
                text: "Bạn có chắc chắn muốn xóa CN PCCC này không ?",
                icon: "warning",
                buttons: {
                    confirm: 'Có',
                    cancel: 'Hủy'
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type : "POST",
                        url : "{{ url('/delete/fire-certificate') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': $id,
                        },
                        success : function(data)
                        {
                            if(data.success){
                                location.reload();
                            }
                            if(data.errors){
                                swal({
                                    title: "Loại xe này đang được sử dụng.",
                                    icon: "warning",
                                    button: "OK"
                                })
                            }
                            
                        }

                    });
                }
            });
    }
    function btnDeleteKD($id){
        swal({
                title: "Xóa KIỂM ĐỊNH",
                text: "Bạn có chắc chắn muốn xóa KIỂM ĐỊNH này không ?",
                icon: "warning",
                buttons: {
                    confirm: 'Có',
                    cancel: 'Hủy'
                },
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type : "POST",
                        url : "{{ url('/delete/verify') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'id': $id,
                        },
                        success : function(data)
                        {
                            if(data.success){
                                
                                location.reload();
                                
                            }
                            if(data.errors){
                                swal({
                                    title: "Loại xe này đang được sử dụng.",
                                    icon: "warning",
                                    button: "OK"
                                })
                            }
                            
                        }

                    });
                }
            });
    }
    </script>
    <script>
        let curentURLString =window.location.href;
        // alert(curentURL);
        let currrentURL = new URL(curentURLString);
        let topId = currrentURL.searchParams.get("top");
        let tableType = currrentURL.searchParams.get("type");
        if(topId && tableType){
            let idScroll = "#"+tableType+"_"+topId;
            // console.log($(idScroll));
                      //  alert( $('body').height());
           // let idScroll = "#editScroll_"+topScroll;  $('body').height() / 2
            $('html,body').animate({
            scrollTop: $(idScroll).offset().top - 200},
            'slow');
        }
        if(!topId && tableType){
            let idScroll = "#"+tableType;
            // console.log($(idScroll));
                      //  alert( $('body').height());
           // let idScroll = "#editScroll_"+topScroll;  $('body').height() / 2
            $('html,body').animate({
            scrollTop: $(idScroll).offset().top - 200},
            'slow');
        }



        /*
          $(document).ready(function(){
   let url_string_scroll =window.location.href;
   let url_scroll = new URL(url_string_scroll);
   let topScroll = url_scroll.searchParams.get("top");
   if(topScroll){
     let idScroll = "#editScroll_"+topScroll;
     $('html,body').animate({
      scrollTop: $(idScroll).offset().top - $('body').height() / 2},
      'slow');
   }
   // alert(topScroll);
   //
 })
*/
        
    </script>

@endsection