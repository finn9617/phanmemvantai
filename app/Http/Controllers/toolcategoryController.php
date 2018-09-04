<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;
use Response;

class toolcategoryController extends Controller
{
    public function index(Request $request)
    {
        $search_bodungcu = DB::table('tbl_tool_category')->groupBy('tool_type')->orderBy('name', 'ASC')->get();
        $search_loaidungcu = DB::table('tbl_tool_category')->groupBy('name')->orderBy('name', 'ASC')->get();

        if ($request->has('bodungcu') && $request->has('loaidungcu')) {
            if ($request->bodungcu == null) {
                $loaidc = DB::table('tbl_tool_category')->where('name', $request->loaidungcu)->orderBy('tool_type','ASC')->orderBy('name','ASC')->get();
            } elseif ($request->loaidungcu == null) {
                $loaidc = DB::table('tbl_tool_category')->where('tool_type', $request->bodungcu)->orderBy('tool_type','ASC')->orderBy('name','ASC')->get();
            } else {
                $loaidc = DB::table('tbl_tool_category')->where('tool_type', $request->bodungcu)->where('name', $request->loaidungcu)->orderBy('tool_type','ASC')->orderBy('name','ASC')->get();
            }
            if ($request->bodungcu == null && $request->loaidungcu == null) {
                $loaidc = DB::table('tbl_tool_category')->orderBy('tool_type','ASC')->orderBy('name','ASC')->get();

                return view('LoaiDungCu.index', compact('loaidc', 'search_bodungcu', 'search_loaidungcu'));
            }

            return view('LoaiDungCu.index', compact('loaidc', 'search_bodungcu', 'search_loaidungcu'));
        } elseif ($request->has('bodungcu')) {
            $loaidc = DB::table('tbl_tool_category')->where('tool_type', $request->bodungcu)->orderBy('tool_type','ASC')->orderBy('name','ASC')->get();

            return view('LoaiDungCu.index', compact('loaidc', 'search_bodungcu', 'search_loaidungcu'));
        } else {
            $loaidc = DB::table('tbl_tool_category')->orderBy('tool_type','ASC')->orderBy('name','ASC')->get();

            return view('LoaiDungCu.index', compact('loaidc', 'search_bodungcu', 'search_loaidungcu'));
        }
    }

    public function Search(Request $request)
    {
        $search_bo = DB::table('tbl_tool_category')->orderBy('name', 'ASC')->get()->toArray();

        return response()->json(['success' => 'success', 'search' => $search_bo]);
    }

    public function CreateGet(Request $request)
    {
        return view('LoaiDungCu.create');
    }

    public function CreatePost(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tendungcu' => 'required',
        ], [
            'required' => 'Trường này không được bỏ trống',
        ]);
        if ($validator->passes()) {
            $check = DB::table('tbl_tool_category')->where('tool_type', $request->bodungcu)->where('name', $request->tendungcu)->count();
            if ($check > 0) {
                $error = (object) ['tendungcu' => ['Tên dụng cụ đã tồn tại']];

                return Response::json(['errors' => $error], 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }
            DB::table('tbl_tool_category')->insert(
                [
                    'tool_type' => $request->bodungcu,
                    'name' => $request->tendungcu,
                    'note' => $request->ghichu,
                ]
            );

            return response()->json(['success' => 'success']);
        }

        return response()->json(['errors' => $validator->errors()]);
    }

    public function EditGet(Request $request, $id)
    {
        $data = DB::table('tbl_tool_category')->where('tool_category_id', $id)->orderBy('name', 'ASC')->first();

        return view('LoaiDungCu.edit', compact('data'));
    }

    public function EditPost(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tendungcu' => 'required',
        ], [
            'required' => 'Trường này không được bỏ trống',
        ]);
        if ($validator->passes()) {
            $check = DB::table('tbl_tool_category')->where('tool_type', $request->bodungcu)->where('name', $request->tendungcu)->count();
            $checkId = DB::table('tbl_tool_category')->where('tool_type', $request->bodungcu)->where('name', $request->tendungcu)->select('tool_category_id')->first();

            $data = json_decode(json_encode($checkId), true);

            if ($check > 0 && !in_array($id, $data)) {
                $error = (object) ['tendungcu' => ['Tên dụng cụ đã tồn tại']];

                return Response::json(['errors' => $error], 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
            }
            DB::table('tbl_tool_category')
                   ->where('tool_category_id', $id)
                ->update([
                    'tool_type' => $request->bodungcu,
                    'name' => $request->tendungcu,
                    'note' => $request->ghichu,
                ]);

            return response()->json(['success' => 'success']);
        }

        return response()->json(['errors' => $validator->errors()]);
    }

    public function DeleteLoaiDungCu(Request $request)
    {
        $loaidc = DB::table('tbl_tool')->where('tool_category_id', $request->id)->count();

        if ($loaidc == 0) {
            DB::table('tbl_tool_category')->where('tool_category_id', $request->id)->delete();

            return response()->json(['success' => 'success']);
        } else {
            return response()->json(['errors' => 'errors']);
        }
    }
}
