<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;
use Response;

class SumMainController extends Controller {
	public function getshow(){
		$car = DB::table('tbl_car')->orderby('car_num')->get();

		$sum = DB::table('tbl_car')
				->leftJoin('tbl_fire_certificate','tbl_car.car_id','=','tbl_fire_certificate.car_id')
				->leftJoin('tbl_verify','tbl_car.car_id','=','tbl_verify.car_id')
				->leftJoin('tbl_insurance','tbl_car.car_id','=','tbl_insurance.car_id')
				->leftJoin('tbl_maintenance','tbl_car.car_id','=','tbl_maintenance.car_id')
				->select(
					'tbl_car.car_id',
					'tbl_car.car_num',
					DB::raw('max(tbl_maintenance.expiration_date) as date_bd'),
					DB::raw('max(tbl_insurance.expiration_date) as date_bh'),
					DB::raw('max(tbl_verify.expiration_date) as date_kd'),
					DB::raw('max(tbl_fire_certificate.expiration_date) as date_cn')
					)
				->orderby('tbl_car.car_num','ASC')
				->groupby('tbl_car.car_id')
				->get();
		
		// return view('tongbaotri.index', compact('car','maintenance','insurance','verify','pccc'));
		return view('sumMaintenance.index', compact('sum','car'));
	}

	public function itemDetail($id)
    {
        $car = DB::table('tbl_car')
		->join('tbl_car_type', 'tbl_car.car_type_id', '=', 'tbl_car_type.car_type_id')
        ->select('tbl_car.*', 'tbl_car_type.name')
        ->where('car_id', '=', $id)->orderBy('name','ASC')->orderBy('car_num','ASC')
        ->first();

		$maintenance = DB::table('tbl_maintenance')
		->leftJoin('tbl_car','tbl_car.car_id','=','tbl_maintenance.car_id')
		->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_maintenance.car_type_id')
		->select('tbl_maintenance.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
		->where('tbl_maintenance.car_id',$id)
		->orderby('expiration_date','DESC')
		->get();

		$insurance = DB::table('tbl_insurance')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_insurance.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_insurance.car_type_id')
		->select('tbl_insurance.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
		->where('tbl_insurance.car_id',$id)
		->orderby('expiration_date','DESC')
		->get();

		$fireCertificate = DB::table('tbl_fire_certificate')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_fire_certificate.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_fire_certificate.car_type_id')
		->select('tbl_fire_certificate.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
		->where('tbl_fire_certificate.car_id',$id)
		->orderby('expiration_date','DESC')
		->get();
		
		$verify = DB::table('tbl_verify')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_verify.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_verify.car_type_id')
		->select('tbl_verify.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
		->where('tbl_verify.car_id',$id)
		->orderby('expiration_date','DESC')
        ->get();
		
        return view('sumMaintenance.edit', compact('car', 'id','maintenance','insurance','verify','fireCertificate'));
	}
	
	public function search(Request $req)
    {	
		$car_id = $req->selsoxe;

		$car = DB::table('tbl_car')->orderby('car_num')->get();

		$sum = DB::table('tbl_car')
				->leftJoin('tbl_fire_certificate','tbl_car.car_id','=','tbl_fire_certificate.car_id')
				->leftJoin('tbl_verify','tbl_car.car_id','=','tbl_verify.car_id')
				->leftJoin('tbl_insurance','tbl_car.car_id','=','tbl_insurance.car_id')
				->leftJoin('tbl_maintenance','tbl_car.car_id','=','tbl_maintenance.car_id')
				->select(
					'tbl_car.car_id',
					'tbl_car.car_num',
					DB::raw('max(tbl_maintenance.expiration_date) as date_bd'),
					DB::raw('max(tbl_insurance.expiration_date) as date_bh'),
					DB::raw('max(tbl_verify.expiration_date) as date_kd'),
					DB::raw('max(tbl_fire_certificate.expiration_date) as date_cn')
					)
				->where('tbl_car.car_id',$car_id)
				->orderby('tbl_car.car_num','ASC')
				->groupby('tbl_car.car_id')
				->get();
	
		return view('sumMaintenance.index', compact('car','sum','car_id'));




	}
}