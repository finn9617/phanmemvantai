<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PoolOperatingTool extends Model
{
    use Notifiable;

    protected $table = 'tbl_pool_operating_tool';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $primaryKey = 'operating_tool_id';

    public $timestamps = false;
}
