<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;

use Response;

class toolController extends Controller {
	public function index(Request $request){
		$toolsearchloai = DB::table('tbl_tool')
			->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			->select(
				'tbl_tool.*',
				'tbl_tool_category.name as tool_category_name',
				'tbl_tool_category.tool_type as tool_type'
			)->orderBy('name','ASC')
			->get();
		$toolsearch = DB::table('tbl_tool')
			->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			->select(
				'tbl_tool.*',
				'tbl_tool_category.name as tool_category_name',
				'tbl_tool_category.tool_type as tool_type'
			)
			->groupBy('tool_category_name')->orderBy('tool_category_name','ASC')
			->get();

		if($request->has('loaidungcu') && $request->has('tendungcu') && $request->has('txtGhichu')){
			// if($request->tendungcu == null) {
			// 	$tool =  DB::table('tbl_tool')
			// 		->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			// 		->select(
			// 			'tbl_tool.*',
			// 			'tbl_tool_category.name as tool_category_name',
			// 			'tbl_tool_category.tool_type as tool_type'
			// 		)
			// 		->where('tbl_tool_category.tool_category_id', $request->loaidungcu)->orderBy('tool_type','ASC')->orderBy('tbl_tool_category.name')->orderBy('tbl_tool.name','ASC')
			// 		->get();
			// }else if($request->loaidungcu == null) {
			// 	$tool =  DB::table('tbl_tool')
			// 		->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			// 		->select(
			// 			'tbl_tool.*',
			// 			'tbl_tool_category.name as tool_category_name',
			// 			'tbl_tool_category.tool_type as tool_type'
			// 		)
			// 		->where('tbl_tool.name', $request->tendungcu)->orderBy('tool_type','ASC')->orderBy('tbl_tool_category.name')->orderBy('tbl_tool.name','ASC')
			// 		->get();
			// }else if($request->txtGhichu == null) {
			// 	$tool =  DB::table('tbl_tool')
			// 		->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			// 		->select(
			// 			'tbl_tool.*',
			// 			'tbl_tool_category.name as tool_category_name',
			// 			'tbl_tool_category.tool_type as tool_type'
			// 		)
			// 		->where('tbl_tool.name', $request->tendungcu)->orWhere('tbl_tool_category.tool_category_id', $request->loaidungcu)->orderBy('tool_type','ASC')->orderBy('tbl_tool_category.name')->orderBy('tbl_tool.name','ASC')
			// 		->get();
			// }
			// else {
			// 	$tool =  DB::table('tbl_tool')
			// 		->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			// 		->select(
			// 			'tbl_tool.*',
			// 			'tbl_tool_category.name as tool_category_name',
			// 			'tbl_tool_category.tool_type as tool_type'
			// 		)
			// 		->where('tbl_tool_category.tool_category_id', $request->loaidungcu)
			// 		->where('tbl_tool.name', $request->tendungcu)->orderBy('tool_type','ASC')->orderBy('tbl_tool_category.name')->orderBy('tbl_tool.name','ASC')
			// 		->get();
			// }
			// if($request->tendungcu == null && $request->loaidungcu == null){
			// 	$tool =  DB::table('tbl_tool')
			// 		->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			// 		->select(
			// 			'tbl_tool.*',
			// 			'tbl_tool_category.name as tool_category_name',
			// 			'tbl_tool_category.tool_type as tool_type'
			// 		)->orderBy('tool_type','ASC')->orderBy('tbl_tool_category.name')->orderBy('tbl_tool.name','ASC')
			// 		->get();
			// }
			$loaidungcu = Input::get('loaidungcu');
			$tendungcu = Input::get('tendungcu');
			$txtGhichu = Input::get('txtGhichu');
			$tool = DB::table('tbl_tool')
			->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			->select('tbl_tool.*','tbl_tool_category.name as tool_category_name',
			'tbl_tool_category.tool_type as tool_type');
			if($loaidungcu != null && $loaidungcu != "")
				$tool = $tool->where('tbl_tool.tool_category_id', '=', $loaidungcu);
			if($tendungcu != null && $tendungcu != "")
				$tool = $tool->where('tbl_tool.tool_id', '=', $tendungcu);
			if($txtGhichu != null && $txtGhichu != "")
				$tool = $tool->where('tbl_tool.infomation','like', '%'.$txtGhichu.'%');
			
			$tool = $tool
			->orderBy('tool_type','ASC')
			->orderBy('tbl_tool_category.name')
			->orderBy('tbl_tool.name','ASC')
			->get()->toArray();
			// dd($tool);
			return view('DungCu.index', compact('tool', 'toolsearch','toolsearchloai'));
		}else if($request->has('loaidungcu')){
			$tool =  DB::table('tbl_tool')
			->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			->select(
				'tbl_tool.*',
				'tbl_tool_category.name as tool_category_name',
				'tbl_tool_category.tool_type as tool_type'
			)
			->where('tbl_tool_category.tool_category_id', $request->loaidungcu)
			->orderBy('tool_type','ASC')
			->orderBy('tbl_tool_category.name')
			->orderBy('tbl_tool.name','ASC')
			
			->get();
			return view('DungCu.index', compact('tool', 'toolsearch','toolsearchloai'));
		}else {
			$tool = DB::table('tbl_tool')
			->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			->select(
				'tbl_tool.*',
				'tbl_tool_category.name as tool_category_name',
				'tbl_tool_category.tool_type as tool_type'
			)
			->orderBy('tool_type','ASC')
			->orderBy('tbl_tool_category.name')
			->orderBy('tbl_tool.name','ASC')
			->get();
			// dd($toolsearch);
			return view('DungCu.index', compact('tool', 'toolsearch','toolsearchloai'));
		}
	}

