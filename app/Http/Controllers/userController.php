<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use Session;

class userController extends Controller
{
	public static function getchucvu ($table,$total_column){
			switch ($table->user_type) {
				case 1:
					$table->user_type = "Admin";
					break;
					case 10:
					$table->user_type = "NVVP";
					break;
					case 11:
					$table->user_type = "Người liên lạc";
					break;
					case 12:
					$table->user_type = "Tài xế";
					break;
					case 13:
					$table->user_type = "Lơ xe";
					break;
					case 14:
					$table->user_type = "Chủ hàng";
					break;
					case 15:
					$table->user_type = "Người phụ trách";
					break;
					case 16:
					$table->user_type = "Điều phối 1";
					break;
					case 17:
					$table->user_type = "ĐIều phối 2";
					break;
					case 18:
					$table->user_type = "Văn phòng bãi xe";
					break;
				default:
					# code...
					$table->user_type = "Admin";
					break;
			}
			return $table;
	}

	public function getuser() {
		require_once "LibForm.php";
		$rule = (object)[
			//URL TƯƠNGỨNG VỚI QUY ĐỊNH {url} TRONG ROUTE
			'url' => 'user',
			//CHỌN CỘT DỮ LIỆU CẦN HIỂN THỊ, TÊN CỘT TRÙNG VỚI TÊN CỘT TRONG DB
			'column' =>
			[
				'user_name',
				'full_name',
				'nick_name',
				'phone',
				'user_type',
				'note'
			],
			//INDEX CỦA MỖI CỘT TƯƠNG ỨNG
			'column_show' => [
				'Username',
				'Họ và tên',
				'Tên thường gọi',
				'Số điện thoại',
				'Chức vụ',
                'Ghi chú'
            ],
			//CHỌN TABLE CẦN XỬ LÝ
			'tableName' => 'tbl_user',
			//TITLE HIỂN THỊ
			'title' => 'NGƯỜI DÙNG',
			//SỐ DÒNG SỮ LIỆU HIỂN THỊ TRONG 1 TRANG
			'pag' => 20,
			//SỐ FIELD CẦN TÌM
			'numfield' => 3,
			//FIELD CẦN TÌM KIẾM
			'searchfield' => [
				'user_type',
				'full_name',
				'user_name',	
			],
			//INDEX FIELD TIM KIEM
			'searchfieldindex'=>[
				'chức vụ',
				'tên',
				'username'
			],

			//TÊN KHÓA CHÍNH CỦA BẢNG
			'idtable' => 'user_id',
			
		];
		//echo "<pre>";
		//print_r($rule['column']);exit();
		list($url, $columns, $column_show, $table, $table_all, $title, $total_column, $total_row, $row_all,$numfield, $searchfield,$searchfieldindex, $idtable,$html) = LibForm::drawTableconfig($rule);
		//echo "<pre>";
		$user = DB::table('tbl_user')->select('user_id','user_type','user_name','full_name')->get()->toArray();
		// $user = DB::select('SELECT DISTINCT user_type, user_id,user_name,full_name FORM tbl_user')->get()->toArray();
		$data = (object)[
			'user' => $user,
		];
		// $table_all = DB::table('tbl_user')->groupby('user_type')->get();
		// $row_all = count($table_all);
		// print_r($data);exit;
		for ($i=0; $i < count($table); $i++) { 
			$table[$i]= userController::getchucvu($table[$i],$total_column);
		}
		for ($i=0; $i < count($table_all); $i++) { 
			$table_all[$i]= userController::getchucvu($table_all[$i],$total_column);
		}
		//echo "<pre>";print_r($table);exit();
		return view('table', compact('url', 'columns', 'column_show', 'table', 'table_all', 'title', 'total_column', 'total_row', 'row_all','numfield', 'searchfield','searchfieldindex', 'idtable','html','data'));
	}
	//Start search user 
	public function search(Request $req) {
		// print_r($req->user_full_name);exit;
		require_once "LibForm.php";
		$rule = (object)[
			//URL TƯƠNGỨNG VỚI QUY ĐỊNH {url} TRONG ROUTE
			'url' => 'user',
			//CHỌN CỘT DỮ LIỆU CẦN HIỂN THỊ, TÊN CỘT TRÙNG VỚI TÊN CỘT TRONG DB
			'column' =>
			[
				'user_name',
				'full_name',
				'user_type',
				'note'
			],
			//INDEX CỦA MỖI CỘT TƯƠNG ỨNG
			'column_show' => [
				'Username',
				'Họ và tên',
				'Chức vụ',
                'Ghi chú'
            ],
			//CHỌN TABLE CẦN XỬ LÝ
			'tableName' => 'tbl_user',
			//TITLE HIỂN THỊ
			'title' => 'NGƯỜI DÙNG',
			//SỐ DÒNG SỮ LIỆU HIỂN THỊ TRONG 1 TRANG
			'pag' => 20,
			//SỐ FIELD CẦN TÌM
			'numfield' => 3,
			//FIELD CẦN TÌM KIẾM
			'searchfield' => [
				'user_type',
				'full_name',
				'user_name',	
			],
			//INDEX FIELD TIM KIEM
			'searchfieldindex'=>[
				'chức vụ',
				'tên',
				'username',	
			],
			//TÊN KHÓA CHÍNH CỦA BẢNG
			'idtable' => 'user_id',
			
		];
		//echo "<pre>";
		//print_r($rule['column']);exit();
		list($url, $columns, $column_show, $table, $table_all, $title, $total_column, $total_row, $row_all,$numfield, $searchfield,$searchfieldindex, $idtable,$html) = LibForm::drawTableconfig($rule);
		//bộ lọc tìm kiếm không sử dụng crud
		if(!empty($req->user_user_type)){
			$type = "";
			switch ($req->user_user_type) {
				case "Admin":
					$type= 1;
					break;
					case "NVVP":
					$type = 10;
					break;
					case "Người liên lạc":
					$type = 11;
					break;
					case "Tài xế":
					$type= 12;
					break;
					case "Lơ xe":
					$type = 13; 
					break;
					case "Chủ hàng":
					$type = 14;
					break;
					case "Người phụ trách":
					$type = 15;
					break;
					case "Điều phối 1":
					$type = 16;
					break;
					case "Điều phối 2":
					$type = 17;
					break;
					case "Văn phòng bãi xe":
					$type = 18;
					break;
				default:
					# code...
					$type = 10;
					break;
			}
			// print_r($type);exit;
			$table = DB::table('tbl_user')->where('tbl_user.user_type','=',$type)->where('tbl_user.full_name','LIKE','%'.$req->user_full_name.'%')->where('tbl_user.user_name','LIKE','%'.$req->user_name.'%')->paginate(20);
			// print_r($table);exit;
		}
		else if(!empty($req->user_full_name)){
			$table = DB::table('tbl_user')->where('tbl_user.full_name','LIKE','%'.$req->user_full_name.'%')->where('tbl_user.user_name','LIKE','%'.$req->user_name.'%')->paginate(20);
		}
		else if(!empty($req->user_user_name)){
			$table = DB::table('tbl_user')->where('tbl_user.user_name','LIKE','%'.$req->user_user_name.'%')->paginate(20);
		}
		
		//./end
		$user = DB::table('tbl_user')->select('user_id','user_type','user_name','full_name')->get()->toArray();
		$data = (object)[
			'user' => $user,
		];
		$total_row = count($table);
		for ($i=0; $i < count($table); $i++) { 
			$table[$i]= userController::getchucvu($table[$i],$total_column);
		}
		for ($i=0; $i < count($table_all); $i++) { 
			$table_all[$i]= userController::getchucvu($table_all[$i],$total_column);
		}
		//echo "<pre>";print_r($table);exit();
		return view('table', compact('url', 'columns', 'column_show', 'table', 'table_all', 'title', 'total_column', 'total_row', 'row_all','numfield', 'searchfield','searchfieldindex', 'idtable','html','data'));
	}
	// ./End search user

