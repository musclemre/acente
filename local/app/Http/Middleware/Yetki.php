<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use DB;

class Yetki
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
		if (Auth::user()->full==0) {

			$u_modul	= DB::table('users_modul')->where('user_id',Auth::user()->id)->get();
			$modul= array();
			foreach($u_modul as $d){
				$modul[$d->modul]= $d;
			}
			session()->put('modul', $modul);
		}
        return $next($request);
    }
}
