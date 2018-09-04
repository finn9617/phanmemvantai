<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
class placeController extends Controller
{
    
	public function itemDetail($id) {
		$loadplace = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.place_id','=',$id)->get();
		return view('place.UpdatePlace',compact('loadplace'));
	}

	public function createItem() {
		
		return view('place.CreatePlace');
	}

	public static function getloaihinh ($table,$total_column){
		switch ($table->place_type) {
			case 0:
			$table->place_type = "Nơi nhận";
				break;
			case 1:
			$table->place_type = "Nơi giao";
				break;
				
			default:
				# code...
				$table->place_type = "";
				break;
		}
		return $table;
	}

	public function getplace() {
		require_once "LibForm.php";
		$rule = (object)[
			//URL TƯƠNG ỨNG VỚI QUY ĐỊNH {url} TRONG ROUTE
			'url' => 'noigiaonhan',
			//CHỌN CỘT DỮ LIỆU CẦN HIỂN THỊ, TÊN CỘT TRÙNG VỚI TÊN CỘT TRONG DB
			'column' =>
			[
				'name',
				'place_type',
				'address',
                'contact_note',
                'warehouse_note'
			],
			//INDEX CỦA MỖI CỘT TƯƠNG ỨNG
			'column_show' =>
			 [
				'Tên',
				'Loại hình',
				'Địa chỉ',
                'Liên lạc',
                'Ghi chú'
            ],
			//CHỌN TABLE CẦN XỬ LÝ
			'tableName' => 'tbl_receipt_delivery_place',
			//TITLE HIỂN THỊ
			'title' => 'NƠI GIAO NHẬN',
			//SỐ DÒNG SỮ LIỆU HIỂN THỊ TRONG 1 TRANG
			'pag' => 20,
			//SỐ FIELD CẦN TÌM
			'numfield' => 3,
			//CHỌN FIELD CẦN TÌM KIẾM
			'searchfield' => [
				'name',
				'address',
				'contact_note'
                
			],
			'searchfieldindex'=>[
				'tên',
				'địa chỉ',
				'liên lạc'
			],
			//
			//TÊN KHÓA CHÍNH CỦA BẢNG
			'idtable' => 'place_id',
			'datajoin'=>null
			
		];
		//echo "<pre>";
		//print_r($rule['datajoin']);exit();
		list($url, $columns, $column_show, $table, $table_all, $title, $total_column, $total_row, $row_all,$numfield, $searchfield,$searchfieldindex, $idtable,$html) = LibForm::drawTableconfig($rule);

		$place = DB::table('tbl_receipt_delivery_place')->get()->toArray();
		$data = (object)[
			'place' => $place,
		];

		for ($i=0; $i < count($table); $i++) { 
			$table[$i]= placeController::getloaihinh($table[$i],$total_column);
		}
		for ($i=0; $i < count($table_all); $i++) { 
			$table_all[$i]= placeController::getloaihinh($table_all[$i],$total_column);
		}
		return view('table', compact('url', 'columns', 'column_show', 'table', 'table_all', 'title', 'total_column', 'total_row', 'row_all','numfield', 'searchfield','searchfieldindex', 'idtable','html','data'));
	}

	public function postcreateItem(Request $req){
		$validator = validator::make($req->all(),[
			'selLoaihinh' => 'between:0,1',
			'txtTenkho' => 'required',
			'txtDiachi' => 'required',
			'txtInfokho' => 'required',
			'txtInfonguoilh' => 'required',
		],[
			'selLoaihinh.between:0,1' =>'Loại hình không hợp lệ',
			'txtTenkho.required' =>'Tên địa điểm không được bỏ trống', 
			'txtDiachi.required' => 'Địa chỉ không được bỏ trống',
			'txtInfokho.required' => 'Thông tin kho không được bỏ trống',
			'txtInfonguoilh.required' => 'Thông tin người liên hệ không được bỏ trống',

		]);
		if($validator->passes()){
			$ins = DB::table('tbl_receipt_delivery_place')->insert([
				'place_type' =>$req->selLoaihinh,
				'name' => $req->txtTenkho,
				'address' => $req->txtDiachi,
				'contact_note' =>$req->txtInfonguoilh,
				'warehouse_note'=> $req->txtInfokho
			]);
			
			return redirect('/noigiaonhan');
		}
		return redirect('/noigiaonhan/create')->withErrors($validator);

	}

