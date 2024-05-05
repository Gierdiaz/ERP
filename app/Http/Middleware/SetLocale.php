<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $lang = null;

        $user = Auth::user();

        if ($user && $user->language) {
            $lang = $user->language;
        } elseif ($request->hasHeader('Accept-Language')) {
            $lang = $request->header('Accept-Language');
        }

        app()->setLocale($lang ?: 'en');

        return $next($request);
    }
}
