<?php

namespace App\Http\Controllers;
use App\Operating;
use App\OperatingTool;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Response;
use DB;
use App\User;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Excel;
use Route;
use Illuminate\Support\Facades\Input;

class DriverController extends Controller
{

	public function getDriver(){
		$drivers = DB::table('tbl_user')->select('tbl_user.*')->orderBy('work_status','ASC')->orderBy('nick_name','ASC')->where('user_type', '=', 12)->get()->toArray();
		$drivingLicenses = DB::table('tbl_driver_license')->leftJoin('tbl_vehicle_class', 'tbl_driver_license.vehicle_class_id', '=', 'tbl_vehicle_class.vehicle_class_id')->select('tbl_driver_license.*', 'tbl_vehicle_class.vehicle_class_title')->get()->toArray();
		$res =(object)[
			'drivers' => $drivers,
			'drivingLicenses'=>$drivingLicenses,
		];
		//return Response::json(['success' => $res]);
		return view('Driver.index', ['resData'=>$res]);
	}

	public function getlisLicense(){
		$drivers = DB::table('tbl_user')->select('tbl_user.*')->orderBy('work_status','ASC')->orderBy('nick_name','ASC')->where('user_type', '=', 12)->get()->toArray();
		$drivingLicenses = DB::table('tbl_driver_license')->leftJoin('tbl_vehicle_class', 'tbl_driver_license.vehicle_class_id', '=', 'tbl_vehicle_class.vehicle_class_id')->select('tbl_driver_license.*', 'tbl_vehicle_class.vehicle_class_title')->get()->toArray();
		$res =(object)[
			'drivers' => $drivers,
			'drivingLicenses'=>$drivingLicenses,
		];
		return Response::json(['success' => $res]);
		// return view('Driver.index', ['resData'=>$res]);
	}

	public function deleteDriver($id){
		if(isset($id) && $id != null && is_numeric($id)){
			DB::table('tbl_user')->where('user_id', '=', $id)->delete();
			return Response::json(['success' => 'ok']);
		}else{
			return Response::json(['error' => 'failed']);
		}
	}

	public function search(){
		$driverName = Input::get('txtDriverName');
		$driverNickName = Input::get('txtNickName');
		$phoneNumber =Input::get('txtPhoneNumber');
		$drivingLicense = Input::get('txtDrivingLicense');
		$identityCardNumber = Input::get('txtIdentityCardNumber');
		$selName = Input::get('selName');
		$note = Input::get('txtGhichu');
		$driverSearch = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', '=', 12);
		if($driverName != null && $driverName != "")
			$driverSearch = $driverSearch->where('full_name', 'like', '%'.$driverName.'%');
		if($driverNickName != null && $driverNickName != "")
			$driverSearch = $driverSearch->where('nick_name', 'like', '%'.$driverNickName.'%');
		if($phoneNumber != null && $phoneNumber != "")
			$driverSearch = $driverSearch->where('phone','like', '%'.$phoneNumber.'%');
		if($drivingLicense != null && $drivingLicense != "")
			$driverSearch = $driverSearch->join('tbl_driver_license', 'tbl_user.user_id', '=', 'tbl_driver_license.user_id')->where('tbl_driver_license.driver_license_num', 'like', '%'.$drivingLicense.'%');
		if($identityCardNumber !=  null && $identityCardNumber != "")
			$driverSearch = $driverSearch->where('tbl_user.identity_id', 'like', '%'.$identityCardNumber.'%');
		if($note !=  null && $note != "")
			$driverSearch = $driverSearch->where('tbl_user.note', 'like', '%'.$note.'%');

		$driverSearch = $driverSearch->orderBy('nick_name','ASC')->get()->toArray();
		$drivingLicenses = DB::table('tbl_driver_license')->leftJoin('tbl_vehicle_class', 'tbl_driver_license.vehicle_class_id', '=', 'tbl_vehicle_class.vehicle_class_id')->select('tbl_driver_license.*', 'tbl_vehicle_class.vehicle_class_title')->get()->toArray();
		$res =(object)[
			'drivers' => $driverSearch,
			'drivingLicenses'=>$drivingLicenses,
		];
		return view('Driver.index', ['resData'=>$res]);
		//return Response::json(['success' => $res]);
	}
	
