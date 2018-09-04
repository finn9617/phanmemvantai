<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orderAccessary extends Model
{
    protected $table ="tbl_accessary_order";
	protected $fillable = [
		'order_accessary_id', 'order_accessary_date', 'user_id', 'import_partner_id', 'export_partner_id', 'car_id','note','order_type','import_user_id','export_user_id'
	];
	public function accessaryOrderDetail()
    {
    	return $this->hasMany(AccessaryOrderDetail::class,'order_accessary_id','order_accessary_id');
    }
}
