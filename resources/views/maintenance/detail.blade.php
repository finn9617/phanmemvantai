@extends('blank')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="row">
        <div class="col-md-12 titleDieuXe"> CHI TIẾT BẢO DƯỠNG XE  </div>
    </div>
    <div class="row">
        <div class="col-md-12 prePage">
        <a href="{{ route('showM') }}" onclick="back()" class="" id="back">
                <span class="glyphicon glyphicon-step-backward">
                    <span class="prePage">DANH SÁCH BẢO DƯỠNG </span>
                </span>
            </a>
        </div>
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning col-md-11">
                <div class="row">
                    <div class="container-fluid" style="margin-top:3rem;">
                        <div class="form-group" style="display: inline;">
                        <a href="{{ url('/maintenance/createItemDeail/'.$id) }}" class="btn btn-success push"><i class="fa fa-plus"></i>&nbsp;&nbsp;Thêm mới chi tiết bảo dưỡng</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="color: #337ab7;font-family: Arial, Helvetica, sans-serif;font-size: 20px; margin-top:30px; margin-bottom:30px;"> CÔNG VIỆC </div>
                    <div class="row" style="margin:1em;">
                        <div class="col-xs-6 col-sm-4 col-md-2" style="font-size:20px; font-weight:400;width:137px;">Thành Tiền:</div>
                        <div class="col-xs-6 col-sm-8 col-md-10" style="font-size:20px; font-weight:400;"><strong>(A) @if($sumjob[0]->pr) {{ number_format($sumjob[0]->pr) }}  @endif</strong>
                    </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="job" class="table table-bordered dataTable table-hover no-footer" role="grid" aria-describedby="example2_info">
                                <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                    <tr role="row">
                                        <th class="sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="STT: activate to sort column ascending" style="width: 10px;" aria-sort="descending">STT</th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Bộ dụng cụ
                                : activate to sort column ascending">TÊN CÔNG VIỆC
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Loại dụng cụ
                                : activate to sort column ascending">ĐƠN GIÁ
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                : activate to sort column ascending">GIẢM GIÁ (%)
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                    : activate to sort column ascending">THÀNH TIỀN
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                    : activate to sort column ascending">THUẾ (%)
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                    : activate to sort column ascending">GHI CHÚ
                                        </th>
                                        <th style="width: 80px">CHỨC NĂNG</th>
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
                                    <?php $i = 0; ?>
                                    @foreach($job as $j)
                                    <tr>
                                        <?php $i++ ?>
                                        <td>{{ $i }}</td>
                                        <td>{{ $j->job_name }}</td>
                                        <td>{{ number_format($j->unitprice) }}</td>
                                        <td>{{ $j->sale }}</td>
                                        <td>{{ number_format($j->price) }}</td>
                                        <td>{{ $j->tax }}</td>
                                        <td>{{ $j->note }}</td>
                                        <td style="width: 80px">
                                            <a class="edit" title="Sửa" href="/Deail/edit/{{$j->job_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                            <a class="delete" href="#" type="button" onclick="btnDeleteJob({{$j->job_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            
                            </table>
                        </div>
                    </div>
                
                <div class="row">
                    <div class="col-md-12" style="color: #337ab7;font-family: Arial, Helvetica, sans-serif;font-size: 20px; margin-top:30px; margin-bottom:30px;"> VẬT TƯ/ PHỤ TÙNG </div>
                        <div class="row" style="margin:1em;">
                            <div class="col-xs-6 col-sm-4 col-md-2" style="font-size:20px; font-weight:400;width:137px;">Thành Tiền:</div>
                            <div class="col-xs-6 col-sm-8 col-md-10" style="font-size:20px; font-weight:400;"><strong> (B) @if($sumaccessary[0]->pr) {{ number_format($sumaccessary[0]->pr) }}  @endif </strong>  </div>
                        </div>  
                        <div class="col-md-12" style="padding-right: 30px; padding-left: 30px;">
                            <div class="table-responsive" >
                                <table id="accesary" class="table table-bordered dataTable table-hover no-footer" role="grid" aria-describedby="example2_info">
                                    <thead style="background-color: #3C8DBC; color: #FFFFFF">
                                        <tr role="row">
                                            <th class="sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="STT: activate to sort column ascending" style="width: 10px;" aria-sort="descending">STT</th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Bộ dụng cụ
                                    : activate to sort column ascending">TÊN PHỤ TÙNG
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Loại dụng cụ
                                    : activate to sort column ascending">SL
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Loại dụng cụ
                                    : activate to sort column ascending">Đ/V
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Loại dụng cụ
                                    : activate to sort column ascending">ĐƠN GIÁ
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                    : activate to sort column ascending">GIẢM GIÁ
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                        : activate to sort column ascending">THÀNH TIỀN
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                        : activate to sort column ascending">THUẾ (%)
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
                                                        : activate to sort column ascending">GHI CHÚ
                                            </th>
                                            <th style="width: 80px">CHỨC NĂNG</th>
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
                                        <?php $i= 0; $thue=0?>
                                            @foreach( $accessary as $a )
                                            <tr>
                                            <?php $i++; ?>
                                            <td>{{ $i }}</td>
                                            <td>{{ $a->accessary_name }}</td>
                                            <td>{{ $a->num }}</td>
                                            <td>{{ $a->unit }}</td>
                                            <td>{{ number_format($a->unitprice) }}</td>
                                            <td>{{ $a->sale }}</td>
                                            <td>{{ number_format($a->price) }}</td>
                                            <td>{{ $a->tax }} <?php $thue=$a->tax?></td>
                                            <td>{{ $a->note }}</td>
                                            <td style="width: 80px">
                                                <a class="edit" title="Sửa" href=" /Deail1/edit/{{$a->m_accessaty_id}}"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;&nbsp;&nbsp;
                                                <a class="delete" href="#" type="button" onclick="btnDeleteAc({{$a->m_accessaty_id}})" title="Xóa" ><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;&nbsp;
                                            </td>
                                        </tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <h2>Chi phí bảo dưỡng</h2>
                    <div class="" style="font-size:20px; font-weight:400; margin-right:3rem;">Chi phí sau giảm giá (A+B): <strong><?php $sum =($sumjob[0]->pr )+($sumaccessary[0]->pr ) ?>{{ number_format($sum) }}</strong></div>
                        <div class="" style="font-size:20px; font-weight:400; margin-right:3rem;">Thuế (VAT): <strong><?php $thue= $thue/100; $thue = $sum * $thue ?> {{number_format($thue)}} </strong></div>
                        <div class="" style="font-size:20px; font-weight:400; margin-right:3rem;">Tổng cộng: <strong> {{ number_format($sum + $thue )}} </strong></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<!-- /.content -->