	public function createDriver(Request $req){
		
		$validator = validator::make($req->all(),[
			'txtNickName' => 'required',
			'txtFullName' => 'required',
		]

		,[
			'txtFullName.required' => 'Thiếu họ tên danh tài xế',
			'txtNickName.required' => 'Thiếu biệt danh tài xế',

		]);
		if($validator->passes()){
			$tmpNickName = $req->txtNickName;
			$count = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$tmpNickName', BINARY) AND work_status = 0");
			if($count[0]->cnt > 0){
				$error = (object)["unique"=>["Biệt danh này đã tồn tại"]];
				return Response::json(['errors'=>$error]);
			}
			if($req->check!=1){
				$count2 = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$tmpNickName', BINARY) AND work_status = 1");
				if($count2[0]->cnt > 0){
					$error1 = (object)["unique"=>["Biệt danh này trùng với người đã nghỉ, bạn có muốn tiếp tục?"]];
					return Response::json(['error1'=>$error1]);
				}
			}
			$fileName = "";
			$t=time();
			$anh =null;
			if($req->hasFile('avatar')){
				$anh = Input::file('avatar')->getClientOriginalName();

				if(!preg_match("/^.*\.(jpg|jpeg|png|gif|svg)$/i" ,$anh, $matchs)){
					$error = (object)["fileanh"=>["Không đúng định dạng file"]];
					return Response::json(['errors'=>$error]);
				}

				$extension = pathinfo($anh, PATHINFO_EXTENSION);
				$anh = pathinfo($anh, PATHINFO_FILENAME);
				$anh = date('dmyhms'). "-".str_slug($anh).".".$extension;
				$file = $req->file('avatar');
				$file->move('img/Users/', $anh);
			}

			$driver = new User();
			$driver->full_name = $req->txtFullName;
			$driver->nick_name = $req->txtNickName;
			$driver->phone = $req->txtPhoneNumber;
			$driver->identity_id = $req->txtIdentityCardNumber;
			$driver->note = $req->txtNote;
			$driver->work_status = $req->selStatus;
			$driver->address = $req->txtAddress;
			$driver->user_type =12;
			$driver->partner_id =0;
			$driver->avatar = $anh;
			$driver->birthday = $req->txtBirthDate; 
			$driver->save();

			$arrDrivingLicense = (array)json_decode($req->arrDrivingLicense);
			// dd($req->arrDrivingLicense);
			if(count($arrDrivingLicense) > 0)
			{
				for($i =0; $i< count($arrDrivingLicense); $i++){
					DB::table('tbl_driver_license')->insert(
						['user_id' => $driver->user_id, 'driver_license_num' => $arrDrivingLicense[$i]->driver_license_num, 'vehicle_class_id'=>$arrDrivingLicense[$i]->vehicle_class_id, 'expiration_date'=>$arrDrivingLicense[$i]->expiration_date]
					);

				}
			}
			
			return Response::json(['success' => "cc"]);
		}else{
			return Response::json(['errors' => ($validator->errors())]);
		}
	}
	public function getCreate(){
		$drivingLicenseClass = DB::table('tbl_vehicle_class')->select('tbl_vehicle_class.*')->orderBy('vehicle_class_title')->get()->toArray();
		$res =(object)[
			
			'drivingLicenseClass'=>$drivingLicenseClass
		];
		return Response::json(['success' => $res]);	
	}
	public function getEditDriver($id){
		$driver  = DB::table('tbl_user')->select('tbl_user.*')->where('user_type', '=', 12)->where('tbl_user.user_id', "=", $id)->get()->toArray();
		$drivingLicenses = DB::table('tbl_driver_license')->where('tbl_driver_license.user_id', "=", $id)->leftJoin('tbl_vehicle_class', 'tbl_driver_license.vehicle_class_id', '=', 'tbl_vehicle_class.vehicle_class_id')->select('tbl_driver_license.*', 'tbl_vehicle_class.vehicle_class_title')->get()->toArray();
		$drivingLicenseClass = DB::table('tbl_vehicle_class')->select('tbl_vehicle_class.*')->orderBy('vehicle_class_title')->get()->toArray();
		$res =(object)[
			'driver' => $driver,
			'drivingLicenses'=>$drivingLicenses,
			'drivingLicenseClass'=>$drivingLicenseClass
		];
		return Response::json(['success' => $res]);
	}

