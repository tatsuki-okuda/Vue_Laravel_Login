<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

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
        if (! $request->expectsJson()) {
            // 未認証
            $user = \Str::of($request->path())->before('/');
            if(strval($user)){
                if( $user === 'user' || $user === 'admin'){
                    return route($user.'.login');
                }
                return route('user.login');
            }
            return route('welcome');
            // return route('login');
        }
    }
}
