@extends('blank')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <!-- <h1>
      Advanced Form Elements
      <small>Preview</small>
    </h1> -->
    <!-- title -->
    <div class="row">
      <div class="col-md-12 titleDieuXe">DANH MỤC {{ App\TitleList::ListTitle('user') }}</div>
    </div>
    <!-- ./ title -->
    <!-- back page -->
    <div class="row">

    </div>
    <!-- ./ back page -->
    <!-- tips -->

  </section>

  <!-- Main content -->
  <section class="content" id="mContent">
    <div class="box box-warning">
      <!-- /.box-header -->
      <div class="box-body boxPadding">
        <form id = "form">
          <div class="row well well-lg">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group col-md-4">
                <select class="form-control" id="txtOffice" name="txtOffice">
                <option id="1" value="1">Admin</option>
                <option id="10" value="10">Nhân viên văn phòng</option>
                <option id="11" value="11">Người liên lạc</option>
                <option id="12" value="12">Tài xế</option>
                <option id="13" value="13">Lơ xe</option>
                <option id="14" value="14">Chủ hàng</option>
                <option id="15" value="15">Người phụ trách</option>
                <option id="16" value="16">Điều phối 1</option>
                <option id="17" value="17">Điều phối 2</option>
                <option id="18" value="18">Văn phòng bãi xe</option>
                </select>
            </div>
            <div class="form-group col-md-4">
              <input type="text" class="form-control" id="txtFullname" placeholder="Họ tên"  name="txtFullname">
            </div>
            <div class="form-group col-md-4">
              <input type="text" class="form-control" id="txtUsername" placeholder="Tên đăng nhập"  name="txtUsername">
            </div>
         <!--  </div>
          <div class="row" -->
          </div>
          <div class="row" style="margin-bottom: 10px">
            <div class="col-md-3">
              <button type="button" class="btn btn-success" value="Thêm mới" id ="btnCreate"><i class="fa fa-plus"></i> Thêm mới</button>


            </div>
            <div class="col-md-9" style="text-align: right;">
              <button class = "btn btn-success" id = "btnSearch"><i class="fa fa-search"></i> Tìm kiếm</button>
              <button class = "btn btn-success" id = "btnReload"><i class="fa fa-refresh" aria-hidden="true"></i> Tất cả</button>
              <!-- <input type="button" class="btn btn-success" value="xx" id="btnxx" > -->
            </div>
          </div>
        </form>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                <table id="tblUser" class="table table-bordered dataTable table-hover no-footer" role="grid" aria-describedby="example2_info">
                  <thead style="background-color: #3C8DBC; color: #FFFFFF">
                    <tr role="row">
                      <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="STT: activate to sort column descending" style="width: 10px;" aria-sort="ascending">STT</th>
                      <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Username
                      : activate to sort column ascending">Tên đăng nhập
                    </th>
                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Họ và tên
                    : activate to sort column ascending">Họ tên
                  </th>
                  <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Tên thường gọi
                  : activate to sort column ascending">Tên thường gọi
                </th>
                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Số điện thoại
                : activate to sort column ascending">Số điện thoại
              </th>
              <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Chức vụ
              : activate to sort column ascending">Chức vụ
            </th>
            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Ghi chú
            : activate to sort column ascending">Ghi chú
            </th>
    <th style="width: 30px" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Chức năng: activate to sort column ascending">Chức năng</th>
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
<tbody id="tbodyUser"> 
  <!-- row data appened here -->
</tbody>
</table>
</div>
</div>

</div>

</div>
</div>
</div>
</div>

<!-- /.box-body -->
<div class="box-footer">

</div>
</div>
<!-- /.box -->
</section>
<!-- /.content -->
<script src = "{{asset('js/user.js')}}"></script>
@endsection