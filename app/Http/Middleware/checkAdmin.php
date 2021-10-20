<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkAdmin
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

        //  dd($request);
        if($request->session()->get('admin_id') == null){
            return redirect('/');
            //   }elseif($request->session()->get('user_id') != null){
            //   echo $request->session()->get('user_id');
            //return redirect('/');
        }
        return $next($request);

        // return $next($request);
    }
}
