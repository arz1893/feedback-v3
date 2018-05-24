<?php

namespace App\Http\Middleware\UserManagement;

use Closure;
use Illuminate\Support\Facades\Auth;

class UserManagementPermit
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
        if(Auth::guest() || Auth::user()->user_group->name != 'Administrator') {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
