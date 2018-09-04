<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Response;
use Illuminate\Support\Facades\Input;


class trailerController extends Controller
{
    public function itemDetail($id)
    {
        return view('trailer.detail', compact('id'));
    }

    //================================== EXAMPLE 3: CREATE ITEM ===========================================

    public function createItem()
    {
        return view('trailer.create');
    }

    //=========================================== EXXAMPLE 5: SHOW USER TABLE ========================================
    public function gettrailer()
    {
        $trailer = DB::table('tbl_trailer')->join('tbl_trailer_type', 'tbl_trailer_type.trailer_type_id', '=', 'tbl_trailer.trailer_type_id')->select('tbl_trailer.*', 'tbl_trailer_type.trailer_type_name')->orderBy('trailer_type_name','ASC')->orderby('trailer_num')->get();

        return view('trailer.index', compact('trailer'));
    }

    public function postcreateItem(Request $req)
    {
        $validator = validator::make($req->all(), [
            'txtSoromooc' => 'required|unique:tbl_trailer,trailer_num',
            'selLoairomooc' => 'required',
        ], [
            'txtSoromooc.unique' => 'Số rơ mooc đã có',
            'txtSoromooc.required' => 'Số rơ mooc không được bỏ trống',
            'selLoairomooc.required' => 'Loại rơ mooc không được trống'
        ]);
        if ($validator->passes()) {
            $insData = DB::table('tbl_trailer')->insert([
                'trailer_num' => $req->txtSoromooc,
                'trailer_type_id' => $req->selLoairomooc,
                'infor' => $req->txtThongtin,
                'note' => $req->txtGhichu,
            ]);

            return redirect('/romooc');
        }

        return redirect('/romooc/create')->withInput()->withErrors($validator);
    }

    public function update(Request $req, $id)
    {
        $validator = validator::make($req->all(), [
            'txtSoromooc' => 'required|unique:tbl_trailer,trailer_num,'.$id.',trailer_id',
            'selLoairomooc' => 'required',
        ], [
            'txtSoromooc.unique' => 'Số rơ mooc đã có',
            'txtSoromooc.required' => 'Số rơ mooc không được bỏ trống',
            'selLoairomooc.required' => 'Loại rơ mooc không được trống'
        ]);
        if ($validator->passes()) {
            $updData = DB::table('tbl_trailer')->where('tbl_trailer.trailer_id', '=', $id)->update([
                'trailer_num' => $req->txtSoromooc,
                'trailer_type_id' => $req->selLoairomooc,
                'note' => $req->txtGhichu,
                'infor' => $req->txtThongtin,

            ]);

	    	return redirect()->away($req->url);
        }

        return redirect()->back()->withInput()->withErrors($validator);
    }

    //=========================================== EXXAMPLE 6: SEARCH USER ========================================
    public function search(Request $req)
    {
        if ($req->selLoai == '' && $req->selRomooc == '' && $req->txtGhichu == '' && $req->txtThongtin == '') {
            return redirect('/romooc');
        }else if($req->has('selLoai') && $req->has('selRomooc') && $req->has('txtGhichu')){
            $selLoai = $type = Input::get('selLoai');
			$selRomooc= $type1 = Input::get('selRomooc');
            $txtGhichu = Input::get('txtGhichu');
            $txtThongtin = Input::get('txtThongtin');
            $trailer = DB::table('tbl_trailer')
                ->join('tbl_trailer_type', 'tbl_trailer_type.trailer_type_id', '=', 'tbl_trailer.trailer_type_id')
                ->select('tbl_trailer.*', 'tbl_trailer_type.trailer_type_name');


            if($selLoai != null && $selLoai != "")
                $trailer = $trailer->where('tbl_trailer.trailer_type_id', '=', $selLoai);
            
               
            if($selRomooc != null && $selRomooc != "")
                $trailer = $trailer->where('tbl_trailer.trailer_id', '=', $selRomooc);

              
            if($txtGhichu != null && $txtGhichu != "")
                $trailer = $trailer->where('tbl_trailer.note','like', '%'.$txtGhichu.'%');

            if($txtThongtin != null && $txtThongtin != "")
                $trailer = $trailer->where('tbl_trailer.infor','like', '%'.$txtThongtin.'%');

            $trailer = $trailer->orderBy('trailer_type_name')->orderBy('trailer_num','ASC')->get();
            return view('trailer.index', compact('trailer','type','type1','txtGhichu'));
        }

    }

    //=========================================== EXXAMPLE 7: DELETE USER ========================================
    public function del($id)
    {
        require_once 'LibForm.php';
        //TÊN TABLE
        $tableName = 'tbl_trailer';
        //TÊN KHÓA CHÍNH CỦA TABLE
        $idtable = 'trailer_id';
        LibForm::delete($tableName, $idtable, $id);

        return redirect()->back();
    }

    public function getData()
    {
        $trailer = DB::table('tbl_trailer')->orderBy('trailer_num')->get()->toArray();
        $trailer_type = DB::table('tbl_trailer_type')->orderBy('trailer_type_name')->get()->toArray();
        $res = (object) [
            'trailer' => $trailer,
            'trailer_type' => $trailer_type,
        ];

        return Response::json(['success' => $res]);
    }
}
