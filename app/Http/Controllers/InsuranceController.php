<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Response;
    

class InsuranceController extends Controller
{
    public function getInsurance(){
        $insurance = DB::table('tbl_insurance')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_insurance.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_insurance.car_type_id')
        ->select('tbl_insurance.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
        ->orderby('tbl_insurance.expiration_date','DESC')
        ->get();
        $insurance_car = DB::table('tbl_insurance')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_insurance.car_id')
        ->groupby('tbl_insurance.car_id')
        ->orderby('tbl_insurance.car_id')
        ->get();
        return view('insurance.index',compact('insurance','insurance_car'));
    } 
    public function Sum($id){
        return view('insurance.sumcreate',compact('id'));
    }

    public function createItem(){
        return view('insurance.create');
    }
 
    public function postcreateItem(Request $req){
 
     $validator = validator::make($req->all(), [
         'selLoaixe' => 'required',
         'selSoxe' => 'required',
        //  'txtSoPhieu' => 'required',
         'date' => 'required',
     ], [
         'selLoaixe.required' => 'Loại xe không được bỏ trống',
         'selSoxe.required' => 'Số xe không được bỏ trống',
        //  'txtSoPhieu.required' => 'Số phiếu không được bỏ trống',
         'date.required' => 'Ngày hết hạn không được bỏ trống',
     ]);
     if ($validator->passes()) {
         // print_r($req->all()); exit();
         $insData = DB::table('tbl_insurance')->insert([
             'car_id' => $req->selSoxe,
             'car_type_id' => $req->selLoaixe,
             'expiration_date'=> $req->date,
             'votes' => $req->txtSoPhieu,
             'note' => $req->txtGhichu

         ]);
 
         return response()->json(['success' => 'success']);
     }
 
     return response()->json(['errors' => $validator->errors()]);
    }
 
    public function itemDetail($id){
         $insurance = DB::table('tbl_insurance')->where('insurance_id','=',$id)->first();
         return view('insurance.edit',compact('insurance'));
    }
 
    public function update(Request $req, $id){
        $validator = validator::make($req->all(),[
         'selLoaixe' => 'required',
         'selSoxe' => 'required',
        //  'txtSoPhieu' => 'required',
         'date' => 'required',
        ], [
         'selLoaixe.required' => 'Loại xe không được bỏ trống',
         'selSoxe.required' => 'Số xe không được bỏ trống',
        //  'txtSoPhieu.required' => 'Số phiếu không được bỏ trống',
         'date.required' => 'Ngày hết hạn không được bỏ trống',
        ]);
 
        if($validator->passes()){
             $baoduong = DB::table('tbl_insurance')->where('insurance_id', $id)
             ->update([
                 'car_id' => $req->selSoxe,
                 'car_type_id' => $req->selLoaixe,
                 'expiration_date'=> $req->date,
                 'votes' => $req->txtSoPhieu,
                 'note' => $req->txtGhichu

             ]
         );
         return response()->json(['success' => 'success']);
        }
 
        return response()->json(['errors' => $validator->errors()]);
 
    }
 
 
    public function del(Request $req){
 
     DB::table('tbl_insurance')->where('insurance_id', '=', $req->id)->delete();
     return response()->json(['success' => 'success']);
 
    }
 
    public function search(Request $req){
 
         $insurance_id = $req->selinsurance;
         $insurance_car = DB::table('tbl_insurance')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_insurance.car_id')
         ->groupby('tbl_insurance.car_id')
         ->orderby('tbl_insurance.car_id')
         ->get();

         $insurance = DB::table('tbl_insurance')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_insurance.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_insurance.car_type_id')
         ->select('tbl_insurance.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->where('tbl_car.car_id', '=',$req->selinsurance)
         ->orderby('tbl_insurance.expiration_date','DESC')
         ->get();

         $insurance_hh = DB::table('tbl_insurance')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_insurance.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_insurance.car_type_id')
         ->select('tbl_insurance.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->orderby('tbl_insurance.expiration_date','DESC')
         ->get();

         return view('insurance.index', compact('insurance', 'insurance_id','insurance_car','insurance_hh'));
    }
 
    public function Print(){
         $insurance = DB::table('tbl_insurance')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_insurance.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_insurance.car_type_id')
         ->select('tbl_insurance.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->orderby('tbl_car_type.name')
         ->orderby('tbl_car.car_id')
         ->get();
     
         return view('insurance.printbh',compact('insurance'));
    }
 
}
