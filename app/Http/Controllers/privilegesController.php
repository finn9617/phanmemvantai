<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class privilegesController extends Controller
{
    //
    public function show(){
        $user[1]='Admin';
        $user[10]='Nhân viên văn phòng';
        $user[11]='Người liên lạc';
        $user[2]='Điều phối';
        $user[3]='Điều phối 2';
        $user[12]='Tài xế';
        $user[13]='Phụ xe';
        $user[14]='Chủ hàng';
        $user[15]='Người phụ trách';
        return view('Privileges.index',compact('user'));
    }
    public function getEdit(Request $request){
        $data = $request->id;
        return view('Privileges.edit',compact('data'));
    }
    public function delete(Request $request){
        echo('asd');
    }
}
