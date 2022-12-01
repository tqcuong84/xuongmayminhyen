<?php

namespace App\Http\Middleware;
use Illuminate\Pagination\Paginator;
use Closure;

class AdminLoadMainMenuMiddleware
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
        Paginator::useBootstrap();
        
        $admin_menu = config("adminmenu.menu");
        \View::share('admin_menus', $admin_menu);

        return $next($request);
    }
}
