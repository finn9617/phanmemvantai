<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use App\Http\Requests;
class Log extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_log';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable = [
        'log_id','user_id', 'url', 'access_time',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // public static function writeLog($url){

    //     $userSS = session()->get('user');
    //     $user_id = $userSS[0]->user_id; 

    //     DB::table('tbl_log')->insert([
    //         ['email' => 'taylor@example.com', 'votes' => 0],
    //         ['email' => 'dayle@example.com', 'votes' => 0]
    //     ]);


    // }
    public static function writeLog($url, $ip){

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $d =  date("Y-m-d h:i:s");
        $userSS = session()->get('user');
        $user_id = $userSS[0]->user_id; 
       // Without Query String...
       // $url = $req->url();
        // With Query String...
        // $url = $req->fullUrl(); 
        // dd($ip);
        DB::table('tbl_log')->insert( ['access_time' => $d, 'user_id'=>$user_id, 'url'=>$url, 'access_ip'=>$ip]);
    }   

}
