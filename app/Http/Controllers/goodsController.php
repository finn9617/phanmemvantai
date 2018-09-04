<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use Response;
use Redirect;

class goodsController extends Controller
{
    public function getgoods()
    {
        $hanghoa = DB::table('tbl_goods')->orderby('full_name')->get();
        $sort_name = DB::table('tbl_goods')->select('goods_id', 'sort_name')->groupby('sort_name')->get();
        $full_name = DB::table('tbl_goods')->select('goods_id', 'full_name')->groupby('full_name')->get();
        $rate = DB::table('tbl_goods')->select('goods_id', 'rate')->groupby('rate')->get();

        return view('HangHoa.index', compact('hanghoa', 'sort_name', 'full_name', 'rate'));
    }

    public function getgoods2()
    {
        $hanghoa = DB::table('tbl_goods')->orderby('full_name')->get();
        $sort_name = DB::table('tbl_goods')->select('goods_id', 'sort_name')->groupby('sort_name')->get();
        $full_name = DB::table('tbl_goods')->select('goods_id', 'full_name')->groupby('full_name')->get();
        $rate = DB::table('tbl_goods')->select('goods_id', 'rate')->groupby('rate')->get();
        $data = (object) [
            'sort_name' => $sort_name,
            'full_name' => $full_name,
            'rate' => $rate,
            'hanghoa' => $hanghoa,
        ];

        return Response::json(['success' => $data]);
    }

    public function createItem()
    {
        return view('HangHoa.create');
    }

    public function itemDetail($id)
    {
        $getGoodsbyID = DB::table('tbl_goods')->where('tbl_goods.goods_id', $id)->first();

        return view('HangHoa.detail', compact('getGoodsbyID'));
    }

    public function postcreateItem(Request $req)
    {
        // var_dump($req->radGoodType); exit();
        $validator = validator::make($req->all(), [
            'txtTendaydu' => 'required',
            'txtTenviettat' => 'required',
            'txtTytrong' => 'nullable|numeric',
            'radGoodType' => 'required',
        ], [
            'txtTendaydu.required' => 'Tên đầy đủ không hợp lệ',
            'txtTenviettat.required' => 'Tên viết tắt không hợp lệ',
            'txtTytrong.numeric' => 'Tỷ trọng không hợp lệ',
            'radGoodType.required' => 'Thiếu thông tin loại hàng',
        ]);
        // print_r($req->all());exit;
        $check = DB::table('tbl_goods')->where('full_name',$req->txtTendaydu)->where('goods_type',$req->radGoodType)->count();
        $check2 = DB::table('tbl_goods')->where('sort_name',$req->txtTenviettat)->where('goods_type',$req->radGoodType)->count();

        $goods = "hàng bồn";
        if($req->radGoodType==1){
            $goods = "hàng phi";
        }
        if($check>0 && $check2>0){
            $validator->errors()->add('txtTenviettat', 'Tên viết tắt của '.$goods.' đã bị trùng');
            $validator->errors()->add('txtTendaydu', 'Tên đầy đủ của '.$goods.' đã bị trùng'); 
            return Response::json(['errors' => $validator->errors()]);
        }
        if($check>0){
            $validator->errors()->add('txtTendaydu', 'Tên đầy đủ của '.$goods.' đã bị trùng');
            return Response::json(['errors' => $validator->errors()]);
        }
        if($check2>0){
            $validator->errors()->add('txtTenviettat', 'Tên viết tắt của '.$goods.' đã bị trùng');
            return Response::json(['errors' => $validator->errors()]);
        }

        if ($validator->passes()) {
            $insData = DB::table('tbl_goods')->insert([
                'full_name' => $req->txtTendaydu,
                'sort_name' => $req->txtTenviettat,
                'rate' => $req->txtTytrong,
                'note' => $req->txtGhichu,
                'goods_type' => $req->radGoodType,
            ]);
            // print_r($insData);exit;
            return Response::json(['success' => 'Thao tác thành công']);
        }

        return Response::json(['errors' => $validator->errors()]);
    }

