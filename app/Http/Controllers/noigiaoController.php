<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Redirect;

class noigiaoController extends Controller{

    public function getNoiGiao(){
    	$noigiao = DB::table('tbl_receipt_delivery_place')->where('place_type',1)->orderby('name')->get();
    	$noigiao_all =  DB::table('tbl_receipt_delivery_place')->where('place_type',1)->orderby('name')->get();
    	// echo"<pre>";
    	// print_r($noigiao);exit;
    	return view('NoiGiao.index',compact('noigiao','noigiao_all'));
    }
    public function createNoiGiao(){
    	return view('NoiGiao.create');
    }
    public function editNoiGiao($id){
    	$getNoiGiaobyID = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.place_id',$id)->first();
    	return view('NoiGiao.detail',compact('getNoiGiaobyID'));
    }
    public function updateNoiGiao(Request $req,$id){
    	$validator = validator::make($req->all(),[
			'txtTennoigiao' => 'required',
		],[
			'txtTennoigiao.required' =>'Tên nơi giao không được bỏ trống',
		]);
		$check = DB::table('tbl_receipt_delivery_place')->where('name',$req->txtTennoigiao)->where('place_type',1)->whereNotIn('place_id',[$id])->count();
		if($check>0){
			$validator->errors()->add('txtTennoigiao', 'Tên nơi giao đã bị trùng!');
			return Redirect::back()->withInput()->withErrors($validator->errors());
		}
		if($validator->passes()){
	    	$upData = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.place_id',$id)->update([
	    		'name' => $req->txtTennoigiao,
	    		'address' => $req->txtDiachinoigiao,
	    		'contact_note' => $req->txtInfonguoilh,
				'warehouse_note' => $req->txtInfonoigiao,
				'goods_type' => $req->radGoodType,
	    	]);
	    	return redirect()->away($req->url);
    }
    return Redirect::back()->withInput()->withErrors($validator->errors());
    }
    public function postcreateNoiGiao(Request $req){
    	$validator = validator::make($req->all(),[
			'txtTennoigiao' => 'required',
		],[
			'txtTennoigiao.required' =>'Tên nơi giao không được bỏ trống',
		]);
		// print_r($req->all());exit;
		$check = DB::table('tbl_receipt_delivery_place')->where('name',$req->txtTennoigiao)->where('place_type',1)->count();
		if($check>0){
			
			$validator->errors()->add('txtTennoigiao', 'Tên nơi giao đã bị trùng!');
			return Redirect::back()->withInput()->withErrors($validator->errors());
		}

    	if($validator->passes()){
	    	$insData = DB::table('tbl_receipt_delivery_place')->insert([
	    		'name' => $req->txtTennoigiao,
	    		'place_type' => 1,
	    		'address' => $req->txtDiachinoigiao,
	    		'contact_note' => $req->txtInfonguoilh,
				'warehouse_note' => $req->txtInfonoigiao,
				'goods_type' => $req->radGoodType,
	    	]);
	    	// print_r($insData);exit;
	    	return redirect('/noigiao');
    	}
    	return Redirect::back()->withInput()->withErrors($validator->errors());
    }
    public function deleteNoiGiao($id){
    	// print_r(1);exit;
    	$delData = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.place_id',$id)->delete();
    	return redirect('/noigiao');
    }
    public function searchNoiGiao(Request $req){
    	$noigiao = DB::table('tbl_receipt_delivery_place')->where('place_type',1)->where('tbl_receipt_delivery_place.place_id','=',$req->tennoigiao)->get();
    	$noigiao_all = DB::table('tbl_receipt_delivery_place')->where('place_type',1)->orderby('name')->get();
    	return view('NoiGiao.index',compact('noigiao','noigiao_all'));
    }
}
