<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;
use App\User;
use Validator;

class userQuocHuyController extends Controller
{
   public function getUser()
   {
   		$getUser = DB::table('tbl_user')->select('tbl_user.*')->get()->toArray();

   		$resData = (object)[
   			'getUser' => $getUser,
   		];

   		return Response::json(['success' => $resData]);

   }

   public function getSearch(Request $req)
   { 
   		$getRole = $req->input('txtOffice');
   		$getFullname = $req->input('txtFullname');
   		$getUsername = $req->input('txtUsername');

   		if($getRole === 'Admin')
   			$getRole = 1;
   		else if($getRole === 'NVVP')
   			$getRole = 10;
   		else if($getRole === 'Người liên lạc')
   			$getRole = 11;
   		else if($getRole === 'Tài xế')
   			$getRole = 12;
   		else if($getRole === 'Lơ xe')
   			$getRole = 13;
   		else if($getRole === 'Chủ hàng')
   			$getRole = 14;
   		else if($getRole === 'Người phụ trách')
   			$getRole = 15;
         else if($getRole === 'Điều phối 1')
            $getRole = 16;
         else if($getRole === 'Điều phối 2')
            $getRole = 17;
         else if($getRole === 'Văn phòng bãi xe')
            $getRole = 18;                                 

   		$userSearch = DB::table('tbl_user')->select('tbl_user.*'); 

   		if($getRole != null && $getRole != "")
   			$userSearch = $userSearch->where('user_type','=', $getRole );
   		if($getFullname != null && $getFullname != "")
   			$userSearch = $userSearch->where('full_name','like','%'.$getFullname.'%');
   		if($getUsername != null && $getUsername != "")
   			$userSearch = $userSearch->where('user_name','like','%'.$getUsername.'%');

   		$userSearch = $userSearch->get()->toArray();

   		$resData = (object)[
   			'userSearch' => $userSearch,
   		];

   		return Response::json(['success'=> $resData]);
   }

   public function getDelete($id)
   {
   		if(isset($id) && $id != null && is_numeric($id))
   			DB::table('tbl_user')->where('user_id','=',$id)->delete();
   			return Response::json(['success'=>'ok']);
   }

   public function getEdit($id)
   {
      $getUser = DB::table('tbl_user')->select('tbl_user.*')->where('user_id','=',$id)->first();
      return Response::json(['success' => $getUser]);
   }

   public function postEdit(Request $req)
   { 

      $getId = $req->id;
      $getUser = User::where('user_id',$getId)->get()->first();
      $getUser->email = $req->email;
      $getUser->password = bcrypt($req->password);      
      $getUser->gender_id = $req->gender;
      $getUser->full_name = $req->fullname;
      $getUser->nick_name = $req->nickname;
      $getUser->user_type = $req->office;
      $getUser->identity_id = $req->identity;
      $getUser->address = $req->address;
      $getUser->phone = $req->phone;
      $getUser->note = $req->note;
      $getUser->work_status = $req->workstatus;
      $getUser->save();
      return Response::json(['success' => $getUser]);
   }

   public function postInsert(Request $req)
   {   

      $getValidator = Validator::make($req->all(),[
         'username' => 'unique:tbl_user,user_name',
      ],[
         'username.unique' => 'Tên đăng nhập đã tồn tại',
      ]);

      if($getValidator->passes())
      {

         $getUser = new User();
         $getUser->user_name = $req->username;
         $getUser->email = $req->email;
         $getUser->password = bcrypt($req->password);       
         $getUser->gender_id = $req->gender;
         $getUser->full_name = $req->fullname;
         $getUser->nick_name = $req->nickname;
         $getUser->user_type = $req->office;
         $getUser->identity_id = $req->identity;
         $getUser->address = $req->address;
         $getUser->phone = $req->phone;
         $getUser->note = $req->note;
         $getUser->work_status = $req->workstatus;
         $getUser->save();
         return Response::json(['success' => 'Insert Complete']);
      }
      return Response::json(['errors' => $getValidator->errors()]);
   }
}