    public function update(Request $req, $id)
    {
        $validator = validator::make($req->all(), [
            'txtTendaydu' => 'required',
            'txtTenviettat' => 'required',
            'txtTytrong' => 'nullable|numeric',
            'radGoodType' => 'required',
        ], [
            'txtTendaydu.required' => 'Tên đầy đủ không hợp lệ',
            'txtTenviettat.required' => 'Tên viết tắt không hợp lệ',
            'txtTytrong.numeric' => 'Tỷ trọng không hợp lệ',
            'txtTendaydu.unique' => 'Tên đầy đủ không được trùng',
            'radGoodType.required' => 'Thiếu thông tin loại hàng',
            'txtTenviettat.unique' => 'Tên viết tắt không được trùng ',
        ]);
        // print_r($req->all());exit;

        $check = DB::table('tbl_goods')->where('full_name',$req->txtTendaydu)->whereNotIn('goods_id',[$id])->where('goods_type',$req->radGoodType)->count();
        $check2 = DB::table('tbl_goods')->where('sort_name',$req->txtTenviettat)->whereNotIn('goods_id',[$id])->where('goods_type',$req->radGoodType)->count();

        $goods = "hàng bồn";
        if($req->radGoodType==1){
            $goods = "hàng phi";
        }
        if($check>0 && $check2>0){
            $validator->errors()->add('txtTenviettat', 'Tên viết tắt của '.$goods.' đã bị trùng');
            $validator->errors()->add('txtTendaydu', 'Tên đầy đủ của '.$goods.' đã bị trùng'); 
            return Response::json(['errors' => $validator->errors()]);
        }
        if($check>0){
            $validator->errors()->add('txtTendaydu', 'Tên đầy đủ của '.$goods.' đã bị trùng');
            return Response::json(['errors' => $validator->errors()]);
        }
        if($check2>0){
            $validator->errors()->add('txtTenviettat', 'Tên viết tắt của '.$goods.' đã bị trùng');
            return Response::json(['errors' => $validator->errors()]);
        }


        if ($validator->passes()) {
            $upData = DB::table('tbl_goods')->where('tbl_goods.goods_id', $id)->update([
                'full_name' => $req->txtTendaydu,
                'sort_name' => $req->txtTenviettat,
                'rate' => $req->txtTytrong,
                'note' => $req->txtGhichu,
                'goods_type' => $req->radGoodType,
            ]);
            // print_r($insData);exit;
            return Response::json(['success' => 'Thao tác thành công']);
        }

        return Response::json(['errors' => $validator->errors()]);
    }

    public function del($id)
    {
        // print_r(1);exit;
        $delData = DB::table('tbl_goods')->where('tbl_goods.goods_id', $id)->delete();

        return redirect()->back();
    }

    public function search(Request $req)
    {
        $hanghoa = DB::table('tbl_goods');
        if (!empty($req->tenviettat)) {
            $hanghoa = $hanghoa->where('tbl_goods.sort_name', 'LIKE', '%'.$req->tenviettat.'%');
        }

        if (!empty($req->tendaydu)) {
            $hanghoa = $hanghoa->where('tbl_goods.full_name', 'LIKE', '%'.$req->tendaydu.'%');
        }

        $hanghoa = $hanghoa->orderby('full_name')->get();

        $sort_name = DB::table('tbl_goods')->select('goods_id', 'sort_name')->groupby('sort_name')->get();
        $full_name = DB::table('tbl_goods')->select('goods_id', 'full_name')->groupby('full_name')->get();
        $rate = DB::table('tbl_goods')->select('goods_id', 'rate')->groupby('rate')->get();

        return view('HangHoa.index', compact('hanghoa', 'sort_name', 'full_name', 'rate'));

        return Redirect::to('form')->withInput();
    }
}
