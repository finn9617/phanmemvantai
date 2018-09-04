<?php

namespace App\Http\Controllers;
use App\Operating;
use App\OperatingTool;
use App\PoolOperating;
use App\PoolOperatingTool;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Response;
use DB;
use App\Log;
use App\User;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Excel;
use Route;
use Illuminate\Pagination\LengthAwarePaginator;
use DateTime;
use DatePeriod;
use DateInterval;

class DieuXeController extends Controller
{
	public function getDieuXe(){
		$goods = DB::table('tbl_goods')->select('tbl_goods.*')->get()->toArray();
		$receiptPlaces = DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->where('tbl_receipt_delivery_place.place_type', "=", 0)->get()->toArray();
		$deliveryPlaces= DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->where('tbl_receipt_delivery_place.place_type', "=", 1)->get()->toArray();
		$deliveryPlaces= DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->where('tbl_receipt_delivery_place.place_type', "=", 1)->get()->toArray();
		$customers= DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 14)->get()->toArray();
		$carTypes = DB::table('tbl_car_type')->select('tbl_car_type.*')->get()->toArray();
		$trailers = DB::table('tbl_trailer')->select('tbl_trailer.*')->get()->toArray();
		$trailerTypes = DB::table('tbl_trailer_type')->select('tbl_trailer_type.*')->get()->toArray();
		$cars = DB::table('tbl_car')->select('tbl_car.*')->get()->toArray();
		$drivers= DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 12)->where('tbl_user.status', "=",  10)->get()->toArray();
		$assistantDriver = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 13)->get()->toArray();
		$clearTanks = DB::table('tbl_clear_tank')->select('tbl_clear_tank.*')->get()->toArray();
		$toolCategories = DB::table('tbl_tool_category')->select('tbl_tool_category.*')->get()->toArray();
		$tools = DB::table('tbl_tool')->select('tbl_tool.*')->where('tbl_tool.num', ">", 0)->get()->toArray();
		$curators = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 15)->get()->toArray();
		$freeDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 12)->whereNotIn('tbl_user.user_id', function($q){
			$q->select('driver_id')->from('tbl_operating')->whereNotNull('driver_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeAssistantDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 13)->whereNotIn('tbl_user.user_id', function($q){
			$q->select('assistant_driver_id')->from('tbl_operating')->whereNotNull('assistant_driver_id' )->where('status', "=", 1);
		})->get()->toArray();

		$freeCars =  DB::table('tbl_car')->select('tbl_car.*')->whereNotIn('tbl_car.car_id', function($q){
			$q->select('car_id')->from('tbl_operating')->whereNotNull('car_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeTrailers =  DB::table('tbl_trailer')->select('tbl_trailer.*')->whereNotIn('tbl_trailer.trailer_id', function($q){
			$q->select('trailer_id')->from('tbl_operating')->whereNotNull('trailer_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeTrailerTypes =  DB::table('tbl_trailer_type')->select('tbl_trailer_type.*')->whereNotIn('tbl_trailer_type.trailer_type_id', function($q){
			$q->select('trailer_type_id')->from('tbl_operating')->whereNotNull('trailer_type_id' )->where('status', "=", 1);
		})->get()->toArray();


		$testQ = DB::table('tbl_operating')->select('tbl_operating.*')->whereNotNull('driver_id')->where('tbl_operating.status', "=", 1)->get();
		$res =(object)[
			'goods' => $goods,
			'receiptPlaces'=>$receiptPlaces,
			'deliveryPlaces'=>$deliveryPlaces,
			'customers'=>$customers,
			'carTypes'=>$carTypes,
			'trailers'=>$trailers,
			'cars'=>$cars,
			'drivers'=>$drivers,
			'assistantDrivers'=>$assistantDriver,
			'clearTanks' => $clearTanks,
			'toolCategories' =>$toolCategories,
			'tools'=>$tools,
			'curators'=>$curators,
			'freeDrivers'=>$freeDrivers,
			'freeAssistantDrivers'=>$freeAssistantDrivers,
			'freeCars'=>$freeCars,
			"testQ"=>$testQ,
			'trailerTypes'=>$trailerTypes,
			'freeTrailers'=>$freeTrailers
		];
		// 	echo "<pre>";
		// var_dump($res);
		// echo "</pre>";
		// exit();
		return view('dieuxe/index', compact('res'));

	}
		// ================================ function get Operating ==================================================
	public function getOperating(Request $req){
		Log::writeLog($req->fullUrl(), $req->ip());
		$goods = DB::table('tbl_goods')->select('tbl_goods.*')->orderBy('tbl_goods.sort_name')->get()->toArray();
		$receiptPlaces = DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->where('tbl_receipt_delivery_place.place_type', "=", 0)->orderBy('tbl_receipt_delivery_place.name')->get()->toArray();
		$deliveryPlaces= DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->where('tbl_receipt_delivery_place.place_type', "=", 1)->orderBy('tbl_receipt_delivery_place.name')->get()->toArray();
		$deliveryPlaces= DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->where('tbl_receipt_delivery_place.place_type', "=", 1)->orderBy('tbl_receipt_delivery_place.name')->get()->toArray();
		$partners = DB::table('tbl_partner')->select('tbl_partner.*')->orderBy('tbl_partner.partner_short_name')->get()->toArray();
		$customers= DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 14)->orderBy('tbl_user.nick_name')->get()->toArray();
		$carTypes = DB::table('tbl_car_type')->select('tbl_car_type.*')->orderBy('tbl_car_type.name')->get()->toArray();
		$trailers = DB::table('tbl_trailer')->select('tbl_trailer.*')->orderBy('tbl_trailer.trailer_num')->get()->toArray();
		$trailerTypes = DB::table('tbl_trailer_type')->select('tbl_trailer_type.*')->orderBy('tbl_trailer_type.trailer_type_name')->get()->toArray();
		$cars = DB::table('tbl_car')->select('tbl_car.*')->orderBy('tbl_car.car_num')->get()->toArray();
		$drivers= DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 12)->where('tbl_user.work_status', "=",  0)->orderBy('tbl_user.nick_name')->get()->toArray();
		$assistantDriver = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 13)->where('tbl_user.work_status', "=",  0)->orderBy('tbl_user.nick_name')->get()->toArray();
		$clearTanks = DB::table('tbl_clear_tank')->select('tbl_clear_tank.*')->orderBy('tbl_clear_tank.clear_tank_name')->get()->toArray();
		$toolCategories = DB::table('tbl_tool_category')->select('tbl_tool_category.*')->orderBy('tbl_tool_category.name')->get()->toArray();
		/*$tools = DB::table('tbl_tool')->select('tbl_tool.*')->where('tbl_tool.num', ">", 0)->orderBy('tbl_tool.name')->get()->toArray();
		$toolsFull = DB::table('tbl_tool')->select('tbl_tool.*')->orderBy('tbl_tool.name')->get()->toArray();*/
		$tools = DB::table('tbl_tool')->where('tbl_tool.num', ">", 0)->leftJoin('tbl_tool_category', 'tbl_tool_category.tool_category_id', '=', 'tbl_tool.tool_category_id')->orderBy('tbl_tool.name')->select('tbl_tool.*', 'tbl_tool_category.tool_type', 'tbl_tool_category.name as category_name')->get()->toArray();
		$toolsFull = DB::table('tbl_tool')->leftJoin('tbl_tool_category', 'tbl_tool_category.tool_category_id', '=', 'tbl_tool.tool_category_id')->orderBy('tbl_tool.name')->select('tbl_tool.*', 'tbl_tool_category.tool_type')->orderBy('tbl_tool.name')->get()->toArray();
		$curators = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 15)->orderBy('tbl_user.nick_name')->get()->toArray();
		$freeDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.work_status', "=",  0)->where('tbl_user.status', "=",  0)->orderBy('tbl_user.nick_name')->where('tbl_user.user_type', "=", 12)->whereNotIn('tbl_user.user_id', function($q){
			$q->select('driver_id')->from('tbl_operating')->whereNotNull('driver_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeAssistantDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 13)->where('tbl_user.work_status', "=",  0)->where('tbl_user.status', "=",  0)->orderBy('tbl_user.nick_name')->whereNotIn('tbl_user.user_id', function($q){
			$q->select('assistant_driver_id')->from('tbl_operating')->whereNotNull('assistant_driver_id' )->where('status', "=", 1);
		})->get()->toArray();

		$freeCars =  DB::table('tbl_car')->select('tbl_car.*')->orderBy('tbl_car.car_num')->whereNotIn('tbl_car.car_id', function($q){
			$q->select('car_id')->from('tbl_operating')->whereNotNull('car_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeTrailers =  DB::table('tbl_trailer')->select('tbl_trailer.*')->orderBy('tbl_trailer.trailer_num')->whereNotIn('tbl_trailer.trailer_id', function($q){
			$q->select('trailer_id')->from('tbl_operating')->whereNotNull('trailer_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeTrailerTypes =  DB::table('tbl_trailer_type')->select('tbl_trailer_type.*')->orderBy('tbl_trailer_type.trailer_type_name')->whereNotIn('tbl_trailer_type.trailer_type_id', function($q){
			$q->select('trailer_type_id')->from('tbl_operating')->whereNotNull('trailer_type_id' )->where('status', "=", 1);
		})->get()->toArray();


		$testQ = DB::table('tbl_operating')->select('tbl_operating.*')->whereNotNull('driver_id')->where('tbl_operating.status', "=", 1)->get();
		$res =(object)[
			'goods' => $goods, 
			'receiptPlaces'=>$receiptPlaces,
			'deliveryPlaces'=>$deliveryPlaces,
			'partners'=>$partners,
			'customers'=>$customers,
			'carTypes'=>$carTypes,
			'trailers'=>$trailers,
			'cars'=>$cars,
			'drivers'=>$drivers,
			'assistantDrivers'=>$assistantDriver,
			'clearTanks' => $clearTanks,
			'toolCategories' =>$toolCategories,
			'tools'=>$tools,
			'toolsFull'=>$toolsFull,
			'curators'=>$curators,
			'freeDrivers'=>$freeDrivers,
			'freeAssistantDrivers'=>$freeAssistantDrivers,
			'freeCars'=>$freeCars,
			"testQ"=>$testQ,
			'trailerTypes'=>$trailerTypes,
			'freeTrailers'=>$freeTrailers
		];
		// 	echo "<pre>";
		// var_dump($res);
		// echo "</pre>";
		// exit();
		// return view('dieuxe/index', compact('res'));
		return Response::json(['success' => $res]);

	}
	public function creatOperating(Request $req){
		DB::beginTransaction();
		try{
			if(session()->has('email'))
			{
				$tmpemail = Session::get('email');
				$sess_email = end($tmpemail);
				$sess_users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $sess_email)->get();
				$currentUser_type =$sess_users[0]->user_type;
			}
			$routeName = Route::getCurrentRoute()->getName();
			$method = $_SERVER['REQUEST_METHOD'];
			$checkAuth = checkAuthController::checkAuth($routeName,$method,$currentUser_type);
			if($checkAuth == 0){
				return response()->json(['error' =>'error']); 
			}
			$validator = validator::make($req->all(),[
				'selLoaiHang' => 'required',
				'selChuHang' => 'required',
				'selGoodsType'=>'required',
			]

			,[
				'selLoaiHang.required' => 'Chưa chọn mặt hàng',
				'selChuHang.required' => 'Chưa chọn chủ hàng',
				'selGoodsType.required' => 'Chưa chọn loại hàng',

			]);
			if($validator->passes()){
			// check seltinhTrang != 2 => check trùng	
					$freeCars =  DB::table('tbl_car')->select('tbl_car.*')->orderBy('tbl_car.car_num')->whereNotIn('tbl_car.car_id', function($q){
						$q->select('car_id')->from('tbl_operating')->whereNotNull('car_id' )->where('status', "=", 1);
					})->pluck('car_id')->toArray();
					$freeTrailers =  DB::table('tbl_trailer')->select('tbl_trailer.*')->orderBy('tbl_trailer.trailer_num')->whereNotIn('tbl_trailer.trailer_id', function($q){
						$q->select('trailer_id')->from('tbl_operating')->whereNotNull('trailer_id' )->where('status', "=", 1);
					})->pluck('trailer_id')->toArray();
					$freeDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.work_status', "=",  0)->where('tbl_user.status', "=",  0)->orderBy('tbl_user.nick_name')->where('tbl_user.user_type', "=", 12)->whereNotIn('tbl_user.user_id', function($q){
						$q->select('driver_id')->from('tbl_operating')->whereNotNull('driver_id' )->where('status', "=", 1);
					})->pluck('user_id')->toArray();
					$freeAssistantDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 13)->where('tbl_user.work_status', "=",  0)->where('tbl_user.status', "=",  0)->orderBy('tbl_user.nick_name')->whereNotIn('tbl_user.user_id', function($q){
						$q->select('assistant_driver_id')->from('tbl_operating')->whereNotNull('assistant_driver_id' )->where('status', "=", 1);
					})->pluck('user_id')->toArray();
					$freeTools = DB::table('tbl_tool')->where('tbl_tool.num', '>', 0)->pluck('tool_id')->toArray();
					if($req->freeRule != 1){
						$errorsBusyData = []; 
						if(isset($req->selTaiXe) && $req->selTaiXe != null && $req->selTaiXe !=''){		
							if(!in_array($req->selTaiXe, $freeDrivers))
								$errorsBusyData['selTaiXe'] = "Tài xế đang trong chuyến đi khác";
						}
						if(isset($req->selPhuXe) && $req->selPhuXe != null && $req->selPhuXe !=''){
							if(!in_array($req->selPhuXe, $freeAssistantDrivers))
								$errorsBusyData['selPhuXe'] = "Phụ xe đang trong chuyến đi khác";
						}
						if(isset($req->selXe) && $req->selXe != null && $req->selXe !=''){
							if(!in_array($req->selXe, $freeCars))
								$errorsBusyData['selXe'] = "Xe đang trong chuyến đi khác";
						}
						if(isset($req->selRomooc) && $req->selRomooc != null && $req->selRomooc !=''){
							if(!in_array($req->selRomooc, $freeTrailers))
								$errorsBusyData['selRomooc'] = "Romooc đang trong chuyến đi khác";
						}
						if(!empty($req->operatingTools) && count($req->operatingTools) > 0){
							$toolErrors = [];
							for($i = 0; $i< count($req->operatingTools); $i++){
								$tmpToolID = $req->operatingTools[$i]['tool_id'];
								if(!in_array($tmpToolID, $freeTools))
									array_push($toolErrors, $tmpToolID);
							}
							if(count($toolErrors) >0)
								$errorsBusyData['toolErrors'] = $toolErrors;
						}
						if(count($errorsBusyData) > 0){
							return Response::json(['errorsBusyData' => $errorsBusyData]);
						}

					}

					// setup data to Insert into Operating item status table -start
					$dataOperatingItemStatus = [];
					if(isset($req->selTaiXe) && $req->selTaiXe != null && $req->selTaiXe !=''){
						$statusDriver = 0;		
						if(!in_array($req->selTaiXe, $freeDrivers))
							$statusDriver = 1;
						$dataDriver = ['item_id'=>$req->selTaiXe, 'item_type'=>1, 'status'=>$statusDriver];	
						array_push($dataOperatingItemStatus, $dataDriver);	
					}
					if(isset($req->selPhuXe) && $req->selPhuXe != null && $req->selPhuXe !=''){
						$statusAssistantDriver = 0;
						if(!in_array($req->selPhuXe, $freeAssistantDrivers))
							$statusAssistantDriver = 1;
						$dataAssistantDriver = ['item_id'=>$req->selPhuXe, 'item_type'=>2, 'status'=>$statusAssistantDriver];
						array_push($dataOperatingItemStatus, $dataAssistantDriver);		
					}
					if(isset($req->selXe) && $req->selXe != null && $req->selXe !=''){
						$statusCar = 0;
						if(!in_array($req->selXe, $freeCars))
							$statusCar = 1;
						$dataCar = ['item_id'=>$req->selXe, 'item_type'=>3, 'status'=>$statusCar];
						array_push($dataOperatingItemStatus, $dataCar);	

					}
					if(isset($req->selRomooc) && $req->selRomooc != null && $req->selRomooc !=''){
						$statusRomooc = 0;
						if(!in_array($req->selRomooc, $freeTrailers))
							$statusRomooc = 1;
						$dataRomooc = ['item_id'=>$req->selRomooc, 'item_type'=>4, 'status'=>$statusRomooc];
						array_push($dataOperatingItemStatus, $dataRomooc);	
					}
					if(!empty($req->operatingTools) && count($req->operatingTools) > 0){
						$toolErrors = [];
						for($i = 0; $i< count($req->operatingTools); $i++){
							$tmpToolID = $req->operatingTools[$i]['tool_id'];
							$statusTool = 0;
							if(!in_array($tmpToolID, $freeTools))
								$statusTool = 1;
							$dataTool = ['item_id'=>$tmpToolID, 'item_type'=>5, 'status'=>$statusTool];
							array_push($dataOperatingItemStatus, $dataTool);	
						}
					}
					// Setup data to Insert into Operating item status table - end
					$operating = new Operating();
					$operating->goods_id = $req->selLoaiHang;
					$operating->goods_type = $req->selGoodsType;
					$operating->owner_id = $req->selChuHang;
					$operating->group_num = $req->txtMaGopChuyen;
					$operating->operating_date = $req->txtNgayDieuXe;
					$operating->receipt_place_id = $req->selNoiNhan;
					$operating->before_receipt_note = $req->txtNDTruocNoiNhan;
					$operating->after_receipt_note = $req->txtNDSauNoiNhan;
					$operating->delivery_place_id = $req->selNoiGiao;
					$operating->before_delivery_note = $req->txtNDTruocNoiGiao;
					$operating->after_delivery_note = $req->txtNDSauNoiGiao;
					$operating->note = $req->txtGhiChu;
					$operating->document1 = $req->txtCTMT1;
					$operating->document2 = $req->txtCTMT2;
					$operating->curator_id = $req->selNguoiPhuTrach;
					$operating->car_type_id = $req->selLoaiXe;
					$operating->car_id = $req->selXe;
					$operating->trailer_id = $req->selRomooc;
					$operating->trailer_type_id = $req->selLoaiRomooc;
					$operating->driver_id = $req->selTaiXe;
					$operating->before_driver_note = $req->txtNDTruocTaiXe;
					$operating->after_driver_note = $req->txtNDSauTaiXe;
					$operating->assistant_driver_id = $req->selPhuXe;
					$operating->before_assistant_note = $req->txtNDTruocPhuXe;
					$operating->after_assistant_note = $req->txtNDSauPhuXe;
					$operating->clear_tank_id =$req->selXitBon;
					$operating->departure_time = $req->txtGioDi;
			$operating->status = 1;//$req->selTinhTrang;
			$operating->num = $req->txtSoLuongHangHoa;
			$operating->order_show = $req->orderShow;
			$operating->before_owner_note = $req->txtNDTruocChuHang;
			$operating->after_owner_note = $req->txtNDSauChuHang;
			$operating->rerule = $req->freeRule;
			$operating->save();

			// insert to table tbl_operating_tool
			$operatingTools = ($req->operatingTools);
			
			if(!empty($operatingTools)){
				$numOperatingTools = count($operatingTools);
				for($i = 0 ; $i < $numOperatingTools; $i++){
					$operatingTool = new OperatingTool();
					$operatingTool->operating_id = $operating->operating_id;
					$operatingTool->tool_id = $operatingTools[$i]['tool_id'];
					$operatingTool->tool_category_id = $operatingTools[$i]['tool_category_id'];
					$operatingTool->tool_type = $operatingTools[$i]['tool_type'];
					$operatingTool->num = $operatingTools[$i]['num'];
					$operatingTool->operating_date = $operating->operating_date;
					$operatingTool->save();

					$tool = DB::table('tbl_tool')->select('tbl_tool.*')->where('tbl_tool.tool_id', "=", $operatingTools[$i]['tool_id'])->get()->toArray();
					$quantity = $tool[0]->num;
					$quantity = $quantity - $operatingTools[$i]['num'];
					DB::table('tbl_tool')
					->where('tool_id', $tool[0]->tool_id)
					->update(['num' => $quantity]);
				}
			}
			//update work status driver
			if(isset($req->selTaiXe) && $req->selTaiXe !=""){
				DB::table('tbl_user')
				->where('user_id', $req->selTaiXe)
				->update([
					'status' => 1
				]);
			}
			if(isset($req->selPhuXe) && $req->selPhuXe !=""){
				DB::table('tbl_user')
				->where('user_id', $req->selPhuXe)
				->update([
					'status' => 1
				]);
			}
			//case complete operating
			if($req->selTinhTrang == 2){
				$checkCompleteOperating = $this->completeOperatingByID($operating->operating_id);
				//var_dump($checkCompleteOperating); exit;
				if(!$checkCompleteOperating)
					return Response::json(['errors' => 'that bai1']);
			}
			// continue Setup and insert Operating item status - start
			if(count($dataOperatingItemStatus) >0){
				for($i=0; $i < count($dataOperatingItemStatus); $i++){
					$dataOperatingItemStatus[$i]['operating_id']= $operating->operating_id;
				}
				DB::table('tbl_operating_item_status')->insert($dataOperatingItemStatus);
			}
			$this->createHistoryOperating($operating->operating_id); // create History
			// continue Setup and insertOperating item status -  end
			DB::commit();
			return Response::json(['success' => $req->all()]);
			// return Response::json(['success' => $operatingTools[0]['tool_id']]);
		}
		return Response::json(['errors' => 'that bai']);
	}catch(\Exception $e) {

		DB::rollback();
		return Response::json(['errors' => 'that bai']);
		//return $e;
		 // print_r($e);
	}
}

	//function get lastestGoods
