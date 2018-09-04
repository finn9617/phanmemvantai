<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Operating;
use App\OperatingTool;
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
use Illuminate\Pagination\LengthAwarePaginator;
use DateTime;
use DatePeriod;
use DateInterval;
use App\PoolOperatingTool;

class DieuXePoolController extends Controller
{

	public static function getCarCH($id){
		$lastcar = [];
		$lastestGoodsQuery = DB::table('tbl_pool_operating')->where('tbl_pool_operating.owner_id', '=', $id)
				->join('tbl_goods', 'tbl_goods.goods_id', '=', 'tbl_pool_operating.goods_id')
				->select('tbl_pool_operating.*', 'tbl_goods.sort_name')
				->orderBy('tbl_pool_operating.operating_date', 'desc')
				->orderBy('tbl_pool_operating.operating_id', 'desc')->get()->toArray();

				// var_dump($lastestGoodsQuery); exit();
		$tol = '';
		if(count($lastestGoodsQuery) < 4)
			
			for($i=0; $i< count($lastestGoodsQuery) ; $i++){
				// dk xe bồn 
				if($lastestGoodsQuery[$i]->car_type_id == 4){
					$tol = '';
					$car = $lastestGoodsQuery[$i]->car_id;
					$carTable = DB::table('tbl_car')->where('car_id','=',$car)->select('car_num')->first();
					if(isset($carTable))
					$tol .= 'Số xe: '.$carTable->car_num.' - Chất: '.$lastestGoodsQuery[$i]->sort_name; 
					array_push($lastcar,$tol);
				}else{
					$tol = '';
					$car = $lastestGoodsQuery[$i]->car_id;
					$carTable = DB::table('tbl_car')->where('car_id','=',$car)->select('car_num')->first();
					$trailer = DB::table('tbl_trailer')->where('trailer_id','=',$lastestGoodsQuery[$i]->trailer_id)->select('trailer_num')->first();
					if(isset($carTable))
						$tol .= 'Số xe: '.$carTable->car_num.' ';

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
				if($lastestGoodsQuery[$i]->car_type_id == 4){
					$tol = '';
					$car = $lastestGoodsQuery[$i]->car_id;
					$carTable = DB::table('tbl_car')->where('car_id','=',$car)->select('car_num')->first();
					if(isset($carTable))
					$tol .= 'Số xe: '.$carTable->car_num.' - Chất: '.$lastestGoodsQuery[$i]->sort_name; 
					array_push($lastcar,$tol);

				}else{
					$tol = '';
					$car = $lastestGoodsQuery[$i]->car_id;
					$carTable = DB::table('tbl_car')->where('car_id','=',$car)->select('car_num')->first();
					$trailer = DB::table('tbl_trailer')->where('trailer_id','=',$lastestGoodsQuery[$i]->trailer_id)->select('trailer_num')->first();
					if(isset($carTable))
						$tol .= 'Số xe: '.$carTable->car_num;

					if(isset($trailer)){
						$tol .= ' - Romooc: '.$trailer->trailer_num;
					}
					 
					//var_dump($lastcar[$i]); exit();
					array_push($lastcar,$tol);

				}

			//	var_dump($carTable->car_num); exit();
			}
		}
		// if(isset($id)){
		// 	//case loại xe bồn
		// 	if(isset($req->selXe) && $req->selLoaiXe == 4){
		// 		$lastestGoodsQuery = DB::table('tbl_operating')->where('tbl_operating.car_id', '=', $id)
		// 		->join('tbl_goods', 'tbl_goods.goods_id', '=', 'tbl_operating.goods_id')
		// 		->select('tbl_operating.*', 'tbl_goods.sort_name')
		// 		->orderBy('tbl_operating.operating_date', 'desc')
		// 		->orderBy('tbl_operating.operating_id', 'desc')->get()->toArray();
		// 		if(count($lastestGoodsQuery) < 4)
		// 			$lastestGoods = $lastestGoodsQuery;
		// 		else{
		// 			array_push($lastestGoods,$lastestGoodsQuery[0], $lastestGoodsQuery[1], $lastestGoodsQuery[2]);
		// 		}
		// 	}else{
		// 		// var_dump($req->selRomooc);exit();
		// 		if(isset($req->selRomooc)){
		// 			$lastestGoodsQuery = DB::table('tbl_operating')->where('tbl_operating.trailer_id', '=', $req->selRomooc)->join('tbl_goods', 'tbl_goods.goods_id', '=', 'tbl_operating.goods_id')->select('tbl_operating.*', 'tbl_goods.sort_name')->orderBy('tbl_operating.operating_date', 'desc')->orderBy('tbl_operating.operating_id', 'desc')->get()->toArray();
		// 			if(count($lastestGoodsQuery) < 4)
		// 				$lastestGoods = $lastestGoodsQuery;
		// 			else{
		// 				array_push($lastestGoods,$lastestGoodsQuery[0], $lastestGoodsQuery[1], $lastestGoodsQuery[2]);
		// 			}
		// 		}
		// 	}
		// }

		return $lastcar;
		// return $arrResult;
	}

