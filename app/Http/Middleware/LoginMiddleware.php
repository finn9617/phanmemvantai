<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;
class LoginMiddleware
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
        if($request->session()->get('email') == null)
        {
            return redirect('/');
            // echo "null"; exit();
        }
       

        $userSS = session()->get('user');
       // dd($userSS);
        $myToken = $userSS[0]->token;
        $user_id = $userSS[0]->user_id;
        $user = DB::table('tbl_user')->select('tbl_user.*')->where('tbl_user.user_id', '=', $user_id)->first();
        if(strcmp($user->token, $myToken) != 0)
             return redirect('/logout');

        // dd(($cc[0]->token));


        // else{
        //     // echo "not null"; exit();
        // }
        return $next($request);
        
    }
}
