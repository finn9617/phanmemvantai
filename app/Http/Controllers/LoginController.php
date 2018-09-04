<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;
use Response;
use App\User;
use Illuminate\Support\Facades\Auth;
use session;
use App\Metadata;
use DB;

class LoginController extends Controller
{
    public function index(){
        return view('gioithieu');
    }
    
    public function getLogin(){

        if(session()->get('email') != null){

            return back();

        }
        else{
            // Metadata::loadMetadata();
            return view('login');
        }
    }
    public function login(Request $request)
    {
         // if($request->session()->get('email') != null){
         //    echo "may login roi"; exit;
         // }
        // echo "xxx"; return ;
        $validator = validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required|min:4|max:20',
        ],[
            'email.required' => 'Username không được phép để trống.',
            'password.required'=>'Mật khẩu không được để trống',
            'password.min'=>'Mật khẩu không được dưới 4 ký tự',
            'password.max'=>'Mật khẩu không được quá 20 ký tự',
        ]);

        if($validator->passes())
        {
            $email = $request->input('email');
            $password = $request->input('password');
            // print_r($password);exit();
            if(Auth::attempt(['user_name'=>$email,'password'=>$password]))
                {
                    session()->push('email', $email);
                    $user = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $email)->first();
                    

              
                    // dd(strcmp("$user->ip_login","*"));
                    ///===============================================
                    Metadata::loadMetadata();
                    if(strcmp("$user->ip_login","*") != 0){
                        $ips =[];
                        if($user->ip_login != null){
                            $tmpIP = explode("::",$user->ip_login);
                            $ips = array_merge($ips,$tmpIP);
                        }


                        $currentIP = $request->ip();
                       // var_dump(Metadata::loadMetadata());exit();

                        $groupsUsers = Metadata::getGroupList('role');
                        if(!empty($groupsUsers)){
                            for($i=0; $i <count($groupsUsers); $i++){
                                if($groupsUsers[$i]['value1'] == $user->user_type ){
                                    $tmpIP = explode("::",$groupsUsers[$i]['value3']);
                                    $ips = array_merge($ips,$tmpIP);

                                    if(!in_array($currentIP, $ips))
                                     return Response::json(['permission' => 1]);
                                //     false

                             }
                         }
                     }
                 }
                 $user->token = session()->get('_token');
                 session()->push('user', $user);
                // dd($user);
                 DB::table('tbl_user')
                 ->where('user_id', $user->user_id)
                 ->update(['token' => session()->get('_token')]);
                //===============================================
                // print_r($password);exit();
                
                 return Response::json(['success' => 'Thao tác thành công']);
             }
             else
             {
                echo "error";
                exit;
            }
        }
        dd($validator->errors());

        return Response::json(['errors' => $validator->errors()]);
    }
    public function getLogout(){
        session()->flush();
        return redirect('/login');
    }
}
