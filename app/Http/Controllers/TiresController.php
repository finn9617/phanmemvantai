<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Response;

class TiresController extends Controller
{
    public function getTires(){
        $tires = DB::table('tbl_tires')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_tires.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_tires.car_type_id')
        ->select('tbl_tires.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->orderby('tbl_car_type.name')
         ->orderby('tbl_car.car_id')
        ->get();
        $tires_car = DB::table('tbl_tires')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_tires.car_id')
        ->groupby('tbl_tires.car_id')
        ->orderby('tbl_tires.car_id')
        ->get();
        return view('tires.index',compact('tires','tires_car'));
    } 
 
    public function createItem(){
        return view('tires.create');
    }
 
    public function postcreateItem(Request $req){
 
     $validator = validator::make($req->all(), [
         'selLoaixe' => 'required',
         'selSoxe' => 'required',
 
     ], [
         'selLoaixe.required' => 'Loại xe không được bỏ trống',
         'selSoxe.required' => 'Số xe không được bỏ trống',
     ]);
     if ($validator->passes()) {
         // print_r($req->all()); exit();
         $insData = DB::table('tbl_tires')->insert([
             'car_id' => $req->selSoxe,
             'car_type_id' => $req->selLoaixe,
             'num_old'=> $req->txtSocu,
             'num_new'=> $req->txtSomoi,
             'num_change' => $req->txtSothay,
             'note_tires' => $req->txtGhichu
         ]);
 
         return response()->json(['success' => 'success']);
     }
 
     return response()->json(['errors' => $validator->errors()]);
    }
 
    public function itemDetail($id){
         $tires = DB::table('tbl_tires')->where('tires_id','=',$id)->first();
         return view('tires.edit',compact('tires'));
    }
 
    public function update(Request $req, $id){
        $validator = validator::make($req->all(),[
         'selLoaixe' => 'required',
         'selSoxe' => 'required',
         // 'txtSoPhieu' => 'required',
         // 'date' => 'required',
        ], [
         'selLoaixe.required' => 'Loại xe không được bỏ trống',
         'selSoxe.required' => 'Số xe không được bỏ trống',
         // 'txtSoPhieu.required' => 'Số phiếu không được bỏ trống',
         // 'date.required' => 'Ngày hết hạn không được bỏ trống',
        ]);
 
        if($validator->passes()){
             $tires = DB::table('tbl_tires')->where('tires_id', $id)
             ->update([
                 'car_id' => $req->selSoxe,
                 'car_type_id' => $req->selLoaixe,
                 'num_old'=> $req->txtSocu,
                 'num_new'=> $req->txtSomoi,
                 'num_change' => $req->txtSothay,
                 'note_tires' => $req->txtGhichu
 
             ]
         );
         return response()->json(['success' => 'success']);
        }
 
        return response()->json(['errors' => $validator->errors()]);
 
    }
 
    public function getCarData(){
         $cars = DB::table('tbl_car')->orderBy('car_num','ASC')
         ->get()->toArray();
 
         $carTypes = DB::table('tbl_car_type')
         ->orderBy('name','ASC')->get()->toArray();
 
         $trailer = DB::table('tbl_trailer')
         ->orderBy('trailer_num','ASC')->get()->toArray();
 
         $trailer_type = DB::table('tbl_trailer_type')
         ->orderBy('trailer_type_name','ASC')->get()->toArray();
 
         $res = (object) [
             'cars' => $cars,
             'carTypes' => $carTypes,
             'trailer' => $trailer,
             'trailerType' => $trailer_type,
         ];
 
         return Response::json(['success' => $res]);
    }
 
    public function del(Request $req){
 
     DB::table('tbl_tires')->where('tires_id', '=', $req->id)->delete();
     return response()->json(['success' => 'success']);
 
    }
 
    public function search(Request $req){
 
         $tires_id = $req->seltires;
         $tires_car = DB::table('tbl_tires')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_tires.car_id')
         ->groupby('tbl_tires.car_id')
         ->orderby('tbl_tires.car_id')
         ->get();

         $tires = DB::table('tbl_tires')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_tires.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_tires.car_type_id')
         ->select('tbl_tires.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->where('tbl_car.car_id', '=',$req->seltires)
         ->get();
 
         $tires_o = DB::table('tbl_tires')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_tires.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_tires.car_type_id')
         ->select('tbl_tires.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->orderby('tbl_car_type.name')
         ->orderby('tbl_car.car_id')
         ->get();
 
         return view('tires.index', compact('tires', 'tires_id','tires_car','tires_o'));
    }
 
    public function Print(){
         $tires = DB::table('tbl_tires')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_tires.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_tires.car_type_id')
         ->select('tbl_tires.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->orderby('tbl_car_type.name')
         ->orderby('tbl_car.car_id')
         ->get();
     
         return view('tires.printbd',compact('tires'));
    }

}