public function getLastestGoods(Request $req){
	$lastestGoods = [];
	if(isset($req->selLoaiXe)){
			//case loại xe bồn
		if(isset($req->selXe) && $req->selLoaiXe == 4){
			$lastestGoodsQuery = DB::table('tbl_operating')->where('tbl_operating.car_id', '=', $req->selXe)->join('tbl_goods', 'tbl_goods.goods_id', '=', 'tbl_operating.goods_id')->select('tbl_operating.*', 'tbl_goods.sort_name')->orderBy('tbl_operating.operating_date', 'desc')->orderBy('tbl_operating.operating_id', 'desc')->get()->toArray();
			if(count($lastestGoodsQuery) < 4)
				$lastestGoods = $lastestGoodsQuery;
			else{
				array_push($lastestGoods,$lastestGoodsQuery[0], $lastestGoodsQuery[1], $lastestGoodsQuery[2]);
			}
		}else{
				// var_dump($req->selRomooc);exit();
			if(isset($req->selRomooc)){
				$lastestGoodsQuery = DB::table('tbl_operating')->where('tbl_operating.trailer_id', '=', $req->selRomooc)->join('tbl_goods', 'tbl_goods.goods_id', '=', 'tbl_operating.goods_id')->select('tbl_operating.*', 'tbl_goods.sort_name')->orderBy('tbl_operating.operating_date', 'desc')->orderBy('tbl_operating.operating_id', 'desc')->get()->toArray();
				if(count($lastestGoodsQuery) < 4)
					$lastestGoods = $lastestGoodsQuery;
				else{
					array_push($lastestGoods,$lastestGoodsQuery[0], $lastestGoodsQuery[1], $lastestGoodsQuery[2]);
				}
			}
		}
	}
	$res =(object)[
		'lastestGoods' => $lastestGoods
	];
	return Response::json(['success' => $res]);
		// return $arrResult;
}

	//FUNCTION GET LAST ROMOOC BY CAR ID
	/*public function getLastestTrailers(Request $req){
		$lastestTrailers = [];
		if(isset($req->selLoaiXe) && $req->selLoaiXe == 3 && $req->selXe){
				$lastestTrailersQuery = DB::table('tbl_operating')->where('tbl_operating.car_id', '=', $req->selXe)->where('tbl_operating.trailer_id', '!=', null)->join('tbl_trailer', 'tbl_trailer.trailer_id', '=', 'tbl_operating.trailer_id')->select('tbl_operating.*', 'tbl_trailer.trailer_num')->orderBy('tbl_trailer.trailer_num')->orderBy('tbl_operating.operating_id')->distinct()->get()->toArray();
				if(count($lastestTrailersQuery) < 4)
					$lastestTrailers = $lastestTrailersQuery;
				else{
					array_push($lastestTrailers,$lastestTrailersQuery[0], $lastestTrailersQuery[1], $lastestTrailersQuery[2]);
				}
		}
		$res =(object)[
			'lastestTrailers' => $lastestTrailers
		];
		return Response::json(['success' => $res]);
	}*/

	//function get lastest car info by place - nơi giao
	public function getLastestCarInfoByPlace(Request $req){
		$lastestCars= [];
		if(isset($req->selNoiGiao) && $req->selNoiGiao != null){
			$lastestCarsQuery = DB::table('tbl_operating')->where('tbl_operating.delivery_place_id', '=', $req->selNoiGiao)->join('tbl_car', 'tbl_car.car_id', '=', 'tbl_operating.car_id')->select('tbl_operating.operating_id', 'tbl_car.car_num', 'tbl_operating.trailer_id')->orderBy('tbl_operating.operating_date', 'desc')->orderBy('tbl_operating.operating_id', 'desc')->get()->toArray();
			$trailers = DB::table('tbl_trailer')->select('tbl_trailer.*')->get()->toArray();
			if(count($lastestCarsQuery) > 0)
				for($k = 0; $k< count($lastestCarsQuery); $k++)
					$lastestCarsQuery[$k]->trailer_num = "";
				
				for($i = 0; $i < count($lastestCarsQuery); $i++){
					$tmpCarNum = $lastestCarsQuery[$i]->trailer_id;
					if($tmpCarNum != null && count($trailers) > 0){
						for($j =0; $j < count($trailers); $j++){
							if($tmpCarNum  == $trailers[$j]->trailer_id)
								$lastestCarsQuery[$i]->trailer_num = $trailers[$j]->trailer_num;
						}
					}

				}
				if(count($lastestCarsQuery) < 4)
					$lastestCars = $lastestCarsQuery;
				else
					array_push($lastestCars,$lastestCarsQuery[0], $lastestCarsQuery[1], $lastestCarsQuery[2]);

			}

			$res =(object)[
				'lastestCars' => $lastestCars
			];
			return Response::json(['success' => $res]);
		}
		// function filter array
		public function arrayFilter($parentArray, $parentColumn, $childArray, $childColumn){
			$arrResult = [];
			for($i = 0 ; $i < count($childArray); $i++){
				for($j = 0 ; $j < count($parentArray); $j++){
					if($parentArray[$j]->$parentColumn == $childArray[$i]->$childColumn)
						array_push($arrResult, $parentArray[$j]);
				}
			}
			return $arrResult;
		}
		// function check element exists in array
		public function checkExitsArray($array, $columnFilter, $value){
			if(count($array) > 0){
				for($i = 0; $i < count($array); $i++){
					if($array[$i][$columnFilter] ==  $value)

						return true;
				}
			}
			return false;
		}
		// function get day in week - betwwen 2 dates
		function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber)
		{
			$startDate = strtotime($startDate);
			$endDate = strtotime($endDate);
			$dateArr = array();
			do
			{
				if(date("w", $startDate) != $weekdayNumber)
				{
			// add 1 day
					$startDate += (24 * 3600); 
				}
			} while(date("w", $startDate) != $weekdayNumber);
			while($startDate <= $endDate)
			{
				$dateArr[] = date('Y-m-d', $startDate);
    	// add 7 days
				$startDate += (7 * 24 * 3600); 
			}
			return($dateArr);
		}

		// FUNCTION GET DRIVER INFOR FOR OPERATING
		public function getDriverInfoForOperating(Request $req){
			$numberOfScheduleCurrentMonth;
			$numberOfScheduleLastMonth;
			$countHYOSUNG = 0; // đếm số xe đến Hyosung 
			$idHYOSUNG = 11; //id nới giao HYOSUNG -  cần thay đổi khi có database chính thức - column: delivery_place_id
			$countFAR = 0;	// đếm số xe đến FAR
			$idFAR = 2; // id nới giao FAR
			$notWorkingDates = [];
			$holiday =['04-30', '05-01', '03-10']; // month - date
			$top =1;
			$topLastMonth = 1;
			$numberOfScheduleByCarType = null;
			$transdate = date('m-d-Y', time());
			$month = date('m');
			$year = date('Y');
			$date = date('d');
			// var_dump($date);
			$carType;
			$startTime = $year."-".$month."-01";
			$endTime = $year."-".$month."-".$date;
			// var_dump($transdate);exit;
			
			// FORMAT HOLYDAY ALLOW CURRENT YEAR
			if(count($holiday) > 0){
				for($i = 0 ; $i < count($holiday); $i++){
					$holiday[$i] = $year."-".$holiday[$i];
				}
			}
			// get all sunday
			$sunDays = $this->getDateForSpecificDayBetweenDates($startTime, $endTime, 0);
			$outDates = array_merge($sunDays,$holiday);
			// ==== GET all date from 01 - current month - current year to today
			$begin = new DateTime($startTime);
			$end = new DateTime($endTime);

			$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
			$fullDate =[];
			foreach($daterange as $date){
				$tmpDate1 =  $date->format("Y-m-d");
				array_push($fullDate, $tmpDate1);
			}
			
			// get all driver and count their operating in current month
			$allDrivers = DB::table('tbl_operating')->groupBy('driver_id')->select('driver_id', 'car_type_id',  DB::raw("COUNT(*) as count_row"))->where('status', '=', 2)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
			// case DRIVER
			if($req->type == 0 && isset($req->selTaiXe ) && $req->selTaiXe != null){
				// count not working dates
				$workingDate = DB::table('tbl_operating')->select('operating_date')->where('status', '=', 2)->where('driver_id', '=', $req->selTaiXe )->where('operating_date', '<=', $endTime)->where('operating_date', '>', $startTime)->pluck('operating_date');
				if(count($workingDate) > 0){
					$tmpDateArray = [];
					for($i= 0; $i < count($workingDate); $i++){
						$tmpDate = explode(" ",$workingDate[$i]);
						array_push($tmpDateArray, $tmpDate[0]);
					}
					$outDates = array_merge($outDates,$tmpDateArray);
				}
				for($d = 0; $d < count($fullDate); $d++){
					if(!in_array($fullDate[$d], $outDates))
						array_push($notWorkingDates, $fullDate[$d]);
				}
				// ./ count not working dates
				// get car type of Driver
				$carType = DB::table('tbl_car')->select('car_type_id')->where('driver_suggestion', '=', $req->selTaiXe)->first();
				if(isset($carType) && $carType != null){
				$driversSameType = DB::table('tbl_car')->groupBy('driver_suggestion')->select('car_type_id', DB::raw("MIN(driver_suggestion) as driver_suggestion"))->where('car_type_id', '=', $carType->car_type_id)->get()->toArray();//->pluck('driver_suggestion');
				// get all drivers by same car type 
				$drivers = $this->arrayFilter($allDrivers, 'driver_id', $driversSameType, 'driver_suggestion');
			}
			// count operating in current month of curent driver
			$scheduleCurrentMonth = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.driver_id', '=', $req->selTaiXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->where('status', '=', 2)->get()->toArray();
			$numberOfScheduleCurrentMonth  =count($scheduleCurrentMonth);
			// cal TOP of current month
			$flagChagneTop = false;
			if(isset($drivers) && $drivers !=null){
				if(count($drivers) > 0){
					$compareValues = [-1];
					for($d =0; $d < count($drivers); $d++){
						$checkExist = in_array($drivers[$d]->count_row, $compareValues);
						if($drivers[$d]->count_row > $numberOfScheduleCurrentMonth && $checkExist ==  false){
							$top++;
							array_push($compareValues, $drivers[$d]->count_row);
						}
					}
				}
			}
			$countHYOSUNG = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.driver_id', '=', $req->selTaiXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->where('delivery_place_id', '=', $idHYOSUNG)->where('status', '=', 2)->count();
			$countFAR = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.driver_id', '=', $req->selTaiXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->where('delivery_place_id', '=', $idFAR)->where('status', '=', 2)->count();
			$numberOfScheduleByCarType = DB::table('tbl_operating')->where('tbl_operating.driver_id', '=', $req->selTaiXe)->where('tbl_operating.status', '=', 2)->groupBy('tbl_operating.car_type_id')->join('tbl_car_type', 'tbl_car_type.car_type_id', '=', 'tbl_operating.car_type_id')->select('tbl_car_type.name', 'tbl_operating.car_type_id', DB::raw("COUNT(*) as count_row"))->get()->toArray();
			if($month > 1)
				$month = $month -1;
			else{
				$month =12;
				$year = $year -1;
			}	
			$scheduleLastMonth = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.driver_id', '=', $req->selTaiXe)->where('tbl_operating.status', '=', 2)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
			$numberOfScheduleLastMonth = count($scheduleLastMonth);
				// top
			$allDriversLastMonth  = DB::table('tbl_operating')->groupBy('driver_id')->select('driver_id', 'car_type_id',  DB::raw("COUNT(*) as count_row"))->where('status', '=', 2)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
			// $driversLastMonth = $this->arrayFilter($allDrivers, 'driver_id', $driversSameType, 'driver_suggestion');
			//
			if(isset($carType) && $carType != null){
				$driversSameType = DB::table('tbl_car')->groupBy('driver_suggestion')->select('car_type_id', DB::raw("MIN(driver_suggestion) as driver_suggestion"))->where('car_type_id', '=', $carType->car_type_id)->get()->toArray();//->pluck('driver_suggestion');
				$driversLastMonth = $this->arrayFilter($allDriversLastMonth, 'driver_id', $driversSameType, 'driver_suggestion');
			}
			//
			if(isset($driversLastMonth) && $driversLastMonth !=null){
				if(count($driversLastMonth) > 0){
					$compareValues = [-1];
					for($d =0; $d < count($driversLastMonth); $d++){
						$checkExist = in_array($driversLastMonth[$d]->count_row, $compareValues);
						if($driversLastMonth[$d]->count_row > $numberOfScheduleLastMonth && $checkExist ==  false){
							$topLastMonth++;
							array_push($compareValues, $driversLastMonth[$d]->count_row);
						}
					}
				}
			}
		}
		// ======================= CASE ASSISTANT DRIVER ================================
		if($req->type != 0 && isset($req->selPhuXe ) && $req->selPhuXe != null){
			
			// start test date

			$transdate = date('m-d-Y', time());
			$month = date('m');
			$year = date('Y');

			// count not working dates
			$workingDate = DB::table('tbl_operating')->select('operating_date')->where('status', '=', 2)->where('assistant_driver_id', '=', $req->selPhuXe )->where('operating_date', '<=', $endTime)->where('operating_date', '>', $startTime)->pluck('operating_date');
			if(count($workingDate) > 0){
				$tmpDateArray = [];
				for($i= 0; $i < count($workingDate); $i++){
					$tmpDate = explode(" ",$workingDate[$i]);
					array_push($tmpDateArray, $tmpDate[0]);
				}
				$outDates = array_merge($outDates,$tmpDateArray);
			}
			for($d = 0; $d < count($fullDate); $d++){
				if(!in_array($fullDate[$d], $outDates))
					array_push($notWorkingDates, $fullDate[$d]);
			}
				// ./ count not working dates



			//  end test date

			$assistantDrivers = DB::table('tbl_operating')->groupBy('assistant_driver_id')->select('assistant_driver_id',  DB::raw("COUNT(*) as count_row"))->where('status', '=', 2)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();

			$countHYOSUNG = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.assistant_driver_id', '=', $req->selPhuXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->where('delivery_place_id', '=', $idHYOSUNG)->where('status', '=', 2)->count();
			$countFAR = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.assistant_driver_id', '=', $req->selPhuXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->where('delivery_place_id', '=', $idFAR)->where('status', '=', 2)->count();
			$scheduleCurrentMonth = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.assistant_driver_id', '=', $req->selPhuXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
			$numberOfScheduleCurrentMonth = count($scheduleCurrentMonth);
			if($month > 1)
				$month = $month -1;
			else{
				$month =12;
				$year = $year -1;
			}
			$scheduleLastMonth = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.assistant_driver_id', '=', $req->selPhuXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
			$numberOfScheduleLastMonth = count($scheduleLastMonth);
					// ====================================
			$flagChagneTop = false;
			if(count($assistantDrivers) > 0){
				//TOP CURRENT MONTH
				$compareValues = [-1];
				for($d =0; $d < count($assistantDrivers); $d++){
					$checkExist = in_array($assistantDrivers[$d]->count_row, $compareValues);
					if($assistantDrivers[$d]->count_row > $numberOfScheduleCurrentMonth && $checkExist ==  false){
						$top++;
						array_push($compareValues, $assistantDrivers[$d]->count_row);
					}
				}

				$assistantDriversLastMonth = DB::table('tbl_operating')->groupBy('assistant_driver_id')->select('assistant_driver_id',  DB::raw("COUNT(*) as count_row"))->where('status', '=', 2)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
				//TOP LAST MONTH
				$compareValues = [-1];
				for($d =0; $d < count($assistantDriversLastMonth); $d++){
					$checkExist = in_array($assistantDriversLastMonth[$d]->count_row, $compareValues);
					if($assistantDriversLastMonth[$d]->count_row > $numberOfScheduleLastMonth && $checkExist ==  false){
						// var_dump($assistantDriversLastMonth[$d]->count_row); exit;
						$topLastMonth++;
						array_push($compareValues, $assistantDriversLastMonth[$d]->count_row);
					}
				}

			}

				// =====================================
		}
		$res =(object)[
			'numberOfScheduleCurrentMonth'=>$numberOfScheduleCurrentMonth,
			'numberOfScheduleLastMonth'=>$numberOfScheduleLastMonth,
			'countHYOSUNG'=>$countHYOSUNG,
			'countFAR'=>$countFAR,
			'numberOfScheduleByCarType'=>$numberOfScheduleByCarType,
			'top'=>$top,
			'topLastMonth'=>$topLastMonth,
			'currentMonth'=>$month,
			'outDates'=>$outDates,
			'notWorkingDates'=>$notWorkingDates,
			'fullDate'=>$fullDate
		];
		return Response::json(['success' => $res]);
	}
	//function check suggest Tools
	public function checkSuggestTool($arrSuggestTool, $arrTool){
		$cSuggestTool = count($arrSuggestTool);
		$cTools = count($arrTool);
		if($cSuggestTool <1 || $cTools <1)
			return false;
		for($i = 0; $i < $cSuggestTool; $i ++)
		{
			for($j=0; $j <$cTools; $j++){
				if($arrSuggestTool[$i]->tool_id == $arrTool[$j]->tool_id && $arrTool[$j]->num < $arrSuggestTool[$i]->num){
					if($arrTool[$j]->num < $arrSuggestTool[$i]->num || $arrTool[$j]->num < 1)
						return false;
				}
			}
		}
		return true;
	}
	// get Operating suggest by hot Key
	public function getSuggestOperatingByHotKey(Request $req){

		$validator = validator::make($req->all(),[
			'selChuHang' => 'required',
		]
		,[
			'selChuHang.required' => 'Chưa chọn chủ hàng',

		]);
		if($validator->passes()){
			$count = DB::table('tbl_operating')->where('owner_id','=', $req->selChuHang);
			if(isset($req->selLoaiHang) && trim($req->selLoaiHang)!=='')
				$count = $count->where('goods_id','=', $req->selLoaiHang);
			if(isset($req->selNoiNhan) && trim($req->selNoiNhan)!=='')
				$count = $count->where('receipt_place_id','=', $req->selNoiNhan);
			if(isset($req->selNoiGiao) && trim($req->selNoiGiao)!=='')
				$count = $count->where('delivery_place_id','=', $req->selNoiGiao);

			$count = $count->count();

			if($count <  1)
				return Response::json(['errors' => 'that bai']);
			$operating = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.owner_id', "=", $req->selChuHang);
			if(isset($req->selLoaiHang) && trim($req->selLoaiHang)!=='')
				$operating = $operating->where('goods_id','=', $req->selLoaiHang);
			if(isset($req->selNoiNhan) && trim($req->selNoiNhan)!=='')
				$operating = $operating->where('receipt_place_id','=', $req->selNoiNhan);
			if(isset($req->selNoiGiao) && trim($req->selNoiGiao)!=='')
				$operating = $operating->where('delivery_place_id','=', $req->selNoiGiao);
			$operating = $operating->orderBy('operating_id', 'desc')->first();

			$busyCars =  DB::table('tbl_operating')->select('tbl_operating.car_id')->whereNotNull('car_id')->where('tbl_operating.status', "=", 1)->pluck('car_id');
			$busyDrivers = DB::table('tbl_operating')->select('tbl_operating.driver_id')->where('tbl_operating.status', "=", 1)->pluck('driver_id');
			$busyAssistantDriver = DB::table('tbl_operating')->select('tbl_operating.assistant_driver_id')->where('tbl_operating.status', "=", 1)->pluck('assistant_driver_id');
			$suggestCar = DB::table('tbl_operating')->select('tbl_operating.car_id')->whereNotNull('car_id')->where('tbl_operating.car_type_id', "=", $operating->car_type_id)->whereNotIn('tbl_operating.car_id', $busyCars)->orderBy('operating_date', 'desc')->pluck('car_id');
			//get suggest romooc
			$busyRomoocs =  DB::table('tbl_operating')->select('tbl_operating.trailer_id')->whereNotNull('trailer_id')->where('tbl_operating.status', "=", 1)->whereNotNull('tbl_operating.trailer_id')->pluck('trailer_id');
			// $suggestRomooc = DB::table('tbl_operating')->select('tbl_operating.trailer_id')->where('tbl_operating.status', "=", 2)->where('tbl_operating.car_type_id', "=", $operating->car_type_id)->whereNotIn('tbl_operating.trailer_id', $busyRomoocs)->orderBy('operating_date', 'desc')->pluck('trailer_id');
			$suggestRomooc = DB::table('tbl_operating')->select('tbl_operating.trailer_id')->whereNotNull('trailer_id')->where('tbl_operating.status', "=", 2)->where('tbl_operating.trailer_type_id', "=", $operating->trailer_type_id)->whereNotIn('tbl_operating.trailer_id', $busyRomoocs)->orderBy('operating_date', 'desc')->pluck('trailer_id');
			//get suggest driver
			$suggestDriver =  DB::table('tbl_operating')->select('tbl_operating.driver_id')->where('tbl_operating.status', "=", 2)->where('tbl_operating.car_type_id', "=", $operating->car_type_id)->whereNotIn('tbl_operating.driver_id', $busyDrivers)->orderBy('operating_date', 'desc')->pluck('driver_id');
			// get suggest assistan driver
			$suggestAssistantDriver =  DB::table('tbl_operating')->select('tbl_operating.assistant_driver_id')->where('tbl_operating.status', "=", 2)->where('tbl_operating.car_type_id', "=", $operating->car_type_id)->whereNotIn('tbl_operating.assistant_driver_id', $busyAssistantDriver)->orderBy('operating_date', 'desc')->pluck('assistant_driver_id');
			//get suggest tools
			// $operatingTools = DB::table('tbl_operating_tool')->select('tbl_operating_tool.*')->where('tbl_operating_tool.operating_id', "=", $operating->operating_id)->get()->toArray();
			$operatingTools = DB::table('tbl_operating_tool')->join('tbl_tool', 'tbl_tool.tool_id', '=', 'tbl_operating_tool.tool_id')->select('tbl_operating_tool.*', 'tbl_tool.name')->where('tbl_operating_tool.operating_id', "=", $operating->operating_id)->get()->toArray();
			$tools = DB::table('tbl_tool')->select('tbl_tool.*')->get()->toArray();
			$query1 = "CAST(order_show AS UNSIGNED) DESC";
			$testO =  DB::table('tbl_operating')->select('tbl_operating.order_show')->orderByRaw($query1)->get()->toArray();
			// $testtoDayRecord =  DB::table('tbl_operating')->select('tbl_operating.order_show')->whereRaw('Date(operating_date) = CURDATE()')->get()->first();
			$testtoDayRecord = Operating::whereDate('operating_date', DB::raw('CURDATE()'))->get();			/*
			SELECT * FROM table where DATE(date)=CURDATE()
			*/
			$operating->testO = $testO;
			$operating->testtoDayRecord = $testtoDayRecord;
			

			// $busyRomoocs1 =  DB::table('tbl_operating')->select('tbl_operating.trailer_id')->where('tbl_operating.status', "=", 1)->pluck('trailer_id');
			// // $suggestRomooc = DB::table('tbl_operating')->select('tbl_operating.trailer_id')->where('tbl_operating.status', "=", 2)->where('tbl_operating.car_type_id', "=", $operating->car_type_id)->whereNotIn('tbl_operating.trailer_id', $busyRomoocs)->orderBy('operating_date', 'desc')->pluck('trailer_id');
			// var_dump($busyRomoocs1); 
			// $arr = [1,2,null];
			// $suggestRomooc1 = DB::table('tbl_operating')->select('tbl_operating.trailer_id')->where('tbl_operating.status', "=", 2)->where('tbl_operating.trailer_type_id', "=", $operating->trailer_type_id)->whereNotIn('tbl_operating.trailer_id', $arr)->orderBy('operating_date', 'desc')->pluck('trailer_id');

			// var_dump($suggestRomooc1); exit;
			// // dd($suggestRomooc1);
			// $operating->busyRomoocs1=$busyRomoocs1;
			// $operating->suggestRomooc1 =$suggestRomooc1;

			
			$checkSuggestTool = $this->checkSuggestTool($operatingTools, $tools);
			$operating->tools = $checkSuggestTool;
			$operating->busyRomoocs = $busyRomoocs;
			$operating->busyCars = $busyCars;
			// if(count($suggestCar) > 0)
			$operating->suggestCar = $suggestCar;
			if(count($suggestRomooc) > 0)
				$operating->suggestRomooc = $suggestRomooc[0];
			if(count($suggestDriver) >0)
				$operating->suggestDriver = $suggestDriver[0];
			if(count($suggestAssistantDriver) >0)
				$operating->suggestAssistantDriver = $suggestAssistantDriver;
			if(count($operatingTools) >0 && $checkSuggestTool)
				$operating->operatingTools = $operatingTools;
			else
				$operating->errSuggestTool = true;

			$res =(object)[
				'operating'=>$operating
			];
			return Response::json(['success' => $res]);
		}
		else{
			return Response::json(['errors' => 'Suggestion operating not found']);
		}

	}
	// Get edit infor
	public function getEditOperating($id){
		$count = DB::table('tbl_operating')->where('operating_id','=', $id)->count();
		if($count<1)
			return Response::json(['errors' => "lỗi"]);
		$operating = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.operating_id', "=", $id)->get()->toArray();
		$goods = DB::table('tbl_goods')->select('tbl_goods.*')->get()->toArray();
		$receiptPlaces = DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->where('tbl_receipt_delivery_place.place_type', "=", 0)->orderBy('tbl_receipt_delivery_place.name')->get()->toArray();
		//$deliveryPlaces= DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->where('tbl_receipt_delivery_place.place_type', "=", 1)->orderBy('tbl_receipt_delivery_place.name')->get()->toArray();
		$deliveryPlaces= DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->where('tbl_receipt_delivery_place.place_type', "=", 1)->orderBy('tbl_receipt_delivery_place.name')->get()->toArray();
		$partners = DB::table('tbl_partner')->select('tbl_partner.*')->orderBy('tbl_partner.partner_short_name')->get()->toArray();
		$customers= DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 14)->orderBy('tbl_user.nick_name')->get()->toArray();
		$carTypes = DB::table('tbl_car_type')->select('tbl_car_type.*')->orderBy('tbl_car_type.name')->get()->toArray();
		$trailers = DB::table('tbl_trailer')->select('tbl_trailer.*')->orderBy('tbl_trailer.trailer_num')->get()->toArray();
		$trailerTypes = DB::table('tbl_trailer_type')->select('tbl_trailer_type.*')->orderBy('tbl_trailer_type.trailer_type_name')->get()->toArray();
		$cars = DB::table('tbl_car')->select('tbl_car.*')->orderBy('tbl_car.car_num')->get()->toArray();
		$drivers= DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 12)->where('tbl_user.work_status', "=",  0)->orderBy('tbl_user.nick_name')->get()->toArray();
		$assistantDriver = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 13)->where('tbl_user.work_status', "=",  0)->orderBy('tbl_user.nick_name')->get()->toArray();
		$clearTanks = DB::table('tbl_clear_tank')->select('tbl_clear_tank.*')->orderBy('tbl_clear_tank.clear_tank_name')->get()->toArray();
		$toolCategories = DB::table('tbl_tool_category')->select('tbl_tool_category.*')->orderBy('tbl_tool_category.name')->get()->toArray();
		// $tools = DB::table('tbl_tool')->select('tbl_tool.*')->get()->toArray();
		/*
		$tools = DB::table('tbl_tool')->select('tbl_tool.*')->where('tbl_tool.num', ">", 0)->orderBy('tbl_tool.name')->get()->toArray();
		$fullTools = DB::table('tbl_tool')->select('tbl_tool.*')->orderBy('tbl_tool.name')->get()->toArray();
		*/
		$tools = DB::table('tbl_tool')->where('tbl_tool.num', ">", 0)->leftJoin('tbl_tool_category', 'tbl_tool_category.tool_category_id', '=', 'tbl_tool.tool_category_id')->orderBy('tbl_tool.name')->select('tbl_tool.*', 'tbl_tool_category.tool_type')->get()->toArray();
		$fullTools = DB::table('tbl_tool')->leftJoin('tbl_tool_category', 'tbl_tool_category.tool_category_id', '=', 'tbl_tool.tool_category_id')->orderBy('tbl_tool.name')->select('tbl_tool.*', 'tbl_tool_category.tool_type')->orderBy('tbl_tool.name')->get()->toArray(); 
		$curators = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 15)->orderBy('tbl_user.nick_name')->get()->toArray();
		$operatingTools = DB::table('tbl_operating_tool')->select('tbl_operating_tool.*')->where('tbl_operating_tool.operating_id', "=", $id)->get()->toArray();
		// dd($operatingTools);
		$freeDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 12)->orderBy('tbl_user.nick_name')->where('tbl_user.work_status', "=",  0)->where('tbl_user.status', "=",  0)->whereNotIn('tbl_user.user_id', function($q){
			$q->select('driver_id')->from('tbl_operating')->whereNotNull('driver_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeDriversCopy = $freeDrivers;
		$freeAssistantDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 13)->orderBy('tbl_user.nick_name')->where('tbl_user.work_status', "=",  0)->where('tbl_user.status', "=",  0)->whereNotIn('tbl_user.user_id', function($q){
			$q->select('assistant_driver_id')->from('tbl_operating')->whereNotNull('assistant_driver_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeAssistantDriversCopy = $freeAssistantDrivers;
		$freeCars =  DB::table('tbl_car')->select('tbl_car.*')->orderBy('tbl_car.car_num')->whereNotIn('tbl_car.car_id', function($q){
			$q->select('car_id')->from('tbl_operating')->whereNotNull('car_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeCarsCopy = $freeCars;
		$currentCar = DB::table('tbl_car')->select('tbl_car.*')->where('tbl_car.car_id', '=', $operating[0]->car_id)->first();
		if($currentCar != null){
			array_push($freeCars, $currentCar);
		}
		$freeTrailers =  DB::table('tbl_trailer')->select('tbl_trailer.*')->orderBy('tbl_trailer.trailer_num')->whereNotIn('tbl_trailer.trailer_id', function($q){
			$q->select('trailer_id')->from('tbl_operating')->whereNotNull('trailer_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeTrailersCopy = $freeTrailers;
		$currentTrailer = DB::table('tbl_trailer')->select('tbl_trailer.*')->where('tbl_trailer.trailer_id', '=', $operating[0]->trailer_id)->first();
		if($currentTrailer != null)
			array_push($freeTrailers, $currentTrailer);
		
		$currentDriver = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 12)->where('tbl_user.user_id', "=", $operating[0]->driver_id)->first();
		// if(empty($currentDriver)==false){
		// 	array_push($freeDrivers, $currentDriver[0]);
		//	}
		if($currentDriver != null)
			array_push($freeDrivers, $currentDriver);
		$currentAssistantDriver = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 13)->where('tbl_user.user_id', "=", $operating[0]->assistant_driver_id)->first();
		if($currentAssistantDriver != null){
			array_push($freeAssistantDrivers, $currentAssistantDriver);
		}	



		$res =(object)[
			'operating'=>$operating,
			'goods' => $goods,
			'receiptPlaces'=>$receiptPlaces,
			'deliveryPlaces'=>$deliveryPlaces,
			'partners'=>$partners,
			'customers'=>$customers,
			'carTypes'=>$carTypes,
			'trailers'=>$trailers,
			'cars'=>$cars,
			'drivers'=>$drivers,
			'assistantDrivers'=>$assistantDriver,
			'clearTanks' => $clearTanks,
			'toolCategories' =>$toolCategories,
			'tools'=>$tools,
			'curators'=>$curators,
			'operatingTools'=>$operatingTools,
			'freeDrivers'=>$freeDrivers,
			'freeAssistantDrivers'=>$freeAssistantDrivers,
			'freeCars'=>$freeCars,
			'currentCar'=>$currentCar,
			'currentTrailer'=>$currentTrailer,
			'currentDriver'=>$currentDriver,
			'trailerTypes'=>$trailerTypes,
			'freeTrailers'=>$freeTrailers,
			'fullTools'=>$fullTools,
			'currentAssistantDriver'=>$currentAssistantDriver
		];
		return Response::json(['success' => $res]);
	}
	//FUNCTION COMPLETE OPERATING 
	public function completeOperatingByID($id, $flagDelete = false){
		DB::beginTransaction();
		try{
			$operating1 = DB::table('tbl_operating')->where('operating_id','=', $id)->get()->toArray();
// var_dump($operating1);exit;
			$operating = DB::table('tbl_operating')->where('operating_id','=', $id)->where('status', '=', 1)->get()->toArray();
			// echo "<pre>";
			// var_dump($operating[0]->driver_id);
			// echo "</pre>";
			// exit();
			$flagError = false;
			if(count($operating) < 1)
				$flagError =  true;
			if($flagDelete == false){
				if(count($operating) < 1 || $operating[0]->driver_id == null || $operating[0]->car_id == null)
					$flagError =  true;
			}

			if($flagError == false){
				if($operating[0]->car_type_id == 3 && $operating[0]->trailer_id == null  )
					$flagError =  true;
			}

			if($flagError ==  true){
				DB::commit();
				return false;
			}

			$operatingID = $operating[0]->operating_id;
			$driverID = $operating[0]->driver_id;
			$assistantDriverID = $operating[0]->assistant_driver_id;
			$carID = $operating[0]->car_id;
			$trailerID = $operating[0]->trailer_id;
		//Update status operating
			DB::table('tbl_operating')
			->where('operating_id', $operatingID )
			->update([
				'status' => 2
			]);

		// Update Driver
			if($driverID != null && $driverID != ""){
				$countDriver = DB::table('tbl_operating')->where('driver_id','=', $driverID)->where('status', '=', 1)->count();
				if($countDriver < 2){
				// update status
					DB::table('tbl_user')
					->where('user_id', $driverID )
					->update([
						'status' => 0
					]);
				}
			}
		//update asistant driver
			if($assistantDriverID != null && $assistantDriverID != ""){
				$countAssistantDriver = DB::table('tbl_operating')->where('assistant_driver_id','=', $assistantDriverID)->where('status', '=', 1)->count();
				if($countAssistantDriver < 2){
				// update status
					DB::table('tbl_user')
					->where('user_id', $assistantDriverID )
					->update([
						'status' => 0
					]);
				}
			}
		//update tools
			$operatingTools =  DB::table('tbl_operating_tool')->where('operating_id','=', $id)->get()->toArray();
		// 	echo "<pre>";
		// var_dump($operatingTools);
		// echo "</pre>";
		// 	exit;
			if(count($operatingTools) > 0){
				// var_dump($operatingTools); exit();
				for($i =0; $i < count($operatingTools); $i++){
					$toolID = $operatingTools[$i]->tool_id;
					$tools = DB::table('tbl_tool')->where('tool_id','=', $toolID)->get()->toArray();
					if(count($tools) > 0){
						$numTool = $tools[0]->num;
						$newNumTool = $numTool + $operatingTools[$i]->num;
						DB::table('tbl_tool')
						->where('tool_id', $toolID)
						->update([
							'num' => $newNumTool
						]);
					}
				}
			}
			DB::commit();
			return true;
		}catch(\Exception $e) {
			DB::rollback();
			return Response::json(['errors' => 'that bai']);
		//return $e;
		 // print_r($e);
		}
	}
	//FUNCTION EXCUTE COMPLETE OPERATING
	// public function excuteCompleteOperating($id){
	// 	$result = completeOperatingByID($id);
	// 	if($result)
	// 		return Response::json(['success' => 'thanh cong']);
	// 	return Response::json(['error' => 'that bai']);

	// }
	// Function post edit operating
	public function checkExistOperatingItemStatus($itemID,  $itemType, $array){
		if(count($array) < 1)
			return false;
		if(count($array) == 1){
			if($array[0]->item_type == $itemType && $array[0]->item_id == $itemID)
				return true;
		}
		if(count($array) > 1){
			for($i = 0; $i < count($array); $i++){
				if($array[$i]->item_type == $itemType && $array[$i]->item_id == $itemID)
					return true;
			}	
		}
		return false;

	}
	// Function post edit operating
	public function postEditOperating(Request $req, $response = true){
		DB::beginTransaction();
		try{
			$validator = validator::make($req->all(),[
				'selLoaiHang' => 'required',
				'selChuHang' => 'required',
				'selGoodsType' => 'required'
			]

			,[
				'selLoaiHang.required' => 'Chưa chọn mặt hàng',
				'selChuHang.required' => 'Chưa chọn chủ hàng',
				'selGoodsType.required' => 'Chưa chọn mặt hàng',

			]);
			if($validator->passes()){
			//if(isset($req->selTinhTrang) && $req->selTinhTrang == 1)
				//dd($req->oldCar['car_id']);
				{
					$oldOperatingTools = $req->oldOperatingTools;
					$newOperatingTools = $req->operatingTools;

				// =============== Get free data - START ======================
					$freeCars =  DB::table('tbl_car')->select('tbl_car.*')->orderBy('tbl_car.car_num')->whereNotIn('tbl_car.car_id', function($q){
						$q->select('car_id')->from('tbl_operating')->whereNotNull('car_id' )->where('status', "=", 1);
					})->pluck('car_id')->toArray();
					if($req->oldCar['car_id'] != null)
						array_push($freeCars, $req->oldCar['car_id']);

					$freeTrailers =  DB::table('tbl_trailer')->select('tbl_trailer.*')->orderBy('tbl_trailer.trailer_num')->whereNotIn('tbl_trailer.trailer_id', function($q){
						$q->select('trailer_id')->from('tbl_operating')->whereNotNull('trailer_id' )->where('status', "=", 1);
					})->pluck('trailer_id')->toArray();
					if($req->oldTrailer['trailer_id'] != null)
						array_push($freeTrailers, $req->oldTrailer['trailer_id']);

					$freeDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.work_status', "=",  0)->where('tbl_user.status', "=",  0)->orderBy('tbl_user.nick_name')->where('tbl_user.user_type', "=", 12)->whereNotIn('tbl_user.user_id', function($q){
						$q->select('driver_id')->from('tbl_operating')->whereNotNull('driver_id' )->where('status', "=", 1);
					})->pluck('user_id')->toArray();
					$freeAssistantDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 13)->where('tbl_user.work_status', "=",  0)->where('tbl_user.status', "=",  0)->orderBy('tbl_user.nick_name')->whereNotIn('tbl_user.user_id', function($q){
						$q->select('assistant_driver_id')->from('tbl_operating')->whereNotNull('assistant_driver_id' )->where('status', "=", 1);
					})->pluck('user_id')->toArray();
					$freeTools = DB::table('tbl_tool')->where('tbl_tool.num', '>', 0)->pluck('tool_id')->toArray();
					$operatingItemStatus = DB::table('tbl_operating_item_status')->where('tbl_operating_item_status.operating_id', '=', $req->operating_id)->get()->toArray();	

				// =============== Get free data - END ========================
					$dataOperatingItemStatus = [];
					//case driver
					if(isset($req->selTaiXe) && $req->selTaiXe != null && $req->selTaiXe !=''){
						$checkDriver = $this->checkExistOperatingItemStatus($req->selTaiXe,  1, $operatingItemStatus);
						if(!$checkDriver){
							DB::table('tbl_operating_item_status')->where('operating_id', '=', $req->operating_id)->where('item_type', '=', 1)->delete();
							$statusDriver = 0;		
							if(!in_array($req->selTaiXe, $freeDrivers))
								$statusDriver = 1;	
							$dataDriver = ['item_id'=>$req->selTaiXe, 'item_type'=>1, 'status'=>$statusDriver, 'operating_id'=>$req->operating_id];
							array_push($dataOperatingItemStatus, $dataDriver);	
						}	

					}else{
						DB::table('tbl_operating_item_status')->where('operating_id', '=', $req->operating_id)->where('item_type', '=', 1)->delete();
					}

					//case asistant
					if(isset($req->selPhuXe) && $req->selPhuXe != null && $req->selPhuXe !=''){
						$checkDriver = $this->checkExistOperatingItemStatus($req->selPhuXe,  2, $operatingItemStatus);

						if(!$checkDriver){
							DB::table('tbl_operating_item_status')->where('operating_id', '=', $req->operating_id)->where('item_type', '=', 2)->delete();
							$statusAssistantDriver = 0;		
							if(!in_array($req->selPhuXe, $freeAssistantDrivers))
								$statusAssistantDriver = 1;	
							$dataAssistantDriver = ['item_id'=>$req->selPhuXe, 'item_type'=>2, 'status'=>$statusAssistantDriver, 'operating_id'=>$req->operating_id];
							array_push($dataOperatingItemStatus, $dataAssistantDriver);	
						}	

					}else{
						DB::table('tbl_operating_item_status')->where('operating_id', '=', $req->operating_id)->where('item_type', '=', 2)->delete();
					}

					//case Car
					try{
						if(isset($req->selXe) && $req->selXe != null && $req->selXe !=''){
							$checkCar = $this->checkExistOperatingItemStatus($req->selXe,  3, $operatingItemStatus);
							// dd($checkCar);
							if(!$checkCar){
								DB::table('tbl_operating_item_status')->where('operating_id', '=', $req->operating_id)->where('item_type', '=', 3)->delete();
								$statusCar = 0;		
								if(!in_array($req->selXe, $freeCars))
									$statusCar = 1;	
								$dataCar = ['item_id'=>$req->selXe, 'item_type'=>3, 'status'=>$statusCar, 'operating_id'=>$req->operating_id];
								array_push($dataOperatingItemStatus, $dataCar);	
							}	

						}else{
							DB::table('tbl_operating_item_status')->where('operating_id', '=', $req->operating_id)->where('item_type', '=', 3)->delete();
						}
					}catch(\Exception $e){return $e;}

					//case Romooc
					if(isset($req->selRomooc) && $req->selRomooc != null && $req->selRomooc !=''){
						$checkRomooc = $this->checkExistOperatingItemStatus($req->selRomooc,  4, $operatingItemStatus);
						if(!$checkRomooc){
							DB::table('tbl_operating_item_status')->where('operating_id', '=', $req->operating_id)->where('item_type', '=', 4)->delete();
							$statusRomooc = 0;		
							if(!in_array($req->selRomooc, $freeTrailers))
								$statusRomooc = 1;	
							$dataRomooc = ['item_id'=>$req->selRomooc, 'item_type'=>4, 'status'=>$statusRomooc, 'operating_id'=>$req->operating_id];
							array_push($dataOperatingItemStatus, $dataRomooc);	
						}	

					}else{
						DB::table('tbl_operating_item_status')->where('operating_id', '=', $req->operating_id)->where('item_type', '=', 4)->delete();
					}

					//case Tool
					if(!empty($newOperatingTools) && count($newOperatingTools) > 0){
						//checkExitsArray($array, $columnFilter, $value)
						try{
							for($i=0; $i<count($newOperatingTools); $i++){
								$checkOldTool = false;
								if(!empty($oldOperatingTools) && count($oldOperatingTools) > 0)
									$checkOldTool = $this->checkExitsArray($oldOperatingTools, 'tool_id', $newOperatingTools[$i]['tool_id']);
								if($checkOldTool == false){
									$statusTool = 0;		
									if(!in_array($newOperatingTools[$i]['tool_id'], $freeTools))
										$statusTool = 1;
									$dataTool = ['item_id'=>$newOperatingTools[$i]['tool_id'], 'item_type'=>5, 'status'=>$statusTool, 'operating_id'=>$req->operating_id];
									array_push($dataOperatingItemStatus, $dataTool);	
								}
							}
							if(!empty($oldOperatingTools) && count($oldOperatingTools) >0){
								for($j=0; $j < count($oldOperatingTools); $j++){
									$checkNewTool = $this->checkExitsArray($newOperatingTools, 'tool_id', $oldOperatingTools[$j]['tool_id']);
									$deleteOldToolID = $oldOperatingTools[$j]['tool_id'];
									if(!$checkNewTool)
										DB::table('tbl_operating_item_status')->where('operating_id', '=', $req->operating_id)->where('item_type', '=', 5)->where('item_id', '=', $deleteOldToolID)->delete();

								}
							}
						}catch(\Exception $e){return $e;}
					}else{

						
						DB::table('tbl_operating_item_status')->where('operating_id', '=', $req->operating_id)->where('item_type', '=', 5)->delete();
						
					}

					if(count($dataOperatingItemStatus) >0){
						try{
							DB::table('tbl_operating_item_status')->insert($dataOperatingItemStatus);
						}catch(\Exeoption $e){return $e;}
					}						

				// =============== validate busy data=================
					if($req->freeRule != 1){
						$errorsBusyData = []; 
						if(isset($req->selTaiXe) && $req->selTaiXe != null && $req->selTaiXe !='' && $req->selTaiXe != $req->oldDriver['user_id']){
							$countDriver = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.driver_id', "=", $req->selTaiXe)->where('tbl_operating.status', '=', 1)->count();
							if($countDriver > 0)
								$errorsBusyData['selTaiXe'] = "Tài xế đang trong chuyến đi khác";
						}
						if(isset($req->selPhuXe) && $req->selPhuXe != null && $req->selPhuXe !='' && $req->selPhuXe != $req->oldAsssistantDriver['user_id']){
							$countAssistantDriver = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.assistant_driver_id', "=", $req->selPhuXe)->where('tbl_operating.status', '=', 1)->count();
							if($countAssistantDriver >0)
								$errorsBusyData['selPhuXe'] = "Phụ xe đang trong chuyến đi khác";
						}
						if(isset($req->selXe) && $req->selXe != null && $req->selXe !='' && $req->selXe != $req->oldCar['car_id']){
							$countCar = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.car_id', "=", $req->selXe)->where('tbl_operating.status', '=', 1)->count();
							if($countCar >0)
								$errorsBusyData['selXe'] = "Xe đang trong chuyến đi khác";
						}
						if(isset($req->selRomooc) && $req->selRomooc != null && $req->selRomooc !='' && $req->selRomooc != $req->oldTrailer['trailer_id']){
							$countRomooc = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.trailer_id', "=", $req->selRomooc)->where('tbl_operating.status', '=', 1)->count();
							if($countRomooc >0)
								$errorsBusyData['selRomooc'] = "Romooc đang trong chuyến đi khác";
						}
						if(!empty($newOperatingTools) && count($newOperatingTools) > 0){
							$toolErrors = [];
							for($i = 0; $i< count($newOperatingTools); $i++){

								$tmpToolID = $newOperatingTools[$i]['tool_id'];
								$checkExist = false;
								if($oldOperatingTools != null && is_array($oldOperatingTools) == true && count($oldOperatingTools) > 0	)
									$checkExist = $this->checkExitsArray($oldOperatingTools, 'tool_id', $tmpToolID);
								if($checkExist == false){
									$countTmpTool = DB::table('tbl_tool')->select('tbl_tool.*')->where('tbl_tool.tool_id', "=", $tmpToolID)->where('tbl_tool.num', '<', 1)->count();
									if($countTmpTool > 0)
										array_push($toolErrors, $tmpToolID);
								}
							}
							if(count($toolErrors) >0)
								$errorsBusyData['toolErrors'] = $toolErrors;
						}
						if(count($errorsBusyData) > 0){
							return Response::json(['errorsBusyData' => $errorsBusyData]);
						}

					}



				// ================================


				// var_dump($req->oldDriver);exit();

				// == update 
					DB::table('tbl_operating')
					->where('operating_id', $req->operating_id)
					->update([
						'goods_id' => $req->selLoaiHang,
						'goods_type'=>$req->selGoodsType,
						'owner_id'=>$req->selChuHang,
						'group_num'=>$req->txtMaGopChuyen,
						'operating_date'=>$req->txtNgayDieuXe,
						'receipt_place_id' => $req->selNoiNhan,
						'before_receipt_note' => $req->txtNDTruocNoiNhan,
						'after_receipt_note' => $req->txtNDSauNoiNhan,
						'delivery_place_id' => $req->selNoiGiao,
						'before_delivery_note' => $req->txtNDTruocNoiGiao,
						'after_delivery_note' => $req->txtNDSauNoiGiao,
						'note' => $req->txtGhiChu,
						'document1' => $req->txtCTMT1,
						'document2' => $req->txtCTMT2,
						'curator_id' => $req->selNguoiPhuTrach,
						'car_type_id' => $req->selLoaiXe,
						'car_id' => $req->selXe,
						'trailer_id' => $req->selRomooc,
						'driver_id' => $req->selTaiXe,
						'before_driver_note' => $req->txtNDTruocTaiXe,
						'after_driver_note' => $req->txtNDSauTaiXe,
						'assistant_driver_id' => $req->selPhuXe,
						'before_assistant_note' => $req->txtNDTruocPhuXe,
						'after_assistant_note' => $req->txtNDSauPhuXe,
						'clear_tank_id' => $req->selXitBon,
						'departure_time' => $req->txtGioDi,
					'status' => 1,//$req->selTinhTrang
					'num' => $req->txtSoLuongHangHoa,
					'order_show'=>$req->orderShow,
					'before_owner_note'=>$req->txtNDTruocChuHang,
					'after_owner_note'=>$req->txtNDSauChuHang,
					'trailer_type_id'=>$req->selLoaiRomooc,
					'rerule' => $req->freeRule
					
				]);
					$oldStatus = $req->oldStatus;
				// update and delete record of tbl_operating_tool
					if(!empty($oldOperatingTools)){
						$oldCount = count($oldOperatingTools);
						for($i = 0; $i < $oldCount; $i++){
							$tmpQuantity = DB:: table('tbl_tool')->select('tbl_tool.num')->where('tbl_tool.tool_id', '=', $oldOperatingTools[$i]['tool_id'])->get()->toArray();
						//if old status == 1 => state not complete =>update num
							if($oldStatus == 1){
								$updateQuantity = $tmpQuantity[0]->num + $oldOperatingTools[$i]['num'];
								DB::table('tbl_tool')
								->where('tool_id', $oldOperatingTools[$i]['tool_id'])
								->update(['num' => $updateQuantity]);
							}
							DB::table('tbl_operating_tool')->where('operating_id', '=', $req->operating_id)->where('tool_id', '=', $oldOperatingTools[$i]['tool_id'] )->delete();
						}
					}
					if(!empty($newOperatingTools)){
						$numOperatingTools = count($newOperatingTools);
						for($i = 0 ; $i < $numOperatingTools; $i++){
							$operatingTool = new OperatingTool();
							$operatingTool->operating_id =$req->operating_id;
							$operatingTool->tool_id = $newOperatingTools[$i]['tool_id'];
							$operatingTool->tool_category_id = $newOperatingTools[$i]['tool_category_id'];
							$operatingTool->tool_type = $newOperatingTools[$i]['tool_type'];
							$operatingTool->num = $newOperatingTools[$i]['num'];
							$operatingTool->operating_date = $req->txtNgayDieuXe;
							$operatingTool->save();

							$tool = DB::table('tbl_tool')->select('tbl_tool.*')->where('tbl_tool.tool_id', "=", $newOperatingTools[$i]['tool_id'])->get()->toArray();
							$quantity = $tool[0]->num;
							$quantity = $quantity - $newOperatingTools[$i]['num'];
						// var_dump($quantity);exit;
							DB::table('tbl_tool')
							->where('tool_id', $tool[0]->tool_id)
							->update(['num' => $quantity]);
						}
					}

				//update work status driver 
					if(isset($req->selTaiXe) && $req->selTaiXe != ""){
						$countDriver =  DB::table('tbl_user')->where('user_id','=', $req->selTaiXe )->count();
						if($countDriver > 0){
							DB::table('tbl_user')
							->where('user_id', $req->selTaiXe)
							->update(['status' => 1]);
						}
					}
				// case old driver diferent new driver

					if(isset($req->oldDriver['user_id']) && $req->oldDriver['user_id'] != "" && $req->oldDriver['user_id'] != null && $req->oldDriver['user_id'] != $req->selTaiXe){
						$countDriver = DB::table('tbl_operating')->where('driver_id','=', $req->oldDriver['user_id'])->where('status', '=', 1)->count();
						if($countDriver < 2){
				// update status
							DB::table('tbl_user')
							->where('user_id', $req->oldDriver['user_id'] )
							->update([
								'status' => 0
							]);
						}
					}
				//update work status assistant driver
					if(isset($req->selPhuXe) && $req->selPhuXe != ""){
						$countAssistantDriver =  DB::table('tbl_user')->where('user_id','=', $req->selTaiXe )->count();
						if($countAssistantDriver > 0){
							DB::table('tbl_user')
							->where('user_id', $req->selPhuXe)
							->update(['status' => 1]);
						}
					}
				// case old assistant driver diferent new assistant driver 
					if(isset($req->oldAsssistantDriver['user_id']) && $req->oldAsssistantDriver['user_id'] != "" && $req->oldAsssistantDriver['user_id'] != null && $req->oldAsssistantDriver != $req->selPhuXe){
						$countAssistantDriver = DB::table('tbl_operating')->where('driver_id','=', $req->oldAsssistantDriver)->where('status', '=', 1)->count();
						if($countAssistantDriver < 2){
				// update status
							DB::table('tbl_user')
							->where('user_id', $req->oldAsssistantDriver['user_id'])
							->update([
								'status' => 0
							]);
						}
					}
				//
				}
			//else
				if(isset($req->selTinhTrang) && $req->selTinhTrang ==2)
				{

					$checkCompleteOperating = $this->completeOperatingByID($req->operating_id);
					if(!$checkCompleteOperating){
						if($response)
							return Response::json(['errors' => 'that bai1']);
						else
							return false;
					}
					// else
					// 	return Response::json(['success' => $req->all()]);
				}
				$this->createHistoryOperating($req->operating_id); // create History
			// end
				DB::commit();
				if($response)
					return Response::json(['success' => $req->all()]);
				else
					return true;
			}
			if($response)
				return Response::json(['errors' => 'that bai']);
			else
				return false;
		}catch(\Exception $e) {
			// return $e;
			DB::rollback();
			if($response)
				return Response::json(['errors' => 'that bai1']);
			else
				return false;
		}
	}

	// function delete Operating
	public function getDeleteOperating($id){
		// echo "string";
		// $count = DB::table('tbl_operating')->where('operating_id','=', $id)->count();
		// if($count > 0){
		// 	DB::table('tbl_operating')->where('operating_id', '=', $id)->delete();
		// 	Session::flash('msgDeleteOperating', 'success');
		// 	// return Response::json(['success' => "delete success id "]);
		// }else{
		// 	Session::flash('msgDeleteOperating', 'error');
		// 	// return Response::json(['errors' => "delete error"]);
		// }
		
		$checkCompleteOperating = $this->completeOperatingByID($id, true);
		// if(!$checkCompleteOperating)
		// 	return Response::json(['errors' => 'restore data failed']);
		// else{
		$del = DB::table('tbl_operating')->where('operating_id', '=', $id)->delete();
		return Redirect::back();
		// }
	}


	//================= POOL OPERATING - START ======================================
	public function pullOperatingPool(Request $req){
		$checkPull = $this->createOperatingPool($req->operating_id);
		if($checkPull)
			return Response::json(['success' => 'success']);
		return Response::json(['errors' => 'Copy thất bại']);

	}
	public function autoPullOperatingPool(Request $req, $token){
		$validToken = DB::table('tbl_metadata')->where('tbl_metadata.meta_group', "=", 'token')->where('tbl_metadata.meta_name', "=", 'auto-pull-operating-pool')->where('tbl_metadata.value1', "=", $token)->count(); 
		$clientIP = $req->ip();
		$checkIP = strcmp($clientIP, '127.0.0.1');
		
		if($validToken > 0 && $checkIP == 0){
			$arrOperatingID = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.can_pull', "=", 0)->where('tbl_operating.status', "=", 2)->pluck('tbl_operating.operating_id')->toArray();
			if(count($arrOperatingID) > 0 ){
				$rs =0;
				for($i=0; $i< count($arrOperatingID); $i++){
					$checkPull = $this->createOperatingPool($arrOperatingID[$i]);
					if($checkPull)
						$rs++;
				}
				echo $rs." operating(s) pulled to tbl_operating_pool";
			}else{
				echo "Empty list - Nothing to pull";
			}

		}else{
			echo "Pull operating pool failed, please check your info and try agian";
		}
	}
	public function createOperatingPool($id){
		DB::beginTransaction();
		try{
			// $checkEditOperating = $this->postEditOperating($req, false);
			// if(!$checkEditOperating){
			// 	DB::commit();
			// 	return Response::json(['errors' => 'Copy thất bại']);
			// }
		// PULL OPERATING - START
			$operating = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.operating_id', "=", $id)->where('tbl_operating.status', "=", 2)->first();
			if($operating != null && $operating->can_pull == 0){
				$operatingPool = new PoolOperating();
				$operatingPool->goods_id = $operating->goods_id;
				$operatingPool->goods_type = $operating->goods_type;
				$operatingPool->owner_id = $operating->owner_id;
				$operatingPool->group_num = $operating->group_num;
				$operating->operating_date = $operating->operating_date;
				$operatingPool->receipt_place_id = $operating->receipt_place_id;
				$operatingPool->before_receipt_note = $operating->before_receipt_note;
				$operatingPool->after_receipt_note = $operating->after_receipt_note;
				$operatingPool->delivery_place_id = $operating->delivery_place_id;
				$operatingPool->before_delivery_note = $operating->before_delivery_note;
				$operatingPool->after_delivery_note = $operating->after_delivery_note;
				$operatingPool->note = $operating->note;
				$operatingPool->document1 = $operating->document1;
				$operatingPool->document2 = $operating->document2;
				$operatingPool->curator_id = $operating->curator_id;
				$operatingPool->car_type_id = $operating->car_type_id;
				$operatingPool->car_id = $operating->car_id;
				$operatingPool->trailer_id = $operating->trailer_id;
				$operatingPool->trailer_type_id = $operating->trailer_type_id;
				$operatingPool->driver_id = $operating->driver_id;
				$operatingPool->before_driver_note = $operating->before_driver_note;
				$operatingPool->after_driver_note = $operating->after_driver_note;
				$operatingPool->assistant_driver_id = $operating->assistant_driver_id;
				$operatingPool->before_assistant_note = $operating->before_assistant_note;
				$operatingPool->after_assistant_note = $operating->after_assistant_note;
				$operatingPool->clear_tank_id =$operating->clear_tank_id;
				$operatingPool->departure_time = $operating->departure_time;
			$operatingPool->status = $operating->status;//$req->selTinhTrang;
			$operatingPool->num = $operating->num;
			$operatingPool->order_show = $operating->order_show;
			$operatingPool->before_owner_note = $operating->before_owner_note;
			$operatingPool->after_owner_note = $operating->after_owner_note;
			$operatingPool->rerule = $operating->rerule;
			$operatingPool->ref_operating_id = $operating->operating_id;
			$operatingPool->save();

			// PULL TOOL
			/*
			 GET OPERATING TOOL
			 COPY TO POOL OPERATING TOOL
			*/
			 $operatingTools = DB::table('tbl_operating_tool')->select('tbl_operating_tool.*')->where('tbl_operating_tool.operating_id', "=", $operating->operating_id)->get()->toArray();
			 if(count($operatingTools) > 0){
			 	for($i = 0; $i < count($operatingTools) ; $i++){
			 		
			 		$poolOperatingTool = new PoolOperatingTool();
			 		$poolOperatingTool->pool_id = $operatingPool->pool_id;
			 		$poolOperatingTool->tool_id = $operatingTools[$i]->tool_id;
			 		$poolOperatingTool->tool_category_id = $operatingTools[$i]->tool_category_id;
			 		$poolOperatingTool->tool_type = $operatingTools[$i]->tool_type;
			 		$poolOperatingTool->num = $operatingTools[$i]->num;
			 		$poolOperatingTool->operating_date = $operatingPool->operating_date;
			 		$poolOperatingTool->save();
			 	}
			 }

			//  edit operating column can pull - ETART
			 DB::table('tbl_operating')
			 ->where('operating_id', $operating->operating_id)
			 ->update([
			 	'can_pull' => 1
			 ]);
			// EDIT OPERATING CAN PULL - end
			 DB::commit();
			 return true;
			}else{
				// not found operating
				return false;
			}
		// PULL OPERATING - END
		}catch(\Exception $e) {
			DB::rollback();
			
			return false;
			
		}
	}

	// public function createOperatingPool($id){
	// 	DB::beginTransaction();
	// 	try{
	// 		$checkEditOperating = $this->postEditOperating($req, false);
	// 		if(!$checkEditOperating){
	// 			DB::commit();
	// 			return Response::json(['errors' => 'Copy thất bại']);
	// 		}
	// 	// PULL OPERATING - START
	// 		$operating = DB::table('tbl_operating')->select('tbl_operating.*')->where('tbl_operating.operating_id', "=", $id)->first();
	// 		if($operating != null && $operating->can_pull == 0){
	// 			$operatingPool = new PoolOperating();
	// 			$operatingPool->goods_id = $operating->goods_id;
	// 			$operatingPool->goods_type = $operating->goods_type;
	// 			$operatingPool->owner_id = $operating->owner_id;
	// 			$operatingPool->group_num = $operating->group_num;
	// 			$operating->operating_date = $operating->operating_date;
	// 			$operatingPool->receipt_place_id = $operating->receipt_place_id;
	// 			$operatingPool->before_receipt_note = $operating->before_receipt_note;
	// 			$operatingPool->after_receipt_note = $operating->after_receipt_note;
	// 			$operatingPool->delivery_place_id = $operating->delivery_place_id;
	// 			$operatingPool->before_delivery_note = $operating->before_delivery_note;
	// 			$operatingPool->after_delivery_note = $operating->after_delivery_note;
	// 			$operatingPool->note = $operating->note;
	// 			$operatingPool->document1 = $operating->document1;
	// 			$operatingPool->document2 = $operating->document2;
	// 			$operatingPool->curator_id = $operating->curator_id;
	// 			$operatingPool->car_type_id = $operating->car_type_id;
	// 			$operatingPool->car_id = $operating->car_id;
	// 			$operatingPool->trailer_id = $operating->trailer_id;
	// 			$operatingPool->trailer_type_id = $operating->trailer_type_id;
	// 			$operatingPool->driver_id = $operating->driver_id;
	// 			$operatingPool->before_driver_note = $operating->before_driver_note;
	// 			$operatingPool->after_driver_note = $operating->after_driver_note;
	// 			$operatingPool->assistant_driver_id = $operating->assistant_driver_id;
	// 			$operatingPool->before_assistant_note = $operating->before_assistant_note;
	// 			$operatingPool->after_assistant_note = $operating->after_assistant_note;
	// 			$operatingPool->clear_tank_id =$operating->clear_tank_id;
	// 			$operatingPool->departure_time = $operating->departure_time;
	// 		$operatingPool->status = $operating->status;//$req->selTinhTrang;
	// 		$operatingPool->num = $operating->num;
	// 		$operatingPool->order_show = $operating->order_show;
	// 		$operatingPool->before_owner_note = $operating->before_owner_note;
	// 		$operatingPool->after_owner_note = $operating->after_owner_note;
	// 		$operatingPool->rerule = $operating->rerule;
	// 		$operatingPool->ref_operating_id = $operating->operating_id;
	// 		$operatingPool->save();

	// 		// PULL TOOL
	// 		/*
	// 		 GET OPERATING TOOL
	// 		 COPY TO POOL OPERATING TOOL
	// 		*/
	// 		 $operatingTools = DB::table('tbl_operating_tool')->select('tbl_operating_tool.*')->where('tbl_operating_tool.operating_id', "=", $operating->operating_id)->get()->toArray();
	// 		 if(count($operatingTools) > 0){
	// 		 	for($i = 0; $i < count($operatingTools) ; $i++){

	// 		 		$poolOperatingTool = new PoolOperatingTool();
	// 		 		$poolOperatingTool->pool_id = $operatingPool->pool_id;
	// 		 		$poolOperatingTool->tool_id = $operatingTools[$i]->tool_id;
	// 		 		$poolOperatingTool->tool_category_id = $operatingTools[$i]->tool_category_id;
	// 		 		$poolOperatingTool->tool_type = $operatingTools[$i]->tool_type;
	// 		 		$poolOperatingTool->num = $operatingTools[$i]->num;
	// 		 		$poolOperatingTool->operating_date = $operatingPool->operating_date;
	// 		 		$poolOperatingTool->save();
	// 		 	}
	// 		 }

	// 		//  edit operating column can pull - ETART
	// 		 DB::table('tbl_operating')
	// 		 ->where('operating_id', $operating->operating_id)
	// 		 ->update([
	// 		 	'can_pull' => 1
	// 		 ]);
	// 		// EDIT OPERATING CAN PULL - end
	// 		 DB::commit();
	// 		 return Response::json(['success' => 'success']);
	// 		}else{
	// 			// not found operating
	// 			return Response::json(['errors' => 'Copy thất bại']);
	// 		}
	// 	// PULL OPERATING - END
	// 	}catch(\Exception $e) {
	// 		DB::rollback();

	// 		return Response::json(['errors' => 'that bai']);

	// 	}
	// }

	// ====================== POOL OPERATING END ===========================

	// ====================== HISTORY OPERATING - START ==================
	public function createHistoryOperating($id){
		$operating = DB::table('tbl_operating')->where('tbl_operating.operating_id', "=", $id)->first();
		if($operating != null){
			// create operating history
			// $lastestVersion = DB::table('tbl_history_operating')->where('ref_operating_id', '=', $operating->operating_id)->where('version', DB::raw("(select max(`version`) from tbl_history_operating)"))->pluck('version')->first();
			$lastestVersion = DB::table('tbl_history_operating')->where('ref_operating_id', '=', $operating->operating_id)->orderBy('version', 'desc')->pluck('version')->first();
			$newVersion = 1;
			if($lastestVersion != null)
				$newVersion = $lastestVersion +1;
			$historyOperating = (array)$operating;
			$historyOperating['ref_operating_id'] = $historyOperating['operating_id'];
			unset($historyOperating['operating_id']);
			$historyOperating['version'] = $newVersion;
			$historyOperatingID =DB::table('tbl_history_operating')->insertGetId(
				$historyOperating
			);

			//create operating tool history
			$operatingTools = DB::table('tbl_operating_tool')->select('tbl_operating_tool.*')->where('tbl_operating_tool.operating_id', "=", $id)->get()->toArray();

			if(count($operatingTools) >0 ){
				$historyOperatingTools = [];
				for($i=0; $i< count($operatingTools); $i++ ){
					$tmpTool = (array)$operatingTools[$i];
					$tmpTool['history_operating_id'] = $historyOperatingID;
					unset($tmpTool['operating_tool_id'], $tmpTool['operating_id']);
					array_push($historyOperatingTools,$tmpTool);
				}
				DB::table('tbl_history_operating_tool')->insert($historyOperatingTools);

			}
			// return true;
		}
		// else{
		// 	return false;
		// }

	}
	// ====================== HISTORY OPERATING - END ====================

	
	public function getShowDieuxe(Request $request, $pagi = null) {
		// dd($pagi);
		if($pagi == null || !is_numeric($pagi) || $pagi < 1)
			$perPage =20;
		if(session()->get('operatingPagi')[0] != null){
			$perPage =session()->get('operatingPagi');
			// dd($perPage);
		}

		if(is_numeric($pagi) && $pagi >0){
			session()->put('operatingPagi', $pagi);
			$perPage =$pagi;
			// dd(session()->get('operatingPagi'));
		}
		$tbl = [];

		$page = LengthAwarePaginator::resolveCurrentPage();

		$table = DB::select("select T.group_num as codeJoin , T.operating_date as daycar, T.status as status, T.operating_id as id, T.document1 as ct1, T.document2 as ct2, T.departure_time as timego, T.order_show as position, T.num as amount, T.note as note, T.before_receipt_note as ndTNN, T.after_receipt_note as ndSNN, T.before_delivery_note as ndTNG, T.after_delivery_note as ndSNG, T.before_driver_note as ndTTX, T.after_driver_note as ndSTX, T.before_assistant_note as ndTLX, T.after_assistant_note as ndSLX, T.before_owner_note as ndTCH, T.after_owner_note as ndSCH, T.rerule as rerule , tbl_car.car_num as carNum, tbl_car.car_id as carID, tbl_car.note as carNote , tbl_goods.full_name as fullName,tbl_goods.sort_name as sortName,tbl_goods.goods_id as goodsID,tbl_goods.rate as goodsRate,tbl_goods.note as goodsNote,receipt.name as receiptName,receipt.place_id as receiptID,delivery.name as deliveryName,delivery.place_id as deliveryID,tbl_partner.partner_short_name as partnerName,tbl_partner.partner_id as partnerID,tbl_partner.contact_note as partnerContactNote,tbl_partner.note as partnerNote,driver.nick_name as driverName,driver.user_id as driverID,assistant.nick_name as assistantName,assistant.user_id as assistantID,tbl_trailer.trailer_id as trailerID,tbl_trailer.trailer_num as trailerNum,tbl_trailer.note as trailerNote,curator.nick_name as curatorName,curator.user_id as curatorID,tbl_clear_tank.clear_tank_id as tankID,tbl_clear_tank.clear_tank_name as tankName  from (SELECT * FROM 
			(
				(SELECT *, 02 AS temp_order FROM `tbl_operating` WHERE SUBSTRING(order_show, 8,3) = '00' order by operating_date DESC,  operating_id DESC)
				UNION 
				(SELECT *, 01 AS temp_order FROM `tbl_operating` WHERE SUBSTRING(order_show, 8,3) <> '00' order by `order_show` DESC)
			)AS B  ORDER BY operating_date DESC,temp_order DESC, order_show DESC, operating_id DESC) AS T 
			LEFT JOIN tbl_car ON 
			T.car_id = tbl_car.car_id  
			LEFT JOIN tbl_goods ON 
			T.goods_id = tbl_goods.goods_id
			LEFT JOIN tbl_receipt_delivery_place AS receipt ON 
			T.receipt_place_id = receipt.place_id
			AND 
			receipt.place_type = 0
			LEFT JOIN tbl_receipt_delivery_place AS delivery ON
			T.delivery_place_id = delivery.place_id
			AND 
			delivery.place_type = 1
			LEFT JOIN tbl_partner ON 
			T.owner_id = tbl_partner.partner_id
			LEFT JOIN tbl_user AS driver ON
			T.driver_id = driver.user_id
			AND 
			driver.user_type = 12	
			LEFT JOIN tbl_user AS assistant ON
			T.assistant_driver_id = assistant.user_id
			AND
			assistant.user_type = 13
			LEFT JOIN tbl_trailer ON 
			T.trailer_id = tbl_trailer.trailer_id
			LEFT JOIN tbl_clear_tank ON
			T.clear_tank_id = tbl_clear_tank.clear_tank_id
			LEFT JOIN tbl_user as curator ON
			T.curator_id = curator.user_id
			AND 
			curator.user_type = 15
			ORDER BY
			operating_date DESC,
			temp_order DESC, 
			order_show DESC, 
			operating_id DESC
			");


		$itemCollection = collect($table);

		//$perPage = $pagi;
		$start = ($page-1)*$perPage;
		$currentPageCollection = $itemCollection->slice($start, $perPage)->all();

		$paginatedItems = new LengthAwarePaginator($currentPageCollection, count($itemCollection), $perPage);

		$paginatedItems->setPath(LengthAwarePaginator::resolveCurrentPath());

		$arrOperatingID = [];

		for ($i=0; $i < count($paginatedItems); $i++) {
			foreach($paginatedItems as $key => $paginate){
				$tbl[$key]= $paginate;
				array_push($arrOperatingID, $paginate->id);
			}
		}


		$arrOperatingID = array_unique($arrOperatingID);
		
		$arr = explode('[',json_encode($arrOperatingID));
		$arr = explode(']',$arr[1]);

		$tool1 = DB::select("SELECT operatool1.operating_tool_id as operatool1 , operatool1.operating_id as operaID1 , 
		operatool1.tool_id as toolID1 , operatool1.tool_category_id as operatoolcat1 , 
		tool1.name as toolName1 , operatool1.tool_type as toolType1 , opeitemstatus1.item_type as itemType1 , opeitemstatus1.status as itemStatus1 , opeitemstatus1.item_id as itemID1 
		FROM tbl_operating
		LEFT JOIN tbl_operating_tool AS operatool1 ON 
			operatool1.operating_id = tbl_operating.operating_id
		LEFT JOIN tbl_tool AS tool1 ON 
			operatool1.tool_id = tool1.tool_id
		LEFT JOIN tbl_operating_item_status AS opeitemstatus1 ON 
			opeitemstatus1.operating_id = tbl_operating.operating_id
		    AND 
		    	opeitemstatus1.item_id = tool1.tool_id
		WHERE
			operatool1.operating_id IN (".$arr[0].")
		    AND 
		    operatool1.tool_type = 1
		    AND 
		    opeitemstatus1.item_type = 5
		");

		$tool2 = DB::select("SELECT operatool2.operating_tool_id as operatool2 , operatool2.operating_id as operaID2 , 
		operatool2.tool_id as toolID2 , operatool2.tool_category_id as operatoolcat2 , 
		tool2.name as toolName2 , operatool2.tool_type as toolType2 , opeitemstatus2.item_type as itemType2 , opeitemstatus2.status as itemStatus2 , opeitemstatus2.item_id as itemID2 , operatool2.num 
		FROM tbl_operating
		LEFT JOIN tbl_operating_tool AS operatool2 ON 
			operatool2.operating_id = tbl_operating.operating_id
		LEFT JOIN tbl_tool AS tool2 ON 
			operatool2.tool_id = tool2.tool_id
		LEFT JOIN tbl_operating_item_status AS opeitemstatus2 ON 
			opeitemstatus2.operating_id = tbl_operating.operating_id
		    AND 
		    	opeitemstatus2.item_id = tool2.tool_id
		WHERE
			operatool2.operating_id IN (".$arr[0].")
		    AND 
		    operatool2.tool_type = 2
		   	AND
		    opeitemstatus2.item_type = 5
		");

		$opeItem = DB::table("tbl_operating")
		->leftJoin('tbl_operating_item_status as opeitem','tbl_operating.operating_id','=','opeitem.operating_id')
		->whereIn('opeitem.operating_id',$arrOperatingID)
		->select('opeitem.item_type as itemType','opeitem.operating_id as opeitemID','opeitem.status as itemStatus','opeitem.item_id as itemID')
		->get()->toArray();

		for($j =$start; $j < $start+count($tbl); $j++){
			$tmpArrayTool = [];
			$tmpArrayTool2 = [];
			$tmpOpeItem = [];
			foreach($tool1 as $key => $t){
				
				if($tbl[$j]->id == $t->operaID1)
					array_push($tmpArrayTool, $t);
			}
			$tmpCollectTool1 = collect($tmpArrayTool);
			
			$tbl[$j]->tool1 =  $tmpCollectTool1;

			foreach($tool2 as $key => $e)
			{
				if($tbl[$j]->id == $e->operaID2)
					array_push($tmpArrayTool2, $e);
			}
			$tmpCollectTool2 = collect($tmpArrayTool2);
			$tbl[$j]->tool2 =  $tmpCollectTool2;

			foreach($opeItem as $key => $o)
			{
				if($tbl[$j]->id == $o->opeitemID)
					array_push($tmpOpeItem, $o);
			}
			$tmpCollectOpeItem = collect($tmpOpeItem);
			$tbl[$j]->operatingstatus = $tmpCollectOpeItem;
		}
		// dd($tbl);

		return view('DieuXe.table',['table' => $paginatedItems])->with(compact('tbl', 'arrOperatingID','start'));
	}
	
	public function getNGShow($id){
		$lastcar = [];
		$lastestGoodsQuery = DB::table('tbl_operating')->where('tbl_operating.delivery_place_id', '=', $id)
		->leftJoin('tbl_goods', 'tbl_goods.goods_id', '=', 'tbl_operating.goods_id')
		->leftJoin('tbl_trailer', 'tbl_trailer.trailer_id', '=', 'tbl_operating.trailer_id')
		->leftJoin('tbl_car', 'tbl_car.car_id', '=', 'tbl_operating.car_id')
		->select('tbl_operating.*', 'tbl_goods.sort_name', 'tbl_car.car_num', 'tbl_trailer.trailer_num')
		->orderBy('tbl_operating.operating_date', 'desc')
		->orderBy('tbl_operating.operating_id', 'desc')->get()->toArray();

		$tol = '';
		if(count($lastestGoodsQuery) < 4)
			
			for($i=0; $i< count($lastestGoodsQuery) ; $i++){

				$tol = '';
				$car = $lastestGoodsQuery[$i]->car_id;

				$carNum = $lastestGoodsQuery[$i]->car_num;
				$trailerNum = $lastestGoodsQuery[$i]->trailer_num;

				if(isset($carNum))
					$tol .= 'Số xe: '.$carNum.' ';

				if(isset($trailerNum )){
					$tol .= '- Romooc: '.$trailerNum;
				}
				array_push($lastcar,$tol);
			}
			else{
				for($i=0; $i< 3 ; $i++){
				// dk xe bồn 

					$tol = '';
					$car = $lastestGoodsQuery[$i]->car_id;

					$carNum = $lastestGoodsQuery[$i]->car_num;
					$trailerNum = $lastestGoodsQuery[$i]->trailer_num;

					if(isset($carNum))
						$tol .= 'Số xe: '.$carNum;

					if(isset($trailerNum)){
						$tol .= ' - Romooc: '.$trailerNum;
					}

					array_push($lastcar,$tol);



				}
			}
			return $lastcar;
		}


		public static function getCarCH($id){
			$lastcar = [];
			$lastestGoodsQuery = DB::table('tbl_operating')->where('tbl_operating.owner_id', '=', $id)
			->where('tbl_operating.car_id', '!=', null)
			->leftJoin('tbl_goods', 'tbl_goods.goods_id', '=', 'tbl_operating.goods_id')
			->leftJoin('tbl_car', 'tbl_car.car_id', '=', 'tbl_operating.car_id')
			->select('tbl_operating.*', 'tbl_goods.sort_name', 'tbl_car.car_num')
			->orderBy('tbl_operating.operating_date', 'desc')
			->orderBy('tbl_operating.operating_id', 'desc')
			->get()->toArray();
			
			$tol = '';
			if(count($lastestGoodsQuery) < 4)

				for($i=0; $i< count($lastestGoodsQuery) ; $i++){
				// dk xe bồn 
					if($lastestGoodsQuery[$i]->car_type_id == 4){
						$tol = '';
						$car = $lastestGoodsQuery[$i]->car_id;
						//$carTable = DB::table('tbl_car')->where('car_id','=',$car)->select('car_num')->first();
						$carNum =$lastestGoodsQuery[$i]->car_num;
						if(isset($carNum))
							$tol .= 'Số xe: '.$carNum.' - Chất: '.$lastestGoodsQuery[$i]->sort_name; 
						array_push($lastcar,$tol);
					}else{
						$tol = '';
						$car = $lastestGoodsQuery[$i]->car_id;
						//$carTable = DB::table('tbl_car')->where('car_id','=',$car)->select('car_num')->first();
						$carNum =$lastestGoodsQuery[$i]->car_num;
						$trailer = DB::table('tbl_trailer')->where('trailer_id','=',$lastestGoodsQuery[$i]->trailer_id)->select('trailer_num')->first();
						if(isset($carNum))
							$tol .= 'Số xe: '.$carNum.' ';

						if(isset($trailer)){
							$tol .= '- Romooc: '.$trailer->trailer_num;
						}
						array_push($lastcar,$tol);
					//var_dump($lastcar[$i]); exit();

					}

			//	var_dump($carTable->car_num); exit();
				}
				else{
					for($i=0; $i< 3 ; $i++){
				// dk xe bồn 
						if($lastestGoodsQuery[$i]->car_type_id == 3)
						{
							//echo "case1-";
							$tol = '';
							$car = $lastestGoodsQuery[$i]->car_id;
							//$carTable = DB::table('tbl_car')->where('car_id','=',$car)->select('car_num')->first();
							$carNum =$lastestGoodsQuery[$i]->car_num;
							$trailer = DB::table('tbl_trailer')->where('trailer_id','=',$lastestGoodsQuery[$i]->trailer_id)->select('trailer_num')->first();
							if(isset($carNum))
								$tol .= 'Số xe: '.$carNum ;

							if(isset($trailer)){
								$tol .= ' - Romooc: '.$trailer->trailer_num;
							}
							array_push($lastcar,$tol);

						}else{
							$tol = '';
							//$car = $lastestGoodsQuery[$i]->car_id;
							$carNum =$lastestGoodsQuery[$i]->car_num;
							//$carTable = DB::table('tbl_car')->where('car_id','=',$car)->select('car_num')->first();
							if(isset($carNum))
								$tol .= 'Số xe: '.$carNum.' - Chất: '.$lastestGoodsQuery[$i]->sort_name; 
							array_push($lastcar,$tol);

						}

			//	var_dump($carTable->car_num); exit();
					}
				}
				// echo "<pre>";
				// var_dump($lastcar);
				// echo "</pre>";
				// exit();
				return $lastcar;

		// return $arrResult;
			}

		public function getShowDieuxe2(Request $req) {
				$arrayOperatingIDPerPage = $req->arrayOperatingIDPerPage;
				$operatings = DB::table('tbl_operating')->whereIn('operating_id', $arrayOperatingIDPerPage)->get()->toArray();
				$arrPartnerID = [];
				$arrCarID =[];
				$arrPlaceID = [];
				for($i=0; $i< count($operatings); $i++){
					if($operatings[$i]->owner_id != null)
						array_push($arrPartnerID, $operatings[$i]->owner_id);
					if($operatings[$i]->car_id != null)
						array_push($arrCarID, $operatings[$i]->car_id);
					if($operatings[$i]->receipt_place_id != null)
						array_push($arrPlaceID, $operatings[$i]->receipt_place_id);
					if($operatings[$i]->delivery_place_id != null)
						array_push($arrPlaceID, $operatings[$i]->delivery_place_id);
				}
			// dd($arrPartnerID);
				$tbl = [];
				$car = DB::table('tbl_car')->get()->toArray();
				$goods = DB::table('tbl_goods')->get()->toArray();
				$nng = DB::table('tbl_receipt_delivery_place')->whereIn('place_id', $arrPlaceID)->get()->toArray();
				$user = DB::table('tbl_user')->get()->toArray();
				$romooc = DB::table('tbl_trailer')->get()->toArray();
				$partner = DB::table('tbl_partner')->whereIn('tbl_partner.partner_id', $arrPartnerID)->get()->toArray();
				$tool = DB::table('tbl_tool')->get()->toArray();

		/**
		 * partner [{id, name, note}, {id, name, note}, {id, name, note}, ....]
		 * for($i =0 ; $i < count(partner; $i++){
		 * 	call function $lastestCars =  getCarByOwnerID(ownerID) = > hàm return ra 1 array gồm tối đa 3 xe đã chạy cho thgn chủ hàng này
		 * $paertner[$i]->lastestCars =  $lastestCars
		 * partner[$i] : {id, name, note, lastestCar[mảng]}
		 * }
		 */
		for($i=0; $i < count($partner); $i++){
			// $last[$i] = DieuXeController::getCarCH($partner[$i]->partner_id);
			$partner[$i]->carNo = DieuXeController::getCarCH($partner[$i]->partner_id);
		}

		for($i=0; $i < count($nng); $i++){
			// $last[$i] = DieuXeController::getNGShow($partner[$i]->partner_id);
			$nng[$i]->carNote = DieuXeController::getNGShow($nng[$i]->place_id);
		}

		//Write code operating history 
		$arr = explode('[',json_encode($arrayOperatingIDPerPage));
		$arr = explode(']',$arr[1]);

		// $idHistory = DB::table('tbl_history_operating')->whereIn('ref_operating_id', $arrayOperatingIDPerPage)->pluck('history_operating_id')->toArray();
		// dd($idHistory);
		// $arr = explode('[',json_encode($idHistory));
		// $arr = explode(']',$arr[1]);

		// dd($arr[0]);
		$getHistory = DB::select("select T.history_operating_id, T.version as verhistory, T.group_num as codeJoin, T.operating_date as daycar, T.status as status, T.ref_operating_id as id, T.document1 as ct1, T.document2 as ct2, T.departure_time as timego, T.order_show as position, T.num as amount, T.note as note, T.before_receipt_note as ndTNN, T.after_receipt_note as ndSNN, T.before_delivery_note as ndTNG, T.after_delivery_note as ndSNG, T.before_driver_note as ndTTX, T.after_driver_note as ndSTX, T.before_assistant_note as ndTLX, T.after_assistant_note as ndSLX, T.before_owner_note as ndTCH, T.after_owner_note as ndSCH, T.rerule as rerule , tbl_car.car_num as carNum, tbl_car.car_id as carID, tbl_car.note as carNote , tbl_goods.full_name as fullName,tbl_goods.sort_name as sortName,tbl_goods.goods_id as goodsID,tbl_goods.rate as goodsRate,tbl_goods.note as goodsNote,receipt.name as receiptName,receipt.place_id as receiptID,delivery.name as deliveryName,delivery.place_id as deliveryID,tbl_partner.partner_short_name as partnerName,tbl_partner.partner_id as partnerID,tbl_partner.contact_note as partnerContactNote,tbl_partner.note as partnerNote,driver.nick_name as driverName,driver.user_id as driverID,assistant.nick_name as assistantName,assistant.user_id as assistantID,tbl_trailer.trailer_id as trailerID,tbl_trailer.trailer_num as trailerNum,tbl_trailer.note as trailerNote,curator.nick_name as curatorName,curator.user_id as curatorID,tbl_clear_tank.clear_tank_id as tankID,tbl_clear_tank.clear_tank_name as tankName  from (SELECT * FROM 
			(
				(SELECT *, 02 AS temp_order FROM `tbl_history_operating` WHERE SUBSTRING(order_show, 8,3) = '00' order by operating_date DESC,  ref_operating_id DESC)
				UNION 
				(SELECT *, 01 AS temp_order FROM `tbl_history_operating` WHERE SUBSTRING(order_show, 8,3) <> '00' order by `order_show` DESC)
			)AS B  ORDER BY operating_date DESC,temp_order DESC, order_show DESC, ref_operating_id DESC) AS T 
			LEFT JOIN tbl_car ON 
			T.car_id = tbl_car.car_id  
			LEFT JOIN tbl_goods ON 
			T.goods_id = tbl_goods.goods_id
			LEFT JOIN tbl_receipt_delivery_place AS receipt ON 
			T.receipt_place_id = receipt.place_id
			AND 
			receipt.place_type = 0
			LEFT JOIN tbl_receipt_delivery_place AS delivery ON
			T.delivery_place_id = delivery.place_id
			AND 
			delivery.place_type = 1
			LEFT JOIN tbl_partner ON 
			T.owner_id = tbl_partner.partner_id
			LEFT JOIN tbl_user AS driver ON
			T.driver_id = driver.user_id
			AND 
			driver.user_type = 12	
			LEFT JOIN tbl_user AS assistant ON
			T.assistant_driver_id = assistant.user_id
			AND
			assistant.user_type = 13
			LEFT JOIN tbl_trailer ON 
			T.trailer_id = tbl_trailer.trailer_id
			LEFT JOIN tbl_clear_tank ON
			T.clear_tank_id = tbl_clear_tank.clear_tank_id
			LEFT JOIN tbl_user as curator ON
			T.curator_id = curator.user_id
			AND 
			curator.user_type = 15
			LEFT JOIN tbl_operating as opera ON
			T.ref_operating_id = opera.operating_id 
			WHERE T.ref_operating_id IN (".$arr[0].")
			ORDER BY
			T.operating_date DESC,
			temp_order DESC, 
			T.order_show DESC, 
			T.ref_operating_id DESC
			");
		// dd($getHistory);
		$tbl = [];
		$idHistory = [];
		for($i=0 ; $i < count($getHistory) ; $i++){
			foreach($getHistory as $key => $History){
				$tbl[$key] = $History;
				array_push($idHistory,$History->history_operating_id); 
			}
		}
		// dd($tbl);
		// dd($idHistory);
		$arrHistoryID = array_unique($idHistory);
		// dd($arrHistoryID);
		$arrHistory = explode('[',json_encode($arrHistoryID));
		$arrHistory = explode(']',$arrHistory[1]);
		// dd($arrHistory[0]);
		$tool1 = DB::select("SELECT operatool1.history_operating_tool_id as operatoolID1 , operatool1.history_operating_id as operaID1 , 
		operatool1.tool_id as toolID1 , operatool1.tool_category_id as operatoolcat1 , 
		tool1.name as toolName1 , operatool1.tool_type as toolType1 , tbl_history_operating.version as versiontool1
		FROM tbl_history_operating
		LEFT JOIN tbl_history_operating_tool AS operatool1 ON 
			operatool1.history_operating_id = tbl_history_operating.history_operating_id
		LEFT JOIN tbl_tool AS tool1 ON 
			operatool1.tool_id = tool1.tool_id
		-- LEFT JOIN tbl_operating_item_status AS opeitemstatus1 ON 
		-- 	opeitemstatus1.operating_id = tbl_history_operating.history_operating_id
		--     AND 
		--     	opeitemstatus1.item_id = tool1.tool_id
		WHERE
			operatool1.history_operating_id IN ($arrHistory[0])
		    AND  
		    operatool1.tool_type = 1
		    -- AND 
		    -- opeitemstatus1.item_type = 5
		");
		// dd($tool1);

		$tool2 = DB::select("SELECT operatool2.history_operating_tool_id as operatoolID2 , operatool2.history_operating_id as operaID2 , 
		operatool2.tool_id as toolID2 , operatool2.tool_category_id as operatoolcat2 , tool2.name as toolName2 , operatool2.tool_type as toolType2 , operatool2.num , tbl_history_operating.version as versiontool2
		FROM tbl_history_operating
		LEFT JOIN tbl_history_operating_tool AS operatool2 ON 
			operatool2.history_operating_id = tbl_history_operating.history_operating_id
		LEFT JOIN tbl_tool AS tool2 ON 
			operatool2.tool_id = tool2.tool_id
		-- LEFT JOIN tbl_operating_item_status AS opeitemstatus2 ON 
		-- 	opeitemstatus2.operating_id = tbl_operating.operating_id
		--     AND 
		--     	opeitemstatus2.item_id = tool2.tool_id
		WHERE
			operatool2.history_operating_id IN ($arrHistory[0])
		    AND 
		    operatool2.tool_type = 2
		");
		// dd($tool2);

		for($j=0; $j<count($tbl); $j++)
		{
			// ip hisstory operating cuar  == nhau
			// tbl[$i]->tool2 =  tool2
			$tmpArrayTool = [];
			$tmpArrayTool2 = [];
			foreach($tool1 as $key => $t){
				if($tbl[$j]->history_operating_id == $t->operaID1)
				array_push($tmpArrayTool, $t);
			}
			$tmpCollectTool1 = collect($tmpArrayTool);
			$tbl[$j]->tool1 =  $tmpCollectTool1;

			foreach($tool2 as $key => $e)
			{
				if($tbl[$j]->history_operating_id == $e->operaID2)
				array_push($tmpArrayTool2, $e);
			}
			$tmpCollectTool2 = collect($tmpArrayTool2);
			$tbl[$j]->tool2 =  $tmpCollectTool2;
		}
		// dd($tbl);
		//End Write code operating history

		//var_dump($nng); exit();
		// dd($tbl);
		$data = (object)[
			'table' => $tbl,
			'car' => $car,
			'goods' => $goods,
			'nng' => $nng,
			'user' => $user,
			'romooc' => $romooc,
			'chuhang' => $partner,
			'dungcu' => $tool
		];

		return Response::json(['success' => $data]);
	}
	public function completeOperating(Request $req){
		if(session()->has('email'))
		{
			$tmpemail = Session::get('email');
			$sess_email = end($tmpemail);
			$sess_users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $sess_email)->get();
			$currentUser_type =$sess_users[0]->user_type;
		}
		$routeName = Route::getCurrentRoute()->getName();
		$method = $_SERVER['REQUEST_METHOD'];
		$checkAuth = checkAuthController::checkAuth($routeName,$method,$currentUser_type);
		if($checkAuth == 0){
			return response()->json(['error' =>'error']); 
		}
		$reqID = $req->data;
		// if(count($req->ID) >0){
		// 	//for($i = 0; $i < count($req->ID); $i++)
		// }

		//$completeOperating = DB::table('tbl_operating')->whereIn('operating_id', $reqID)->update(['tbl_operating.status' => 2]);
		$arrCompleteOperID = [];
		// $tmpOperatingID = 
		$tmpOperatingID = DB::table('tbl_operating')->select('operating_id')->where('status', '=', 1)->whereIn('operating_id', $reqID)->pluck('operating_id');
		// var_dump($reqID);

		// var_dump($tmpOperatingID);exit();
		for ($i=0; $i<count($tmpOperatingID); $i++){
			$checkComplete = $this->completeOperatingByID($tmpOperatingID[$i]);
			if($checkComplete == true){
				$completeOperating = DB::table('tbl_operating')->leftJoin('tbl_car','tbl_operating.car_id','=','tbl_car.car_id')
				->leftJoin('tbl_goods','tbl_operating.goods_id','=','tbl_goods.goods_id')
				// ->join('tbl_receipt_delivery_place','tbl_operating.receipt_place_id','=','tbl_receipt_delivery_place.place_id')
				// ->join('tbl_receipt_delivery_place','tbl_operating.delivery_place_id','=','tbl_receipt_delivery_place.place_id')
				->leftJoin('tbl_receipt_delivery_place as receipt', function ($join) {
					$join->on('tbl_operating.receipt_place_id', '=', 'receipt.place_id')->where('receipt.place_type', 0);
				})
				->leftJoin('tbl_receipt_delivery_place as delivery', function ($join) {
					$join->on('tbl_operating.delivery_place_id', '=', 'delivery.place_id')->where('delivery.place_type', 1);
				})
				->leftJoin('tbl_partner','tbl_operating.owner_id','=','tbl_partner.partner_id')
				->select('tbl_operating.operating_date','tbl_goods.sort_name','receipt.name as receipt','delivery.name as delivery','tbl_partner.partner_short_name','tbl_car.car_num')
				->where('tbl_operating.operating_id','=',$reqID[$i])->first();
				array_push($arrCompleteOperID, $completeOperating);
			}
		}
		 // var_dump($arrCompleteOperID); exit();
		return response()->json(['success'=>'success','arr'=>$arrCompleteOperID]);
		
	}
	public function completeOneOperating(Request $req){
		if(session()->has('email'))
		{
			$tmpemail = Session::get('email');
			$sess_email = end($tmpemail);
			$sess_users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $sess_email)->get();
			$currentUser_type =$sess_users[0]->user_type;
		}
		$routeName = Route::getCurrentRoute()->getName();
		$method = $_SERVER['REQUEST_METHOD'];
		$checkAuth = checkAuthController::checkAuth($routeName,$method,$currentUser_type);
		if($checkAuth == 0){
			return response()->json(['error' =>'error']); 
		}
		$reqID = $req->data;
		// $completeOperating = DB::table('tbl_operating')->where('operating_id', $reqID)->update(['tbl_operating.status' => 2]);
		// return response()->json(['success' =>'success']); 
		/**
		 * $arrCompltedOperID =[];
		 * arrOpers = [1, 2, 3]
		 * for($i =0; $i  <count(arrOper); $i++){
		 * $checkComplete = $this->completeOperatingByID($arrrOoper[$i]);
		 * if($checkComplete == true){
		 * array_push($arrCompltedOperID, $arrrOoper[$i]);
		 * }
		 * 
		 * 
		 * 
		 * }
		 */
		$checkComplete = $this->completeOperatingByID($reqID);
		if($checkComplete == true)
			return response()->json(['success' =>'success']); 

		return response()->json(['error' =>'error']);
	}
	//CONVERTER ARRAY  KEY VALUES 
	public static  function converterArray($arr,$id){
		$newArr = [];
		foreach($arr as $a) {
			array_push($newArr,$a->$id);
		}
		return $newArr;
	}
	//SEARCHOPERATING
	public function search(Request $req){
		$page = LengthAwarePaginator::resolveCurrentPage();
		$table = DB::table('tbl_operating')
		->leftJoin('tbl_clear_tank', 'tbl_operating.clear_tank_id', '=', 'tbl_clear_tank.clear_tank_id' )
		->leftJoin('tbl_receipt_delivery_place as delivery_place', 'tbl_operating.delivery_place_id', '=', 'delivery_place.place_id' )
		->leftJoin('tbl_receipt_delivery_place as receipt_place', 'tbl_operating.receipt_place_id', '=', 'receipt_place.place_id' )
		->leftJoin('tbl_user as driver', 'tbl_operating.driver_id', '=', 'driver.user_id' )
		->leftJoin('tbl_user as assistant', 'tbl_operating.assistant_driver_id', '=', 'assistant.user_id' )
		->leftJoin('tbl_user as user', 'tbl_operating.user_id', '=', 'user.user_id' )
		->leftJoin('tbl_partner as owner', 'tbl_operating.owner_id', '=', 'owner.partner_id' )
		->leftJoin('tbl_user as curator', 'tbl_operating.curator_id', '=', 'curator.user_id' )
		->leftJoin('tbl_goods as goods', 'tbl_operating.goods_id', '=', 'goods.goods_id' )
		->leftJoin('tbl_trailer as trailer', 'tbl_operating.trailer_id', '=', 'trailer.trailer_id' )
		->leftJoin('tbl_car as car', 'tbl_operating.car_id', '=', 'car.car_id' )
		->leftJoin('tbl_operating_tool as operating_tool1', function ($join) {
			$join->on('tbl_operating.operating_id', '=', 'operating_tool1.operating_id')->where('operating_tool1.tool_type', 1);
		})
		->leftJoin('tbl_tool as tool1', 'operating_tool1.tool_id', '=', 'tool1.tool_id' )
		->leftJoin('tbl_operating_tool as operating_tool2', function ($join) {
			$join->on('tbl_operating.operating_id', '=', 'operating_tool2.operating_id')->where('operating_tool2.tool_type', 2);
		})
		->leftJoin('tbl_tool as tool2', 'operating_tool2.tool_id', '=', 'tool2.tool_id' )
		->select(
			'tbl_operating.*'
		);


		// Search Date
		if($req->dateStart !='' && $req->dateEnd == '') {
			$table = $table->where('tbl_operating.operating_date','>=', $req->dateStart);
		}else if($req->dateEnd !='' && $req->dateStart == ''){
			$table = $table->where('tbl_operating.operating_date','<=', $req->dateEnd);
		}else if($req->dateStart !='' && $req->dateEnd !='') {
			$table = $table->where('tbl_operating.operating_date','>=', $req->dateStart)->where('tbl_operating.operating_date','<=', $req->dateEnd);
		}else {
			$table = $table;
		}
		// Search Status
		if(!$req->status)
			$req->status = 0;
		if($req->status != 0 && !empty($req->status)){
			$table = $table->where('tbl_operating.status',$req->status);
		}
		// Ruler Search 
		$search = null;
		array_set($search, 'search_car','car.car_num');
		array_set($search, 'search_goods','goods.sort_name');
		array_set($search, 'search_receipt','receipt_place.name');
		array_set($search, 'search_delivery','delivery_place.name');
		array_set($search, 'search_owner','owner.partner_short_name');
		array_set($search, 'search_num','tbl_operating.num');
		array_set($search, 'search_driver','driver.nick_name');
		array_set($search, 'search_assistant_driver','assistant.nick_name');
		array_set($search, 'search_departure_time','tbl_operating.departure_time');
		array_set($search, 'search_clear','tbl_clear_tank.clear_tank_name');
		array_set($search, 'search_trailer','trailer.trailer_num');
		array_set($search, 'search_document1','tbl_operating.document1');
		array_set($search, 'search_document2','tbl_operating.document2');
		array_set($search, 'search_tool1','tool1.name');
		array_set($search, 'search_tool2','tool2.name');
		array_set($search, 'search_note','tbl_operating.note');
		array_set($search, 'search_curator','curator.nick_name');
		array_set($search, 'search_ordershow','tbl_operating.order_show');
		// Search Select
		if($req->search1 && $req->ContentSearch1) {
			$table = $table->where($search[$req->search1],'like','%'. $req->ContentSearch1. '%');
		}
		if($req->search2 && $req->ContentSearch2) {
			$table = $table->where($search[$req->search2],'like','%'. $req->ContentSearch2. '%');
		}
		if($req->search3 && $req->ContentSearch3) {
			$table = $table->where($search[$req->search3],'like','%'. $req->ContentSearch3. '%');
		}

		$table = $table->select('tbl_operating.group_num as codeJoin','tbl_operating.operating_date as daycar', 'tbl_operating.status as status', 'tbl_operating.operating_id as id', 'tbl_operating.document1 as ct1', 'tbl_operating.document2 as ct2', 'tbl_operating.departure_time as timego', 'tbl_operating.order_show as position', 'tbl_operating.num as amount', 'tbl_operating.note as note', 'tbl_operating.before_receipt_note as ndTNN', 'tbl_operating.after_receipt_note as ndSNN', 'tbl_operating.before_delivery_note as ndTNG', 'tbl_operating.after_delivery_note as ndSNG', 'tbl_operating.before_driver_note as ndTTX', 'tbl_operating.after_driver_note as ndSTX', 'tbl_operating.before_assistant_note as ndTLX', 'tbl_operating.after_assistant_note as ndSLX', 'tbl_operating.before_owner_note as ndTCH', 'tbl_operating.after_owner_note as ndSCH', 'tbl_operating.rerule as rerule' , 'car.car_num as carNum', 'car.car_id as carID', 'car.note as carNote' , 'goods.full_name as fullName','goods.sort_name as sortName','goods.goods_id as goodsID','goods.rate as goodsRate','goods.note as goodsNote', 'receipt_place.name as receiptName','receipt_place.place_id as receiptID','delivery_place.name as deliveryName','delivery_place.place_id as deliveryID','owner.partner_short_name as partnerName','owner.partner_id as partnerID','owner.contact_note as partnerContactNote','owner.note as partnerNote','driver.nick_name as driverName','driver.user_id as driverID','assistant.nick_name as assistantName','assistant.user_id as assistantID','trailer.trailer_id as trailerID','trailer.trailer_num as trailerNum','trailer.note as trailerNote','curator.nick_name as curatorName','curator.user_id as curatorID','tbl_clear_tank.clear_tank_id as tankID','tbl_clear_tank.clear_tank_name as tankName')->orderBy('daycar', 'desc')->orderBy('order_show', 'desc')->orderBy('id', 'desc')->distinct()->get()->toArray();

		$itemCollection = collect($table);

		$perPage = 20;
		$start = ($page-1)*$perPage;

		$currentPageCollection = $itemCollection->slice($start, $perPage)->all();
		$paginatedItems = new LengthAwarePaginator($currentPageCollection, count($itemCollection), $perPage);

		$paginatedItems->setPath(LengthAwarePaginator::resolveCurrentPath());
		// $abc = count($paginatedItems);
		$arrOperatingID =[];
		// dd($paginatedItems);
		for ($i=0; $i < count($paginatedItems); $i++) { 
			foreach($paginatedItems as $key => $paginate){
				$tbl[$key]= $paginate;
				array_push($arrOperatingID, $paginate->id);
			}
		}
		// dd($tbl);

		$arrOperatingID = array_unique($arrOperatingID);
		$arr = explode('[',json_encode($arrOperatingID));
		$arr = explode(']',$arr[1]);
		// dd( $arr[0]);
		if($arr[0] =="")
		{
			$arr[0] = -1;
		}

		// dd($arr[0]);
		$tool1 = DB::select("SELECT operatool1.operating_tool_id as operatool1 , operatool1.operating_id as operaID1 , 
		operatool1.tool_id as toolID1 , operatool1.tool_category_id as operatoolcat1 , 
		tool1.name as toolName1 , operatool1.tool_type as toolType1 , opeitemstatus1.item_type as itemType1 , opeitemstatus1.status as itemStatus1 , opeitemstatus1.item_id as itemID1 
		FROM tbl_operating
		LEFT JOIN tbl_operating_tool AS operatool1 ON 
			operatool1.operating_id = tbl_operating.operating_id
		LEFT JOIN tbl_tool AS tool1 ON 
			operatool1.tool_id = tool1.tool_id
		LEFT JOIN tbl_operating_item_status AS opeitemstatus1 ON 
			opeitemstatus1.operating_id = tbl_operating.operating_id
		    AND 
		    	opeitemstatus1.item_id = tool1.tool_id
		WHERE
			operatool1.operating_id IN ($arr[0])
			AND 
		    operatool1.tool_type = 1
		   	AND
		    opeitemstatus1.item_type = 5	
		");
		

		$tool2 = DB::select("SELECT operatool2.operating_tool_id as operatool2 , operatool2.operating_id as operaID2 , 
		operatool2.tool_id as toolID2 , operatool2.tool_category_id as operatoolcat2 , 
		tool2.name as toolName2 , operatool2.tool_type as toolType2 , opeitemstatus2.item_type as itemType2 , opeitemstatus2.status as itemStatus2 , opeitemstatus2.item_id as itemID2 , operatool2.num 
		FROM tbl_operating
		LEFT JOIN tbl_operating_tool AS operatool2 ON 
			operatool2.operating_id = tbl_operating.operating_id

		LEFT JOIN tbl_tool AS tool2 ON 
			operatool2.tool_id = tool2.tool_id
		LEFT JOIN tbl_operating_item_status AS opeitemstatus2 ON 
			opeitemstatus2.operating_id = tbl_operating.operating_id
		    AND 
		    	opeitemstatus2.item_id = tool2.tool_id
		WHERE
			operatool2.operating_id IN ($arr[0])
			AND 
		    operatool2.tool_type = 2
		    AND
		    opeitemstatus2.item_type = 5
		");


		$opeItem = DB::table("tbl_operating")
		->leftJoin('tbl_operating_item_status as opeitem','tbl_operating.operating_id','=','opeitem.operating_id')
		->whereIn('opeitem.operating_id',$arrOperatingID)
		->select('opeitem.item_type as itemType','opeitem.operating_id as opeitemID','opeitem.status as itemStatus','opeitem.item_id as itemID')
		->get()->toArray();
		if(!empty($tbl))
		{
		for($j =$start; $j < $start+count($tbl); $j++){
			$tmpArrayTool = [];
			$tmpArrayTool2 = [];
			$tmpOpeItem = [];
			foreach($tool1 as $key => $t){
				
				if($tbl[$j]->id == $t->operaID1)
					array_push($tmpArrayTool, $t);
			}
			$tmpCollectTool1 = collect($tmpArrayTool);
			$tbl[$j]->tool1 =  $tmpCollectTool1;

			foreach($tool2 as $key => $e)
			{
				if($tbl[$j]->id == $e->operaID2)
					array_push($tmpArrayTool2, $e);
			}
			$tmpCollectTool2 = collect($tmpArrayTool2);
			$tbl[$j]->tool2 =  $tmpCollectTool2;

			foreach($opeItem as $key => $o)
			{
				if($tbl[$j]->id == $o->opeitemID)
					array_push($tmpOpeItem, $o);
			}
			$tmpCollectOpeItem = collect($tmpOpeItem);
			$tbl[$j]->operatingstatus = $tmpCollectOpeItem;
		}
		}


		return view('DieuXe.table',['table' => $paginatedItems])->with(compact('tbl','arrOperatingID','start'));
	}
	//-------------------------map--------------------------------
	public function mapArrResult($value , $arr, $columnFilterName, $columnResultName){
		if(count($arr) >0){
			for($a= 0 ; $a< count($arr) ; $a++){
				if(isset($arr[$a]->$columnFilterName) && $arr[$a]->$columnFilterName == $value ){
					if(isset($arr[$a]->$columnResultName))
						return $arr[$a]->$columnResultName;
				}
			}
		}
		return "";
	}
	//=========================================================

	// --- EXAMPLE CALL EXPORT EXCEL FUNCTION
	public function exampleExportExcel(Request $req){

		if(session()->has('email'))
		{
			$tmpemail = Session::get('email');
			$sess_email = end($tmpemail);
			$sess_users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $sess_email)->get();
			$currentUser_type =$sess_users[0]->user_type;
		}
		$routeName = Route::getCurrentRoute()->getName();
		$method = $_SERVER['REQUEST_METHOD'];
		$checkAuth = checkAuthController::checkAuth($routeName,$method,$currentUser_type);
		if($checkAuth == 0){
			return view('errors');
			exit;
		}

		$ope_id = $req->data;
		
		$ope_id_ordered = implode(',', $ope_id);
		if( $ope_id == null || count($ope_id) <1)
			return;
			//dd($ope_id);
			// array_reverse($ope_id, true);
		// //	dd($ope_id);
		// 	$ope_id= ['296', '298'];
		$operatingTitle = DB::table('tbl_operating')
		// ->join('tbl_user','tbl_operating.owner_id','=','tbl_user.user_id')
		// ->join('tbl_car','tbl_operating.car_id','=','tbl_car.car_id')
		->select("tbl_operating.operating_date as NGÀY ĐIỀU XE" ,
				 "tbl_operating.car_id as SỐ XE",//car
				 "tbl_operating.goods_id as LOẠI HÀNG",
				 "tbl_operating.receipt_place_id as NƠI NHẬN HÀNG",//place id
				 "tbl_operating.delivery_place_id as NƠI GIAO HÀNG",//place id
				 "tbl_operating.owner_id as CHỦ HÀNG",
				 "tbl_operating.num as SỐ LƯỢNG",//0 user
				 "tbl_operating.driver_id as TÀI XẾ",//1user
				 "tbl_operating.assistant_driver_id as LƠ XE",//2user
				 "tbl_operating.departure_time as GIỜ ĐI",
				 "tbl_operating.trailer_id as RƠ MOOC",//romooc
				 "tbl_operating.clear_tank_id as XỊT BỒN",//1xit bon
				 "tbl_operating.document1 as CHỨNG TỪ MANG THEO 1",
				 "tbl_operating.document2 as CHỨNG TỪ MANG THEO 2",
				 "tbl_operating.document2 as DỤNG CỤ 1",
				 "tbl_operating.document2 as DỤNG CỤ 2",
				 "tbl_operating.note as GHI CHÚ",
				 "tbl_operating.curator_id as N.PHỤ TRÁCH")//3user
		->whereIn('operating_id', $ope_id)
		->orderByRaw(DB::raw("FIELD(operating_id, $ope_id_ordered)"))
		->get()->toArray();

		$operating = DB::table('tbl_operating')
		// ->join('tbl_user','tbl_operating.owner_id','=','tbl_user.user_id')
		// ->join('tbl_car','tbl_operating.car_id','=','tbl_car.car_id')
		->select("tbl_operating.operating_date" ,
				 "tbl_operating.car_id",//car
				 "tbl_operating.goods_id", //loại hàng
				 "tbl_operating.receipt_place_id",//place id
				 "tbl_operating.delivery_place_id",//place id
				 "tbl_operating.owner_id"
				 ,"tbl_operating.num",//0 user
				 "tbl_operating.driver_id",//1user
				 "tbl_operating.assistant_driver_id",//2user
				 "tbl_operating.operating_date",
				 'tbl_operating.departure_time',
				 "tbl_operating.trailer_id",//romooc
				 "tbl_operating.clear_tank_id",//1xit bon
				 "tbl_operating.document1",
				 "tbl_operating.document2",
				 "tbl_operating.note",
				 "tbl_operating.curator_id")//3user
		->whereIn('operating_id', $ope_id)
		->orderByRaw(DB::raw("FIELD(operating_id, $ope_id_ordered)"))
		->get()->toArray();
		//dd($operating);
		// get list id
		$operatingsID = DB::table('tbl_operating')
		// ->join('tbl_user','tbl_operating.owner_id','=','tbl_user.user_id')
		// ->join('tbl_car','tbl_operating.car_id','=','tbl_car.car_id')
		->select("tbl_operating.operating_id")//3user
		->whereIn('operating_id', $ope_id)
		->orderByRaw(DB::raw("FIELD(operating_id, $ope_id_ordered)"))
		->get()->toArray();
	//	dd($operatingsID[0]->operating_id);
		// ./ get list id
		//dd($operatingsID);
		$goods = DB::table('tbl_goods')->select('tbl_goods.*')->get()->toArray();
		$car = DB::table('tbl_car')->select('tbl_car.*')->get()->toArray();
		$place = DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->get()->toArray();
		$users = DB::table('tbl_user')->select('tbl_user.*')->get()->toArray();
		$trailer = DB::table('tbl_trailer')->select('tbl_trailer.*')->get()->toArray();
		$clear_tank = DB::table('tbl_clear_tank')->select('tbl_clear_tank.*')->get()->toArray();
		$partner = DB::table('tbl_partner')->select('tbl_partner.*')->get()->toArray();


		//$operating = array_push('tool1');
		 //dd($operating);
		//dd($tool1);
	// $date = date_create($table->operating_date);
	// $date = date_format($date,'d/m/Y');
		if(count($operating) > 0){
			for($k= 0; $k < count($operating); $k++){
			//	dd($operating[$k]);
				// =====================
				$operatingtool1 = DB::table('tbl_operating')
				->leftJoin('tbl_operating_tool as operating_tool1', function ($join){
					$join->on('tbl_operating.operating_id', '=', 'operating_tool1.operating_id')
					->where('operating_tool1.tool_type', 1);
				})
				->leftJoin('tbl_tool as tool1', 'operating_tool1.tool_id', '=', 'tool1.tool_id' )
				->where('tbl_operating.operating_id',$operatingsID[$k]->operating_id)
				->select('tool1.name')
				->get();
				//dd($operatingtool1);
				//dd($operatingsID[$k]->operating_id);
				$tool1= '';

				foreach( $operatingtool1 as $key =>  $o1){
					if($o1 ->name != null)
						$tool1 .= $o1 ->name;
					if(isset($operatingtool1[$key+1]))
						if($operatingtool1[$key+1] ->name != null)
							$tool1 .= ', ';
					}
				//==============

					$operatingtool2 = DB::table('tbl_operating')
					->leftJoin('tbl_operating_tool as operating_tool2', function ($join) {
						$join->on('tbl_operating.operating_id', '=', 'operating_tool2.operating_id')
						->where('operating_tool2.tool_type', 2);
					})
					->leftJoin('tbl_tool as tool2', 'operating_tool2.tool_id', '=', 'tool2.tool_id' )
					->where('tbl_operating.operating_id',$operatingsID[$k]->operating_id)
					->select('tool2.name','operating_tool2.num')
					->get();
					
					$beforeAfter = DB::table('tbl_operating')
					->select("before_receipt_note","after_receipt_note","before_delivery_note","after_delivery_note","before_driver_note","after_driver_note","before_assistant_note","after_assistant_note","before_owner_note","after_owner_note")
					->where('operating_id',$operatingsID[$k]->operating_id)->get();

					$tool2= '';

					foreach( $operatingtool2 as $key =>  $o2){
						if($o2 ->name != null)
							if($o2 ->num > 1){
								if($o2 ->num < 10){
									$tool2 .= '0'.$o2 ->num.' ';
								}else $tool2 .= $o2 ->num.' ';
							}
							$tool2 .= $o2 ->name;
							if(isset($operatingtool2[$key+1]))
								if($operatingtool2[$key+1] ->name != null)
									$tool2 .= ', ';
							}

							$operating[$k]->tools1 = $tool1;
							$operating[$k]->tools2 = $tool2;

							$date = date_create($operating[$k]->operating_date);
							$operating[$k]->operating_date = date_format($date,'d/m/Y');

							$car_num = $this->mapArrResult($operating[$k]->car_id, $car, "car_id" , "car_num");
							$car_num = mb_strtoupper($car_num, 'UTF-8');				
				$operating[$k]->car_id = $car_num;//số xe

				$goods_name = $this->mapArrResult($operating[$k]->goods_id,$goods,"goods_id","sort_name");
				
				$operating[$k]->goods_id =  mb_strtoupper($goods_name, 'UTF-8');//TÊN hàng
				
				$receiptPlaces = $this->mapArrResult($operating[$k]->receipt_place_id,$place,"place_id","name");
				$receipt_note = mb_strtoupper($beforeAfter[0]->before_receipt_note, 'UTF-8');
				$receipt_note_a = mb_strtoupper($beforeAfter[0]->after_receipt_note, 'UTF-8');
				$receiptPlaces = mb_strtoupper($receiptPlaces, 'UTF-8');

				if($receiptPlaces != null){
					$operating[$k]->receipt_place_id = $receipt_note.' ' .$receiptPlaces. ' '.$receipt_note_a;//noi nhận
				}else{
					$operating[$k]->receipt_place_id = '';
				}

				$deliveryPlaces = $this->mapArrResult($operating[$k]->delivery_place_id,$place,"place_id","name");
				$delivery_note = mb_strtoupper($beforeAfter[0]->before_delivery_note, 'UTF-8');
				$delivery_note_a = mb_strtoupper($beforeAfter[0]->after_delivery_note, 'UTF-8');
				$deliveryPlaces = mb_strtoupper($deliveryPlaces, 'UTF-8');

				if($deliveryPlaces != null){
					$operating[$k]->delivery_place_id =$delivery_note. ' ' .$deliveryPlaces.' '. $delivery_note_a ;//nơi giao
				}else{
					$operating[$k]->delivery_place_id = '';
				}


				$driver = $this->mapArrResult($operating[$k]->driver_id,$users,"user_id","nick_name");
				$driver_note = mb_strtoupper( $beforeAfter[0]->before_driver_note, 'UTF-8');
				$driver_note_a = mb_strtoupper($beforeAfter[0]->after_driver_note, 'UTF-8');

				if($driver != null){
					$operating[$k]->driver_id = $driver_note.' ' .$driver.' '.$driver_note_a;
				}else{
					$operating[$k]->driver_id = '';
				}


				$trailer_num = $this->mapArrResult($operating[$k]->trailer_id,$trailer,"trailer_id","trailer_num");
				$operating[$k]->trailer_id = $trailer_num;

				$owner  = $this->mapArrResult($operating[$k]->owner_id,$partner,"partner_id","partner_short_name");
				$owner_note = mb_strtoupper( $beforeAfter[0]->before_owner_note, 'UTF-8');
				$owner_a = mb_strtoupper($beforeAfter[0]->after_owner_note, 'UTF-8');
				if($owner != null){
					$operating[$k]->owner_id = $owner_note.' '.$owner.' '. $owner_a;
				}else{
					$operating[$k]->owner_id = '';
				}

				$operating[$k]->departure_time = mb_strtoupper($operating[$k]->departure_time, 'UTF-8');

				$operating[$k]->document1 = mb_strtoupper($operating[$k]->document1, 'UTF-8');

				$operating[$k]->document2 = mb_strtoupper($operating[$k]->document2, 'UTF-8');


				$operating[$k]->num = mb_strtoupper($operating[$k]->num, 'UTF-8');



				$assistantDriver = $this->mapArrResult($operating[$k]->assistant_driver_id,$users,"user_id","nick_name");
				$assistant_note = mb_strtoupper(  $beforeAfter[0]->before_assistant_note, 'UTF-8');
				$assistant_note_a = mb_strtoupper($beforeAfter[0]->after_assistant_note, 'UTF-8');
				$assistantDriver = mb_strtoupper($assistantDriver, 'UTF-8');

				if($assistantDriver != null){
					$operating[$k]->assistant_driver_id = $assistant_note.' ' .$assistantDriver.' '.$assistant_note_a ;
				}else{
					$operating[$k]->assistant_driver_id = '';
				}

				$clear_tank_name = $this->mapArrResult($operating[$k]->clear_tank_id,$clear_tank,"clear_tank_id","clear_tank_name");
				$operating[$k]->clear_tank_id =  mb_strtoupper($clear_tank_name, 'UTF-8');

				$curators_name = $this->mapArrResult($operating[$k]->curator_id,$users,"user_id","nick_name");
				$operating[$k]->curator_id = $curators_name;
				//$operating[$k] = (array)$operating[$k];
				
				/*$ta=array("tool1"=>$tool1,"tool2"=>$tool2);

				array_splice($operating[$k],1,0,["tool2"=>$tool2]); */


				$tmpTool1 = 	$operating[$k]->tools1;
				$tmpTool2 = 	$operating[$k]->tools2;
				$tmpNote = $operating[$k]->note;
				$tmpCuratorsName  = $operating[$k]->curator_id;

				
				$operating[$k]->tools1 = mb_strtoupper($tmpNote, 'UTF-8');
				$operating[$k]->tools2 = mb_strtoupper($tmpCuratorsName, 'UTF-8');
				$operating[$k]->note = mb_strtoupper($tmpTool1, 'UTF-8');
				$operating[$k]->curator_id = mb_strtoupper($tmpTool2, 'UTF-8');


			}
		}
	//	dd($operating);
			// echo "<pre>";
				// var_dump($tmpNote = $operating[$k]);
				// echo "</pre>";
				//  exit;
		array_unshift($operating , $operatingTitle[0]);

		for($x=  0; $x < count($operating); $x++){
			$operating[$x] = (array)$operating[$x] ;
		}

	// return response()->json(['success' =>'success','x' => $operating]); 
	// $yyy =  count($resData);
	// $resData = Operating::select("operating_id as Mã Lệnh" , "group_num as Mã gộp chuyến", "operating_date as NGÀY ĐIỀU XE", "owner_id as MÃ KHÁCH HÀNG", "goods_id as MÃ HÀNG HÓA", "receipt_place_id as NƠi NHẬN ID", "before_receipt_note as GHI CHÚ TRƯỚC NƠI NHẬN", "before_receipt_note AS GHI CHÚ SAU NƠI NHẬN", "delivery_place_id AS NƠI GIAO ID", "before_delivery_note AS GHI CHÚ TRƯỚC NƠI GIAO", "after_delivery_note AS GHI CHÚ SAU NƠI GIAO", "note AS GHI CHÚ ĐIỀU XE" )->whereIn('operating_id', $ope_id)->get()->toArray();
	// $xxx = is_array($resData[0]);
	// 	$yyy =  count($resData);
	// var_dump($resData);
	// exit();
	// $abc = $this->cc($resData);

	// var_dump($data);
	// exit();
		$size = array(
			'A'     =>  15,
			'B'     =>  15,
			'C'     =>  25,
			'D'     =>  30,
			'E'     =>  32,
			'F'     =>  32,
			'G'     =>  32,
			'H'     =>  20,
			'I'     =>  20,
		);
		$this->exportExcel($operating,null, "LỆNH TỔNG", $size);
	}

	function formatInputDataExcel($data){
		$result = [];
		$flagBreakRow = 0;
		if(count($data) > 0){
			// if(count($data[0]) % 2 == 0)
			$flagBreakRow = count($data[0]) /2 ;
			// else
				// $flagBreakRow = ( count($data[0]) / 2) + 1;

		// get 2 header rows
			$tmp = $data[0];
			$tmpCount =0;
			$header1 = [];
			$header2 = [];

			foreach ($tmp as $key => $value){
				if($tmpCount < $flagBreakRow)
					$header1[$key] = $key;
				else
					$header2[$key] = $key;
				$tmpCount++;
			}

		// CAN` UNSET DATA INDEX0 
			array_unshift($result , $header2);
			array_unshift($result , $header1);

		//get data
			for($i = 1; $i <count($data); $i++){
				$tmpData = $data[$i];
				$tmpRow1 = [];
				$tmpRow2 = [];
				$tmpCount2 = 0;
				foreach ($tmpData as $key => $value){
					if($tmpCount2 < $flagBreakRow)
						$tmpRow1[$key] = $value;
					else
						$tmpRow2[$key] = $value;
					$tmpCount2++;
				}
				array_push($result,$tmpRow1);
				array_push($result,$tmpRow2);
			}

			return $result;
		}
	}

// Function caulator width of title
	function mapTitle($width){
		$result = [];
		$countBreak = 1;
		if($width > 0){
			$countBreak = floor($width / 25) ;
			$endPoint = ($width % 25);
			$char = chr($endPoint + 64);
			if($countBreak == 0){
				$range = 'A1:'.$char.'1';
				array_push($result,$range, $char);
			}else{
				$char2nd = chr($countBreak +64);
				$range = 'A1:'.$char2nd.$char.'1';
				$endCell = $char2nd.$char;
				array_push($result,$range, $endCell);
			}
		}
		return $result;
	}

// ----------------------------------- EXPORT EXCEL FUNCTION ----------------------------------------------
/*
input:
	$data:
	 array(
		 [0] => array(
			columnName1 => value1,
			columnName2 => value2,
			...
			columnNameN => valueN
		)
		...
		[n] => array(
			columnName1 => value1,
			columnName2 => value2,
			...
			columnNameN => valueN
		)
	)
	$fileName:
		if($fileName == null) => name of file: lenh-tong-tong-hop-dd-mm-yyyy
		if($fileName !=null) => name of file = $fileName
	$title:
		if($title == null) => default title Lenh Tong
		if($title != null) => title of file is $title

OUT PUT: 1 xlsx file
*/



public function exportExcel($data, $fileName  = null, $titleInput = null,$cellSize = []){
	if(count($data) < 1)
		return;
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	$data = $this->formatInputDataExcel($data);
	$flagRow = 0;
	$date = date('m-d-Y', time());
	$funcTitleMergeCell = $this->mapTitle(count($data[0]));
	$titleMergeCell = $funcTitleMergeCell[0];
	$endCellEachRow = $funcTitleMergeCell[1];
	$nameSheet = "lenh-tong-tong-hop-".$date;
	if($fileName != null)
		$nameSheet = $fileName;
	$title = "LỆNH TỔNG";
	if( $titleInput != null )
		$title = $titleInput;
	if($title != null)
	{
		$title = array($title);
		Excel::create($nameSheet, function($excel) use($data, $title, $nameSheet, $flagRow, $titleMergeCell, $endCellEachRow,$cellSize) {
			$excel->sheet($nameSheet, function($sheet) use($data, $title, $flagRow, $titleMergeCell, $endCellEachRow,$cellSize) {
				$sheet->fromArray($data);
				$sheet->setFontFamily('Arial');
				$sheet->row(1, function($row) { $row->setBackground('#ffffff')->setFontSize(20);})
				->row(2, function($row) { $row->setBackground('#00FF00');})
				->row(3, function($row) { $row->setBackground('#00FF00');});
				$sheet->row(1, $title);
				$sheet->mergeCells($titleMergeCell); // titleMergeCell example A1:AG1
				//set boder for cells by range
				$rangeBoder ='A1'.':'.$endCellEachRow.(count($data)+1);
				$sheet->getStyle($rangeBoder . $sheet->getHighestRow())->getAlignment()->setWrapText(true);

				// $sheet->setPaperSize(1);

				// căn lề 0.35 0.2
				$sheet->setPageMargin(array(
					0.2, 0, 0.2, 0.3
				));
				//end căn lề 

				// xoay trang ngang
				$sheet->setOrientation('landscape');
				// colums fit all
				$sheet->setScale(59);
				// $sheet->setFitToWidth(true);


				$ra ='A1'.':'.$endCellEachRow.'2';

				$sheet->cells($ra, function($cells) {
					$cells->setAlignment('center');
				});
				

				$sheet->cells($rangeBoder, function($cells) {
					$cells->setValignment('center');
				});

				for( $i = 4; $i< count($data)+2; $i=$i+2 ){

					// $sheet->setMergeColumn(array(
					// 	'columns' => array('J'),
					// 	'rows' => array(
					// 		array($i,$i+1)
					// 	)
					// ));

					$rangeBoder1 ='A'.$i.':'.$endCellEachRow.(count($data)+1);

					$sheet->cells($rangeBoder1, function($cells) {
						$cells->setAlignment('center');
					});

					$sheet->cells('D'.($i+1).':H'.($i+1), function($cells) {
						$cells->setAlignment('left');
					});

				}

				$sheet->setWidth($cellSize);
				$sheet->setBorder($rangeBoder, 'thin');
				for($i = 6; $i< count($data)+2; $i++ ){
					if($i % 2 == 0 && $flagRow %2 ==0){
						$sheet->row($i, function($row) { $row->setBackground('#D9EDF7');});
						$sheet->row($i+1, function($row) { $row->setBackground('#D9EDF7');});					
					}
					if($i % 2 == 0 )
						$flagRow ++;
				};
			});
			
		})->export('xlsx');
	}
}
 //======================================PRINT========================
public function getListPrint(Request $req){
	if(session()->has('email'))
	{
		$tmpemail = Session::get('email');
		$sess_email = end($tmpemail);
		$sess_users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $sess_email)->get();
		$currentUser_type =$sess_users[0]->user_type;
	}
	$checkAuth = checkAuthController::checkAuth("print","get",$currentUser_type);
	if($checkAuth == 0){
		return view('errors');
		exit;
	}
		// var_dump($id);exit();
	$tmpID= $req->id;
	
		// $xx =[1,2,3];
	$ope_id_ordered = implode(',', $tmpID);
	$goods = DB::table('tbl_goods')->select('tbl_goods.*')->get()->toArray();
	$cars = DB::table('tbl_car')->select('tbl_car.*')->get()->toArray();
	$trailers = DB::table('tbl_trailer')->select('tbl_trailer.*')->get()->toArray();
	$places =  DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.*')->get()->toArray();
	$users = DB::table('tbl_user')->select('tbl_user.*')->get()->toArray();
	$partner = DB::table('tbl_partner')->select('tbl_partner.*')->get()->toArray();
	$clear = DB::table('tbl_clear_tank')->select('tbl_clear_tank.*')->get()->toArray();
	$operating = DB::table('tbl_operating')->select('tbl_operating.*')->whereIn('tbl_operating.operating_id', $tmpID)->orderByRaw(DB::raw("FIELD(operating_id, $ope_id_ordered)"))->get()->toArray();

	if(count($operating) > 0){
		for($k = 0; $k < count($operating); $k++){
			//noi dung trước s
			$beforeAfter = DB::table('tbl_operating')
			->select("before_receipt_note","after_receipt_note","before_delivery_note","after_delivery_note","before_driver_note","after_driver_note","before_assistant_note","after_assistant_note","before_owner_note","after_owner_note")
			->where('operating_id',$operating[$k]->operating_id)->get();
			//end nội dung

			$operating[$k]->goods_name  = $this->mapArrResult($operating[$k]->goods_id,$goods, "goods_id", "sort_name" );

			$operating[$k]->trailer_num  = $this->mapArrResult($operating[$k]->trailer_id,$trailers, "trailer_id", "trailer_num" );
			$operating[$k]->car_num  = $this->mapArrResult($operating[$k]->car_id, $cars, "car_id", "car_num" );

			// $operating[$k]->document1 = '- '.$operating->document1;
			// $operating[$k]->document2 = '- '.$operating->document2;

			$receiptPlaces = $this->mapArrResult($operating[$k]->receipt_place_id, $places, "place_id", "name" );
			$receipt_note = mb_strtoupper($beforeAfter[0]->before_receipt_note, 'UTF-8');
			$receipt_note_a = mb_strtoupper($beforeAfter[0]->after_receipt_note, 'UTF-8');

			if($receiptPlaces != null){
				$operating[$k]->receipt_place_name = $receipt_note.' ' .$receiptPlaces. ' '.$receipt_note_a;//noi nhận
			}else{
				$operating[$k]->receipt_place_name = '';
			}

			$operating[$k]->clear_tank_name  = $this->mapArrResult($operating[$k]->clear_tank_id, $clear, "clear_tank_id", "clear_tank_name" );
			
			$deliveryPlaces  = $this->mapArrResult($operating[$k]->delivery_place_id, $places, "place_id", "name" );
			$delivery_note = mb_strtoupper($beforeAfter[0]->before_delivery_note, 'UTF-8');
			$delivery_note_a = mb_strtoupper($beforeAfter[0]->after_delivery_note, 'UTF-8');

			if($deliveryPlaces != null){
				$operating[$k]->delivery_place_name =$delivery_note. ' ' .$deliveryPlaces.' '. $delivery_note_a ;//nơi giao
			}else{
				$operating[$k]->delivery_place_name = '';
			}

			$driver = $this->mapArrResult($operating[$k]->driver_id,$users,"user_id","nick_name");
			$driver_note = mb_strtoupper( $beforeAfter[0]->before_driver_note, 'UTF-8');
			$driver_note_a = mb_strtoupper($beforeAfter[0]->after_driver_note, 'UTF-8');

			if($driver != null){
				$operating[$k]->driver_name = $driver_note.' ' .$driver.' '.$driver_note_a;
			}else{
				$operating[$k]->driver_name = '';
			}

			$assistantDriver = $this->mapArrResult($operating[$k]->assistant_driver_id,$users,"user_id","nick_name");
			$assistant_note = mb_strtoupper(  $beforeAfter[0]->before_assistant_note, 'UTF-8');
			$assistant_note_a = mb_strtoupper($beforeAfter[0]->after_assistant_note, 'UTF-8');
			$assistantDriver = mb_strtoupper($assistantDriver, 'UTF-8');

			if($assistantDriver != null){
				$operating[$k]->assistant_driver_name = $assistant_note.' ' .$assistantDriver.' '.$assistant_note_a ;
			}else{
				$operating[$k]->assistant_driver_name = '';
			}

			$owner  = $this->mapArrResult($operating[$k]->owner_id, $partner, "partner_id", "partner_short_name" );
			$owner_note = mb_strtoupper( $beforeAfter[0]->before_owner_note, 'UTF-8');
			$owner_a = mb_strtoupper($beforeAfter[0]->after_owner_note, 'UTF-8');

			if($owner != null){
				$operating[$k]->owner_name = $owner_note.' '.$owner.' '. $owner_a;
			}else{
				$operating[$k]->owner_name = '';
			}
			// ng phụ trách 
			$curator = $this->mapArrResult($operating[$k]->curator_id,$users,"user_id","nick_name");
			$curator = mb_strtoupper($curator, 'UTF-8');
			$operating[$k]->curator_name = $curator;

			// phone ng phụ trách
			$curator_phone = $this->mapArrResult($operating[$k]->curator_id,$users,"user_id","phone");
			$curator_phone = mb_strtoupper($curator_phone, 'UTF-8');
			$operating[$k]->curator_phone = $curator_phone;

				// get tools
			$tmpTools1 = DB::table('tbl_operating')->join('tbl_operating_tool', 'tbl_operating_tool.operating_id', '=', 'tbl_operating.operating_id')->join('tbl_tool', 'tbl_tool.tool_id', '=', 'tbl_operating_tool.tool_id')->select('tbl_tool.*')->where('tbl_operating_tool.operating_id', "=", $operating[$k]->operating_id)->where('tbl_operating_tool.tool_type', '=', 1)->get()->toArray();
			$tools1 = "- ";
			if(count($tmpTools1) > 0){
				$tools1 =" - ";
				for($m = 0 ; $m < count($tmpTools1); $m++){
					if($m < count($tmpTools1)-1)
						$tools1 .= $tmpTools1[$m]->name .", ";
					else
						$tools1 .= $tmpTools1[$m]->name;
				}
			}
			$operating[$k]->tools1 = $tools1;


			$tmpTools2 = DB::table('tbl_operating')
			->join('tbl_operating_tool', 'tbl_operating_tool.operating_id', '=', 'tbl_operating.operating_id')
			->join('tbl_tool', 'tbl_tool.tool_id', '=', 'tbl_operating_tool.tool_id')
			->select('tbl_tool.*','tbl_operating_tool.num as num1')->where('tbl_operating_tool.operating_id', "=", $operating[$k]->operating_id)
			->where('tbl_operating_tool.tool_type', '=', 2)->get()->toArray();
				// $operating[$k]->xxx = $tmpTools2;
			//var_dump($tmpTools2); exit();
			$tools2= "- ";
			if(count($tmpTools2) > 0){
				$tools2 =" - ";
				for($m = 0 ; $m < count($tmpTools2); $m++){
					if($m < count($tmpTools2)-1){
						if($tmpTools2[$m]->num1 > 1) {
							if($tmpTools2[$m]->num1 < 10)
								$tools2 .= "0".$tmpTools2[$m]->num1." ";
							else 
								$tools2 .= $tmpTools2[$m]->num1." ";
						}	
						$tools2 .= $tmpTools2[$m]->name ;
						if(isset($tmpTools2[$m+1]->num1)){
							$tools2 .= ', ';
						}
					}
					else{
						if($tmpTools2[$m]->num1 > 1){
							if($tmpTools2[$m]->num1 < 10)
								$tools2 .= "0".$tmpTools2[$m]->num1." ";
							else 
								$tools2 .= $tmpTools2[$m]->num1." ";
						}
						$tools2 .= $tmpTools2[$m]->name;

					}

				}
			}
			$operating[$k]->tools2 = $tools2;

				// replace null value to empty
			if(!isset($operating[$k]->num))$operating[$k]->num ="";
			if(!isset($operating[$k]->departure_time))$operating[$k]->departure_time ="";
			if(!isset($operating[$k]->document1)){
				$operating[$k]->document1 ="- ";
			}else{
				$operating[$k]->document1 = "- ".$operating[$k]->document1;
			}
			if(!isset($operating[$k]->document2)){
				$operating[$k]->document2 ="- ";
			}else{
				$operating[$k]->document2 = "- ".$operating[$k]->document2;

			}

			if(!isset($operating[$k]->note))$operating[$k]->note ="";

		}
	}
		//$operating[0]->dkm = "hihi";
		// $operating[0]->cc  = $this->mapArrResult(1232,$goods, "goods_id", "full_name" );

		// if(isset($operating[0]->cc))
		// 	$operating[0]->dkm ="dkmmmm";
		// if(count($operating) > 0){
		// 	for($j = 0; $j < count($operating); $j++)
		// 	{

		// 	}
		// }
		// $xxx = is_array($operating);

	return Response::json(['success' => $operating]);
}
}