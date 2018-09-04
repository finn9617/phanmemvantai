<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class accessaryController extends Controller
{
    //
    public function index(){
        $accessary = DB::table('tbl_accessary')->orderBy('accessary_name')->get();
        return view('Accessary.index',compact('accessary'));
    }
    
    public function search(Request $request){
        $shortname = $request->shortname;
        $fullname = $request->fullname;
        if ($request->fullname!=null && $request->shortname!=null){
            $accessary = DB::table('tbl_accessary')->where('accessary_name','like','%'.$shortname.'%')->orderBy('accessary_name','ASC')->get();
        }
        if ($request->fullname!=null && $request->shortname==null){
            $accessary = DB::table('tbl_accessary')->where('accessary_name','like','%'.$fullname.'%')->orderBy('accessary_name','ASC')->get();
        }
        if ($request->fullname==null && $request->shortname!=null){
            $accessary = DB::table('tbl_accessary')->where('alternative_name','like','%'.$shortname.'%')->orderBy('accessary_name','ASC')->get();
        }
        if($request->fullname==null && $request->shortname==null){
            $accessary = DB::table('tbl_accessary')->orderBy('accessary_name')->get();
        }
        return view('Accessary.index',compact('accessary'));
    }

    public function searchOutStock(){
        $accessary = DB::select("SELECT * FROM tbl_accessary WHERE amount <= remain_alert AND need_import = 0");
        return view('Accessary.index',compact('accessary'));
    }

    public function getEdit(Request $request){
        $data = DB::table('tbl_accessary')->where('accessary_id',$request->id)->first();
        return view('Accessary.edit',compact('data'));
    }

    public function create(Request $request){
        DB::beginTransaction();
        try{
            $rule = [
                'fullname' => 'required|unique:tbl_accessary,accessary_name',
            ];
            $messages = [
                'fullname.required' => 'Vui lòng nhập tên phụ tùng',
                'fullname.unique' => 'Tên phụ tùng đã tồn tại',
            ];
            
            $validator = Validator::make($request->all(),$rule,$messages);

            if($validator->passes()){
                $accessary = DB::table('tbl_accessary')->insert([
                    'accessary_name' => $request->fullname,
                    'alternative_name' => $request->shortname,
                    'unit' => $request->unit,
                    'note' => $request->note,
                    'position' => $request->position,
                    'need_import' => $request->unimport,
                    'remain_alert' => $request->remain,
                    'last_price' =>$request->price
                ]);
                DB::commit();
                return response()->json(['success'=>'success']);
            }
            return response()->json(['error'=>$validator->errors()]);
        }catch(\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$validator->errors()]);
            //return $e;
             // print_r($e);
        }
    }

    public function postEdit(Request $request){
        DB::beginTransaction();
        try{
            $rule = [
                'fullname' => 'required|unique:tbl_accessary,accessary_name,'.$request->id.',accessary_id',
            ];
            $messages = [
                'fullname.required' => 'Vui lòng nhập tên phụ tùng',
                'fullname.unique' => 'Tên phụ tùng đã tồn tại',
            ];
            
            $validator = Validator::make($request->all(),$rule,$messages);
            if($validator->passes()){
                $accessary = DB::table('tbl_accessary')->where('accessary_id',$request->id)->update([
                    'accessary_name' => $request->fullname,
                    'alternative_name' => $request->shortname,
                    'unit' => $request->unit,
                    'note' => $request->note,
                    'position' => $request->position,
                    'need_import' => $request->unimport,
                    'remain_alert' => $request->remain,
                    'last_price' => $request->price
                ]);
                DB::commit();
                return response()->json(['success'=>'success']);
            }
            return response()->json(['error'=>$validator->errors()]);
        }catch(\Exception $e) {
            DB::rollback();
            return response()->json(['error'=>$validator->errors()]);
            //return $e;
             // print_r($e);
        }
        
        
    }

    public function delete(Request $request){
        $delete = DB::table('tbl_accessary')->where('accessary_id',$request->id)->delete();
        return response()->json(['success'=>'success']);
    }
}
