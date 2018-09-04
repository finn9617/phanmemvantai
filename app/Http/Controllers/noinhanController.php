<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Redirect;

class noinhanController extends Controller
{
    public function getNoiNhan(){
    	$noinhan = DB::table('tbl_receipt_delivery_place')->where('place_type',0)->orderby('name')->get();
    	$noinhan_all =  DB::table('tbl_receipt_delivery_place')->where('place_type',0)->orderby('name')->get();
    	// echo"<pre>";
    	// print_r($noigiao);exit;
    	return view('NoiNhan.index',compact('noinhan','noinhan_all'));
    }
    public function createNoiNhan(){
    	return view('NoiNhan.create');
    }
    public function editNoiNhan($id){
    	$getNoiNhanbyID = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.place_id',$id)->first();
    	return view('NoiNhan.detail',compact('getNoiNhanbyID'));
    }
    public function updateNoiNhan(Request $req,$id){
    	$validator = validator::make($req->all(),[
			'txtTennoinhan' => 'required',
		],[
			'txtTennoinhan.required' =>'Tên nơi nhận không được bỏ trống',
		]);
		$check = DB::table('tbl_receipt_delivery_place')->where('name',$req->txtTennoinhan)->where('place_type',0)->whereNotIn('place_id',[$id])->count();
		if($check>0){
			$validator->errors()->add('txtTennoinhan', 'Tên nơi nhận đã bị trùng!');
			return Redirect::back()->withInput()->withErrors($validator->errors());
		}
		if($validator->passes()){
	    	$upData = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.place_id',$id)->update([
	    		'name' => $req->txtTennoinhan,
	    		'address' => $req->txtDiachinoinhan,
	    		'contact_note' => $req->txtInfonguoilh,
				'warehouse_note' => $req->txtInfonoinhan,
	    	]);
	    	return redirect()->away($req->url);
    }
    return Redirect::back()->withInput()->withErrors($validator->errors());
    }
    public function postcreateNoiNhan(Request $req){
    	$validator = validator::make($req->all(),[
			'txtTennoinhan' => 'required',
		],[
			'txtTennoinhan.required' =>'Tên nơi nhận không được bỏ trống',
		]);
		// print_r($req->all());exit;
		$check = DB::table('tbl_receipt_delivery_place')->where('name',$req->txtTennoinhan)->where('place_type',0)->count();
		if($check>0){
			
			$validator->errors()->add('txtTennoinhan', 'Tên nơi nhận đã bị trùng!');
			return Redirect::back()->withInput()->withErrors($validator->errors());
		}
    	if($validator->passes()){
	    	$insData = DB::table('tbl_receipt_delivery_place')->insert([
	    		'name' => $req->txtTennoinhan,
	    		'place_type' => 0,
	    		'address' => $req->txtDiachinoinhan,
	    		'contact_note' => $req->txtInfonguoilh,
				'warehouse_note' => $req->txtInfonoinhan,
	    	]);
	    	// print_r($insData);exit;
	    	return redirect('/noinhan');
    	}
    	 return Redirect::back()->withInput()->withErrors($validator->errors());
    }
    public function deleteNoiNhan($id){
    	// print_r(1);exit;
    	$delData = DB::table('tbl_receipt_delivery_place')->where('tbl_receipt_delivery_place.place_id',$id)->delete();
    	return redirect('/noinhan');
    }
    public function searchNoiNhan(Request $req){
    	$noinhan = DB::table('tbl_receipt_delivery_place')->where('place_type',0)->where('tbl_receipt_delivery_place.place_id','LIKE','%'.$req->tennoinhan.'%')->get();
    	$noinhan_all = DB::table('tbl_receipt_delivery_place')->where('place_type',0)->orderby('name')->get();
    	return view('NoiNhan.index',compact('noinhan','noinhan_all'));
    }
}
