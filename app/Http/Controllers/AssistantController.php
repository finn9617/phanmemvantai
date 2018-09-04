<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;

class AssistantController extends Controller
{
    public function index(Request $request)
    {
        $search_tdd = DB::table('tbl_user')->where('user_type', 13)->orderby('full_name', 'ASC')->orderby('nick_name', 'ASC')->get();
        $search_tdx = DB::table('tbl_user')->where('user_type', 13)->orderby('nick_name', 'ASC')->get();

        $driverName = Input::get('tendaydu');
		$driverNickName = Input::get('tendixe');
        $phoneNumber =Input::get('txtPhoneNumber');
        $identityCardNumber = Input::get('txtIdentityCardNumber');
        $note = Input::get('txtGhichu');
        
        $assistant = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_type', '=', 13);
        // if ($request->has('tendaydu') && $request->has('tendixe')) {
        //     if ($request->tendaydu == null && $request->tendixe != null) {
        //         $assistant = DB::table('tbl_user')
        //             ->where('nick_name', 'like', '%'.$request->tendixe.'%')
        //             ->where('user_type', 13)->orderby('nick_name', 'ASC')
        //             ->get();
        //     // dd($assistant);
        //     } elseif ($request->tendixe == null && $request->tendaydu != null) {
        //         $assistant = DB::table('tbl_user')
        //             ->where('full_name', 'like', '%'.$request->tendaydu.'%')
        //             ->where('user_type', 13)->orderby('nick_name', 'ASC')
        //             ->get();
        //     // dd($assistant);
        //     } elseif ($request->tendixe != null && $request->tendaydu != null) {
        //         $assistant = DB::table('tbl_user')
        //             ->where('full_name', 'like', '%'.$request->tendaydu.'%')
        //             ->where('nick_name', 'like', '%'.$request->tendixe.'%')
        //             ->where('user_type', 13)->orderby('nick_name', 'ASC')
        //             ->get();
        //     } else {
        //         $assistant = DB::table('tbl_user')->where('user_type', 13)->orderby('nick_name', 'ASC')->get();
        //     }

        //     return view('Assistant.index', compact('assistant', 'search_tdd', 'search_tdx'));
        // } else {
        //     $assistant = DB::table('tbl_user')->where('user_type', 13)->orderby('nick_name', 'ASC')->get();

        //     return view('Assistant.index', compact('assistant', 'search_tdd', 'search_tdx'));
        // }
        if($driverName != null && $driverName != "")
			$assistant = $assistant->where('full_name', 'like', '%'.$driverName.'%');
		if($driverNickName != null && $driverNickName != "")
			$assistant = $assistant->where('nick_name', 'like', '%'.$driverNickName.'%');
		if($phoneNumber != null && $phoneNumber != "")
			$assistant = $assistant->where('phone', 'like', '%'.$phoneNumber.'%');
		if($identityCardNumber !=  null && $identityCardNumber != "")
            $assistant = $assistant->where('tbl_user.identity_id', 'like', '%'.$identityCardNumber.'%');
        if($note !=  null && $note != "")
			$assistant = $assistant->where('tbl_user.note', 'like', '%'.$note.'%');

        $assistant = $assistant->orderBy('work_status','ASC')->orderBy('nick_name','ASC')->get()->toArray();
        return view('Assistant.index', compact('assistant', 'search_tdd', 'search_tdx'));
    }

    public function AddAssistantGet(Request $request)
    {
        return view('Assistant.create');
    }
    
