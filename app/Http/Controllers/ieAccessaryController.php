<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use App\orderAccessary;
use App\AccessaryOrderDetail;
use Excel;
use Input;

class ieAccessaryController extends Controller
{
    //Nhập phụ tùng
    public function indexImport(){
        // $data = DB::table('tbl_accessary_order')
        // ->leftJoin('tbl_accessary_order_detail','tbl_accessary_order_detail.order_accessary_id','=','tbl_accessary_order.order_accessary_id')
        // ->leftJoin('tbl_accessary','tbl_accessary_order_detail.accessary_id','=','tbl_accessary.accessary_id')
        // ->leftJoin('tbl_partner','tbl_accessary_order.import_partner_id','=','tbl_partner.partner_id')
        // ->leftJoin('tbl_user as import','tbl_accessary_order.import_user_id','=','import.user_id')
        // ->leftJoin('tbl_user as using','tbl_accessary_order.user_id','=','using.user_id')
        // ->select('tbl_accessary_order.*','tbl_accessary_order_detail.*','tbl_accessary.*','import.nick_name','using.nick_name','tbl_partner.partner_short_name')->get();

        $data = DB::table('tbl_accessary_order')
        ->leftJoin('tbl_user as import','tbl_accessary_order.import_user_id','=','import.user_id')->where('order_type','=',1)
        ->orderBy('order_accessary_date')->select('tbl_accessary_order.*','import.nick_name')->paginate(20);
        $arrID = $data->pluck('order_accessary_id');
        $details = DB::table('tbl_accessary_order_detail')->whereIn('order_accessary_id', $arrID)
        ->leftJoin('tbl_partner','tbl_accessary_order_detail.import_partner_id','=','tbl_partner.partner_id')
        ->leftJoin('tbl_accessary','tbl_accessary_order_detail.accessary_id','=','tbl_accessary.accessary_id')
        ->get();
        // dd($details);
        for($i=0;$i<count($data);$i++){
            $tmpData =[];
            $tmpAccessaryName ="";
            $tmpPartnerName ="";

            for($j=0; $j<count($details); $j++){
                if($data[$i]->order_accessary_id == $details[$j]->order_accessary_id)
                {
                    $tmpAccessaryName .= $details[$j]->accessary_name . ", ";
                    $tmpPartnerName .= $details[$j]->partner_short_name . ", ";
                }
                
               
            }
           $tmpAccessaryName = rtrim($tmpAccessaryName,", ");
           $tmpPartnerName = rtrim($tmpPartnerName,", ");

           $data[$i]->accessaryNames =   $tmpAccessaryName;
           $data[$i]->partnerNames =   $tmpPartnerName;
        }
        return view('importAccessary.index',compact('data'));
    }

    public function searchImport(Request $req){
        $accessaryName = $req->aShortname;
        $partnerName = $req->pShortname;
        $from = $req->ioStart;
        $to = $req->ioEnd;

        if($from){
            $from = date_create($req->ioStart);
            $from = date_format($from,'Y-m-d');
        }
        if($to){
            $to = date_create($req->ioEnd);
            $to = date_format($to,'Y-m-d');
        }
        $data = DB::table('tbl_accessary_order')
            ->leftJoin('tbl_user as import','tbl_accessary_order.import_user_id','=','import.user_id')->where('order_type','=',1)
            ->orderBy('order_accessary_date')->select('tbl_accessary_order.*','import.nick_name');
        $arrID = $data->pluck('order_accessary_id');
        $details = DB::table('tbl_accessary_order_detail')->whereIn('order_accessary_id', $arrID)
            ->leftJoin('tbl_partner','tbl_accessary_order_detail.import_partner_id','=','tbl_partner.partner_id')
            ->leftJoin('tbl_accessary','tbl_accessary_order_detail.accessary_id','=','tbl_accessary.accessary_id');


        if($accessaryName!=null){
            $acc = DB::table('tbl_accessary')->where('accessary_name','like','%'.$accessaryName.'%')->get();

            $accId = [];
            foreach ($acc as $a){
                array_push($accId,$a->accessary_id);
            }
            $details = $details->whereIn('tbl_accessary_order_detail.accessary_id',$accId);
        }

        if($partnerName!=null){
            $pner = DB::table('tbl_partner')->where('partner_short_name','like','%'.$partnerName.'%')->where('partner_type','=',2)->get();

            $pnerId = [];
            foreach($pner as $pn){
                array_push($pnerId,$pn);
            }
            $data = $data->whereIn('tbl_accessary_order.import_partner_id',$pnerId);
        }
        if($from!=null && $to==null){
            $data = $data->where('order_accessary_date','>=',$from);
        }
        if($from==null && $to!=null){
            $data = $data->where('order_accessary_date','<=',$to);
        }
        if($from!=null && $to!=null){
            $data = $data->whereBetWeen('order_accessary_date',[$from,$to]);
        }

        $data = $data->paginate(20);
        $details = $details->get();
        for($i=0;$i<count($data);$i++){
            $tmpData =[];
            $tmpAccessaryName ="";
            $tmpPartnerName ="";

            for($j=0; $j<count($details); $j++){
                if($data[$i]->order_accessary_id == $details[$j]->order_accessary_id)
                {
                    $tmpAccessaryName .= $details[$j]->accessary_name . ", ";
                    $tmpPartnerName .= $details[$j]->partner_short_name . ", ";
                }
                
               
            }
           $tmpAccessaryName = rtrim($tmpAccessaryName,", ");
           $tmpPartnerName = rtrim($tmpPartnerName,", ");

           $data[$i]->accessaryNames =   $tmpAccessaryName;
           $data[$i]->partnerNames =   $tmpPartnerName;
        }
        return view('importAccessary.index',compact('data'));
    }

    public function getCreateImport(){
        $accessary = DB::table('tbl_accessary')->get();
        $partner = DB::table('tbl_partner')->where('partner_type','=',2)->get();
        return view('importAccessary.create',compact('accessary','partner'));
    }

