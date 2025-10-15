<?php

namespace App\Http\Middleware;

use Closure;

class AllowOnlyAjaxRequests
{
    public function handle($request, Closure $next)
    {
        if(!$request->ajax()) {
            // Handle the non-ajax request
            return response()->view("layouts.admin_redirect");
            // return \App::abort(302, '', ['Location' => url('beranda?tab='.$request)]);
        }

        return $next($request);
    }
}
