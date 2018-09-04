<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Phần Mềm Vận Tải Quốc Huy</title>
    <link rel="shortcut icon" type="../image/x-icon" href="img/web/LogoQuocHuy.png" />
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ url('libs/bootstrap/dist/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->

    <link rel="stylesheet" href="{{ url('libs/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ url('libs/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->

    <!-- style LTE -->
    <link rel="stylesheet" href="{{ url('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ url('css/skins/_all-skins.css')}}">
    <!-- item List style -->
    <!-- Data table -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js">
    <!-- DieuXe style -->
    <link rel="stylesheet" href="{{ url('css/DieuXe.css')}}">
    <link rel="stylesheet" href="{{ url('css/lenhtong.css')}}">

    	<style type="text/css">
            /* .container1{
                min-height: 1122px/2;
            } */
            .borderless td, .borderless th {
                border: none !important;
            }

             .required {
            color: red;
        }
            @media print {
                html, body {
                    width: 210mm;
                    height: 297mm;        
                }
            }
            @page {
                size: A4;
                margin: 0;
                padding:0;
                
             }
        
             
        </style>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


    <!-- jQuery 3 -->
    <script src="{{ url('libs/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ url('libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>


    <script src="{{ url('libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ url('libs/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>

</head>

<body>
    <div class="container">
        <section class="content">

            <div style="text-align: center;color:#0528a9; font-size:20px">DANH SÁCH XE GẦN HẾT HẠN</div>
            <div class="box box-primary">
                <!-- /.box-header -->
                <div class="box-body">

                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                        <div class="row">
                            <div class="col-sm-6"></div>
                            <div class="col-sm-6"></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example2" class="table table-bordered dataTable table-hover no-footer" role="grid" aria-describedby="example2_info">
                                    <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                        <tr role="row">
                                            <th class="sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="STT: activate to sort column ascending" style="width: 10px;" aria-sort="descending">STT</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Bộ dụng cụ
                                            : activate to sort column ascending">Số xe
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Loại dụng cụ
                                            : activate to sort column ascending">Loại xe
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                            : activate to sort column ascending">Số phiếu PCCC
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                        : activate to sort column ascending">Ngày đăng ký 
                                                        </th>
                                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                                : activate to sort column ascending">Ngày hết hạn 
                                                        </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                                : activate to sort column ascending">Số ngày còn lại
                                            </th>
                                        </tr>
                                    </thead>
                                    <style type="text/css">
                                        tbody:nth-child(odd) {
                                            background: #E9F6FC;
                                        }
                                        
                                        tr.even {
                                            background: #FFFFFF;
                                        }
                                    </style>
                                    <tbody>
                                            <?php $stt = 1;?>
                                            @foreach($fireCertificate as $bh)
                                                <?php
                                                    $date1=date_create(date('Y-m-d'));
                                                    $date2=date_create($bh->expiration_date);
                                                    $diff=date_diff($date1,$date2);
                                                ?>
                                            @if($diff->format("%R") === '-' || $diff->format("%R%a") === '+7' || intval($diff->format("%a")) <= 7 )
                                                <tr>
                                                <td><?php echo $stt; $stt++;?></td>
                                                <td>{{$bh->car_num}}</td>
                                                <td>{{$bh->name}}</td> 
                                                <td>{{$bh->votes}}</td> 
                                                <td> <?php   echo date_format(  date_create($bh->register_date) , 'd/m/Y'); ?></td> 
                                                <td> <?php   echo date_format(  date_create($bh->expiration_date) , 'd/m/Y'); ?></td> 
                                                <td>
                                                    <?php
                                                        if($diff->format("%R") === '-')
                                                            echo '<span style="color:red;">ĐÃ HẾT HẠN</span>';
                                                        else if(intval($diff->format("%a")) <= 7)
                                                         echo '<span style="color:#f39c12;">CÒN '.$diff->format("%d").' NGÀY NỮA HẾT HẠN</span>';
                                                        ?>
                                                    </td> 
                                                </tr>
                                            @endif
                                            @endforeach
                                    </tbody>
                                </table>
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
    </div>
    <!-- /.modal-content -->
    </div>
</body>
<script>
    function delete1() {
        swal({
                title: "Xác nhận xóa số km vỏ xe này !",
                text: "Bạn có chắc chắn xóa ?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Bạn đã xóa thành công !", {
                        icon: "success",
                    });
                }
            });
    }

    setTimeout(window.print(), 5000);
    // tắc in
    window.onafterprint = window.close();
</script>

</html>

</html>