    public function AddAssistantPost(Request $request)
    {
        // return response()->json(['errors' => $request->all()]);exit;
        $validator = Validator::make($request->all(), [
            'hoten' => 'required',
            'tendixe' => 'required',
            'danhxung' => 'required',
            // 'email' => 'email',
            // 'tendangnhap' => 'regex:/^[A-Za-z0-9_]+$/|unique:tbl_user,user_name|min:6',
            //'password' => 'min:6',
            //'password_confirmation' => 'same:password',
            'cmnd' => 'regex:/^[0-9-.\s]{5,20}$/|unique:tbl_user,identity_id',
            'sdt' => 'regex:/^[0-9-.\s]{9,15}$/',
            'avatar' => 'mimes:jpeg,jpg,png,gif,svg|max:2048',
            //'dateNam' => 'regex:/^[0-9-.\s]$/',
            // 'avatar' => 'avatar1',
        ], [
            'required' => 'Trường này không được bỏ trống',
            // 'email.email' => 'Email không đúng định dạng',
            // 'tendangnhap.regex' => 'Tên đăng nhập không hợp lệ',
            // 'tendangnhap.unique' => 'Tên đăng nhập đã tồn tại',
            'tendixe.unique' => 'Tên đi xe đã tồn tại',
            'cmnd.unique' => 'CMND đã tồn tại',
            'sdt.regex' => 'Số điện thoại không hợp lệ, có thể quá dài, không được có chữ',
            //'dateNam.regex' => 'Số điện thoại không hợp lệ, có thể quá dài, không được có chữ',
            'cmnd.regex' => 'CMND không hợp lệ, có thể quá dài, không được có chữ',
            'tendangnhap.min' => 'Tên đăng nhập quá ngắn',
            //'password.min' => 'Mật khẩu quá ngắn',
            //'password_confirmation.same' => 'Mật khẩu không khớp',
            'avatar.mimes' => 'Ảnh không đúng định dạng jpeg, jpg, png, gif, svg',
            'avatar.max' => 'Ảnh không quá 2mb',
            // 'avatar.avatar1' => 'Ảnh không hợp lệ',
        ]);
        if ($validator->passes()) {
            if ($request->tendixe) {
                // $tendixe = DB::table('tbl_user')->whereIn('tbl_user.user_type', [12, 13])->where('nick_name', '=', '%'.$request->tendixe.'%')->where('work_status',0)->count();
                $tendixe = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$request->tendixe',BINARY) AND tbl_user.work_status = 0");
                //var_dump($tendixe);
                // exit;
                if ($tendixe[0]->cnt > 0) {
                    $error = (object) ['tendixe' => ['Tên đi xe không được trùng']];
                    return response()->json(['errors' => $error]);
                }
                if($request->check!=1){
                    //dd($request->check);exit;
                    $checkTen = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$request->tendixe',BINARY) AND tbl_user.work_status = 1");
                    if ($checkTen[0]->cnt > 0){
                        $error = (object) ['checkten' => ['Tên đi xe trùng với phụ xe đã nghỉ, bạn vẫn muốn tạo?']];
                        return response()->json(['loi' => $error]);
                    }
                }
                
            }

            // if ($request->password || $request->tendangnhap) {
            //     if (!(strlen($request->password) > 0 && strlen($request->tendangnhap))) {
            //         $error = (object) ['infologin' => [' Vui lòng điền đầy đủ thông tin đăng nhập']];

            //         return response()->json(['errors' => $error]);
            //     }
            // }
            if ($request->hasFile('avatar')) {
                $fileName = Input::file('avatar')->getClientOriginalName();

                if (!preg_match("/^([^\\\\\']|\\\.)*$/", $fileName, $matchs)) {
                    $error = (object) ['avatar' => ['Không đúng định dạng file']];

                    return response()->json(['errors' => $error]);
                }

                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = pathinfo($fileName, PATHINFO_FILENAME);
                $fileName = date('dmyhms').'-'.str_slug($fileName).'.'.$extension;
                $file = $request->file('avatar');
                $file->move('img/Users', $fileName);
                $avatar = $fileName;
            } else {
                $avatar = null;
            }
            if ($request->password) {
                $password = Hash::make($request->password);
            } else {
                $password = '';
            }

            DB::table('tbl_user')->insert(
                [
                    'full_name' => $request->hoten,
                    'nick_name' => $request->tendixe,
                    'gender_id' => $request->danhxung,
                    'identity_id' => $request->cmnd,
                    'note' => $request->ghichu,
                    'address' => $request->diachi,
                    'phone' => $request->sdt,
                    //'user_name' => $request->tendangnhap,
                    //'email' => $request->email,
                    //'password' => $password,
                    'avatar' => $avatar,
                    'user_type' => 13,
                    'birthday' => $request->dateNam,
                    'work_status' => $request->trangthai,
                ]
            );

            return response()->json(['success' => 'success']);
        }

        return response()->json(['errors' => $validator->errors()]);
    }

