<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Helpers;
use DB;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
		if (Auth::user()->full==0) {
			$yetki	= explode(':',$guard);
			$yetki	= Helpers::Modul($yetki[0],$yetki[1]);
			
			if($yetki==0){
				//return redirect('/');
				return response('Yetkisiz Erisim!', 401);
			}
		}
        return $next($request);
    }
}
