<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class checkAuthController extends Controller
{
	public static function getArrUsertype($arr){
		$arr = explode("::", $arr);
		return $arr;
	}
    public static function checkAuth($routename, $method , $currentUser_type){
    	$role = DB::table('tbl_role')->where('tbl_role.routename','=',$routename)->where('tbl_role.method','=',$method)->get();
    	$user_type = DB::table('tbl_role')->where('tbl_role.routename','=',$routename)->where('tbl_role.method','=',$method)->select('tbl_role.user_type')->get();
    	$arrUser_type = checkAuthController::getArrUsertype($user_type[0]->user_type);
    	//print_r($arrUser_type);
    	// print_r($currentUser_type);
    	$flag = 0;
    	for($i = 0 ; $i < count($arrUser_type) ; $i++){
	    	if($arrUser_type[$i] == $currentUser_type){
	    		$flag = 1;
	    	}
	    }
	    if($flag == 1) return true ;
	    else return false;
    }
}
