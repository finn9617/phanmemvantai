<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;

class cleartankController extends Controller
{
    public function itemDetail($id)
    {
        $xit = DB::table('tbl_clear_tank')->where('clear_tank_id', '=', $id)->first();

        return view('xitbon.detail', compact('xit'));
    }

    public function createItem()
    {
        return view('xitbon.create');
    }

    public function getcleartank()
    {
        $clear = DB::table('tbl_clear_tank')->orderby('clear_tank_name')->get();

        return view('xitbon.index', compact('clear'));
    }

    public function postcreateItem(Request $req)
    {
        $validator = validator::make($req->all(), [
            'tenxitbon' => 'required|unique:tbl_clear_tank,clear_tank_name',
        ], [
            'tenxitbon.required' => 'Tên xịt bồn không được bỏ trống',
            'tenxitbon.unique' => 'Tên xịt bồn đã tồn tại',
        ]);
        if ($validator->passes()) {
            // print_r($req->all()); exit();
            $insData = DB::table('tbl_clear_tank')->insert([
                'clear_tank_name' => $req->tenxitbon,
                'note' => $req->note,
            ]);

            return response()->json(['success' => 'success']);
        }

        return response()->json(['errors' => $validator->errors()]);
    }

    public function update(Request $req)
    {
        $validator = validator::make($req->all(), [
            'tenxitbon' => 'required|unique:tbl_clear_tank,clear_tank_name,'.$req->id.',clear_tank_id',
        ], [
            'tenxitbon.required' => 'Tên xịt bồn không được bỏ trống',
            'tenxitbon.unique' => 'Tên xịt bồn đã tồn tại',
        ]);
        if ($validator->passes()) {
            // print_r($req->all()); exit();
            $partner = DB::table('tbl_clear_tank')->where('clear_tank_id', $req->id)
            ->update([
                'clear_tank_name' => $req->tenxitbon,
                'note' => $req->note,
                ]
            );

            return response()->json(['success' => 'success']);
        }

        return response()->json(['errors' => $validator->errors()]);
    }

    public function search(Request $req)
    {
        $searchold = $req->selxitbon;
        $clear = DB::table('tbl_clear_tank')->where('clear_tank_id', 'LIKE', '%'.$req->selxitbon.'%')->get();

        return view('xitbon.index', compact('clear', 'searchold'));
    }

    //=========================================== EXXAMPLE 7: DELETE USER ========================================
    public function del(Request $req)
    {
        DB::table('tbl_clear_tank')->where('clear_tank_id', '=', $req->id)->delete();

        return response()->json(['success' => 'success']);
    }
}