<!-- ==================================================================  JAVASCRIPT ====================================================== -->
<script>
  


    // function add option to selectBox
  /*
    select: where add option (.class or id of selectbox)
    options : array[{'value':'Value of option' , 'text': 'text display'}]
    */
    function addOptionSelectBox(select, options, colValue, colText){
      $.each(options, function (i, item) {
      // var lol = ''+colValue;
      // console.log(item[lol]);
      $(select).append($('<option>', { 
        value: item[colValue],
        text :  item[colText]
      }));
    });
    }

  // function search a element in array
  /*
    value : value search
    arr : array search
    filterCol: column of array
    => return undefined if array is empty or can't find
    */
    function arrSearch(value, arr, filterCol){
    // console.log(arr.length);
    if(arr.length == 0)
      return undefined;
    else{
      if(arr.length == 1){
        return arr[0];
      }
      for(var cArr = 0 ; cArr < arr.length; cArr++)
      {
        if(arr[cArr][filterCol] == value)
          return arr[cArr];
      }
    }
    return undefined;
  }
  // function lọc mảng con
  // duyệt mảng cha lọc ra mảng con theo điều kiện
  //value = id loOẠI cần lấy ra 1
  // arr : mảng tất cả các xe
  // filterCol : trường trong mảng xe cần so sánh
  // 
  function arrFilter(value, arr, filterCol){
    //alert('xxx');
    var chilArrayFilter =[];
    if(arr.length == 0)
      return undefined;
    if(arr.length == 1){
      if(arr[0][filterCol] == value){
        chilArrayFilter.push(arr[0]);
      }else{
        return undefined;
      }
    }
    if(arr.length > 1){
      for(var cArrFilter = 0 ; cArrFilter < arr.length; cArrFilter++){
        if(arr[cArrFilter][filterCol] == value){
          chilArrayFilter.push(arr[cArrFilter]);
        }
      }
    }
    if(chilArrayFilter.length == 0)
      return undefined;
    else
      return chilArrayFilter;

  }

     //call ajax to get car data
  var resData;
  var operating ;


    $.ajax('{{url("maintenance/getCardata")}}', {
      type: 'GET',  
      data: {},
      dataType:"json",
      async: false,
      success: function (result) {
        if(result.success)
        {
          resData = result.success;

       }else{
        swal("Lỗi", "Không tìm thấy !", "error");
      } 
    }

  });
  //add options to selLoaiXe
  addOptionSelectBox('#selLoaixe', resData['carTypes'], 'car_type_id', 'name');
  addOptionSelectBox('#selSoxe', resData['cars'], 'car_id', 'car_num');
  addOptionSelectBox('#selLoaixe', resData['trailerType'], 'trailer_type_id', 'trailer_type_name');
  addOptionSelectBox('#selSoxe', resData['trailer'], 'trailer_id', 'trailer_num');

    $('#selLoaixe').on('change', function() {
        $("#selSoxe option[value!='']").each(function() {
        $(this).remove();
        });

        // using arrFilter() to get car by car type
        let carOptions = arrFilter(this.value, resData['cars'],'car_type_id');
        addOptionSelectBox('#selSoxe', carOptions, 'car_id', 'car_num');
        let carOptions1 = arrFilter(this.value, resData['trailer'],'trailer_type_id');
        addOptionSelectBox('#selSoxe', carOptions1, 'trailer_id', 'trailer_num');
    });

   </script>

   <script>
    $(function () {
  //Initialize Select2 Elements
  $('.select2').select2(
  {
      // placeholder: "Assign to:",
      allowClear: true
    }
    )

})
</script>

