<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Redirect;
use Response;
use Illuminate\Support\Facades\Input;

class carController extends Controller
{
    public function itemDetail($id)
    {
        $car = DB::table('tbl_car')
        ->join('tbl_car_type', 'tbl_car.car_type_id', '=', 'tbl_car_type.car_type_id')
        ->select('tbl_car.*', 'tbl_car_type.name')
        ->where('car_id', '=', $id)->orderBy('name','ASC')->orderBy('car_num','ASC')
        ->first();

        return view('xe.detail', compact('car', 'id'));
    }

    public function createItem()
    {
        return view('xe.create');
    }

    public function getcar()
    {
        $car = DB::table('tbl_car')
        ->join('tbl_car_type', 'tbl_car.car_type_id', '=', 'tbl_car_type.car_type_id')
        ->select('tbl_car.*', 'tbl_car_type.name','tbl_car_type.car_type_id')
        ->orderBy('name','ASC')->orderBy('car_num','ASC')->get();

        return view('xe.index', compact('car'));
    }

    public function postcreateItem(Request $req)
    {
        $validator = validator::make($req->all(), [
            'txtSoxe' => 'required|unique:tbl_car,car_num',
            'selLoaixe' => 'required',
        ], [
            'txtSoxe.required' => 'Số xe không được bỏ trống',
            'txtSoxe.unique' => 'Số xe không được trùng',
            'selLoaixe.required' => 'Loại xe không được bỏ trống'
        ]);
        if ($validator->passes()) {
            $insData = DB::table('tbl_car')->insert([
                'car_type_id' => $req->selLoaixe,
                'car_num' => $req->txtSoxe,
                'driver_suggestion' => $req->taixe,
                'assistant_driver_suggestion' => $req->slphuxe,
                'note' => $req->txtGhichu,
            ]);

            return redirect('/xe');
        }

        return Redirect::back()->withInput()->withErrors($validator->errors());
    }

    public function update(Request $req, $id)
    {
        $validator = validator::make($req->all(), [
            'txtSoxe' => 'required|unique:tbl_car,car_num,'.$id.',car_id',
            'selLoaixe' => 'required',
        ], [
            'txtSoxe.required' => 'Số xe không được bỏ trống',
            'txtSoxe.unique' => 'Số xe không được trùng',
            'selLoaixe.required' => 'Loại xe không được bỏ trống'
        ]);
        if ($validator->passes()) {
            $updData = DB::table('tbl_car')->where('tbl_car.car_id', '=', $id)->update([
                'car_type_id' => $req->selLoaixe,
                'car_num' => $req->txtSoxe,
                'driver_suggestion' => $req->taixe,
                'assistant_driver_suggestion' => $req->slphuxe,
                'note' => $req->txtGhichu,

            ]);

	    	return redirect()->away($req->url);
        }

        return redirect()->back()->withInput()->withErrors($validator);
    }

    public function search(Request $request)
    {   
        if ($request->selLoaixe == '' && $request->selxe == '' && $request->txtGhichu == '' && $request->txtThongtin == '') {
            return redirect('/xe');
        }
        else if($request->has('selLoaixe') && $request->has('selxe') && $request->has('txtGhichu')){
            $selLoaixe = $type = Input::get('selLoaixe');
			$selxe= $type1 = Input::get('selxe');
            $txtGhichu = Input::get('txtGhichu');
            $txtThongtin = Input::get('txtThongtin');
            $car = DB::table('tbl_car')
                    ->join('tbl_car_type', 'tbl_car.car_type_id', '=', 'tbl_car_type.car_type_id')
                    ->select('tbl_car.*', 'tbl_car_type.name');
            if($selLoaixe != null && $selLoaixe != "")
                $car = $car->where('tbl_car.car_type_id', '=', $selLoaixe);
            
               
            if($selxe != null && $selxe != "")
                $car = $car->where('tbl_car.car_id', '=', $selxe);

              
            if($txtGhichu != null && $txtGhichu != "")
                $car = $car->where('tbl_car.note','like', '%'.$txtGhichu.'%');

            $car = $car->orderBy('name','ASC')->orderBy('car_num','ASC')->get();

            return view('xe.index', compact('car','type','type1','txtGhichu'));
        }

        // if ($req->selLoaixe == '' && $req->selxe == '') {
        //     return redirect('/xe');
        // }

        // if ($req->selLoaixe == '' && $req->selxe == '') {
        //     return redirect('/xe');
        // } else {
        //     if ($req->selxe == '') {
        //         $car = DB::table('tbl_car')
        //             ->join('tbl_car_type', 'tbl_car.car_type_id', '=', 'tbl_car_type.car_type_id')
        //             ->select('tbl_car.*', 'tbl_car_type.name')
        //             ->where('tbl_car.car_type_id', '=', $req->selLoaixe)->orderBy('name','ASC')->orderBy('car_num','ASC')
        //             ->get();
        //         $type = $req->selLoaixe;

        //         return view('xe.index', compact('car', 'type'));
        //     } else {
        //         $car = DB::table('tbl_car')
        //         ->join('tbl_car_type', 'tbl_car.car_type_id', '=', 'tbl_car_type.car_type_id')
        //         ->select('tbl_car.*', 'tbl_car_type.name')
        //         ->where('car_id', '=', $req->selxe)->orderBy('name','ASC')->orderBy('car_num','ASC')
        //         ->get();
        //         $type = $req->selLoaixe;
        //         $type1 = $req->selxe;

        //         return view('xe.index', compact('car', 'type', 'type1'));
        //     }
        // }
    }

    public function del($id)
    {
        $del = DB::table('tbl_car')->where('car_id', '=', $id)->delete();

        return redirect()->back();
    }

    public function getCarData()
    {
        $cars = DB::table('tbl_car')->orderBy('car_num','ASC')->get()->toArray();
        $carTypes = DB::table('tbl_car_type')->orderBy('name','ASC')->get()->toArray();
        $res = (object) [
            'cars' => $cars,
            'carTypes' => $carTypes,
        ];

        return Response::json(['success' => $res]);
    }
}
