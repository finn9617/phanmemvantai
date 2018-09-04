<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;
use Redirect;

class cartypeController extends Controller
{
    public function itemDetail($id)
    {
        return view('loaixe.detail', compact('id'));
    }

    public function createItem()
    {
        return view('loaixe.create');
    }

    public function getcartype()
    {
        $car_type = DB::table('tbl_car_type')->orderby('name')->get();

        return view('loaixe.index', compact('car_type'));
    }

    public function postcreateItem(Request $req)
    {
        $validator = validator::make($req->all(), [
            'txtTenloaixe' => 'required|unique:tbl_car_type,name',
        ], [
            'txtTenloaixe.required' => 'Loại xe không được bỏ trống',
            'txtTenloaixe.unique' => 'Tên loại xe đã bị trùng',
        ]);
        if ($validator->passes()) {
            $insData = DB::table('tbl_car_type')->insert([
                'name' => $req->txtTenloaixe,
                'note' => $req->txtThongtin,
            ]);

            return redirect('/loaixe');
        }

        return Redirect::back()->withInput()->withErrors($validator->errors());
    }

    public function update(Request $req, $id)
    {
        $validator = validator::make($req->all(), [
            'txtTenloaixe' => 'required|unique:tbl_car_type,name,'.$id.',car_type_id',
        ], [
            'txtTenloaixe.required' => 'Loại xe không được bỏ trống',
            'txtTenloaixe.unique' => 'Tên loại xe đã bị trùng',
        ]);
        if ($validator->passes()) {
            $updData = DB::table('tbl_car_type')->where('tbl_car_type.car_type_id', '=', $id)->update([
            'name' => $req->txtTenloaixe,
            'note' => $req->txtThongtin,
            ]);

	    	return redirect()->away($req->url);
        }

        return Redirect::back()->withInput()->withErrors($validator->errors());
    }

    public function search(Request $req)
    {
        $searchold = $req->loaixe;
        $car_type = DB::table('tbl_car_type')->where('tbl_car_type.name', 'LIKE', '%'.$req->loaixe.'%')->orderBy('name', 'ASC')->get();

        return view('loaixe.index', compact('car_type', 'searchold'));
    }

    public function del(Request $req)
    {
        $delerror = DB::table('tbl_car_type')->where('car_type_id', '=', $req->id)->count();
        if ($delerror == 0) {
            $del = DB::table('tbl_car_type')->where('car_type_id', '=', $req->id)->delete();

            return response()->json(['success' => 'success']);
        } else {
            return response()->json(['errors' => 'errors']);
        }
    }
}
