<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = 'id'; // Default to Indonesian

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->language) {
                $locale = $user->language;
            }
        } elseif (session('locale')) {
            $locale = session('locale');
        }

        // Set locale for the application
        App::setLocale($locale);

        // Set locale in session for consistency
        session(['locale' => $locale]);

        return $next($request);
    }
}
