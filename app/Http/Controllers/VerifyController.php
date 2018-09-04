<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Response;

class VerifyController extends Controller
{
    public function getKD(){
        $verify = DB::table('tbl_verify')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_verify.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_verify.car_type_id')
        ->select('tbl_verify.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
        ->orderby('tbl_verify.expiration_date','DESC')
        ->get();
        $verify_car = DB::table('tbl_verify')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_verify.car_id')
        ->groupby('tbl_verify.car_id')
        ->orderby('tbl_verify.car_id')
        ->get();
        return view('verify.index',compact('verify','verify_car'));
    } 
 
    public function createItem(){
        return view('verify.create');
    }

    public function Sum($id){
        return view('verify.sumcreate',compact('id'));
    }
    public function postcreateItem(Request $req){
 
     $validator = validator::make($req->all(), [
         'selLoaixe' => 'required',
         'selSoxe' => 'required',
        //  'txtSoPhieu' => 'required',
         'date' => 'required',
         'date1' => 'required',
     ], [
         'selLoaixe.required' => 'Loại xe không được bỏ trống',
         'selSoxe.required' => 'Số xe không được bỏ trống',
        //  'txtSoPhieu.required' => 'Số phiếu không được bỏ trống',
         'date.required' => 'Ngày đăng ký không được bỏ trống',
         'date1.required' => 'Ngày hết hạn không được bỏ trống',
     ]);
     if ($validator->passes()) {
         // print_r($req->all()); exit();
         $insData = DB::table('tbl_verify')->insert([
             'car_id' => $req->selSoxe,
             'car_type_id' => $req->selLoaixe,
             'register_date'=> $req->date,
             'expiration_date'=> $req->date1,
             'votes' => $req->txtSoPhieu,
             'note' => $req->txtGhichu,
         ]);
 
         return response()->json(['success' => 'success']);
     }
 
     return response()->json(['errors' => $validator->errors()]);
    }
 
    public function itemDetail($id){
         $verify = DB::table('tbl_verify')->where('verify_id','=',$id)->first();
         return view('verify.edit',compact('verify'));
    }
 
    public function update(Request $req, $id){
        $validator = validator::make($req->all(),[
         'selLoaixe' => 'required',
         'selSoxe' => 'required',
        //  'txtSoPhieu' => 'required',
         'date' => 'required',
         'date1' => 'required',
        ], [
         'selLoaixe.required' => 'Loại xe không được bỏ trống',
         'selSoxe.required' => 'Số xe không được bỏ trống',
        //  'txtSoPhieu.required' => 'Số phiếu không được bỏ trống',
         'date.required' => 'Ngày đăng ký không được bỏ trống',
         'date1.required' => 'Ngày hết hạn không được bỏ trống',
        ]);
 
        if($validator->passes()){
             $baoduong = DB::table('tbl_verify')->where('verify_id', $id)
             ->update([
                 'car_id' => $req->selSoxe,
                 'car_type_id' => $req->selLoaixe,
                 'register_date'=> $req->date,
                 'expiration_date'=> $req->date1,
                 'votes' => $req->txtSoPhieu,
                 'note' => $req->txtGhichu,
             ]
         );
         return response()->json(['success' => 'success']);
        }
 
        return response()->json(['errors' => $validator->errors()]);
 
    }
 
 
    public function del(Request $req){
 
     DB::table('tbl_verify')->where('verify_id', '=', $req->id)->delete();
     return response()->json(['success' => 'success']);
 
    }
 
    public function search(Request $req){
 
         $verify_id = $req->selverify;
         $verify_car = DB::table('tbl_verify')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_verify.car_id')
         ->groupby('tbl_verify.car_id')
         ->orderby('tbl_verify.car_id')
         ->get();
         $verify = DB::table('tbl_verify')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_verify.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_verify.car_type_id')
         ->select('tbl_verify.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->where('tbl_car.car_id', '=',$req->selverify)
         ->orderby('tbl_verify.expiration_date','DESC')
         ->get();

         $verify_hh = DB::table('tbl_verify')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_verify.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_verify.car_type_id')
         ->select('tbl_verify.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->orderby('tbl_verify.expiration_date','DESC')
         ->get();

         return view('verify.index', compact('verify', 'verify_id','verify_car','verify_hh'));
    }
 
    public function Print(){
         $verify = DB::table('tbl_verify')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_verify.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_verify.car_type_id')
         ->select('tbl_verify.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->orderby('tbl_car_type.name')
         ->orderby('tbl_car.car_id')
         ->get();
     
         return view('verify.printkd',compact('verify'));
    }
 
}
