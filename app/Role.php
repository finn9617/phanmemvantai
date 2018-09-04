<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'tbl_role';
    protected $fillable = [
        'role_id', 'method', 'routename', 'user_type',
    ];
	public static function isDisabled($role,$routename,$method) {
		$check = static::where('routename',$routename)->first()->toArray();
		$arrRole =array_filter( explode("::",$check['user_type']));
		if (in_array($role, $arrRole)){
			return '';
		}
		return 'disabled';
	}
	public static function hasAuth($role,$routename,$method){
		$check = static::where('routename',$routename)->first()->toArray();
		$arrRole =array_filter( explode("::",$check['user_type']));
		if (in_array($role, $arrRole)){
			return true;
		}
		return false;
	}
}