	// Start create user
	public function createItem(){
		$noinhan = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.place_type','=',0)->get();
		$nguoiphutrach = DB::table('tbl_user')->where('tbl_user.user_type','=','15')->get();
		return view('User.CreatUser',compact('noinhan','nguoiphutrach'));
	}
	// ./ end create user
	public static function configUserdetail($user){
		if($user->partner_id == 0 ||$user->partner_id == null  ){
			$user->partner_id = "Công ty TNK";
		}
	}

	// start load user details 
	public function Itemdetail($id){
		$user = DB::table('tbl_user')->where('tbl_user.user_id','=',$id)->get();
		$noinhan = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.place_type','=',0)->get();
		$nguoiphutrach = DB::table('tbl_user')->where('tbl_user.user_type','=',15)->get();
		$gplx = DB::table('tbl_driver_license')->where('tbl_driver_license.user_id','=',$id)->get();
		return view('User.UpdateUser',compact('noinhan','nguoiphutrach','user','gplx'));
	}
	// ./ end load user details
	
	// hàm chuẩn hóa chuỗi có dấu
	public static function stripUnicode($str){
		if(!$str) return false;
		 $unicode = array(
			'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
			'd'=>'đ',
			'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
			'i'=>'í|ì|ỉ|ĩ|ị',
			'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
			'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
			'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		 );
	  foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
	  return $str;
	  }
	  //hàm chuẩn hóa username theo full name, chức vụ, tên công ty (tạm thời mặc định là TNK), công thức fullname + chức vụ viết tắt + _tnk
	public static function chuanhoausername($fullname, $user_type){
		$name = preg_replace('/\s+/', '', $fullname);
		$name = userController::stripUnicode($name);
		$chucvu = "nv";
		if($user_type == 11) 
			$chucvu = "nll";
		else if($user_type == 12)
			$chucvu = "tx";
		else if($user_type == 13)
			$chucvu = "lx";
		else if($user_type == 14)
			$chucvu = "ch";
		else if($user_type == 15)
			$chucvu = "npt";
		$username = $name."_tnk";
		return $username; 
	}
	//Start update user
	public function updateuser(Request $req, $id){
		//check validate
		if($req->data[0]['password'] != $req->data[0]['confirm_password']){
			return response()->json(['password_error' =>'password_error']); 
		}else if($req->data[0]['full_name'] == NULL){
			return response()->json(['name_error' =>'name_error']);
		}else if (!is_numeric($req->data[0]['identity_id']) && $req->data[0]['identity_id']){
			return response()->json(['identity_error' =>'identity_error']);
		}else if(!filter_var($req->data[0]['email'], FILTER_VALIDATE_EMAIL) && $req->data[0]['email']){
			return response()->json(['email_error' =>'email_error']);
		}
		//end check
		//Mã hóa password
		if($req->data[0]['password'] != ""){
			$hash_pass = Hash::make( $req->data[0]['password']);
		}
		else $hash_pass = null;
		if(!$req->data[0]['user_name'])
			$username = userController::chuanhoausername($req->data[0]['full_name'],$req->data[0]['user_type']);
		else $username = $req->data[0]['user_name'];
		//chuẩn hóa username theo fullname chức vụ và công ty
		// if(!$req->data[0]['user_name'])
		// 	$username = userController::chuanhoausername($req->data[0]['full_name'],$req->data[0]['user_type']);
		// else $username = $req->data[0]['user_name'];
		$response = array(
			// 'user_name'=>$username,
			'email'=>$req->data[0]['email'],
			'phone'=>$req->data[0]['phone'],
			'password'=>$hash_pass,
			'full_name'=>$req->data[0]['full_name'],
			'nick_name'=>$req->data[0]['nick_name'],
			'avatar'=>'avt.jpg',
			'gender_id'=>$req->data[0]['gender_id'],
			'address'=>$req->data[0]['address'],
			'note'=>$req->data[0]['note'],
			'user_type'=>$req->data[0]['user_type'],
			'identity_id'=>$req->data[0]['identity_id'],
			'can_login'=>1,
			'status'=>$req->data[0]['status'],
			'role'=>1,
		);
		$can_login = 1;
		if($hash_pass == null){
			$can_login =0;
		}
		if(isset($req->data[0]['password'])){
		$updUser = DB::table('tbl_user')->where('user_id',$id)->update([
			// 'user_name'=>$response['user_name'],
			'email'=>$response['email'],
			'phone'=>$response['phone'],
			'password'=>$response['password'],
			'full_name'=>$response['full_name'],
			'nick_name'=>$response['nick_name'],
			'avatar'=>'avt.jpg',
			'gender_id'=>$response['gender_id'],
			'address'=>$response['address'],
			'note'=>$response['note'],
			'user_type'=>$response['user_type'],
			'identity_id'=>$response['identity_id'],
			'can_login'=>$can_login,
			'status'=>$response['status'],
			'role'=>1,

		]);
		}else{
			$updUser = DB::table('tbl_user')->where('user_id',$id)->update([
			// 'user_name'=>$response['user_name'],
			'email'=>$response['email'],
			'phone'=>$response['phone'],
			// 'password'=>$response['password'],
			'full_name'=>$response['full_name'],
			'nick_name'=>$response['nick_name'],
			'avatar'=>'avt.jpg',
			'gender_id'=>$response['gender_id'],
			'address'=>$response['address'],
			'note'=>$response['note'],
			'user_type'=>$response['user_type'],
			'identity_id'=>$response['identity_id'],
			'can_login'=>$can_login,
			'status'=>$response['status'],
			'role'=>1,

		]);
		}
		if(isset($req->data[0]['data_license'])){
			$driver_license = array($req->data[0]['data_license']);
			for($i = 0 ; $i< count($driver_license[0]) ; $i++){
				$insDriver_license = DB::table('tbl_driver_license')->insert([
				'user_id' => $id,
				'driver_license_num' => $driver_license[0][$i][0],
				'vehicle_class_id' => $driver_license[0][$i][1],
				'expiration_date' => $driver_license[0][$i][2],
				]);
			}
		}
		if(isset($req->data[0]['receipt_place_id']) || isset($req->data[0]['curator_id'])){
				$in = DB::table('tbl_user')->where('tbl_user.user_id','=',$id)->update([
					'receipt_place_id'=>$req->data[0]['receipt_place_id'],
					'curator_id'=>$req->data[0]['curator_id'],
				]);
			}
		return response()->json(['success' =>'success','x' => $updUser]); 
	}
	// ./ end update user
	public function createuser(Request $req){
		// return response()->json(['success' =>'success','x' => $req->data[0]]);
		//check validate
		$curr_user = DB::table('tbl_user')->select('user_name','email')->get();
		if($req->data[0]['password'] != $req->data[0]['confirm_password']){
			return response()->json(['password_error' =>'password_error']); 
		}else if($req->data[0]['full_name'] == NULL){
			return response()->json(['name_error' =>'name_error']);
		}else if (!is_numeric($req->data[0]['identity_id']) && $req->data[0]['identity_id']){
			return response()->json(['identity_error' =>'identity_error']);
		}else if(!filter_var($req->data[0]['email'], FILTER_VALIDATE_EMAIL) && $req->data[0]['email']){
			return response()->json(['email_error' =>'email_error']);
		}else if(!preg_match("/^[A-Za-z0-9_\.]{6,32}$/" ,$req->data[0]['user_name'], $matchs)){
			return response()->json(['username_error' =>'username_error']);
		}
		foreach ($curr_user as $curr_u) {
			# code...
			if($req->data[0]['email'] == $curr_u->email && $req->data[0]['email'])
				return response()->json(['repmail_error' =>'repmail_error']);
			if($req->data[0]['user_name'] == $curr_u->user_name && $req->data[0]['user_name'])
				return response()->json(['repname_error' =>'repname_error']);
		}
		//end check
		if($req->data[0]['password'] != ""){
			$hash_pass = Hash::make( $req->data[0]['password']);
		}
		else $hash_pass = null;
		if(!$req->data[0]['user_name'])
			$username = userController::chuanhoausername($req->data[0]['full_name'],$req->data[0]['user_type']);
		else $username = $req->data[0]['user_name'];
		//========GET REQUEST====
		$response = array(
			'user_name'=>$username,
			'email'=>$req->data[0]['email'],
			'phone'=>$req->data[0]['phone'],
			'password'=>$hash_pass,
			'full_name'=>$req->data[0]['full_name'],
			'nick_name'=>$req->data[0]['nick_name'],
			'avatar'=>'avt.jpg',
			'gender_id'=>$req->data[0]['gender_id'],
			'address'=>$req->data[0]['address'],
			'identity_id'=>$req->data[0]['identity_id'],
			'note'=>$req->data[0]['address'],
			'user_type'=>$req->data[0]['user_type'],
			'can_login'=>1,
			'status'=>$req->data[0]['status'],
			'role'=>1,

			//'driver_license' =>$req->data[0]['data_license'],
		);
		$can_login = 1;
		if($hash_pass == null){
			$can_login =0;
		}
		// if($validator->passes()){
			$insUser = DB::table('tbl_user')->insertGetId([
				'user_name'=>$response['user_name'],
				'email'=>$response['email'],
				'phone'=>$response['phone'],
				'password'=>$response['password'],
				'full_name'=>$response['full_name'],
				'nick_name'=>$response['nick_name'],
				'avatar'=>'avt.jpg',
				'gender_id'=>$response['gender_id'],
				'address'=>$response['address'],
				'note'=>$response['note'],
				'user_type'=>$response['user_type'],
				'identity_id'=>$response['identity_id'],
				'can_login'=>$can_login,
				'status'=>$response['status'],
				'role'=>1,
			]);
			if(isset($req->data[0]['data_license'])){
				$driver_license = array($req->data[0]['data_license']);
				for($i = 0 ; $i< count($driver_license[0]) ; $i++){
					$insDriver_license = DB::table('tbl_driver_license')->insert([
					'user_id' => $insUser,
					'driver_license_num' => $driver_license[0][$i][0],
					'vehicle_class_id' => $driver_license[0][$i][1],
					'expiration_date' => $driver_license[0][$i][2],
					]);
				}
			}
			
			if(isset($req->data[0]['receipt_place_id']) || isset($req->data[0]['curator_id'])){
				$in = DB::table('tbl_user')->where('tbl_user.user_id','=',$insUser)->update([
					'receipt_place_id'=>$req->data[0]['receipt_place_id'],
					'curator_id'=>$req->data[0]['curator_id'],
				]);
			}
			return response()->json(['success' =>'success','x' => $insUser]); 
		// }
		// return response()->json(['errors' => 'that bai']);
	}
	public function del($id) {
		$tmpemail = Session::get('email');
	    $email = end($tmpemail);
	    $users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $email)->get();
	    $currentUser =$users[0];
	    $user = $users[0]->user_id;
	    $currentUser_id = $users[0]->user_id;
		require_once "LibForm.php";
		//TÊN TABLE
		$tableName = 'tbl_user';
		//TÊN KHÓA CHÍNH CỦA TABLE
		$idtable = 'user_id';
		if($currentUser_id == $id){
			return response()->json(['error' =>'error']); 
		}
		LibForm::delete($tableName, $idtable, $id);
		return redirect()->back();
	}
}