    public function DeleteAssistantPost(Request $request)
    {
        $image = DB::table('tbl_user')->where('user_id', $request->id)->first();
        $file = $image->avatar;
        if (isset($file)) {
            if (file_exists(public_path().'/img/Users/'.$file)) {
                unlink(public_path().'/img/Users/'.$file);
            }
        }

        DB::table('tbl_user')->where('user_id', $request->id)->delete();

        return response()->json(['success' => 'success']);
    }

    public function EditAssistantGet(Request $request, $id)
    {
        $user = DB::table('tbl_user')->where('user_id', $id)->first();

        return view('Assistant.edit', compact('user'));
    }

    public function EditAssistantPost(Request $request, $id)
    {
        //dd($request->sdt);
        $validator = Validator::make($request->all(), [
            'hoten' => 'required',
            'tendixe' => 'required',
            'danhxung' => 'required',
            // 'email' => 'email',
            // 'tendangnhap' => 'regex:/^[A-Za-z0-9_]+$/|min:6|unique:tbl_user,user_name,'.$id.',user_id',
            // 'password' => 'min:6',
            // 'password_confirmation' => 'same:password',
            'cmnd' => 'regex:/^[0-9-.\s]{5,20}$/|unique:tbl_user,identity_id,'.$id.',user_id',
            'sdt' => 'regex:/\d*([.,\/\s]?\d+){9,15}/',
            'avatar' => 'mimes:jpeg,jpg,png,gif,svg|max:2048',
           // 'avatar' => 'avatar1',
        ], [
            'required' => 'Trường này không được bỏ trống',
            // 'email.email' => 'Email không đúng định dạng',
            // 'password.confirmed' => 'Mật khẩu không khớp',
            // 'tendangnhap.regex' => 'Tên đăng nhập không hợp lệ',
            // 'tendangnhap.unique' => 'Tên đăng nhập đã tồn tại',
            'tendixe.unique' => 'Tên đi xe đã tồn tại',
            'cmnd.unique' => 'CMND đã tồn tại',
            'sdt.regex' => 'Số điện thoại không hợp lệ, có thể quá dài, không được có chữ',
            'cmnd.regex' => 'CMND không hợp lệ, có thể quá dài, không được có chữ',
            // 'tendangnhap.min' => 'Tên đăng nhập quá ngắn',
            // 'password.min' => 'Mật khẩu quá ngắn',
            // 'password_confirmation.same' => 'Mật khẩu không khớp',
           // 'avatar.avatar1' => 'Ảnh không hợp lệ',
            'avatar.mimes' => 'Ảnh không đúng định dạng jpeg, jpg, png, gif, svg',
            'avatar.max' => 'Ảnh không quá 2mb',
        ]);

        if ($validator->passes()) {
            if ($request->tendixe) {
                $tendixe = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$request->tendixe',BINARY) AND tbl_user.user_id NOT IN ($id) AND tbl_user.work_status = 0");
                // var_dump($tendixe[0]->cnt);
                // exit();
                if ($tendixe[0]->cnt > 0) {
                    $error = (object) ['tendixe' => ['Tên đi xe không được trùng']];

                    return response()->json(['errors' => $error]);
                }
                if($request->check!=1){
                    //dd($request->check);exit;
                    $checkTen = DB::select("SELECT COUNT(*) as cnt FROM tbl_user WHERE tbl_user.user_type IN (12,13) AND CONVERT(tbl_user.nick_name,BINARY) = CONVERT('$request->tendixe',BINARY) AND tbl_user.work_status = 1");
                    if ($checkTen[0]->cnt > 0){
                        $error = (object) ['checkten' => ['Tên đi xe trùng với phụ xe đã nghỉ, bạn vẫn muốn tạo?']];
                        return response()->json(['loi' => $error]);
                    }
                }
            }

            if ($request->password) {
                $password = Hash::make($request->password);
            } else {
                $password = '';
            }
            $check = DB::table('tbl_user')->where('user_id', $id)->select('user_name')->first();
            if ($request->hasFile('avatar')) {
                $fileName = Input::file('avatar')->getClientOriginalName();
                if (!preg_match("/^([^\\\\\']|\\\.)*$/", $fileName, $matchs)) {
                    $error = (object) ['avatar' => ['Không đúng định dạng file']];

                    return response()->json(['errors' => $error]);
                }
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                $fileName = pathinfo($fileName, PATHINFO_FILENAME);
                $fileName = date('dmyhms').'-'.str_slug($fileName).'.'.$extension;
                $file = $request->file('avatar');
                $file->move('img/Users', $fileName);
                $avatar = $fileName;

                $partner = DB::table('tbl_user')->where('user_id', $id)->first();
                $file1 = $partner->avatar;
                if (isset($file1)) {
                    if (file_exists(public_path().'/img/Users/'.$file1)) {
                        unlink(public_path().'/img/Users/'.$file1);
                    }
                }
                
                // if ($check->user_name) {
                    DB::table('tbl_user')
                        ->where('user_id', $id)
                        ->update(
                        [
                            'full_name' => $request->hoten,
                            'nick_name' => $request->tendixe,
                            'gender_id' => $request->danhxung,
                            'identity_id' => $request->cmnd,
                            'note' => $request->ghichu,
                            'address' => $request->diachi,
                            'phone' => $request->sdt,
                            // 'email' => $request->email,
                            // 'password' => $password,
                            'avatar' => $avatar,
                            'birthday' => $request->dateNam,
                            'work_status' => $request->trangthai,
                        ]
                    );
                // } else {
                //     // if ($request->password || $request->tendangnhap) {
                //     //     if (!(strlen($request->password) > 0 && strlen($request->tendangnhap))) {
                //     //         $error = (object) ['infologin' => [' Vui lòng điền đầy đủ thông tin đăng nhập']];

                //     //         return response()->json(['errors' => $error]);
                //     //     }
                //     // }
                //     DB::table('tbl_user')
                //         ->where('user_id', $id)
                //         ->update(
                //         [
                //             'full_name' => $request->hoten,
                //             'nick_name' => $request->tendixe,
                //             'gender_id' => $request->danhxung,
                //             'identity_id' => $request->cmnd,
                //             'note' => $request->ghichu,
                //             'address' => $request->diachi,
                //             'phone' => $request->sdt,
                //             'user_name' => $request->tendangnhap,
                //             'email' => $request->email,
                //             'password' => $password,
                //             'avatar' => $avatar,
                //             'birthday' => $request->dateNam,
                //             'work_status' => $request->trangthai,
                //         ]
                //     );
                // }

                return response()->json(['success' => 'success']);
            } else {
                // if ($check->user_name) {
                   
                    DB::table('tbl_user')
                        ->where('user_id', $id)
                        ->update(
                        [
                            'full_name' => $request->hoten,
                            'nick_name' => $request->tendixe,
                            'gender_id' => $request->danhxung,
                            'identity_id' => $request->cmnd,
                            'note' => $request->ghichu,
                            'address' => $request->diachi,
                            'phone' => $request->sdt,
                            // 'email' => $request->email,
                            // 'password' => $password,
                            'birthday' => $request->dateNam,
                            'work_status' => $request->trangthai,
                        ]
                    );
                // } else {
                //     if ($request->password || $request->tendangnhap) {
                //         if (!(strlen($request->password) > 0 && strlen($request->tendangnhap))) {
                //             $error = (object) ['infologin' => [' Vui lòng điền đầy đủ thông tin đăng nhập']];

                //             return response()->json(['errors' => $error]);
                //         }
                //     }
                //     DB::table('tbl_user')
                //         ->where('user_id', $id)
                //         ->update(
                //         [
                //             'full_name' => $request->hoten,
                //             'nick_name' => $request->tendixe,
                //             'gender_id' => $request->danhxung,
                //             'identity_id' => $request->cmnd,
                //             'note' => $request->ghichu,
                //             'address' => $request->diachi,
                //             'phone' => $request->sdt,
                //             'user_name' => $request->tendangnhap,
                //             'email' => $request->email,
                //             'password' => $password,
                //             'birthday' => $request->dateNam,
                //             'work_status' => $request->trangthai,
                //         ]
                //     );
                // }

                return response()->json(['success' => 'success']);
            }
        }

        return response()->json(['errors' => $validator->errors()]);
    }
}