	public function CreateGet(Request $request){
		$tool_cate = DB::table('tbl_tool')
			->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			->select(
				'tbl_tool.*',
				'tbl_tool_category.name as tool_category_name',
				'tbl_tool_category.tool_type as tool_type'
			)
			->groupBy('tool_category_name')->orderBy('name','ASC')
			->get();
			$tool_category = DB::table('tbl_tool_category')->orderBy('name','ASC')->get();
		// dd($tool_cate);
		return view('DungCu.create', compact('tool_cate','tool_category'));
	}

	public function CreatePost(Request $request) {
		$validator = Validator::make($request->all(), [
            'tenloaidungcu' => 'required',
            'tendungcu' => 'required',
            'soluong' => 'required|numeric',
        ],[
			'required' => 'Trường này không được bỏ trống',
			'soluong.numeric' => 'Số lượng không hợp lệ',
		]);
        if ($validator->passes()) {
			$check = DB::table('tbl_tool')->where('tool_category_id',$request->tenloaidungcu)->where('name',$request->tendungcu)->count();
			if($check>0){
				$error = (object)["tendungcu"=>["Tên dụng cụ đã tồn tại"]];
				return Response::json(['errors'=>$error],200,array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
			}

			$cate = DB::table('tbl_tool_category')->where('tool_category_id', $request->tenloaidungcu)->first();
			if($cate->tool_type == 1) {
				DB::table('tbl_tool')->insert(
					[
						'tool_category_id' => $request->tenloaidungcu, 
						'name' => $request->tendungcu,
						'num' => 1,
						'parameter' => $request->thongso,
						'infomation' => $request->thongtin,

					]
				);
			}else {
				DB::table('tbl_tool')->insert(
					[
						'tool_category_id' => $request->tenloaidungcu, 
						'name' => $request->tendungcu,
						'num' => $request->soluong,
						'parameter' => $request->thongso,
						'infomation' => $request->thongtin,

					]
				);
			}
			return response()->json(['success'=>'success']);
		}
    	return response()->json(['errors'=>$validator->errors()]);
	}

	public function EditGet(Request $request, $id) {
		$data = DB::table('tbl_tool')
			->join('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			->select(
				'tbl_tool.*',
				'tbl_tool_category.name as tool_category_name',
				'tbl_tool_category.tool_type as tool_type'
			)
			->where('tool_id', $id)->orderBy('tbl_tool_category.name','ASC')
			->first();
			
		$search = DB::table('tbl_tool')
			->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			->select(
				'tbl_tool.*',
				'tbl_tool_category.name as tool_category_name',
				'tbl_tool_category.tool_type as tool_type'
			)
			->groupBy('tool_category_name')->orderBy('tbl_tool_category.name','ASC')
			->get();
				// dd($search);
		// thao tam thoi sua de anh hung test
		$search= DB::table('tbl_tool_category')->orderBy('name','ASC')->get();
		return view('DungCu.edit', compact('data','search','tool_category'));
	}
	
	public function EditPost(Request $request, $id){
		$validator = Validator::make($request->all(), [
            'tenloaidungcu' => 'required',
            'tendungcu' => 'required',
            'soluong' => 'required|numeric',
        ],[
			'required' => 'Trường này không được bỏ trống',
			'soluong.numeric' => 'Số lượng không hợp lệ',
		]);
        if ($validator->passes()) {
			$check = DB::table('tbl_tool')->where('tool_category_id',$request->tenloaidungcu)->where('name',$request->tendungcu)->count();
			$checkId = DB::table('tbl_tool')->where('tool_category_id',$request->tenloaidungcu)->where('name',$request->tendungcu)->select('tool_id')->first();
			$data = json_decode( json_encode($checkId), true);

			if($check>0 && !in_array($id,$data)){
				$error = (object)["tendungcu"=>["Tên dụng cụ đã tồn tại"]];
				return Response::json(['errors'=>$error],200,array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
			}

			$cate = DB::table('tbl_tool_category')->where('tool_category_id', $request->tenloaidungcu)->first();
			if($cate->tool_type == 1) {
				DB::table('tbl_tool')
				->where('tool_id', $id)
				->update([
					'tool_category_id' => $request->tenloaidungcu, 
					'name' => $request->tendungcu,
					'num' => 1,
					'parameter' => $request->thongso,
					'infomation' => $request->thongtin,
				]);
			}else {
				DB::table('tbl_tool')
				->where('tool_id', $id)
				->update([
					'tool_category_id' => $request->tenloaidungcu, 
					'name' => $request->tendungcu,
					'num' => $request->soluong,
					'parameter' => $request->thongso,
					'infomation' => $request->thongtin,
				]);
			}
			return response()->json(['success'=>'success']);
		}
    	return response()->json(['errors'=>$validator->errors()]);
	}

	public function DeleteDungCu(Request $request) {
		DB::table('tbl_tool')->where('tool_id',  $request->id)->delete();
		return response()->json(['success'=>'success']);
	}
	public function Search(Request $request) {
		$search_bo = DB::table('tbl_tool')
			->leftJoin('tbl_tool_category', 'tbl_tool.tool_category_id', '=', 'tbl_tool_category.tool_category_id')
			->select(
				'tbl_tool.*',
				'tbl_tool_category.name as tool_category_name',
				'tbl_tool_category.tool_type as tool_type'
			)->orderBy('tool_category_name','ASC')
			->get()->toArray();
		return response()->json(['success'=>'success','search'=>$search_bo]);
	}
}
