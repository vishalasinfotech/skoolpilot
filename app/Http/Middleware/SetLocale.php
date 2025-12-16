<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Language;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get locale from session or use default from database
        $locale = Session::get('locale');

        if (! $locale) {
            // Get default language from database
            $locale = Language::getDefaultCode();
        }

        // Validate locale against database
        $language = Language::where('code', $locale)
            ->where('is_active', true)
            ->first();

        if (! $language) {
            // Fallback to default language
            $locale = Language::getDefaultCode();
        }

        // Set application locale
        App::setLocale($locale);

        return $next($request);
    }
}
