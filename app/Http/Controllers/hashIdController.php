<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class hashIdController extends Controller
{
    public static function hashID($id,$str){
    	$idString_hash = 'hash'.$id.'_'.$str;
    	$idString_hash = Hash::make($idString_hash);
    	return $idString_hash;
    }
    public static function rehashID($id,$str){
    	
    }
}