	public function postEditDriver(Request $req){

		$oldDrivingLicenses = (array)json_decode($req->oldDrivingLicenses);
		$newDrivingLicenses = (array)json_decode($req->newDrivingLicenses);
		$idOld = [];
		for($i = 0; $i < count($oldDrivingLicenses); $i++){
			array_push($idOld, $oldDrivingLicenses[$i]->driver_license);
		}
		

		$validator = validator::make($req->all(),[
			'txtNickName' => 'required',
			'txtFullName'=>'required',
		]

		,[
			'txtFullName.required' => 'Thiếu tên đầy đủ của tài xế',
			'txtNickName.required' => 'Thiếu biệt danh tài xế',

		]);
		if($validator->passes()){
			$tmpNickName = $req->txtNickName;
			$count = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$req->txtNickName', BINARY) AND tbl_user.user_id NOT IN ($req->user_id) AND work_status = 0");
			if($count[0]->cnt > 0){
				$error = (object)["unique"=>["Biệt danh này đã tồn tại"]];
				return Response::json(['errors'=>$error]);
			}
			if($req->check!=1){
				$count2 = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$tmpNickName', BINARY) AND work_status = 1");
				if($count2[0]->cnt > 0){
					$error1 = (object)["unique"=>["Biệt danh này trùng với người đã nghỉ, bạn có muốn tiếp tục?"]];
					return Response::json(['error1'=>$error1]);
				}
			}

			$fileName ="";
			$t=time();
			if($req->hasFile('avatar')){
				$anh = Input::file('avatar')->getClientOriginalName();

				if(!preg_match("/^.*\.(jpg|jpeg|png|gif|svg)$/i" ,$anh, $matchs)){
					$error = (object)["fileanh"=>["Không đúng định dạng file"]];
					return Response::json(['errors'=>$error]);
				}

				$extension = pathinfo($anh, PATHINFO_EXTENSION);
				$anh = pathinfo($anh, PATHINFO_FILENAME);
				$anh = date('dmyhms'). "-".str_slug($anh).".".$extension;
				$file = $req->file('avatar');
				$file->move('img/Users/', $anh);


				DB::table('tbl_user')
				->where('user_id', $req->user_id)
				->update([
					'full_name' => $req->txtFullName,
					'nick_name'=>$req->txtNickName,
					'phone' => $req->txtPhoneNumber,
					'identity_id' => $req->txtIdentityCardNumber,
					'note' => $req->txtNote,
					'work_status' => $req->selStatus,
					'address' => $req->txtAddress,
					'partner_id'=>0,
					'birthday'=>$req->txtBirthDate,
					'avatar' => $anh
				]);

			}else{

				DB::table('tbl_user')
				->where('user_id', $req->user_id)
				->update([
					'full_name' => $req->txtFullName,
					'nick_name'=>$req->txtNickName,
					'phone' => $req->txtPhoneNumber,
					'identity_id' => $req->txtIdentityCardNumber,
					'note' => $req->txtNote,
					'work_status' => $req->selStatus,
					'address' => $req->txtAddress,
					'birthday'=>$req->txtBirthDate,
					'partner_id'=>0
				]);
			}

			DB::table('tbl_driver_license')->whereIn('driver_license', $idOld)->delete();
			if(count($newDrivingLicenses) > 0)
			{
				for($i =0; $i< count($newDrivingLicenses); $i++){
					DB::table('tbl_driver_license')->insert(
						['user_id' => $req->user_id, 'driver_license_num' => $newDrivingLicenses[$i]->driver_license_num, 'vehicle_class_id'=>$newDrivingLicenses[$i]->vehicle_class_id, 'expiration_date'=>$newDrivingLicenses[$i]->expiration_date]
					);

				}
			}
			
			return Response::json(['success' => "cc"]);
			//return redirect('home/dashboard');

		}else{
			return Response::json(['errors' => ($validator->errors())]);
		}
	}


































































