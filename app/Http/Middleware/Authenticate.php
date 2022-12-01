<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('admin.login');
        } else {
            return response()->json([
                'error' => 'Unauthorized!'
            ], 401);
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);
        if (!Auth::guest()) {
            if (Auth::check()) {
                return $next($request);
            } else {
                return redirect(route('admin.login'));
            }
        }

        return redirect()->guest(route('admin.login'));
    }
}
