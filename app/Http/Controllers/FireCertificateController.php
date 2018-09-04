<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Response;

class FireCertificateController extends Controller
{
    public function getCN(){
        $fireCertificate = DB::table('tbl_fire_certificate')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_fire_certificate.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_fire_certificate.car_type_id')
        ->select('tbl_fire_certificate.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
        ->orderby('tbl_fire_certificate.expiration_date','DESC')
        ->get();

        $fireCertificate_car = DB::table('tbl_fire_certificate')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_fire_certificate.car_id')
        ->groupby('tbl_fire_certificate.car_id')
        ->orderby('expiration_date')
        ->get();
        
        return view('fire-certificate.index',compact('fireCertificate','fireCertificate_car'));
    } 
    
    public function Sum($id){
        return view('fire-certificate.sumcreate',compact('id'));
    }

    public function createItem(){
        return view('fire-certificate.create');
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
         $insData = DB::table('tbl_fire_certificate')->insert([
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
         $fireCertificate = DB::table('tbl_fire_certificate')->where('fire_certificate_id','=',$id)->first();
         return view('fire-certificate.edit',compact('fireCertificate'));
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
             $baoduong = DB::table('tbl_fire_certificate')->where('fire_certificate_id', $id)
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
 
     DB::table('tbl_fire_certificate')->where('fire_certificate_id', '=', $req->id)->delete();
     return response()->json(['success' => 'success']);
 
    }
 
    public function search(Request $req){
 
         $fireCertificate_id = $req->selfireCertificate;
         $fireCertificate_car = DB::table('tbl_fire_certificate')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_fire_certificate.car_id')
         ->groupby('tbl_fire_certificate.car_id')
         ->orderby('tbl_fire_certificate.car_id')
         ->get();
         
         $fireCertificate = DB::table('tbl_fire_certificate')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_fire_certificate.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_fire_certificate.car_type_id')
         ->select('tbl_fire_certificate.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->where('tbl_car.car_id', '=',$req->selfireCertificate)
         ->orderby('tbl_fire_certificate.expiration_date','DESC')
         ->get();

         $fireCertificate_hh = DB::table('tbl_fire_certificate')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_fire_certificate.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_fire_certificate.car_type_id')
         ->select('tbl_fire_certificate.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->orderby('tbl_fire_certificate.expiration_date','DESC')
         ->get();

         return view('fire-certificate.index', compact('fireCertificate', 'fireCertificate_id','fireCertificate_car','fireCertificate_hh'));
    }
 
    public function Print(){
         $fireCertificate = DB::table('tbl_fire_certificate')
         ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_fire_certificate.car_id')
         ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_fire_certificate.car_type_id')
         ->select('tbl_fire_certificate.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
         ->orderby('tbl_car_type.name')
         ->orderby('tbl_car.car_id')
         ->get();
     
         return view('fire-certificate.printcn',compact('fireCertificate'));
    }
 
}
