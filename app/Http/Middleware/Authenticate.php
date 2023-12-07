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
            alert()->warning('برای ادامه لطفا ابتدا وارد شوید',"سپاس");

            $url=parse_url(url()->previous());
            session(['loginLand'=>$url['path']]);
            return route('login');
        }
    }
}
