<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Response;

class OilController extends Controller
{
   public function getO(){
       $oil = DB::table('tbl_oil')
       ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_oil.car_id')
       ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_oil.car_type_id')
       ->select('tbl_oil.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
        ->orderby('tbl_car_type.name')
        ->orderby('tbl_car.car_id')
       ->get();
       $oil_car = DB::table('tbl_oil')
       ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_oil.car_id')
       ->groupby('tbl_oil.car_id')
       ->orderby('tbl_oil.car_id')
       ->get();
       return view('motorOil.index',compact('oil','oil_car'));
   } 

   public function createItem(){
       return view('motorOil.create');
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
        $insData = DB::table('tbl_oil')->insert([
            'car_id' => $req->selSoxe,
            'car_type_id' => $req->selLoaixe,
            'num_old'=> $req->txtSocu,
            'num_new'=> $req->txtSomoi,
            'num_change' => $req->txtSothay,
            'note_oil' => $req->txtGhichu
        ]);

        return response()->json(['success' => 'success']);
    }

    return response()->json(['errors' => $validator->errors()]);
   }

   public function itemDetail($id){
        $oil = DB::table('tbl_oil')->where('oil_id','=',$id)->first();
        return view('motorOil.edit',compact('oil'));
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
            $oil = DB::table('tbl_oil')->where('oil_id', $id)
            ->update([
                'car_id' => $req->selSoxe,
                'car_type_id' => $req->selLoaixe,
                'num_old'=> $req->txtSocu,
                'num_new'=> $req->txtSomoi,
                'num_change' => $req->txtSothay,
                'note_oil' => $req->txtGhichu

            ]
        );
        return response()->json(['success' => 'success']);
       }

       return response()->json(['errors' => $validator->errors()]);

   }

   public function del(Request $req){

    DB::table('tbl_oil')->where('oil_id', '=', $req->id)->delete();
    return response()->json(['success' => 'success']);

   }

   public function search(Request $req){

        $oil_id = $req->seloil;
        $oil_car = DB::table('tbl_oil')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_oil.car_id')
        ->groupby('tbl_oil.car_id')
        ->orderby('tbl_oil.car_id')
        ->get();
        $oil = DB::table('tbl_oil')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_oil.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_oil.car_type_id')
        ->select('tbl_oil.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
        ->where('tbl_car.car_id', '=',$req->seloil)
        ->get();

        $oil_o = DB::table('tbl_oil')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_oil.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_oil.car_type_id')
        ->select('tbl_oil.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
        ->orderby('tbl_car_type.name')
        ->orderby('tbl_car.car_id')
        ->get();

        return view('motorOil.index', compact('oil', 'oil_id','oil_car','oil_o'));
   }

   public function Print(){
        $oil = DB::table('tbl_oil')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_oil.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_oil.car_type_id')
        ->select('tbl_oil.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
        ->orderby('tbl_car_type.name')
        ->orderby('tbl_car.car_id')
        ->get();
    
        return view('oil.printbd',compact('oil'));
   }

}
