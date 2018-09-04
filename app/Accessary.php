<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accessary extends Model
{
    //
    protected $table ="tbl_accessary";
	protected $fillable = [
		'accessary_id', 'full_name', 'short_name', 'num', 'unit', 'last_import', 'last_export'
	];
}
