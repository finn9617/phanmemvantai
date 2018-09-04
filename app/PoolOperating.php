<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PoolOperating extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_pool_operating';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'pool_id';

    public $timestamps = false;


    // protected $fillable = [
    //     'user_id','name', 'email', 'password',

    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
}