	public function getNGShow($id){
		$lastcar = [];
		$lastestGoodsQuery = DB::table('tbl_pool_operating')->where('tbl_pool_operating.delivery_place_id', '=', $id)
				->join('tbl_goods', 'tbl_goods.goods_id', '=', 'tbl_pool_operating.goods_id')
				->select('tbl_pool_operating.*', 'tbl_goods.sort_name')
				->orderBy('tbl_pool_operating.operating_date', 'desc')
				->orderBy('tbl_pool_operating.operating_id', 'desc')->get()->toArray();

				// var_dump($lastestGoodsQuery); exit();
		$tol = '';
		if(count($lastestGoodsQuery) < 4)
			
			for($i=0; $i< count($lastestGoodsQuery) ; $i++){
				// dk xe bồn 
				
					$tol = '';
					$car = $lastestGoodsQuery[$i]->car_id;
					$carTable = DB::table('tbl_car')->where('car_id','=',$car)->select('car_num')->first();
					$trailer = DB::table('tbl_trailer')->where('trailer_id','=',$lastestGoodsQuery[$i]->trailer_id)->select('trailer_num')->first();
					if(isset($carTable))
						$tol .= 'Số xe: '.$carTable->car_num.' ';

					if(isset($trailer)){
						$tol .= '- Romooc: '.$trailer->trailer_num;
					}
					array_push($lastcar,$tol);
					//var_dump($lastcar[$i]); exit();

				

			//	var_dump($carTable->car_num); exit();
			}
		else{
			for($i=0; $i< 3 ; $i++){
				// dk xe bồn 
			
					$tol = '';
					$car = $lastestGoodsQuery[$i]->car_id;
					$carTable = DB::table('tbl_car')->where('car_id','=',$car)->select('car_num')->first();
					$trailer = DB::table('tbl_trailer')->where('trailer_id','=',$lastestGoodsQuery[$i]->trailer_id)->select('trailer_num')->first();
					if(isset($carTable))
						$tol .= 'Số xe: '.$carTable->car_num;

					if(isset($trailer)){
						$tol .= ' - Romooc: '.$trailer->trailer_num;
					}
					 
					//var_dump($lastcar[$i]); exit();
					array_push($lastcar,$tol);

				

			//	var_dump($carTable->car_num); exit();
			}
		}
		return $lastcar;
	}
	public static function rule($table){
		$date = date_create($table->operating_date);
		$date = date_format($date,'d/m/Y');
		$rule = (object)[
			'ngaydieuxe'=>$date,
			'soxe'=>DB::table('tbl_car')->select('tbl_car.car_num','tbl_car.car_id','tbl_car.note')->where('tbl_car.car_id','=',$table->car_id)->get(),
			'loaihang'=> DB::table('tbl_goods')->select('tbl_goods.full_name','tbl_goods.sort_name','tbl_goods.goods_id','tbl_goods.rate','tbl_goods.note')->where('tbl_goods.goods_id','=',$table->goods_id)->get(),
			'noinhan'=>DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.name','tbl_receipt_delivery_place.place_id')->where('tbl_receipt_delivery_place.place_id','=',$table->receipt_place_id)->where('tbl_receipt_delivery_place.place_type','=',0)->get(),
			'noigiao'=>DB::table('tbl_receipt_delivery_place')->select('tbl_receipt_delivery_place.name','tbl_receipt_delivery_place.place_id')->where('tbl_receipt_delivery_place.place_id','=',$table->delivery_place_id)->where('tbl_receipt_delivery_place.place_type','=',1)->get(),
			'chuhang'=>DB::table('tbl_partner')->select('tbl_partner.partner_short_name','tbl_partner.partner_id','tbl_partner.contact_note','tbl_partner.note')->where('tbl_partner.partner_id','=',$table->owner_id)->get(),
			'',
			'taixe'=>DB::table('tbl_user')->select('tbl_user.nick_name','tbl_user.user_id')->where('tbl_user.user_id','=',$table->driver_id)->where('tbl_user.user_type','=',12)->get(),
			'lo'=>DB::table('tbl_user')->select('tbl_user.nick_name','tbl_user.user_id')->where('tbl_user.user_id','=',$table->assistant_driver_id)->where('tbl_user.user_type','=',13)->get(),
			'tinhtrang'=>$table->status,
			'id' => $table->operating_id,
			'romooc' => DB::table('tbl_trailer')->select('tbl_trailer.trailer_id','tbl_trailer.trailer_num','tbl_trailer.note')->where('tbl_trailer.trailer_id','=',$table->trailer_id)->get(),
			'ct1'=>$table->document1,
			'ct2'=>$table->document2,
			'giodi'=>$table->departure_time,
			'nguoiphutrach'=>DB::table('tbl_user')->select('tbl_user.nick_name','tbl_user.user_id')->where('tbl_user.user_id','=',$table->curator_id)->where('tbl_user.user_type','=',15)->get(),
			'vt' => $table->order_show,
			'soluong' => $table->num,
			'xitbon' => DB::table('tbl_clear_tank')->select('tbl_clear_tank.clear_tank_id','tbl_clear_tank.clear_tank_name')->where('tbl_clear_tank.clear_tank_id','=',$table->clear_tank_id)->get(),
			'ghichu' => $table->note,
			'dungcu1' =>DB::table('tbl_pool_operating_tool')->join('tbl_tool','tbl_pool_operating_tool.tool_id','=','tbl_tool.tool_id')->select('tbl_pool_operating_tool.operating_tool_id','tbl_pool_operating_tool.operating_id','tbl_pool_operating_tool.tool_id','tbl_pool_operating_tool.tool_category_id','tbl_tool.name')->where('tbl_pool_operating_tool.operating_id','=',$table->operating_id)->where('tbl_pool_operating_tool.tool_type','=',1)->get(),
			'dungcu2' =>DB::table('tbl_pool_operating_tool')->join('tbl_tool','tbl_pool_operating_tool.tool_id','=','tbl_tool.tool_id')->select('tbl_pool_operating_tool.num','tbl_pool_operating_tool.operating_tool_id','tbl_pool_operating_tool.operating_id','tbl_pool_operating_tool.tool_id','tbl_pool_operating_tool.tool_category_id','tbl_tool.name')->where('tbl_pool_operating_tool.operating_id','=',$table->operating_id)->where('tbl_pool_operating_tool.tool_type','=',2)->get(),
			'ndTNN' => $table->before_receipt_note,
			'ndSNN' => $table->after_receipt_note,
			'ndTNG' => $table->before_delivery_note,
			'ndSNG' => $table->after_delivery_note,
			'ndTTX' => $table->before_driver_note,
			'ndSTX' => $table->after_driver_note,
			'ndTLX' => $table->before_assistant_note,
			'ndSLX' => $table->after_assistant_note,
			'ndTCH' => $table->before_owner_note,
			'ndSCH' => $table->after_owner_note,
			'rerule' => $table->rerule
			
		];
		return $rule;
	}

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
	