<script>
	$(function () {
		$('#accesary').DataTable( {
			// "bLengthChange": false,
			'searching'   : false,
			"bStateSave": true, // presumably saves state for reloads
			// "bInfo": false,
		});
	})

    $(function () {
		$('#job').DataTable( {
			// "bLengthChange": false,
			'searching'   : false,
			"bStateSave": true, // presumably saves state for reloads
			// "bInfo": false,
		});
	})

 	function btnDeleteJob(id){
		swal({
				title: "Xóa Công việc",
				text: "Bạn có chắc chắn muốn xóa CÔNG VIỆC này không ?",
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
						url : "{{ url('/Deail/delete') }}",
						data: {
							'_token': "{{ csrf_token() }}",
							'id': id,
						},
						success : function(data)
						{
              if(data.success){
                location.reload();
                }
						}
					});
				}
			});
	}
    function btnDeleteAc(id){
        swal({
				title: "Xóa Phụ Tùng ",
				text: "Bạn có chắc chắn muốn xóa PHỤ TÙNG này không ?",
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
						url : "{{ url('/Deail1/delete') }}",
						data: {
							'_token': "{{ csrf_token() }}",
							'id': id,
						},
						success : function(data)
						{
              if(data.success){
                location.reload();
                }
						}
					});
				}
			});
	}
</script>
@endsection