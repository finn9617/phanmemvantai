<div class="box-body">
	<div class="row" style="margin-bottom: 20px;">
		<div class="col-md-12">
			<button class="btn btn-success pull-right" style="margin-left: 30px;"><i class="fa fa-check"></i>&nbsp;&nbsp;In lệnh</button>
			<button class="btn btn-success pull-right" style="margin-right: 30px;"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Xuất Excel</button>
		</div>
	</div>
	<div class="table-responsive">
		<table id="lenhtong" class="table">
			<thead>
				<tr role="row">
					<th style="min-width: 10px;" rowspan="2" class="dieuphoi">STT</th>
					<th class="cb dieuphoi" style="min-width: 43px;" rowspan="2">
						<label class="container-header">
							<!-- <input type="checkbox">  -->
							<input type="checkbox" id="checkall">
							<span class="checkmark1"></span>
						</label>
					</th>
					{{-- ĐIỀU PHỐI --}}
					@if($currentUser_type == 1 || $currentUser_type == 2 || $currentUser_type == 3)
						@foreach($showcol1 as $key => $value)
							@if($value == "rowspan")
								<th style="min-width: 150px;" rowspan="2" class="bangke">{{ $key }}</th>
							@else
								<th style="min-width: 300px;" colspan="{{ $value }}" class="bangke">{{ $key }}</th>
							@endif
						@endforeach
					@endif
					{{-- ĐIỀU PHỐI --}} 

					{{-- CHI PHÍ --}} 
					@if($currentUser_type == 1 || $currentUser_type == 4)
					<th style="min-width: 150px;" rowspan="2" class="chiphi">Đầu ngày</th>
					<th style="min-width: 150px;" rowspan="2" class="chiphi">Ứng</th>
					<th style="min-width: 300px;" colspan="2" class="chiphi">
						VÉ CẦU ĐƯỜNG
					</th>
					<th style="min-width: 150px;" class="chiphi">Tổng tiền</th>
					<th style="min-width: 150px;" rowspan="2" class="chiphi">Xịt bồn (Rửa xe)</th>
					<th style="min-width: 150px;" rowspan="2" class="chiphi">Vá vỏ</th>
					<th style="min-width: 150px;" rowspan="2" class="chiphi">Người duyệt</th>
					<th style="min-width: 300px;" colspan="2" class="chiphi">
						BỒI DƯỠNG, BƠM HÀNG
					</th>
					<th style="min-width: 150px;" class="chiphi">Tổng tiền</th>
					<th style="min-width: 150px;" rowspan="2" class="chiphi">Người duyệt</th>
					<th style="min-width: 300px;" colspan="2" class="chiphi">
						CHI HỘ
					</th>
					<th style="min-width: 150px;" class="chiphi">Tổng tiền</th>
					<th style="min-width: 300px;" colspan="2" class="chiphi">
						CÁC TRẠM
					</th>
					<th style="min-width: 150px;" class="chiphi">Tổng tiền</th>
					<th style="min-width: 150px;" rowspan="2" class="chiphi">Cơm Tài
					</th>
					<th style="min-width: 150px;" rowspan="2" class="chiphi">Cơm Lơ
					</th>
					<th style="min-width: 150px;" rowspan="2" class="chiphi">Đổ Dầu ngoài
					</th>
					<th style="min-width: 300px;" colspan="2" class="chiphi">
						CHI KHÁC
					</th>
					<th style="min-width: 150px;" class="chiphi">Tổng tiền</th>
					<th style="min-width: 150px;" rowspan="2" class="chiphi">TỔNG CHI
					</th>
					<th style="min-width: 150px;" rowspan="2" class="chiphi">CUỐI NGÀY
					</th>
					<th style="min-width: 300px;" rowspan="2" class="chiphi">GHI CHÚ
					</th>
					@endif 
					{{-- CHI PHÍ --}} 
					
					{{-- LƯƠNG --}} 
					@if($currentUser_type == 1 || $currentUser_type == 5)
					<th style="min-width: 150px;" rowspan="2" class="luong">SỐ LƯỢNG QUY ĐỔI
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">MÃ NHÓM SỐ LƯỢNG
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">TÀI XẾ
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">LƠ
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">CỰ LY
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">SỐ KM
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">MÃ TÍNH LƯƠNG
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">LƯƠNG TÀI
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">LƯƠNG LƠ
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">CƠM TÀI
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">CƠM LƠ
					</th>
					<th style="min-width: 300px;" rowspan="2" class="luong">NƠI NHẬN ĐẾN NƠI GIAO
					</th>
					<th style="min-width: 150px;" rowspan="2" class="luong">NGHỈ PHÉP
					</th>
					@endif {{-- LƯƠNG --}}
					<th style="min-width: 150px;" rowspan="2" class="bangke">Chức năng</th>
				</tr>
				<tr>
					{{--  @if($currentUser_type == 1 || $currentUser_type == 2 || $currentUser_type == 3) 
					<th class="bangke">Diễn giải</th>
					<th class="bangke">Số tiền</th>
					@endif  --}}
					@if($currentUser_type == 1 || $currentUser_type == 2 || $currentUser_type == 3)
						@if($showcol2)
							@foreach($showcol2 as $key => $value)
								<th class="bangke">{{ $value }}</th>
							@endforeach
						@endif
					@endif 
					@if($currentUser_type == 1 || $currentUser_type == 4) {{-- LƯƠNG --}}
					<th class="chiphi">Diễn giải</th>
					<th class="chiphi">Số tiền</th>
					<th class="chiphi">Tổng tiền</th>

					<th class="chiphi">Diễn giải</th>
					<th class="chiphi">Số tiền</th>
					<th class="chiphi">Tổng tiền</th>

					<th class="chiphi">Diễn giải</th>
					<th class="chiphi">Số tiền</th>
					<th class="chiphi">Tổng tiền</th>

					<th class="chiphi">Diễn giải</th>
					<th class="chiphi">Số tiền</th>
					<th class="chiphi">Tổng tiền</th>

					<th class="chiphi">Diễn giải</th>
					<th class="chiphi">Số tiền</th>
					<th class="chiphi">Tổng tiền</th>
					@endif
				</tr>
			</thead>
			<tbody style="border: none;" class="index">
				@foreach($dieuphoi as $key => $value)
				<tr>
					<td>{{ $loop->index+1 }}</td>
					<td>
						<label class="container-header">
							<!-- <input type="checkbox">  -->
							<input type="checkbox" id="checkall">
							<span class="checkmark1"></span>
						</label>
					</td>
					@foreach($colnamefor as $key2 => $value2)
						<td @if($value2 == '1') contenteditable @endif>
							{{ $value->$key2 }}
						</td>
					@endforeach
					<td><a class="delete" href="#" onclick="btnDelete('244')" title="Xóa"><i class="glyphicon glyphicon-check"></i></a></td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>