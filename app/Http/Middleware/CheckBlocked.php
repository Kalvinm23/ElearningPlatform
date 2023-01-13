<?php

namespace App\Http\Middleware;

use Closure;

class CheckBlocked
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
        if (auth()->check()) 
        {
        if (auth()->user()->status == 2) {   
           auth()->logout();     
           return redirect()->route('login')->with('error', 'Your account has been blocked. Please contact Premier Training for more information');      
          }            
         } 
        return $next($request);
    }
}
