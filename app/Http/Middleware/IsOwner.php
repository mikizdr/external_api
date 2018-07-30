<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\UserIsOwnerService;

class IsOwner
{
    /**
     * Handle an incoming request.
     * Laravel version: 5.6.26
     * Implementation: $this->post('login', 'Auth\LoginController@login')->middleware('is.owner');
     * In \vendor\laravel\framework\src\Illuminate\Routing\Router.php line 1133
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!UserIsOwnerService::isOwner($request)) {
            return redirect('login');
        }
        return $next($request);
    }
}
