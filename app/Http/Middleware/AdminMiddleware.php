<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$tmpemail = Session::get('email');
	    $sess_email = end($tmpemail);
	    $sess_users = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_name', '=', $sess_email)->get();
	    $currentUser_type =$sess_users[0]->user_type;
        if($currentUser_type == 1 || $currentUser_type == 16)
        {
         	return $next($request);   
            // echo "null"; exit();
        }
        // else{
        //     // echo "not null"; exit();
        // }
        return redirect()->back();
        
        
    }
}