    public function postCreateImport(Request $request){
        DB::beginTransaction();
        try{
            $rule = [
                // 'shortname' => 'required',
                'importDate' => 'required',
                // 'amount' => 'required|numeric',
            ];
    
            $messages = [
                // 'shortname.required' => 'Vui lòng chọn tên phụ tùng',
                'importDate.required' => 'Vui lòng chọn ngày nhập',
                // 'amount.required' => 'Vui lòng nhập số lượng',
                // 'amount.numeric' => 'Số lượng không hợp lệ'
            ];

            if($request->row === null){
                $rule['row']='required';
                $messages['row.required']='Đơn nhập hàng không được trống';
            }
    
            $validator = Validator::make($request->all(),$rule,$messages);
            if($validator->passes()){
                $tbl = DB::table('tbl_accessary_order')->insertGetId([
                    'order_accessary_date' => $request->importDate,
                    'import_user_id' => $request->import_user,
                    'note' => $request->noteOrder,
                    'order_type' => 1,
                ]);

                $data1 = array();
                $arr = array();

                for($i=1;$i<=$request->row;$i++){
                    $name  = "data".$i;
                    $dt = explode(',',$request->$name);
                    $arr['order_accessary_id']=$tbl;
                    $arr['amount']=$dt[3];
                    $arr['price']=$dt[5];
                    $arr['total_price']=$dt[6];
                    $arr['note']=$dt[7];
                    $arr['accessary_id']=$dt[9];
                    $arr['import_partner_id']=$dt[10];
                    array_push($data1,$arr);
                }
                
                DB::table('tbl_accessary_order_detail')->insert($data1);

                for($i=0;$i<$request->row;$i++){
                    $accId = $data1[$i]['accessary_id'];

                    $amount = DB::table('tbl_accessary')->where('accessary_id','=',$accId)->first();

                    $updateAm = $amount->amount + $data1[$i]['amount'];

                    DB::table('tbl_accessary')->where('accessary_id','=',$accId)->update(['amount'=>$updateAm]);
                }

                DB::commit();
                return response()->json(['success'=>'success']);
            }
            return response()->json(['error'=>$validator->errors()]);
        }
        catch(\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$e]);
            //return $e;
             // print_r($e);
        }
    }

    public function getEditImport(Request $request){
        $oA = DB::table('tbl_accessary_order')->where('order_accessary_id','=',$request->id)->first();
        $oAD = DB::table('tbl_accessary_order_detail')
        ->leftJoin('tbl_accessary','tbl_accessary_order_detail.accessary_id','=','tbl_accessary.accessary_id')
        ->leftJoin('tbl_partner','tbl_accessary_order_detail.import_partner_id','=','tbl_partner.partner_id')
        ->where('order_accessary_id','=',$request->id)->select('tbl_accessary_order_detail.*','tbl_accessary.accessary_name','tbl_accessary.unit','tbl_partner.partner_short_name')->get();
        $accessary = DB::table('tbl_accessary')->get();
        $partner = DB::table('tbl_partner')->where('partner_type','=',2)->get();

        return view('importAccessary.edit',compact('oA','partner','accessary','oAD'));
    }

    public function postEditImport(Request $request){
        DB::beginTransaction();
        try{
            $rule = [
                'importDate' => 'required',
            ];
    
            $messages = [
                'importDate.required' => 'Vui lòng chọn ngày nhập',
            ];

            if($request->row === null){
                $rule['row']='required';
                $messages['row.required']='Đơn nhập hàng không được trống';
            }
    
            $validator = Validator::make($request->all(),$rule,$messages);
            if($validator->passes()){
                $tbl = DB::table('tbl_accessary_order')->where('order_accessary_id','=',$request->orderId)
                ->update([
                    'order_accessary_date' => $request->importDate,
                    'note' => $request->noteOrder,
                ]);

                $data1 = array();
                $arr = array();

                for($i=1;$i<=$request->row;$i++){
                    $name  = "data".$i;
                    $dt = explode(',',$request->$name);
                    $arr['order_accessary_id']=$request->orderId;
                    $arr['amount']=$dt[3];
                    $arr['price']=$dt[5];
                    $arr['total_price']=$dt[6];
                    $arr['note']=$dt[7];
                    $arr['accessary_id']=$dt[9];
                    $arr['import_partner_id']=$dt[10];
                    if($dt[11]!='nodata'){
                        $arr['accessary_order_detail_id']=$dt[11];
                    }
                    else{
                        $arr['accessary_order_detail_id']="";
                    }
                    array_push($data1,$arr);
                }

                $deleteId = [];

                for($i=0;$i<$request->row;$i++){
                    $id = $data1[$i]['accessary_order_detail_id'];
                    if($id!=""){
                        array_push($deleteId,$id);
                    }
                }

                $subAmount = DB::table('tbl_accessary_order_detail')->where('order_accessary_id','=',$request->orderId)->whereNotIn('accessary_order_detail_id',$deleteId)->get();

                for($i=0;$i<count($subAmount);$i++){
                    $accId = $subAmount[$i]->accessary_id;

                    $amount = DB::table('tbl_accessary')->where('accessary_id','=',$accId)->first();

                    $updateAm = $amount->amount - $subAmount[$i]->amount;

                    DB::table('tbl_accessary')->where('accessary_id','=',$accId)->update(['amount'=>$updateAm]);
                }
                
                DB::table('tbl_accessary_order_detail')->where('order_accessary_id','=',$request->orderId)->whereNotIn('accessary_order_detail_id',$deleteId)->delete();
                
                for($i=0;$i<$request->row;$i++){
                    if($data1[$i]['accessary_order_detail_id']!=""){
                        DB::table('tbl_accessary_order_detail')->where('accessary_order_detail_id','=',$data1[$i]['accessary_order_detail_id'])
                        ->update($data1[$i]);
                    }
                    else{
                        DB::table('tbl_accessary_order_detail')->insert($data1[$i]);

                        $accId = $data1[$i]['accessary_id'];

                        $amount = DB::table('tbl_accessary')->where('accessary_id','=',$accId)->first();

                        $updateAm = $amount->amount + $data1[$i]['amount'];

                        DB::table('tbl_accessary')->where('accessary_id','=',$accId)->update(['amount'=>$updateAm]);
                    }
                }

                DB::commit();
                return response()->json(['success'=>'success']);
            }
            return response()->json(['error'=>$validator->errors()]);
        }
        catch(\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$e]);
            //return $e;
             // print_r($e);
        }
    }

    public function deleteImport(Request $req){
        DB::beginTransaction();
        try{
            $delete = DB::table('tbl_accessary_order_detail')->where('order_accessary_id','=',$req->id)->get()->toArray();
            for($i=0;$i<count($delete);$i++){
                $accessary = DB::table('tbl_accessary')->where('accessary_id','=',$delete[$i]->accessary_id)->first();
                $amount = $accessary->amount;
                
                $tAmount = $amount - $delete[$i]->amount;

                DB::table('tbl_accessary')->where('accessary_id','=',$delete[$i]->accessary_id)->update(['amount'=>$tAmount]);
                DB::table('tbl_accessary_order_detail')->where('order_accessary_id','=',$req->id)->delete();
                DB::table('tbl_accessary_order')->where('order_accessary_id','=',$req->id)->delete();

            }

            DB::commit();
            return response()->json(['success'=>'success']);
        }
        catch(\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$e]);
            //return $e;
            // print_r($e);
        }
    }

    public function reportImport(Request $request){
        $start = $request->start;
        $end = $request->end;

        $excelR = DB::table('tbl_accessary_order')
        ->leftJoin('tbl_accessary_order_detail','tbl_accessary_order.order_accessary_id','=','tbl_accessary_order_detail.order_accessary_id')
        ->leftJoin('tbl_accessary','tbl_accessary_order_detail.accessary_id','=','tbl_accessary.accessary_id')
        ->leftJoin('tbl_partner','tbl_accessary_order_detail.import_partner_id','=','tbl_partner.partner_id')
        ->leftJoin('tbl_user','tbl_accessary_order.import_user_id','=','tbl_user.user_id')
        ->select('tbl_accessary_order.order_accessary_date as NGÀY NHẬP','tbl_user.nick_name as NGƯỜI NHẬP','tbl_partner.partner_short_name as NHÀ CUNG CẤP',
                    'tbl_accessary.accessary_name as TÊN PHỤ TÙNG','tbl_accessary_order_detail.amount as SỐ LƯỢNG','tbl_accessary.unit as ĐƠN VỊ TÍNH',
                    'tbl_accessary_order_detail.price as ĐƠN GIÁ','tbl_accessary_order_detail.total_price as THÀNH TIỀN','tbl_accessary_order_detail.note as GHI CHÚ')
        ->whereBetWeen('order_accessary_date',[$start,$end])
        ->where('order_type','=',1)->get()->toArray();

        $excelR =  json_decode(json_encode($excelR), true);
        for ($i=0;$i<count($excelR);$i++){
            $excelR[$i]['NGÀY NHẬP'] = date_create($excelR[$i]['NGÀY NHẬP']);
            $excelR[$i]['NGÀY NHẬP'] = date_format($excelR[$i]['NGÀY NHẬP'],'d-m-Y');
           
        }
        $title = 'Bao-cao-nhap-tu-'.$start.'-den-'.$end;
        if(count($excelR)>0){
            $this->excel($excelR,$title,0);
        }
        else{
            return redirect()->back()->withInput(Input::all())->with('status', 'Không có dữ liệu');
        }

    }

    //Xuất phụ tùng
    public function indexExport(){
        $data = DB::table('tbl_accessary_order')
        ->leftJoin('tbl_user as export','tbl_accessary_order.export_user_id','=','export.user_id')
        ->leftJoin('tbl_car','tbl_accessary_order.car_id','=','tbl_car.car_id')->where('order_type','=',2)
        ->leftJoin('tbl_user as request','tbl_accessary_order.user_id','=','request.user_id')
        ->orderBy('order_accessary_date')->select('tbl_accessary_order.*','export.nick_name as exporter','request.nick_name as requester','tbl_car.car_num')->paginate(20);
        $arrID = $data->pluck('order_accessary_id');
        $details = DB::table('tbl_accessary_order_detail')->whereIn('order_accessary_id', $arrID)
        ->leftJoin('tbl_accessary','tbl_accessary_order_detail.accessary_id','=','tbl_accessary.accessary_id')->select('tbl_accessary_order_detail.*','tbl_accessary.accessary_name')
        ->get();
        // dd($details);
        for($i=0;$i<count($data);$i++){
            $tmpData =[];
            $tmpAccessaryName ="";

            for($j=0; $j<count($details); $j++){
                if($data[$i]->order_accessary_id == $details[$j]->order_accessary_id)
                {
                    $tmpAccessaryName .= $details[$j]->accessary_name . " (".$details[$j]->amount.")" . ", ";
                }
                
               
            }
           $tmpAccessaryName = rtrim($tmpAccessaryName,", ");

           $data[$i]->accessaryNames =   $tmpAccessaryName;
        }
        return view('exportAccessary.index',compact('data'));
    }

    public function searchExport(Request $req){
        $accessaryName = $req->aShortname;
        $eUser = $req->eUser;
        $uUser = $req->uUser;
        $car = $req->carNum;
        $from = $req->ioStart;
        $to = $req->ioEnd;

        if($from){
            $from = date_create($req->ioStart);
            $from = date_format($from,'Y-m-d');
        }
        if($to){
            $to = date_create($req->ioEnd);
            $to = date_format($to,'Y-m-d');
        }
        $data = DB::table('tbl_accessary_order')
            ->leftJoin('tbl_user as export','tbl_accessary_order.export_user_id','=','export.user_id')
            ->leftJoin('tbl_car','tbl_accessary_order.car_id','=','tbl_car.car_id')->where('order_type','=',2)
            ->leftJoin('tbl_user as request','tbl_accessary_order.user_id','=','request.user_id')
            ->orderBy('order_accessary_date')->select('tbl_accessary_order.*','export.nick_name as exporter','request.nick_name as requester','tbl_car.car_num');
        $arrID = $data->pluck('order_accessary_id');
        $details = DB::table('tbl_accessary_order_detail')->whereIn('order_accessary_id', $arrID)
            ->leftJoin('tbl_accessary','tbl_accessary_order_detail.accessary_id','=','tbl_accessary.accessary_id');


        if($accessaryName!=null){
            $acc = DB::table('tbl_accessary')->where('accessary_name','like','%'.$accessaryName.'%')->get();

            $accId = [];
            foreach ($acc as $a){
                array_push($accId,$a->accessary_id);
            }
            $details = $details->whereIn('tbl_accessary_order_detail.accessary_id',$accId);
        }

        if($eUser!=null){
            $eUser = DB::table('tbl_user')->where('nick_name','like','%'.$eUser.'%')->get();

            $eUserId = [];
            foreach($eUser as $eU){
                array_push($eUserId,$eU);
            }
            $data = $data->whereIn('tbl_accessary_order.export_user_id',$eUserId);
        }

        if($uUser!=null){
            $uUser = DB::table('tbl_user')->where('nick_name','like','%'.$uUser.'%')->get();

            $uUserId = [];
            foreach($uUser as $uU){
                array_push($uUserId,$uU);
            }
            $data = $data->whereIn('tbl_accessary_order.user_id',$uUserId);
        }

        if($car!=null){
            $car = DB::table('tbl_car')->where('nick_name','=',$car)->get();

            $carId = [];
            foreach($car as $c){
                array_push($carId,$c);
            }
            $data = $data->whereIn('tbl_accessary_order.car_id',$carId);
        }

        if($from!=null && $to==null){
            $data = $data->where('order_accessary_date','=>',$from);
        }
        if($from==null && $to!=null){
            $data = $data->where('order_accessary_date','=>',$to);
        }
        if($from!=null && $to!=null){
            $data = $data->where('order_accessary_date','=>',$from)->where('order_accessary_date','<=',$to);
        }

        $data = $data->paginate(20);
        $details = $details->get();
        for($i=0;$i<count($data);$i++){
            $tmpData =[];
            $tmpAccessaryName ="";

            for($j=0; $j<count($details); $j++){
                if($data[$i]->order_accessary_id == $details[$j]->order_accessary_id)
                {
                    $tmpAccessaryName .= $details[$j]->accessary_name . ", ";
                }
                
               
            }
           $tmpAccessaryName = rtrim($tmpAccessaryName,", ");

           $data[$i]->accessaryNames =   $tmpAccessaryName;
        }
        return view('exportAccessary.index',compact('data'));
    }

    public function getCreateExport(){
        $user = DB::table('tbl_user')->get();
        $car = DB::table('tbl_car')->get();
        $accessary = DB::table('tbl_accessary')->get();
        return view('exportAccessary.create',compact('user','car','accessary'));
    }

    public function postCreateExport(Request $request){
        DB::beginTransaction();
        try{
            $rule = [
                'importDate' => 'required',
            ];
    
            $messages = [
                'importDate.required' => 'Vui lòng chọn ngày nhập',
            ];

            if($request->row === null){
                $rule['row']='required';
                $messages['row.required']='Đơn nhập hàng không được trống';
            }
    
            $validator = Validator::make($request->all(),$rule,$messages);
            if($validator->passes()){
                $row = $request->row;
                $tbl = DB::table('tbl_accessary_order')->insertGetId([
                    'order_accessary_date' => $request->importDate,
                    'export_user_id' => $request->export_user,
                    'user_id' => $request->request_user,
                    'car_id' => $request->car_num,
                    'note' => $request->noteOrder,
                    'order_type' => 2,
                ]);

                $data = [];
                $arr = [];

                for($i=1;$i<=$row;$i++){
                    $name = "data".$i;
                    $dt = explode(',',$request->$name);
                    $arr['order_accessary_id'] = $tbl;
                    $arr['amount'] = $dt[2];
                    $arr['note'] = $dt[4];
                    $arr['accessary_id'] = $dt[6];
                    array_push($data,$arr);
                }
                
                for($i=0;$i<count($data);$i++){
                    $check = DB::table('tbl_accessary')->where('accessary_id','=',$data[$i]['accessary_id'])->first();

                    $amount = $check->amount;
                    if($amount >= $data[$i]['amount']){
                        DB::table('tbl_accessary_order_detail')->insert($data[$i]);
                        $updateAmount = $amount - $data[$i]['amount'];
                        DB::table('tbl_accessary')->where('accessary_id','=',$data[$i]['accessary_id'])->update(['amount'=>$updateAmount]);
                    }
                    else{
                        $data = ['outStock'=>'Số lượng còn lại trong kho đã hết hoặc không đủ'];
                        return response()->json(['error'=>$data]);
                    }
                }

                DB::commit();
                return response()->json(['success'=>'success']);
            }
            return response()->json(['error'=>$validator->errors()]);
        }
        catch(\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$e]);
        }
    }

    public function getEditExport(Request $request){
        $oA = DB::table('tbl_accessary_order')->where('order_accessary_id','=',$request->id)->first();
        $car = DB::table('tbl_car')->get();
        $user = DB::table('tbl_user')->get();
        $data = DB::table('tbl_accessary_order_detail')
            ->leftJoin('tbl_accessary','tbl_accessary_order_detail.accessary_id','=','tbl_accessary.accessary_id')
            ->where('order_accessary_id','=',$request->id)
            ->select('tbl_accessary_order_detail.*','tbl_accessary.accessary_name as name','tbl_accessary.unit')->get();
        $accessary = DB::table('tbl_accessary')->get();
        return view('exportAccessary.edit',compact('oA','car','user','data','accessary'));
    }

    public function postEditExport(Request $request){
        DB::beginTransaction();
        try{
            $rule = [
                'importDate' => 'required',
            ];
    
            $messages = [
                'importDate.required' => 'Vui lòng chọn ngày nhập',
            ];

            if($request->row === null){
                $rule['row']='required';
                $messages['row.required']='Đơn nhập hàng không được trống';
            }
    
            $validator = Validator::make($request->all(),$rule,$messages);
            if($validator->passes()){
                $row = $request->row;
                $tbl = DB::table('tbl_accessary_order')->where('order_accessary_id','=',$request->orderId)->update([
                    'order_accessary_date' => $request->importDate,
                    'export_user_id' => $request->export_user,
                    'user_id' => $request->request_user,
                    'car_id' => $request->car_num,
                    'note' => $request->noteOrder,
                ]);
                $data = [];
                $arr = [];

                for($i=1;$i<=$row;$i++){
                    $name = "data".$i;
                    $dt = explode(',',$request->$name);
                    $arr['order_accessary_id'] = $request->orderId;
                    $arr['amount'] = $dt[2];
                    $arr['note'] = $dt[4];
                    $arr['accessary_id'] = $dt[7];
                    if($dt[6]!="nodata"){
                        $arr['accessary_order_detail_id'] = $dt[6];
                    }
                    else{
                        $arr['accessary_order_detail_id'] = "";
                    }
                    array_push($data,$arr);
                }
                $deleteId = [];
                for($i=0;$i<$row;$i++){
                    $id = $data[$i]['accessary_order_detail_id'];
                    if($id!=""){
                        array_push($deleteId,$id);
                    }
                }

                $subAmount = DB::table('tbl_accessary_order_detail')->where('order_accessary_id','=',$request->orderId)->whereNotIn('accessary_order_detail_id',$deleteId)->get();

                for($i=0;$i<count($subAmount);$i++){
                    $accId = $subAmount[$i]->accessary_id;
                    
                    $amount = DB::table('tbl_accessary')->where('accessary_id','=',$accId)->first();
                    
                    $updateAm = $amount->amount + $subAmount[$i]->amount;
                    DB::table('tbl_accessary')->where('accessary_id','=',$accId)->update(['amount'=>$updateAm]);
                    
                }
                DB::table('tbl_accessary_order_detail')->where('order_accessary_id','=',$request->orderId)->whereNotIn('accessary_order_detail_id',$deleteId)->delete();

                for($i=0;$i<$row;$i++){

                    $check = DB::table('tbl_accessary')->where('accessary_id','=',$data[$i]['accessary_id'])->first();

                    $amount = $check->amount;

                    if($data[$i]['accessary_order_detail_id']!=""){
                        DB::table('tbl_accessary_order_detail')->where('accessary_order_detail_id','=',$data[$i]['accessary_order_detail_id'])->update($data[$i]);
                        $am = DB::table('tbl_accessary_order_detail')->where('accessary_order_detail_id','=',$data[$i]['accessary_order_detail_id'])->first();
                        $aM = $am->amount;
                        $updateAmount = $aM;

                        if($aM!=$data[$i]['amount']){
                            $updateAmount = $amount - $data[$i]['amount'];
                            DB::table('tbl_accessary')->where('accessary_id','=',$data[$i]['accessary_id'])->update(['amount'=>$updateAmount]);
                        }
                    }
                    else{
                        if($amount >= $data[$i]['amount'] ){

                            DB::table('tbl_accessary_order_detail')->insert($data[$i]);

                            $accId = $data[$i]['accessary_id'];

                            $amount = DB::table('tbl_accessary')->where('accessary_id','=',$accId)->first();

                            $updateAm = $amount->amount - $data[$i]['amount'];

                            DB::table('tbl_accessary')->where('accessary_id','=',$accId)->update(['amount'=>$updateAm]);
                        }
                        else{
                            
                            $data = ['outStock'=>'Số lượng còn lại trong kho đã hết hoặc không đủ'];
                            return response()->json(['error'=>$data]);
                        }
                    }                       
                        
                    
                }


                DB::commit();
                return response()->json(['success'=>'success']);
            }
            return response()->json(['error'=>$validator->errors()]);
        }
        catch(\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$e]);
        }
    }

    public function deleteExport(Request $req){
        DB::beginTransaction();
        try{
            $delete = DB::table('tbl_accessary_order_detail')->where('order_accessary_id','=',$req->id)->get()->toArray();
            for($i=0;$i<count($delete);$i++){
                $accessary = DB::table('tbl_accessary')->where('accessary_id','=',$delete[$i]->accessary_id)->first();
                $amount = $accessary->amount;
                
                $tAmount = $amount + $delete[$i]->amount;

                DB::table('tbl_accessary')->where('accessary_id','=',$delete[$i]->accessary_id)->update(['amount'=>$tAmount]);
                DB::table('tbl_accessary_order_detail')->where('order_accessary_id','=',$req->id)->delete();
                DB::table('tbl_accessary_order')->where('order_accessary_id','=',$req->id)->delete();

            }

            DB::commit();
            return response()->json(['success'=>'success']);
        }
        catch(\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$e]);
            //return $e;
            // print_r($e);
        }
    }

    public function reportExport(Request $request){
        $start = $request->start;
        $end = $request->end;

        $excelR = DB::table('tbl_accessary_order')
        ->leftJoin('tbl_accessary_order_detail','tbl_accessary_order.order_accessary_id','=','tbl_accessary_order_detail.order_accessary_id')
        ->leftJoin('tbl_accessary','tbl_accessary_order_detail.accessary_id','=','tbl_accessary.accessary_id')
        ->leftJoin('tbl_user as exporter','tbl_accessary_order.export_user_id','=','exporter.user_id')
        ->leftJoin('tbl_car','tbl_accessary_order.car_id','=','tbl_car.car_id')
        ->leftJoin('tbl_user as user','tbl_accessary_order.user_id','=','user.user_id')
        ->select('tbl_accessary_order.order_accessary_date as NGÀY XUẤT','tbl_car.car_num as SỐ XE','tbl_accessary.accessary_name as TÊN PHỤ TÙNG',
                    'tbl_accessary_order_detail.amount as SỐ LƯỢNG','tbl_accessary.unit as ĐƠN VỊ TÍNH','exporter.nick_name as NGƯỜI XUẤT','user.nick_name as NGƯỜI NHẬN',
                    'tbl_accessary_order_detail.note as GHI CHÚ')
        ->whereBetWeen('order_accessary_date',[$start,$end])
        ->where('order_type','=',2)->get()->toArray();
        
        $excelR =  json_decode(json_encode($excelR), true);
        for ($i=0;$i<count($excelR);$i++){
            $excelR[$i]['NGÀY XUẤT'] = date_create($excelR[$i]['NGÀY XUẤT']);
            $excelR[$i]['NGÀY XUẤT'] = date_format($excelR[$i]['NGÀY XUẤT'],'d-m-Y');
           
        }
        
        $title = 'Bao-cao-xuat-tu-'.$start.'-den-'.$end;
        if(count($excelR)>0){
            $this->excel($excelR,$title,0);
        }
        else{
            return redirect()->back()->withInput(Input::all())->with('status', 'Không có dữ liệu');
        }
    }

    //Báo cáo tồn

    public function indexReport(){

        $dateL = "<= LAST_DAY(CURDATE() - INTERVAL 1 MONTH)";
        $dateC = "BETWEEN DATE_FORMAT(NOW() ,'%Y-%m-01') AND CURDATE()";
        

        $join = "'stt' AS 'SỐ THỨ TỰ', `tbl_accessary`.`accessary_name` AS 'TÊN PHỤ TÙNG', `tbl_accessary`.`unit` AS 'ĐƠN VỊ TÍNH', `tbl_accessary`.`position` AS 'VỊ TRÍ',
        'tondauky' AS 'TỒN ĐẦU KÌ', 'tongnhap' AS 'TỔNG NHẬP', 'tongxuat' AS 'TỔNG XUẤT', 'toncuoiki' AS 'TỒN CUỐI KÌ', `tbl_accessary`.`remain_alert` AS 'TỒN DƯỚI',
        'khongnhap' AS 'KHÔNG NHẬP', `tbl_accessary`.`note` AS 'GHI CHÚ'";
        
        $join2 = "LEFT JOIN `tbl_accessary` ON `tbl_accessary`.`accessary_id` = `tbl_accessary_order_detail`.`accessary_id`";

        $importRemainL = DB::SELECT("
            SELECT `tbl_accessary_order_detail`.`accessary_id`, SUM(`tbl_accessary_order_detail`.`amount`) AS total_import_last FROM `tbl_accessary_order` 
            LEFT JOIN `tbl_accessary_order_detail` ON `tbl_accessary_order`.`order_accessary_id` = `tbl_accessary_order_detail`.`order_accessary_id`
            WHERE `tbl_accessary_order`.`order_type` = '1'
            AND `tbl_accessary_order`.`order_accessary_date` ".$dateL."
            GROUP BY `tbl_accessary_order_detail`.`accessary_id`
        ");

        $exportRemainL = DB::SELECT("
            SELECT `tbl_accessary_order_detail`.`accessary_id`, SUM(`tbl_accessary_order_detail`.`amount`) AS total_export_last FROM `tbl_accessary_order` 
            LEFT JOIN `tbl_accessary_order_detail` ON `tbl_accessary_order`.`order_accessary_id` = `tbl_accessary_order_detail`.`order_accessary_id`
            WHERE `tbl_accessary_order`.`order_type` = '2'
            AND `tbl_accessary_order`.`order_accessary_date` ".$dateL."
            GROUP BY `tbl_accessary_order_detail`.`accessary_id`
        ");

        $importRemainL =  json_decode(json_encode($importRemainL), true);
        $exportRemainL =  json_decode(json_encode($exportRemainL), true);
        
        $tonDauKiThangHienTai = [];
        for($i= 0; $i < count( $importRemainL); $i++){
            $checkInExportRemainL = $this->arraySearch('accessary_id',$importRemainL[$i]['accessary_id'], $exportRemainL);
            if($checkInExportRemainL != null){
                $tmpAmount = $importRemainL[$i]['total_import_last'] -  $checkInExportRemainL['total_export_last'];
            }else{
                $tmpAmount = $importRemainL[$i]['total_import_last'] ;
            }
            $tmpTonDau = [];
            $tmpTonDau['accessary_id'] =  $importRemainL[$i]['accessary_id'];
            $tmpTonDau['amount']= $tmpAmount;
            array_push($tonDauKiThangHienTai, $tmpTonDau);
        }
        $importRemainC = DB::SELECT("
            SELECT `tbl_accessary_order_detail`.`accessary_id`, SUM(`tbl_accessary_order_detail`.`amount`) AS total_import_current FROM `tbl_accessary_order` 
            LEFT JOIN `tbl_accessary_order_detail` ON `tbl_accessary_order`.`order_accessary_id` = `tbl_accessary_order_detail`.`order_accessary_id`
            WHERE `tbl_accessary_order`.`order_type` = '1'
            AND `tbl_accessary_order`.`order_accessary_date` ".$dateC."
            GROUP BY `tbl_accessary_order_detail`.`accessary_id`
        ");
        $exportRemainC = DB::SELECT("
            SELECT `tbl_accessary_order_detail`.`accessary_id`, SUM(`tbl_accessary_order_detail`.`amount`) AS total_export_current FROM `tbl_accessary_order` 
            LEFT JOIN `tbl_accessary_order_detail` ON `tbl_accessary_order`.`order_accessary_id` = `tbl_accessary_order_detail`.`order_accessary_id`
            WHERE `tbl_accessary_order`.`order_type` = '2'
            AND `tbl_accessary_order`.`order_accessary_date` ".$dateC."
            GROUP BY `tbl_accessary_order_detail`.`accessary_id`
        ");
        $accessary = DB::SELECT("
            SELECT `tbl_accessary`.`accessary_name`, `tbl_accessary`.`unit`,`tbl_accessary`.`accessary_id`, `tbl_accessary`.`position`,
                    'tondauky' AS 'tondauky', 'tongnhap' AS 'tongnhap', 'tongxuat' AS 'tongxuat', 'toncuoiki' AS 'toncuoiki', `tbl_accessary`.`remain_alert`,
                    `tbl_accessary`.`need_import`, `tbl_accessary`.`note`
            FROM `tbl_accessary` ORDER BY `tbl_accessary`.`accessary_name`
        ");
        // $accessary1 = DB::table('tbl_accessary')
        // ->select('accessary_name','unit','accessary_id','position',DB::raw("'tondauky' AS tondauky"),DB::raw("'tongnhap' AS tongnhap")
        //         ,DB::raw("'tongxuat' AS tongxuat"),DB::raw("'toncuoiki' AS toncuoiki"),'remain_alert','need_import','note')->paginate(20);
        //         $accessary1 =  json_decode(json_encode($accessary1), true);
        //         dd($accessary1);
        $accessary =  json_decode(json_encode($accessary), true);
        $importRemainC =  json_decode(json_encode($importRemainC), true);
        $exportRemainC =  json_decode(json_encode($exportRemainC), true);

        $arrID = [];
        //$arrID2 = [];
        if(!empty($importRemainC) && count($importRemainC) >0){
            for($m =0; $m <count($importRemainC); $m++)
                array_push($arrID, $importRemainC[$m]['accessary_id']);
        }
        if(!empty($exportRemainC)  && count($exportRemainC) >0){
            for($n =0; $n <count($exportRemainC); $n++){
                if(!in_array($exportRemainC[$n]['accessary_id'], $arrID))
                array_push($arrID, $exportRemainC[$n]['accessary_id']);
            }
                //$arrID2[$exportRemainC[$m]['accessary_id']] ='xxx';
        }
        //============
        //Tồn cuối = Tồn đầu + tổng nhập tháng hiện tại - tổng xuất tháng hiện tại
        $tonCuoiKiHienTai = [];
        for($i= 0; $i < count($arrID); $i++){
            $checkTonDau = $this->arraySearch('accessary_id',$arrID[$i], $tonDauKiThangHienTai); // recoerd / null
            $checkNhap =   $this->arraySearch('accessary_id',$arrID[$i], $importRemainC); // recoerd / null
            $checkXuat =   $this->arraySearch('accessary_id',$arrID[$i], $exportRemainC); // recoerd / null
           
            $tmpAmoutDau = 0;
            if( $checkTonDau != null)
            {$tmpAmoutDau   = $checkTonDau['amount'];}
        
            $tmpAmountNhap = 0;
            $tmpAmountxuat= 0;
            if($checkNhap !=null)
               $tmpAmountNhap = $checkNhap['total_import_current'];
            if($checkXuat !=null)
               $tmpAmountXuat = $checkXuat['total_export_current'];
            $amount =   $tmpAmoutDau  +$tmpAmountNhap -$tmpAmountXuat;
            $tmpArr = [];
            $tmpArr['accessary_id'] = $arrID[$i];
            $tmpArr['soluong'] = $amount;

            array_push($tonCuoiKiHienTai, $tmpArr);
               
        }
        for ($i=0;$i<count($accessary);$i++){

            $checkTonDau = $this->arraySearch('accessary_id', $accessary[$i]['accessary_id'], $tonDauKiThangHienTai); // recoerd / null
            $checkNhap = $this->arraySearch('accessary_id', $accessary[$i]['accessary_id'], $importRemainC); // recoerd / null
            $checkXuat = $this->arraySearch('accessary_id', $accessary[$i]['accessary_id'], $exportRemainC); // recoerd / null
            $checkTonCuoi = $this->arraySearch('accessary_id', $accessary[$i]['accessary_id'], $tonCuoiKiHienTai);
            
            $accessary[$i]['tondauky'] = 0;
            $accessary[$i]['tongnhap'] = 0;
            $accessary[$i]['tongxuat'] = 0;
            $accessary[$i]['toncuoiki'] = 0;

            if($checkTonDau != null){
                $accessary[$i]['tondauky'] = $tonDauKiThangHienTai[$i]['amount'];
            }
            if($checkNhap != null){
                $accessary[$i]['tongnhap'] = (int)$importRemainC[$i]['total_import_current'];
            }
            if($checkXuat != null){
                $accessary[$i]['tongxuat'] = (int)$exportRemainC[$i]['total_export_current'];
            }
            if($checkTonCuoi != null){
                $accessary[$i]['toncuoiki'] = $tonCuoiKiHienTai[$i]['soluong'];
            }

        }
        
        return view('Accessary.remainReport',compact('accessary'));
    }

    public function remainReport(Request $request){

        $start = $request->start;
        $end = $request->end;
        
//      BETWEEN '".$start."' AND '".$end."

        if ($start!=null && $end!=null){
            $dateL = "<= LAST_DAY('".$start."' - INTERVAL 1 MONTH)";
            $dateC = "BETWEEN '".$start."' AND '".$end."'";
        }
        if ($start!=null && $end==null){
            $dateL = "<= LAST_DAY('".$start."' - INTERVAL 1 MONTH)";
            $dateC = "BETWEEN '".$start."' AND CURDATE()";
        }

        $join = "'stt' AS 'SỐ THỨ TỰ', `tbl_accessary`.`accessary_name` AS 'TÊN PHỤ TÙNG', `tbl_accessary`.`unit` AS 'ĐƠN VỊ TÍNH', `tbl_accessary`.`position` AS 'VỊ TRÍ',
        'tondauky' AS 'TỒN ĐẦU KÌ', 'tongnhap' AS 'TỔNG NHẬP', 'tongxuat' AS 'TỔNG XUẤT', 'toncuoiki' AS 'TỒN CUỐI KÌ', `tbl_accessary`.`remain_alert` AS 'TỒN DƯỚI',
        'khongnhap' AS 'KHÔNG NHẬP', `tbl_accessary`.`note` AS 'GHI CHÚ'";
        
        $join2 = "LEFT JOIN `tbl_accessary` ON `tbl_accessary`.`accessary_id` = `tbl_accessary_order_detail`.`accessary_id`";

        $importRemainL = DB::SELECT("
            SELECT `tbl_accessary_order_detail`.`accessary_id`, SUM(`tbl_accessary_order_detail`.`amount`) AS total_import_last FROM `tbl_accessary_order` 
            LEFT JOIN `tbl_accessary_order_detail` ON `tbl_accessary_order`.`order_accessary_id` = `tbl_accessary_order_detail`.`order_accessary_id`
            WHERE `tbl_accessary_order`.`order_type` = '1'
            AND `tbl_accessary_order`.`order_accessary_date` ".$dateL."
            GROUP BY `tbl_accessary_order_detail`.`accessary_id`
        ");

        $exportRemainL = DB::SELECT("
            SELECT `tbl_accessary_order_detail`.`accessary_id`, SUM(`tbl_accessary_order_detail`.`amount`) AS total_export_last FROM `tbl_accessary_order` 
            LEFT JOIN `tbl_accessary_order_detail` ON `tbl_accessary_order`.`order_accessary_id` = `tbl_accessary_order_detail`.`order_accessary_id`
            WHERE `tbl_accessary_order`.`order_type` = '2'
            AND `tbl_accessary_order`.`order_accessary_date` ".$dateL."
            GROUP BY `tbl_accessary_order_detail`.`accessary_id`
        ");

        $importRemainL =  json_decode(json_encode($importRemainL), true);
        $exportRemainL =  json_decode(json_encode($exportRemainL), true);
        
        $tonDauKiThangHienTai = [];
        for($i= 0; $i < count( $importRemainL); $i++){
            $checkInExportRemainL = $this->arraySearch('accessary_id',$importRemainL[$i]['accessary_id'], $exportRemainL);
            if($checkInExportRemainL != null){
                $tmpAmount = $importRemainL[$i]['total_import_last'] -  $checkInExportRemainL['total_export_last'];
            }else{
                $tmpAmount = $importRemainL[$i]['total_import_last'] ;
            }
            $tmpTonDau = [];
            $tmpTonDau['accessary_id'] =  $importRemainL[$i]['accessary_id'];
            $tmpTonDau['amount']= $tmpAmount;
            array_push($tonDauKiThangHienTai, $tmpTonDau);
        }
        $importRemainC = DB::SELECT("
            SELECT `tbl_accessary_order_detail`.`accessary_id`, SUM(`tbl_accessary_order_detail`.`amount`) AS total_import_current FROM `tbl_accessary_order` 
            LEFT JOIN `tbl_accessary_order_detail` ON `tbl_accessary_order`.`order_accessary_id` = `tbl_accessary_order_detail`.`order_accessary_id`
            WHERE `tbl_accessary_order`.`order_type` = '1'
            AND `tbl_accessary_order`.`order_accessary_date` ".$dateC."
            GROUP BY `tbl_accessary_order_detail`.`accessary_id`
        ");
        $exportRemainC = DB::SELECT("
            SELECT `tbl_accessary_order_detail`.`accessary_id`, SUM(`tbl_accessary_order_detail`.`amount`) AS total_export_current FROM `tbl_accessary_order` 
            LEFT JOIN `tbl_accessary_order_detail` ON `tbl_accessary_order`.`order_accessary_id` = `tbl_accessary_order_detail`.`order_accessary_id`
            WHERE `tbl_accessary_order`.`order_type` = '2'
            AND `tbl_accessary_order`.`order_accessary_date` ".$dateC."
            GROUP BY `tbl_accessary_order_detail`.`accessary_id`
        ");
        $accessary = DB::SELECT("
            SELECT 'stt' AS 'SỐ THỨ TỰ', `tbl_accessary`.`accessary_name` AS 'TÊN PHỤ TÙNG', `tbl_accessary`.`accessary_id`,`tbl_accessary`.`unit` AS 'ĐƠN VỊ TÍNH', `tbl_accessary`.`position` AS 'VỊ TRÍ',
                    'tondauky' AS 'TỒN ĐẦU KÌ', 'tongnhap' AS 'TỔNG NHẬP', 'tongxuat' AS 'TỔNG XUẤT', 'toncuoiki' AS 'TỒN CUỐI KÌ', `tbl_accessary`.`remain_alert` AS 'TỒN DƯỚI',
                    'khongnhap' AS 'KHÔNG NHẬP', `tbl_accessary`.`note` AS 'GHI CHÚ'
            FROM `tbl_accessary` ORDER BY `tbl_accessary`.`accessary_name`
        ");
        $accessary =  json_decode(json_encode($accessary), true);
        $importRemainC =  json_decode(json_encode($importRemainC), true);
        $exportRemainC =  json_decode(json_encode($exportRemainC), true);
        //dd($importRemainC);
        $arrID = [];
        //$arrID2 = [];
        if(!empty($importRemainC) && count($importRemainC) >0){
            for($m =0; $m <count($importRemainC); $m++)
                array_push($arrID, $importRemainC[$m]['accessary_id']);
        }
        if(!empty($exportRemainC)  && count($exportRemainC) >0){
            for($n =0; $n <count($exportRemainC); $n++){
                if(!in_array($exportRemainC[$n]['accessary_id'], $arrID))
                array_push($arrID, $exportRemainC[$n]['accessary_id']);
            }
                //$arrID2[$exportRemainC[$m]['accessary_id']] ='xxx';
        }
        //============
        //Tồn cuối = Tồn đầu + tổng nhập tháng hiện tại - tổng xuất tháng hiện tại
        $tonCuoiKiHienTai = [];
        for($i= 0; $i < count($arrID); $i++){
            $checkTonDau = $this->arraySearch('accessary_id',$arrID[$i], $tonDauKiThangHienTai); // recoerd / null
            $checkNhap =   $this->arraySearch('accessary_id',$arrID[$i], $importRemainC); // recoerd / null
            $checkXuat =   $this->arraySearch('accessary_id',$arrID[$i], $exportRemainC); // recoerd / null
           
            $tmpAmoutDau = 0;
            if( $checkTonDau != null)
            {$tmpAmoutDau   = $checkTonDau['amount'];}
        
            $tmpAmountNhap = 0;
            $tmpAmountxuat= 0;
            if($checkNhap !=null)
               $tmpAmountNhap = $checkNhap['total_import_current'];
            if($checkXuat !=null)
               $tmpAmountXuat = $checkXuat['total_export_current'];
            $amount =   $tmpAmoutDau  +$tmpAmountNhap -$tmpAmountXuat;
            $tmpArr = [];
            $tmpArr['accessary_id'] = $arrID[$i];
            $tmpArr['soluong'] = $amount;

            array_push($tonCuoiKiHienTai, $tmpArr);
               
        }
        for ($i=0;$i<count($accessary);$i++){
            if($accessary[$i]['KHÔNG NHẬP']==1){
                $accessary[$i]['KHÔNG NHẬP'] = 'KHÔNG NHẬP';
            }
            else{
                $accessary[$i]['KHÔNG NHẬP'] = '';
            }
            $accessary[$i]['SỐ THỨ TỰ']=$i+1;

            $checkTonDau = $this->arraySearch('accessary_id', $accessary[$i]['accessary_id'], $tonDauKiThangHienTai); // recoerd / null
            $checkNhap = $this->arraySearch('accessary_id', $accessary[$i]['accessary_id'], $importRemainC); // recoerd / null
            $checkXuat = $this->arraySearch('accessary_id', $accessary[$i]['accessary_id'], $exportRemainC); // recoerd / null
            $checkTonCuoi = $this->arraySearch('accessary_id', $accessary[$i]['accessary_id'], $tonCuoiKiHienTai);
            //dd($checkTonCuoi);
            $accessary[$i]['TỒN ĐẦU KÌ'] = 0;
            $accessary[$i]['TỔNG NHẬP'] = 0;
            $accessary[$i]['TỔNG XUẤT'] = 0;
            $accessary[$i]['TỒN CUỐI KÌ'] = 0;

            if($checkTonDau != null){
                $accessary[$i]['TỒN ĐẦU KÌ'] = $tonDauKiThangHienTai[$i]['amount'];
            }
            if($checkNhap != null){
                $accessary[$i]['TỔNG NHẬP'] = (int)$importRemainC[$i]['total_import_current'];
            }
            if($checkXuat != null){
                $accessary[$i]['TỔNG XUẤT'] = (int)$exportRemainC[$i]['total_export_current'];
            }
            if($checkTonCuoi != null){
                $accessary[$i]['TỒN CUỐI KÌ'] = $tonCuoiKiHienTai[$i]['soluong'];
            }

        }
        
        $title = 'Bao-cao-phu-tung-tu-'.$start.'-den-'.$end;
        $this->excel($accessary,$title,1);
    }

    //Excel
    public function excel($data,$title,$header){
        
        Excel::create($title, function($excel) use ($data, $header) {

            $excel->sheet('Sheetname', function($sheet) use ($data, $header) {
                $arr = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P",
                    "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
                $sheet->setFontFamily('Arial');
                if($header==0){                    
                    $sheet->fromArray($data);
    
                    $r = count($data)+1;
                    $e = count($data[0])-1;
    
                    $c = 'A1:'.$arr[$e].$r;
                    $sheet->setBorder($c, 'thin');
                }
                
                if($header==1){
                    $datasheet = array();
                    $datasheet[0] = array('Công ty TNHH MTV VT QUỐC HUY');
                    $datasheet[1] = array('135A Lũy Bán Bích, Tân Thới Hòa, Tân Phú');
                    $datasheet[2] = array('BẢNG XUẤT NHẬP TỒN PHỤ TÙNG XE');
                    $datasheet[3] = array();
                    $datasheet[4] = array('STT', 'TÊN PHỤ TÙNG', 'ĐƠN VỊ TÍNH', 'VỊ TRÍ', 'TỒN ĐẦU KÌ', 
                                            'TỔNG NHẬP', 'TỔNG XUẤT', 'TỒN CUỐI KÌ', 'TỒN DƯỚI', 'KHÔNG NHẬP', 'GHI CHÚ');
                    $i=5;
                    foreach($data as $dt){
                        $datasheet[$i]=array($dt['SỐ THỨ TỰ'], $dt['TÊN PHỤ TÙNG'], $dt['ĐƠN VỊ TÍNH'], $dt['VỊ TRÍ'], $dt['TỒN ĐẦU KÌ'], 
                        $dt['TỔNG NHẬP'], $dt['TỔNG XUẤT'], $dt['TỒN CUỐI KÌ'], $dt['TỒN DƯỚI'], $dt['KHÔNG NHẬP'], $dt['GHI CHÚ']);
                        $i++;
                    }
                    $sheet->fromArray($datasheet);

                    $r = count($data)+6;
                    $b = count($data[0])-2;
                    $border = 'A6:'.$arr[$b].$r;
                    $sheet->setBorder($border,'thin');
                    $sheet->mergeCells('A2:K2');
                    $sheet->mergeCells('A3:K3');
                    $sheet->mergeCells('A4:K4');
                    $sheet->getStyle('A4')->getAlignment()->applyFromArray(
                        array('horizontal' => 'center')
                    );
                    $sheet->cell('A4:K4',function($cell) {                    
                        $cell->setFontWeight('bold');
                    });
                }
            });
        
        })->export('xlsx');
        
    }

    public function arraySearch($colName,$value,$arraySource){
        if(count($arraySource) >0){
            for($i =0; $i<count($arraySource); $i++){
                if($arraySource[$i][$colName] == $value)
                    {return $arraySource[$i];}
                //else{return null;}
            }
        }
        return null;
    }

    
}
