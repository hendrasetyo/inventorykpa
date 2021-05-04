<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class HasRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $roles = Role::get();
            if ($request->user()->hasAnyRole($roles)) {
                return $next($request);
            } else {
                abort(403);
            }
        } else {
            //abort(403);
            return redirect('login');
        }
    }
}
