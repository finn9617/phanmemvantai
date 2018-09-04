<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
	protected $table ="tbl_menu";
	protected $fillable = [
		'menu_id', 'menu_parent_id', 'title', 'url', 'url2', 'url3', 'roles'
	];


	public static function canAccess($arrMenu, $menu_id, $user_role){
		foreach ($arrMenu as $menu) {
			if($menu['menu_id'] == $menu_id){
				$strRoles = $menu['roles'];

				$arrRole =array_filter( explode("::",$strRoles));
				// echo "<pre>";
				// print_r($arrRole);
				// echo "</pre>";

				// echo "-------------------------------";
				// unset($arrRole[2]);
				// echo "<pre>";
				// print_r($arrRole);
				// echo "</pre>";

				if (in_array($user_role, $arrRole)){
					return true;
				}
			}
		}
		return false;
	}
}
