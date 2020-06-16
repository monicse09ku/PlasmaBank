<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
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
        if ($request->user()->isSuperAdmin() || $request->user()->isAdmin()) {
            return $next($request);
        }

        $actions = $request->route()->getAction();

        $role = (isset($actions['roles'])) ? $actions['roles'] : null;

        if ($request->user()->hasRole($role)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return respondError('Insufficient Permissions!', 403);
        }

        flash('Insufficient Permissions!', 'danger');
        return redirect()->to('/');
    }
}