	public function update(Request $req, $id){
		$validator = validator::make($req->all(),[
			'selLoaihinh' => 'between:0,1',
			'txtTenkho' => 'required',
			'txtDiachi' => 'required',
			'txtInfokho' => 'required',
			'txtInfonguoilh' => 'required',
		],[
			'selLoaihinh.between:0,1' =>'Loại hình không hợp lệ',
			'txtTenkho.required' =>'Tên địa điểm không được bỏ trống', 
			'txtDiachi.required' => 'Địa chỉ không được bỏ trống',
			'txtInfokho.required' => 'Thông tin kho không được bỏ trống',
			'txtInfonguoilh.required' => 'Thông tin người liên hệ không được bỏ trống',
		]);
		if($validator->passes()){
			$upd = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.place_id','=',$id)->update([
				'place_type' =>$req->selLoaihinh,
				'name' => $req->txtTenkho,
				'address' => $req->txtDiachi,
				'contact_note' =>$req->txtInfonguoilh,
				'warehouse_note'=> $req->txtInfokho
			]);
			return redirect('/noigiaonhan');
		}
		return redirect()->back()->withErrors($validator);
	}

	public function search(Request $req) {
		require_once "LibForm.php";
		$rule = (object)[
			//URL TƯƠNG ỨNG VỚI QUY ĐỊNH {url} TRONG ROUTE
			'url' => 'noigiaonhan',
			//CHỌN CỘT DỮ LIỆU CẦN HIỂN THỊ, TÊN CỘT TRÙNG VỚI TÊN CỘT TRONG DB
			'column' =>
			[
				'name',
				'place_type',
				'address',
                'contact_note',
                'warehouse_note'
			],
			//INDEX CỦA MỖI CỘT TƯƠNG ỨNG
			'column_show' =>
			 [
				'Tên',
				'Loại hình',
				'Địa chỉ',
                'Liên lạc',
                'Ghi chú'
            ],
			//CHỌN TABLE CẦN XỬ LÝ
			'tableName' => 'tbl_receipt_delivery_place',
			//TITLE HIỂN THỊ
			'title' => 'NƠI GIAO NHẬN',
			//SỐ DÒNG SỮ LIỆU HIỂN THỊ TRONG 1 TRANG
			'pag' => 20,
			//SỐ FIELD CẦN TÌM
			'numfield' => 3,
			//CHỌN FIELD CẦN TÌM KIẾM
			'searchfield' => [
				'name',
				'address',
				'contact_note'
                
			],
			'searchfieldindex'=>[
				'tên',
				'địa chỉ',
				'liên lạc'
			],
			//
			//TÊN KHÓA CHÍNH CỦA BẢNG
			'idtable' => 'place_id',
			'datajoin'=>null
			
		];
		//echo "<pre>";
		//print_r($rule['datajoin']);exit();
		list($url, $columns, $column_show, $table, $table_all, $title, $total_column, $total_row, $row_all,$numfield, $searchfield,$searchfieldindex, $idtable,$html) = LibForm::drawTableconfig($rule);

		$place = DB::table('tbl_receipt_delivery_place')->get()->toArray();
		$data = (object)[
			'place' => $place,
		];
		if(!empty($req->noigiaonhan_name)){
			$table = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.name','LIKE','%'.$req->noigiaonhan_name.'%')->where('tbl_receipt_delivery_place.address','LIKE','%'.$req->noigiaonhan_address)->where('tbl_receipt_delivery_place.contact_note','LIKE','%'.$req->noigiaonhan_contact_note)->paginate(20);	
		}
		else if(!empty($req->noigiaonhan_address)){
			$table = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.address','LIKE','%'.$req->noigiaonhan_addrees)->where('tbl_receipt_delivery_place.contact_note','LIKE','%'.$req->noigiaonhan_contact_note)->paginate(20);	
		}
		else if(!empty($req->noigiaonhan_contact_note)){
			$table = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.contact_note','LIKE','%'.$req->noigiaonhan_contact_note)->paginate(20);
		}
		$total_row = count($table);
		for ($i=0; $i < count($table); $i++) { 
			$table[$i]= placeController::getloaihinh($table[$i],$total_column);
		}
		for ($i=0; $i < count($table_all); $i++) { 
			$table_all[$i]= placeController::getloaihinh($table_all[$i],$total_column);
		}
		return view('table', compact('url', 'columns', 'column_show', 'table', 'table_all', 'title', 'total_column', 'total_row', 'row_all','numfield', 'searchfield','searchfieldindex', 'idtable','html','data'));
	}

	public function del($id) {
		require_once "LibForm.php";
		//TÊN TABLE
		$tableName = 'tbl_receipt_delivery_place';
		//TÊN KHÓA CHÍNH CỦA TABLE
		$idtable = 'place_id';
		LibForm::delete($tableName, $idtable, $id);
		return redirect()->back();
	}

}