	/*
	public function getDriver(){
		$drivers = DB::table('tbl_user')->select('tbl_user.*')->orderBy('work_status','ASC')->orderBy('nick_name','ASC')->where('user_type', '=', 12)->get()->toArray();
		$drivingLicenses = DB::table('tbl_driver_license')->leftJoin('tbl_vehicle_class', 'tbl_driver_license.vehicle_class_id', '=', 'tbl_vehicle_class.vehicle_class_id')->select('tbl_driver_license.*', 'tbl_vehicle_class.vehicle_class_title')->get()->toArray();
		$res =(object)[
			'drivers' => $drivers,
			'drivingLicenses'=>$drivingLicenses,
		];
		return Response::json(['success' => $res]);
	}

	public function deleteDriver($id){
		if(isset($id) && $id != null && is_numeric($id)){
			DB::table('tbl_user')->where('user_id', '=', $id)->delete();
			return Response::json(['success' => 'ok']);
		}else{
			return Response::json(['error' => 'failed']);
		}
	}

	public function search(){
		$driverName = Input::get('txtDriverName');
		$driverNickName = Input::get('txtNickName');
		$phoneNumber =Input::get('txtPhoneNumber');
		$drivingLicense = Input::get('txtDrivingLicense');
		$identityCardNumber = Input::get('txtIdentityCardNumber');
		$selName = Input::get('selName');
		$driverSearch = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', '=', 12);
		if($driverName != null && $driverName != "")
			$driverSearch = $driverSearch->where('full_name', 'like', '%'.$driverName.'%');
		if($driverNickName != null && $driverNickName != "")
			$driverSearch = $driverSearch->where('nick_name', 'like', '%'.$driverNickName.'%');
		if($phoneNumber != null && $phoneNumber != "")
			$driverSearch = $driverSearch->where('phone','like', '%'.$phoneNumber.'%');
		if($drivingLicense != null && $drivingLicense != "")
			$driverSearch = $driverSearch->join('tbl_driver_license', 'tbl_user.user_id', '=', 'tbl_driver_license.user_id')->where('tbl_driver_license.driver_license_num', 'like', '%'.$drivingLicense.'%');
		if($identityCardNumber !=  null && $identityCardNumber != "")
			$driverSearch = $driverSearch->where('tbl_user.identity_id', 'like', '%'.$identityCardNumber.'%');

		$driverSearch = $driverSearch->orderBy('nick_name','ASC')->get()->toArray();
		$res =(object)[
			'driverSearch' => $driverSearch
		];
		return Response::json(['success' => $res]);
	}
	
	public function createDriver(Request $req){
		$validator = validator::make($req->all(),[
			'txtNickName' => 'required',
			'txtFullName' => 'required',
		]

		,[
			'txtFullName.required' => 'Thiếu họ tên danh tài xế',
			'txtNickName.required' => 'Thiếu biệt danh tài xế',

		]);
		if($validator->passes()){
			$tmpNickName = $req->txtNickName;
			$count = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$tmpNickName', BINARY) AND work_status = 0");
			if($count[0]->cnt > 0){
				$error = (object)["unique"=>["Biệt danh này đã tồn tại"]];
				return Response::json(['errors'=>$error]);
			}
			if($req->check!=1){
				$count2 = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$tmpNickName', BINARY) AND work_status = 1");
				if($count2[0]->cnt > 0){
					$error1 = (object)["unique"=>["Biệt danh này trùng với người đã nghỉ, bạn có muốn tiếp tục?"]];
					return Response::json(['error1'=>$error1]);
				}
			}
			$fileName = "";
			$t=time();
			$anh =null;
			if($req->hasFile('avatar')){
				$anh = Input::file('avatar')->getClientOriginalName();

				if(!preg_match("/^.*\.(jpg|jpeg|png|gif|svg)$/i" ,$anh, $matchs)){
					$error = (object)["fileanh"=>["Không đúng định dạng file"]];
					return Response::json(['errors'=>$error]);
				}

				$extension = pathinfo($anh, PATHINFO_EXTENSION);
				$anh = pathinfo($anh, PATHINFO_FILENAME);
				$anh = date('dmyhms'). "-".str_slug($anh).".".$extension;
				$file = $req->file('avatar');
				$file->move('img/Users/', $anh);
			}

			$driver = new User();
			$driver->full_name = $req->txtFullName;
			$driver->nick_name = $req->txtNickName;
			$driver->phone = $req->txtPhoneNumber;
			$driver->identity_id = $req->txtIdentityCardNumber;
			$driver->note = $req->txtNote;
			$driver->work_status = $req->selStatus;
			$driver->address = $req->txtAddress;
			$driver->user_type =12;
			$driver->partner_id =0;
			$driver->avatar = $anh;
			$driver->birthday = $req->txtBirthDate; 
			$driver->save();

			$arrDrivingLicense = (array)json_decode($req->arrDrivingLicense);
			if(count($arrDrivingLicense) > 0)
			{
				for($i =0; $i< count($arrDrivingLicense); $i++){
					DB::table('tbl_driver_license')->insert(
						['user_id' => $driver->user_id, 'driver_license_num' => $arrDrivingLicense[$i]->driver_license_num, 'vehicle_class_id'=>$arrDrivingLicense[$i]->vehicle_class_id, 'expiration_date'=>$arrDrivingLicense[$i]->expiration_date]
					);

				}
			}
			
			return Response::json(['success' => "cc"]);
		}else{
			return Response::json(['errors' => ($validator->errors())]);
		}
	}
	public function getCreate(){
		$drivingLicenseClass = DB::table('tbl_vehicle_class')->select('tbl_vehicle_class.*')->orderBy('vehicle_class_title')->get()->toArray();
		$res =(object)[
			
			'drivingLicenseClass'=>$drivingLicenseClass
		];
		return Response::json(['success' => $res]);	
	}
	public function getEditDriver($id){
		$driver  = DB::table('tbl_user')->select('tbl_user.*')->where('user_type', '=', 12)->where('tbl_user.user_id', "=", $id)->get()->toArray();
		$drivingLicenses = DB::table('tbl_driver_license')->where('tbl_driver_license.user_id', "=", $id)->leftJoin('tbl_vehicle_class', 'tbl_driver_license.vehicle_class_id', '=', 'tbl_vehicle_class.vehicle_class_id')->select('tbl_driver_license.*', 'tbl_vehicle_class.vehicle_class_title')->get()->toArray();
		$drivingLicenseClass = DB::table('tbl_vehicle_class')->select('tbl_vehicle_class.*')->orderBy('vehicle_class_title')->get()->toArray();
		$res =(object)[
			'driver' => $driver,
			'drivingLicenses'=>$drivingLicenses,
			'drivingLicenseClass'=>$drivingLicenseClass
		];
		return Response::json(['success' => $res]);
	}

	public function postEditDriver(Request $req){

		$oldDrivingLicenses = (array)json_decode($req->oldDrivingLicenses);
		$newDrivingLicenses = (array)json_decode($req->newDrivingLicenses);
		$idOld = [];
		for($i = 0; $i < count($oldDrivingLicenses); $i++){
			array_push($idOld, $oldDrivingLicenses[$i]->driver_license);
		}
		

		$validator = validator::make($req->all(),[
			'txtNickName' => 'required',
			'txtFullName'=>'required',
		]

		,[
			'txtFullName.required' => 'Thiếu tên đầy đủ của tài xế',
			'txtNickName.required' => 'Thiếu biệt danh tài xế',

		]);
		if($validator->passes()){
			$tmpNickName = $req->txtNickName;
			$count = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$req->txtNickName', BINARY) AND tbl_user.user_id NOT IN ($req->user_id) AND work_status = 0");
			if($count[0]->cnt > 0){
				$error = (object)["unique"=>["Biệt danh này đã tồn tại"]];
				return Response::json(['errors'=>$error]);
			}
			if($req->check!=1){
				$count2 = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$tmpNickName', BINARY) AND work_status = 1");
				if($count2[0]->cnt > 0){
					$error1 = (object)["unique"=>["Biệt danh này trùng với người đã nghỉ, bạn có muốn tiếp tục?"]];
					return Response::json(['error1'=>$error1]);
				}
			}

			$fileName ="";
			$t=time();
			if($req->hasFile('avatar')){
				$anh = Input::file('avatar')->getClientOriginalName();

				if(!preg_match("/^.*\.(jpg|jpeg|png|gif|svg)$/i" ,$anh, $matchs)){
					$error = (object)["fileanh"=>["Không đúng định dạng file"]];
					return Response::json(['errors'=>$error]);
				}

				$extension = pathinfo($anh, PATHINFO_EXTENSION);
				$anh = pathinfo($anh, PATHINFO_FILENAME);
				$anh = date('dmyhms'). "-".str_slug($anh).".".$extension;
				$file = $req->file('avatar');
				$file->move('img/Users/', $anh);


				DB::table('tbl_user')
				->where('user_id', $req->user_id)
				->update([
					'full_name' => $req->txtFullName,
					'nick_name'=>$req->txtNickName,
					'phone' => $req->txtPhoneNumber,
					'identity_id' => $req->txtIdentityCardNumber,
					'note' => $req->txtNote,
					'work_status' => $req->selStatus,
					'address' => $req->txtAddress,
					'partner_id'=>0,
					'birthday'=>$req->txtBirthDate,
					'avatar' => $anh
				]);

			}else{

				DB::table('tbl_user')
				->where('user_id', $req->user_id)
				->update([
					'full_name' => $req->txtFullName,
					'nick_name'=>$req->txtNickName,
					'phone' => $req->txtPhoneNumber,
					'identity_id' => $req->txtIdentityCardNumber,
					'note' => $req->txtNote,
					'work_status' => $req->selStatus,
					'address' => $req->txtAddress,
					'birthday'=>$req->txtBirthDate,
					'partner_id'=>0
				]);
			}

			DB::table('tbl_driver_license')->whereIn('driver_license', $idOld)->delete();
			if(count($newDrivingLicenses) > 0)
			{
				for($i =0; $i< count($newDrivingLicenses); $i++){
					DB::table('tbl_driver_license')->insert(
						['user_id' => $req->user_id, 'driver_license_num' => $newDrivingLicenses[$i]->driver_license_num, 'vehicle_class_id'=>$newDrivingLicenses[$i]->vehicle_class_id, 'expiration_date'=>$newDrivingLicenses[$i]->expiration_date]
					);

				}
			}
			
			return Response::json(['success' => "cc"]);

		}else{
			return Response::json(['errors' => ($validator->errors())]);
		}
	}
	*/
}
