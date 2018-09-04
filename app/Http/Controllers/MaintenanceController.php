<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Response;

class MaintenanceController extends Controller
{
   public function getMaintenance(){
       $maintenance = DB::table('tbl_maintenance')
       ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_maintenance.car_id')
       ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_maintenance.car_type_id')
       ->select('tbl_maintenance.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
       ->orderby('tbl_maintenance.expiration_date','DESC')
       ->get();
       $maintenance_car = DB::table('tbl_maintenance')
       ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_maintenance.car_id')
       ->groupby('tbl_maintenance.car_id')
       ->orderby('tbl_maintenance.car_id')
       ->get();
       return view('maintenance.index',compact('maintenance','maintenance_car'));
   } 
   public function Sum($id){
       return view('maintenance.sumcreate',compact('id'));
   }
   public function createItem(){
       return view('maintenance.create');
   }

   public function postcreateItem(Request $req){

    $validator = validator::make($req->all(), [
        'selLoaixe' => 'required',
        'selSoxe' => 'required',
        // 'txtSoPhieu' => 'required',
        'date' => 'required',
    ], [
        'selLoaixe.required' => 'Loại xe không được bỏ trống',
        'selSoxe.required' => 'Số xe không được bỏ trống',
        // 'txtSoPhieu.required' => 'Số phiếu không được bỏ trống',
        'date.required' => 'Ngày hết hạn không được bỏ trống',
    ]);
    if ($validator->passes()) {
        // print_r($req->all()); exit();
        $insData = DB::table('tbl_maintenance')->insert([
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
        $maintenance = DB::table('tbl_maintenance')->where('maintenance_id','=',$id)->first();
        return view('maintenance.edit',compact('maintenance'));
   }

   public function update(Request $req, $id){
       $validator = validator::make($req->all(),[
        'selLoaixe' => 'required',
        'selSoxe' => 'required',
        // 'txtSoPhieu' => 'required',
        'date' => 'required',
       ], [
        'selLoaixe.required' => 'Loại xe không được bỏ trống',
        'selSoxe.required' => 'Số xe không được bỏ trống',
        // 'txtSoPhieu.required' => 'Số phiếu không được bỏ trống',
        'date.required' => 'Ngày hết hạn không được bỏ trống',
       ]);

       if($validator->passes()){
            $maintenance = DB::table('tbl_maintenance')->where('maintenance_id', $id)
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

   public function getCarData(Request $req){
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

   public function getCar(Request $req){
        $cars = DB::table('tbl_car')
                ->leftJoin('tbl_car_type','tbl_car.car_type_id','=','tbl_car_type.car_type_id')
                ->where('tbl_car.car_id',$req->id)
                ->get()
                ->toArray();
        
        $res = (object)[
            'cars' => $cars
        ];

        return Response::json(['success' => $res]);
   }
   public function del(Request $req){

    DB::table('tbl_maintenance')->where('maintenance_id', '=', $req->id)->delete();
    return response()->json(['success' => 'success']);

   }

   public function search(Request $req){

        $maintenance_id = $req->selmaintenance;
        $maintenance_car = DB::table('tbl_maintenance')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_maintenance.car_id')
        ->groupby('tbl_maintenance.car_id')
        ->orderby('tbl_maintenance.car_id')
        ->get();

        $maintenance = DB::table('tbl_maintenance')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_maintenance.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_maintenance.car_type_id')
        ->select('tbl_maintenance.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
        ->where('tbl_car.car_id', '=',$req->selmaintenance)
        ->orderby('tbl_maintenance.expiration_date','DESC')
        ->get();

        $maintenance_bd = DB::table('tbl_maintenance')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_maintenance.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_maintenance.car_type_id')
        ->select('tbl_maintenance.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
        ->orderby('tbl_maintenance.expiration_date','DESC')
        ->get();

        return view('maintenance.index', compact('maintenance', 'maintenance_id','maintenance_car','maintenance_bd'));
   }

   public function Print(){
        $maintenance = DB::table('tbl_maintenance')
        ->leftJoin('tbl_car','tbl_car.car_id','=','tbl_maintenance.car_id')
        ->leftJoin('tbl_car_type','tbl_car_type.car_type_id','=','tbl_maintenance.car_type_id')
        ->select('tbl_maintenance.*','tbl_car.car_num','tbl_car.car_id','tbl_car_type.name')
        ->orderby('tbl_car_type.name')
        ->orderby('tbl_car.car_id')
        ->get();
    
        return view('maintenance.printbd',compact('maintenance'));
   }

   public function Detailmaintenance($id){
       $job = DB::table('tbl_job')->where('maintenance_id','=',$id)
       ->orderby('job_name')
       ->get();

       $sumjob = DB::table('tbl_job')->where('maintenance_id','=',$id)
       ->select(DB::raw('SUM(price) as pr'))
       ->get();

       $accessary = DB::table('tbl_main_accessary')
       ->where('maintenance_id','=',$id)
       ->orderby('accessary_name')
       ->get();

       $sumaccessary = DB::table('tbl_main_accessary')
       ->where('maintenance_id','=',$id)
        ->select(DB::raw('SUM(price) as pr'))
        ->get();

       return view('maintenance.detail',compact('id','job','sumjob','accessary','sumaccessary'));
   }


   public function CreateItemDeltail($id){
       return view('maintenance.createdetail',compact('id'));
   }


   public function PostItemDeltail(Request $req,$id){

        $validator = validator::make($req->all(),[
            'txtCty' => 'required',
        ]
        ,[
            'txtCty.required' => 'Cần nhập tên công ty bảo dưỡng',
        ]);
        
        if($validator->passes()){
            if(!empty($req->table)){
                $tbl_job = $req->table;
                $tbl = count($tbl_job);
                for($i=0; $i < $tbl; $i++){
                    $job = DB::table('tbl_job')->insert([
                        'maintenance_id' => $id,
                        'company_name' => $req->txtCty,
                        'job_name' => $tbl_job[$i]['job'],
                        'unitprice' => $tbl_job[$i]['unit'],
                        'sale' => $tbl_job[$i]['sale'],
                        'price' => $tbl_job[$i]['price'],
                        'tax' => $tbl_job[$i]['tax'],
                        'note' => $tbl_job[$i]['note']
                    ]);
                    
                }
                return response()->json(['success' => 1]);          
            }
            return response()->json(['errors' => 'errors']);
        }
        return response()->json(['error' => $validator->errors()]);

   }

   public function PostItemDeltail1(Request $req,$id){

        $validator = validator::make($req->all(),[
            'txtCty' => 'required',
        ]
        ,[
            'txtCty.required' => 'Cần nhập tên công ty bảo dưỡng',
        ]);
        if($validator->passes()){
            if(!empty($req->table)){
                $acc = $req->table;
                $tbl = count($acc);
                for($i=0; $i < $tbl; $i++){
                    $job = DB::table('tbl_main_accessary')->insert([
                        'maintenance_id' => $id,
                        'company_name' => $req->txtCty,
                        'accessary_name' => $acc[$i]['txtAcc'],
                        'num' => $acc[$i]['txtAmount'],
                        'unit' => $acc[$i]['txtUnit1'],
                        'unitprice' => $acc[$i]['txtUnitPrice1'],
                        'tax' => $acc[$i]['txtTax1'],
                        'sale' => $acc[$i]['txtSale1'],
                        'note' => $acc[$i]['txtGhichu1'],
                        'price' => $acc[$i]['txtPrice1']
                    ]);
                    
                }
                return response()->json(['success' => 'success']);          
            }
            return response()->json(['errors' => 'errors']);
        }
        return response()->json(['error' => $validator->errors()]);

    }

    public function DeltailDel(Request $req){
        DB::table('tbl_job')->where('job_id', '=', $req->id)->delete();

        return response()->json(['success' => 'success']);
    }

    public function Deltail1Del(Request $req){
        DB::table('tbl_main_accessary')->where('m_accessaty_id', '=', $req->id)->delete();

        return response()->json(['success' => 'success']);
    }

    public function DeltailEdit(Request $req,$id){
        $job= DB::table('tbl_job')->where('job_id','=',$id)->first();
        return view('maintenance.editJob',compact('job'));
    }

    public function DeltailEdit1(Request $req){

        $validator = validator::make($req->all(),[
            'txtAcc' => 'required',
        ]
        ,[
            'txtAcc.required' => 'Cần nhập tên phụ tùng',
        ]);
        // dd($req->ac_id); exit;
        if($validator->passes()){
                $job = DB::table('tbl_main_accessary')->where('m_accessaty_id','=',$req->ac_id)->update([
                    'accessary_name' => $req->txtAcc,
                    'num' => $req->txtAmount,
                    'unit' => $req->txtUnit1,
                    'unitprice' => $req->txtUnitPrice1,
                    'tax' => $req->txtTax1,
                    'sale' => $req->txtSale1,
                    'note' => $req->txtGhichu1,
                    'price' => $req->txtPrice1
                ]);
                    
            return response()->json(['success' => 'success']);          
        }
        return response()->json(['error' => $validator->errors()]);
    }

    public function Deltail1Edit(Request $req,$id){
        $Ac= DB::table('tbl_main_accessary')->where('m_accessaty_id','=',$id)->first();
        return view('maintenance.editAc',compact('Ac'));
    }

    public function Deltail1Edit1(Request $req){
        $validator = validator::make($req->all(),[
            'txtJob' => 'required',
        ]
        ,[
            'txtJob.required' => 'Cần nhập tên phụ tùng',
        ]);
        // dd($req->ac_id); exit;
        if($validator->passes()){
                $job = DB::table('tbl_job')->where('job_id','=',$req->job_id)->update([
                    'job_name' => $req->txtJob,
                    'unitprice' => $req->txtUnitPrice,
                    'sale' => $req->txtSale,
                    'price' => $req->txtPrice,
                    'tax' => $req->txtTax,
                    'note' => $req->txtGhichu
                ]);
                    
            return response()->json(['success' => 'success']);          
        }
        return response()->json(['error' => $validator->errors()]);
    }
    
}