					// căn lề 
					$sheet->setPageMargin(0.28);
					//end căn lề 
					$sheet->setPaperSize(1);
	
					// xoay trang ngang
					$sheet->setOrientation('landscape');
					// end
	
					$ra ='A1'.':'.$endCellEachRow.'2';
	
					$sheet->cells($ra, function($cells) {
						$cells->setAlignment('center');
					});
					
	
					$sheet->cells($rangeBoder, function($cells) {
						$cells->setValignment('top');
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

    public function getShowDieuxePool(Request $request) {

		$tbl = [];
		$car = DB::table('tbl_car')->get()->toArray();
		$goods = DB::table('tbl_goods')->get()->toArray();
		$nng = DB::table('tbl_receipt_delivery_place')->get()->toArray();
		$user = DB::table('tbl_user')->get()->toArray();
		$romooc = DB::table('tbl_trailer')->get()->toArray();
		$partner = DB::table('tbl_partner')->get()->toArray();
		$data = (object)[
			'car' => $car,
			'goods' => $goods,
			'nng' => $nng,
			'user' => $user,
			'romooc' => $romooc,
			'chuhang' => $partner
		];
		// echo "<pre>"; print_r($data);exit();
		$table = DB::select("SELECT * FROM 
			(
			(SELECT *, 02 AS temp_order FROM `tbl_pool_operating` WHERE SUBSTRING(order_show, 8,3) = '00' order by operating_date DESC,  operating_id DESC)
			UNION 
			(SELECT *, 01 AS temp_order FROM `tbl_pool_operating` WHERE SUBSTRING(order_show, 8,3) <> '00' order by `order_show` DESC)
		)AS B  ORDER BY operating_date DESC,temp_order DESC, order_show DESC, operating_id DESC");
		
		
		//dd($table); 
		$itemCollection = collect($table);
		$count = count($itemCollection);

		$perPage = 20;
		$page = LengthAwarePaginator::resolveCurrentPage();

		$paginatedItems = new LengthAwarePaginator($itemCollection->forPage($page, $perPage)->values(), $itemCollection->count(), $perPage, $page, ['path'=>$request->url()]);
		// dd($paginatedItems);
		for ($i=0; $i < count($paginatedItems); $i++) { 
			$tbl[$i]= DieuXePoolController::rule($paginatedItems[$i]);
		}
		//dd($tbl);
		return view('DieuXePool.table',['table' => $paginatedItems])->with(compact('tbl','data'));
	}

	public function getShowDieuxePool2() {
		$tbl = [];
		$car = DB::table('tbl_car')->get()->toArray();
		$goods = DB::table('tbl_goods')->get()->toArray();
		$nng = DB::table('tbl_receipt_delivery_place')->get()->toArray();
		$user = DB::table('tbl_user')->get()->toArray();
		$romooc = DB::table('tbl_trailer')->get()->toArray();
		$partner = DB::table('tbl_partner')->get()->toArray();

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
			$partner[$i]->carNo = DieuXePoolController::getCarCH($partner[$i]->partner_id);
		}

		for($i=0; $i < count($nng); $i++){
			// $last[$i] = DieuXeController::getNGShow($partner[$i]->partner_id);
			$nng[$i]->carNote = DieuXePoolController::getNGShow($nng[$i]->place_id);
		}

		//var_dump($nng); exit();
		$data = (object)[
			'car' => $car,
			'goods' => $goods,
			'nng' => $nng,
			'user' => $user,
			'romooc' => $romooc,
			'chuhang' => $partner
		];

		
		//var_dump($data); exit();

		return Response::json(['success' => $data]);
	}

	public function searchPool(Request $req){
		$tbl = [];
		$car = DB::table('tbl_car')->get()->toArray();
		$goods = DB::table('tbl_goods')->get()->toArray();
		$nng = DB::table('tbl_receipt_delivery_place')->get()->toArray();
		$user = DB::table('tbl_user')->get()->toArray();
		$romooc = DB::table('tbl_trailer')->get()->toArray();
		$data = (object)[
			'car' => $car,
			'goods' => $goods,
			'nng' => $nng,
			'user' => $user,
			'romooc' => $romooc,
		];
		$table = DB::table('tbl_pool_operating')
		->leftJoin('tbl_clear_tank', 'tbl_pool_operating.clear_tank_id', '=', 'tbl_clear_tank.clear_tank_id' )
		->leftJoin('tbl_receipt_delivery_place as delivery_place', 'tbl_pool_operating.delivery_place_id', '=', 'delivery_place.place_id' )
		->leftJoin('tbl_receipt_delivery_place as receipt_place', 'tbl_pool_operating.receipt_place_id', '=', 'receipt_place.place_id' )
		->leftJoin('tbl_user as driver', 'tbl_pool_operating.driver_id', '=', 'driver.user_id' )
		->leftJoin('tbl_user as assistant', 'tbl_pool_operating.assistant_driver_id', '=', 'assistant.user_id' )
		->leftJoin('tbl_user as user', 'tbl_pool_operating.user_id', '=', 'user.user_id' )
		->leftJoin('tbl_partner as owner', 'tbl_pool_operating.owner_id', '=', 'owner.partner_id' )
		->leftJoin('tbl_user as curator', 'tbl_pool_operating.curator_id', '=', 'curator.user_id' )
		->leftJoin('tbl_goods as goods', 'tbl_pool_operating.goods_id', '=', 'goods.goods_id' )
		->leftJoin('tbl_trailer as trailer', 'tbl_pool_operating.trailer_id', '=', 'trailer.trailer_id' )
		->leftJoin('tbl_car as car', 'tbl_pool_operating.car_id', '=', 'car.car_id' )
		->leftJoin('tbl_pool_operating_tool as operating_tool1', function ($join) {
			$join->on('tbl_pool_operating.operating_id', '=', 'operating_tool1.operating_id')->where('operating_tool1.tool_type', 1);
		})
		->leftJoin('tbl_tool as tool1', 'operating_tool1.tool_id', '=', 'tool1.tool_id' )
		->leftJoin('tbl_pool_operating_tool as operating_tool2', function ($join) {
			$join->on('tbl_pool_operating.operating_id', '=', 'operating_tool2.operating_id')->where('operating_tool2.tool_type', 2);
		})
		->leftJoin('tbl_tool as tool2', 'operating_tool2.tool_id', '=', 'tool2.tool_id' )
		->select(
			'tbl_pool_operating.*'
		);
		// Search Date
		if($req->dateStart !='' && $req->dateEnd == '') {
			$table = $table->where('tbl_pool_operating.operating_date','>=', $req->dateStart);
		}else if($req->dateEnd !='' && $req->dateStart == ''){
			$table = $table->where('tbl_pool_operating.operating_date','<=', $req->dateEnd);
		}else if($req->dateStart !='' && $req->dateEnd !='') {
			$table = $table->where('tbl_pool_operating.operating_date','>=', $req->dateStart)->where('tbl_pool_operating.operating_date','<=', $req->dateEnd);
		}else {
			$table = $table;
		}
		// Search Status
		if(!$req->status)
			$req->status = 0;
		if($req->status != 0 && !empty($req->status)){
			$table = $table->where('tbl_pool_operating.status',$req->status);
		}
		// Ruler Search 
		$search = null;
		array_set($search, 'search_car','car.car_num');
		array_set($search, 'search_goods','goods.sort_name');
		array_set($search, 'search_receipt','receipt_place.name');
		array_set($search, 'search_delivery','delivery_place.name');
		array_set($search, 'search_owner','owner.partner_short_name');
		array_set($search, 'search_num','tbl_pool_operating.num');
		array_set($search, 'search_driver','driver.nick_name');
		array_set($search, 'search_assistant_driver','assistant.nick_name');
		array_set($search, 'search_departure_time','tbl_pool_operating.departure_time');
		array_set($search, 'search_clear','tbl_clear_tank.clear_tank_name');
		array_set($search, 'search_trailer','trailer.trailer_num');
		array_set($search, 'search_document1','tbl_pool_operating.document1');
		array_set($search, 'search_document2','tbl_pool_operating.document2');
		array_set($search, 'search_tool1','tool1.name');
		array_set($search, 'search_tool2','tool2.name');
		array_set($search, 'search_note','tbl_pool_operating.note');
		array_set($search, 'search_curator','curator.nick_name');
		array_set($search, 'search_ordershow','tbl_pool_operating.order_show');
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
		$table = $table->select('tbl_pool_operating.*')->orderBy('operating_date', 'desc')->orderBy('order_show', 'desc')->orderBy('operating_id', 'desc')->distinct()->paginate(20);

		for ($i=0; $i < count($table); $i++) { 
			$tbl[$i]= DieuXePoolController::rule($table[$i]);
		}
		// dd($tbl);
		return view('DieuXePool.table')->with(compact('tbl','table','data'));
	}

	public function getListPrintPool(Request $req){
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
		$operating = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->whereIn('tbl_pool_operating.operating_id', $tmpID)->orderByRaw(DB::raw("FIELD(operating_id, $ope_id_ordered)"))->get()->toArray();
	
		if(count($operating) > 0){
			for($k = 0; $k < count($operating); $k++){
				//noi dung trước s
				$beforeAfter = DB::table('tbl_pool_operating')
				->select("before_receipt_note","after_receipt_note","before_delivery_note","after_delivery_note","before_driver_note","after_driver_note","before_assistant_note","after_assistant_note","before_owner_note","after_owner_note")
				->where('operating_id',$operating[$k]->operating_id)->get();
				//end nội dung
	
				$operating[$k]->goods_name  = $this->mapArrResult($operating[$k]->goods_id,$goods, "goods_id", "sort_name" );
	
				$operating[$k]->trailer_num  = $this->mapArrResult($operating[$k]->trailer_id,$trailers, "trailer_id", "trailer_num" );
				$operating[$k]->car_num  = $this->mapArrResult($operating[$k]->car_id, $cars, "car_id", "car_num" );
	
				$receiptPlaces = $this->mapArrResult($operating[$k]->receipt_place_id, $places, "place_id", "name" );
				$receipt_note = mb_strtoupper($beforeAfter[0]->before_receipt_note, 'UTF-8');
				$receipt_note_a = mb_strtoupper($beforeAfter[0]->after_receipt_note, 'UTF-8');
	
				if($receiptPlaces != null){
					$operating[$k]->receipt_place_name = $receipt_note.' ' .$receiptPlaces. ' '.$receipt_note_a;//noi nhận
				}else{
					$operating[$k]->receipt_place_name = '';
				}
	
				
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
	
					// get tools
				$tmpTools1 = DB::table('tbl_pool_operating')->join('tbl_pool_operating_tool', 'tbl_pool_operating_tool.operating_id', '=', 'tbl_pool_operating.operating_id')->join('tbl_tool', 'tbl_tool.tool_id', '=', 'tbl_pool_operating_tool.tool_id')->select('tbl_tool.*')->where('tbl_pool_operating_tool.operating_id', "=", $operating[$k]->operating_id)->where('tbl_pool_operating_tool.tool_type', '=', 1)->get()->toArray();
				$tools1 = "0";
				if(count($tmpTools1) > 0){
					$tools1 ="";
					for($m = 0 ; $m < count($tmpTools1); $m++){
						if($m < count($tmpTools1)-1)
							$tools1 .= $tmpTools1[$m]->name .", ";
						else
							$tools1 .= $tmpTools1[$m]->name;
					}
				}
				$operating[$k]->tools1 = $tools1;
	
	
				$tmpTools2 = DB::table('tbl_pool_operating')
				->join('tbl_pool_operating_tool', 'tbl_pool_operating_tool.operating_id', '=', 'tbl_pool_operating.operating_id')
				->join('tbl_tool', 'tbl_tool.tool_id', '=', 'tbl_pool_operating_tool.tool_id')
				->select('tbl_tool.*','tbl_pool_operating_tool.num as num1')->where('tbl_pool_operating_tool.operating_id', "=", $operating[$k]->operating_id)
				->where('tbl_pool_operating_tool.tool_type', '=', 2)->get()->toArray();
					// $operating[$k]->xxx = $tmpTools2;
				//var_dump($tmpTools2); exit();
				$tools2= "0";
				if(count($tmpTools2) > 0){
					$tools2 ="";
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
				if(!isset($operating[$k]->document1))$operating[$k]->document1 ="";
				if(!isset($operating[$k]->document2))$operating[$k]->document2 ="";
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

	public function exampleExportExcelPool(Request $req){

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
		$operatingTitle = DB::table('tbl_pool_operating')
		// ->join('tbl_user','tbl_pool_operating.owner_id','=','tbl_user.user_id')
		// ->join('tbl_car','tbl_pool_operating.car_id','=','tbl_car.car_id')
		->select("tbl_pool_operating.operating_date as NGÀY ĐIỀU XE" ,
				 "tbl_pool_operating.car_id as SỐ XE",//car
				 "tbl_pool_operating.goods_id as LOẠI HÀNG",
				 "tbl_pool_operating.receipt_place_id as NƠI NHẬN HÀNG",//place id
				 "tbl_pool_operating.delivery_place_id as NƠI GIAO HÀNG",//place id
				 "tbl_pool_operating.owner_id as CHỦ HÀNG",
				 "tbl_pool_operating.num as SỐ LƯỢNG",//0 user
				 "tbl_pool_operating.driver_id as TÀI XẾ",//1user
				 "tbl_pool_operating.assistant_driver_id as LƠ XE",//2user
				 "tbl_pool_operating.departure_time as GIỜ ĐI",
				 "tbl_pool_operating.trailer_id as RƠ MOOC",//romooc
				 "tbl_pool_operating.clear_tank_id as XỊT BỒN",//1xit bon
				 "tbl_pool_operating.document1 as CHỨNG TỪ MANG THEO 1",
				 "tbl_pool_operating.document2 as CHỨNG TỪ MANG THEO 2",
				 "tbl_pool_operating.document2 as DỤNG CỤ 1",
				 "tbl_pool_operating.document2 as DỤNG CỤ 2",
				 "tbl_pool_operating.note as GHI CHÚ",
				 "tbl_pool_operating.curator_id as N.PHỤ TRÁCH")//3user
		->whereIn('operating_id', $ope_id)
		->orderByRaw(DB::raw("FIELD(operating_id, $ope_id_ordered)"))
		->get()->toArray();

		$operating = DB::table('tbl_pool_operating')
		// ->join('tbl_user','tbl_pool_operating.owner_id','=','tbl_user.user_id')
		// ->join('tbl_car','tbl_pool_operating.car_id','=','tbl_car.car_id')
		->select("tbl_pool_operating.operating_date" ,
				 "tbl_pool_operating.car_id",//car
				 "tbl_pool_operating.goods_id", //loại hàng
				 "tbl_pool_operating.receipt_place_id",//place id
				 "tbl_pool_operating.delivery_place_id",//place id
				 "tbl_pool_operating.owner_id"
				 ,"tbl_pool_operating.num",//0 user
				 "tbl_pool_operating.driver_id",//1user
				 "tbl_pool_operating.assistant_driver_id",//2user
				 "tbl_pool_operating.operating_date",
				 'tbl_pool_operating.departure_time',
				 "tbl_pool_operating.trailer_id",//romooc
				 "tbl_pool_operating.clear_tank_id",//1xit bon
				 "tbl_pool_operating.document1",
				 "tbl_pool_operating.document2",
				 "tbl_pool_operating.note",
				 "tbl_pool_operating.curator_id")//3user
		->whereIn('operating_id', $ope_id)
		->orderByRaw(DB::raw("FIELD(operating_id, $ope_id_ordered)"))
		->get()->toArray();
		//dd($operating);
		// get list id
		$operatingsID = DB::table('tbl_pool_operating')
		// ->join('tbl_user','tbl_pool_operating.owner_id','=','tbl_user.user_id')
		// ->join('tbl_car','tbl_pool_operating.car_id','=','tbl_car.car_id')
		->select("tbl_pool_operating.operating_id")//3user
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
				$operatingtool1 = DB::table('tbl_pool_operating')
				->leftJoin('tbl_pool_operating_tool as operating_tool1', function ($join){
					$join->on('tbl_pool_operating.operating_id', '=', 'operating_tool1.operating_id')
					->where('operating_tool1.tool_type', 1);
				})
				->leftJoin('tbl_tool as tool1', 'operating_tool1.tool_id', '=', 'tool1.tool_id' )
				->where('tbl_pool_operating.operating_id',$operatingsID[$k]->operating_id)
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

					$operatingtool2 = DB::table('tbl_pool_operating')
					->leftJoin('tbl_pool_operating_tool as operating_tool2', function ($join) {
						$join->on('tbl_pool_operating.operating_id', '=', 'operating_tool2.operating_id')
						->where('operating_tool2.tool_type', 2);
					})
					->leftJoin('tbl_tool as tool2', 'operating_tool2.tool_id', '=', 'tool2.tool_id' )
					->where('tbl_pool_operating.operating_id',$operatingsID[$k]->operating_id)
					->select('tool2.name','operating_tool2.num')
					->get();
					
					$beforeAfter = DB::table('tbl_pool_operating')
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
			'D'     =>  31,
			'E'     =>  31,
			'F'     =>  32.5,
			'G'     =>  24,
			'H'     =>  18,
			'I'     =>  16,
		);
		$this->exportExcel($operating,null, "LỆNH TỔNG", $size);
	}

	public function postEditOperatingPool(Request $req){
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
			{
				$oldOperatingTools = $req->oldOperatingTools;
				$newOperatingTools = $req->operatingTools;

				// =============== validate busy data=================
				
				if($req->freeRule != 1){
					$errorsBusyData = []; 
					if(isset($req->selTaiXe) && $req->selTaiXe != null && $req->selTaiXe !='' && $req->selTaiXe != $req->oldDriver['user_id']){
						$countDriver = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.driver_id', "=", $req->selTaiXe)->where('tbl_pool_operating.status', '=', 1)->count();
						if($countDriver > 0)
							$errorsBusyData['selTaiXe'] = "Tài xế đang trong chuyến đi khác";
					}
					if(isset($req->selPhuXe) && $req->selPhuXe != null && $req->selPhuXe !='' && $req->selPhuXe != $req->oldAsssistantDriver['user_id']){
						$countAssistantDriver = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.assistant_driver_id', "=", $req->selPhuXe)->where('tbl_pool_operating.status', '=', 1)->count();
						if($countAssistantDriver >0)
							$errorsBusyData['selPhuXe'] = "Phụ xe đang trong chuyến đi khác";
					}
					if(isset($req->selXe) && $req->selXe != null && $req->selXe !='' && $req->selXe != $req->oldCar['car_id']){
						$countCar = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.car_id', "=", $req->selXe)->where('tbl_pool_operating.status', '=', 1)->count();
						if($countCar >0)
							$errorsBusyData['selXe'] = "Xe đang trong chuyến đi khác";
					}
					if(isset($req->selRomooc) && $req->selRomooc != null && $req->selRomooc !='' && $req->selRomooc != $req->oldTrailer['trailer_id']){
						$countRomooc = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.trailer_id', "=", $req->selRomooc)->where('tbl_pool_operating.status', '=', 1)->count();
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
				DB::table('tbl_pool_operating')
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
				// $oldOperatingTools = $req->oldOperatingTools;
				// $newOperatingTools = $req->operatingTools;
				$oldStatus = $req->oldStatus;
				// var_dump($newOperatingTools);exit;
				// update and delete record of tbl_pool_operating_tool
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
						DB::table('tbl_pool_operating_tool')->where('operating_id', '=', $req->operating_id)->where('tool_id', '=', $oldOperatingTools[$i]['tool_id'] )->delete();
					}
				}
				if(!empty($newOperatingTools)){
					$numOperatingTools = count($newOperatingTools);
					for($i = 0 ; $i < $numOperatingTools; $i++){
						$operatingTool = new PoolOperatingTool();
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
					$countDriver = DB::table('tbl_pool_operating')->where('driver_id','=', $req->oldDriver['user_id'])->where('status', '=', 1)->count();
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
					$countAssistantDriver = DB::table('tbl_pool_operating')->where('driver_id','=', $req->oldAsssistantDriver)->where('status', '=', 1)->count();
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
				if($checkCompleteOperating)
					return Response::json(['success' => $req->all()]);
				else
					return Response::json(['errors' => 'that bai1']);
			}
			// end
			return Response::json(['success' => $req->all()]);
		}
		return Response::json(['errors' => 'that bai']);
	}

	public function getEditOperatingPool($id){
		$count = DB::table('tbl_pool_operating')->where('operating_id','=', $id)->count();
		if($count<1)
			return Response::json(['errors' => "lỗi"]);
		$operating = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.operating_id', "=", $id)->get()->toArray();
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
		$tools = DB::table('tbl_tool')->select('tbl_tool.*')->where('tbl_tool.num', ">", 0)->orderBy('tbl_tool.name')->get()->toArray();
		$fullTools = DB::table('tbl_tool')->select('tbl_tool.*')->orderBy('tbl_tool.name')->get()->toArray();
		$curators = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 15)->orderBy('tbl_user.nick_name')->get()->toArray();
		$operatingTools = DB::table('tbl_pool_operating_tool')->select('tbl_pool_operating_tool.*')->where('tbl_pool_operating_tool.operating_id', "=", $id)->get()->toArray();
		$freeDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 12)->orderBy('tbl_user.nick_name')->where('tbl_user.work_status', "=",  0)->where('tbl_user.status', "=",  0)->whereNotIn('tbl_user.user_id', function($q){
			$q->select('driver_id')->from('tbl_pool_operating')->whereNotNull('driver_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeDriversCopy = $freeDrivers;
		$freeAssistantDrivers =  DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', "=", 13)->orderBy('tbl_user.nick_name')->where('tbl_user.work_status', "=",  0)->where('tbl_user.status', "=",  0)->whereNotIn('tbl_user.user_id', function($q){
			$q->select('assistant_driver_id')->from('tbl_pool_operating')->whereNotNull('assistant_driver_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeAssistantDriversCopy = $freeAssistantDrivers;
		$freeCars =  DB::table('tbl_car')->select('tbl_car.*')->orderBy('tbl_car.car_num')->whereNotIn('tbl_car.car_id', function($q){
			$q->select('car_id')->from('tbl_pool_operating')->whereNotNull('car_id' )->where('status', "=", 1);
		})->get()->toArray();
		$freeCarsCopy = $freeCars;
		$currentCar = DB::table('tbl_car')->select('tbl_car.*')->where('tbl_car.car_id', '=', $operating[0]->car_id)->first();
		if($currentCar != null){
			array_push($freeCars, $currentCar);
		}
		$freeTrailers =  DB::table('tbl_trailer')->select('tbl_trailer.*')->orderBy('tbl_trailer.trailer_num')->whereNotIn('tbl_trailer.trailer_id', function($q){
			$q->select('trailer_id')->from('tbl_pool_operating')->whereNotNull('trailer_id' )->where('status', "=", 1);
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

	//function get lastestGoods
	public function getLastestGoods(Request $req){
		$lastestGoods = [];
		if(isset($req->selLoaiXe)){
			//case loại xe bồn
			if(isset($req->selXe) && $req->selLoaiXe == 4){
				$lastestGoodsQuery = DB::table('tbl_pool_operating')->where('tbl_pool_operating.car_id', '=', $req->selXe)->join('tbl_goods', 'tbl_goods.goods_id', '=', 'tbl_pool_operating.goods_id')->select('tbl_pool_operating.*', 'tbl_goods.sort_name')->orderBy('tbl_pool_operating.operating_date', 'desc')->orderBy('tbl_pool_operating.operating_id', 'desc')->get()->toArray();
				if(count($lastestGoodsQuery) < 4)
					$lastestGoods = $lastestGoodsQuery;
				else{
					array_push($lastestGoods,$lastestGoodsQuery[0], $lastestGoodsQuery[1], $lastestGoodsQuery[2]);
				}
			}else{
				// var_dump($req->selRomooc);exit();
				if(isset($req->selRomooc)){
					$lastestGoodsQuery = DB::table('tbl_pool_operating')->where('tbl_pool_operating.trailer_id', '=', $req->selRomooc)->join('tbl_goods', 'tbl_goods.goods_id', '=', 'tbl_pool_operating.goods_id')->select('tbl_pool_operating.*', 'tbl_goods.sort_name')->orderBy('tbl_pool_operating.operating_date', 'desc')->orderBy('tbl_pool_operating.operating_id', 'desc')->get()->toArray();
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
			$allDrivers = DB::table('tbl_pool_operating')->groupBy('driver_id')->select('driver_id', 'car_type_id',  DB::raw("COUNT(*) as count_row"))->where('status', '=', 2)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
			// case DRIVER
			if($req->type == 0 && isset($req->selTaiXe ) && $req->selTaiXe != null){
				// count not working dates
				$workingDate = DB::table('tbl_pool_operating')->select('operating_date')->where('status', '=', 2)->where('driver_id', '=', $req->selTaiXe )->where('operating_date', '<=', $endTime)->where('operating_date', '>', $startTime)->pluck('operating_date');
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
			$scheduleCurrentMonth = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.driver_id', '=', $req->selTaiXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->where('status', '=', 2)->get()->toArray();
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
			$countHYOSUNG = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.driver_id', '=', $req->selTaiXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->where('delivery_place_id', '=', $idHYOSUNG)->where('status', '=', 2)->count();
			$countFAR = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.driver_id', '=', $req->selTaiXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->where('delivery_place_id', '=', $idFAR)->where('status', '=', 2)->count();
			$numberOfScheduleByCarType = DB::table('tbl_pool_operating')->where('tbl_pool_operating.driver_id', '=', $req->selTaiXe)->where('tbl_pool_operating.status', '=', 2)->groupBy('tbl_pool_operating.car_type_id')->join('tbl_car_type', 'tbl_car_type.car_type_id', '=', 'tbl_pool_operating.car_type_id')->select('tbl_car_type.name', 'tbl_pool_operating.car_type_id', DB::raw("COUNT(*) as count_row"))->get()->toArray();
			if($month > 1)
				$month = $month -1;
			else{
				$month =12;
				$year = $year -1;
			}	
			$scheduleLastMonth = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.driver_id', '=', $req->selTaiXe)->where('tbl_pool_operating.status', '=', 2)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
			$numberOfScheduleLastMonth = count($scheduleLastMonth);
				// top
			$allDriversLastMonth  = DB::table('tbl_pool_operating')->groupBy('driver_id')->select('driver_id', 'car_type_id',  DB::raw("COUNT(*) as count_row"))->where('status', '=', 2)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
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
			$workingDate = DB::table('tbl_pool_operating')->select('operating_date')->where('status', '=', 2)->where('assistant_driver_id', '=', $req->selPhuXe )->where('operating_date', '<=', $endTime)->where('operating_date', '>', $startTime)->pluck('operating_date');
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

			$assistantDrivers = DB::table('tbl_pool_operating')->groupBy('assistant_driver_id')->select('assistant_driver_id',  DB::raw("COUNT(*) as count_row"))->where('status', '=', 2)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();

			$countHYOSUNG = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.assistant_driver_id', '=', $req->selPhuXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->where('delivery_place_id', '=', $idHYOSUNG)->where('status', '=', 2)->count();
			$countFAR = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.assistant_driver_id', '=', $req->selPhuXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->where('delivery_place_id', '=', $idFAR)->where('status', '=', 2)->count();
			$scheduleCurrentMonth = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.assistant_driver_id', '=', $req->selPhuXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
			$numberOfScheduleCurrentMonth = count($scheduleCurrentMonth);
			if($month > 1)
				$month = $month -1;
			else{
				$month =12;
				$year = $year -1;
			}
			$scheduleLastMonth = DB::table('tbl_pool_operating')->select('tbl_pool_operating.*')->where('tbl_pool_operating.assistant_driver_id', '=', $req->selPhuXe)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
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

				$assistantDriversLastMonth = DB::table('tbl_pool_operating')->groupBy('assistant_driver_id')->select('assistant_driver_id',  DB::raw("COUNT(*) as count_row"))->where('status', '=', 2)->whereMonth('operating_date' ,'=', $month)->whereYear('operating_date', '=', $year)->get()->toArray();
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
}


