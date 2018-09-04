<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Redirect;

class TypetrailerController extends Controller
{
    public function itemDetail($id)
    {
        return view('typetrailer.detail', compact('id'));
    }

    //================================== EXAMPLE 3: CREATE ITEM ===========================================

    public function createItem()
    {
        return view('typetrailer.create');
    }

    //=========================================== EXXAMPLE 5: SHOW USER TABLE ========================================
    public function gettrailer()
    {
        $type_trailer = DB::table('tbl_trailer_type')->orderby('trailer_type_name')->get();

        return view('typetrailer.index', compact('type_trailer'));
    }

    public function postcreateItem(Request $req)
    {
        $validator = validator::make($req->all(), [
            'txtTenloaimooc' => 'required|unique:tbl_trailer_type,trailer_type_name',
        ], [
            'txtTenloaimooc.required' => 'Loại rơ mooc không được bỏ trống',
            'txtTenloaimooc.unique' => 'Loại rơ mooc đã bị trùng',
        ]);
        if ($validator->passes()) {
            // print_r($req->all()); exit();
            $insData = DB::table('tbl_trailer_type')->insert([
                'trailer_type_name' => $req->txtTenloaimooc,
                'note' => $req->txtThongtin,
            ]);

            return redirect('/loairomooc');
        }

        return Redirect::back()->withInput()->withErrors($validator->errors());
    }

    public function update(Request $req, $id)
    {
        $validator = validator::make($req->all(), [
            'txtTenloaimooc' => 'required|unique:tbl_trailer_type,trailer_type_name,'.$id.',trailer_type_id',
        ], [
            'txtTenloaimooc.required' => 'Loại rơ mooc không được bỏ trống',
            'txtTenloaimooc.unique' => 'Loại rơ mooc đã bị trùng',
        ]);
        if ($validator->passes()) {
            $updData = DB::table('tbl_trailer_type')->where('tbl_trailer_type.trailer_type_id', '=', $id)->update([
                'trailer_type_name' => $req->txtTenloaimooc,
                'note' => $req->txtThongtin,
            ]);

	    	return redirect()->away($req->url);
        }

        return redirect()->back()->withInput()->withErrors($validator);
    }

    //=========================================== EXXAMPLE 6: SEARCH USER ========================================
    public function search(Request $req)
    {
        $searchold = $req->loairomooc;
        $type_trailer = DB::table('tbl_trailer_type')->where('tbl_trailer_type.trailer_type_name', 'LIKE', '%'.$req->loairomooc.'%')->get();

        return view('typetrailer.index', compact('type_trailer', 'searchold'));
    }

    //=========================================== EXXAMPLE 7: DELETE USER ========================================
    public function del(Request $req)
    {
        $delerror = DB::table('tbl_trailer')->where('trailer_type_id', '=', $req->id)->count();
        if ($delerror == 0) {
            $del = DB::table('tbl_trailer_type')->where('trailer_type_id', '=', $req->id)->delete();

            return response()->json(['success' => 'success']);
        } else {
            return response()->json(['errors' => 'errors']);
        }
    }
}
