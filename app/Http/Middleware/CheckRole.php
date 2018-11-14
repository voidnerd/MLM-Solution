<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Support\Facades\Auth;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

   
    public function handle($request, Closure $next, $role)
    {
        
        
        $roles = explode(':', $role);

        foreach($roles as $role) {
            if($role == $request->user()->role) {
                return $next($request);
            }
        }
     
       
        $request->session()->flash('error', 'Unauthorized!');
         return redirect('home');
        

       
       
    }
}
