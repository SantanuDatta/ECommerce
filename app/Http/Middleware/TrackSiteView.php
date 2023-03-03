<?php

namespace App\Http\Middleware;

use App\Models\SiteView;
use Closure;
use Illuminate\Http\Request;

class TrackSiteView
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
        // Get the visitor's IP address
        $ipAddress = $request->ip();

        // Check if a record already exists for the current date and IP address
        $viewCount = SiteView::where('ip_address', $ipAddress)
            ->whereDate('created_at', now())
            ->count();

        // Insert a new record if one does not already exist
        if ($viewCount == 0) {
            SiteView::create([
                'ip_address' => $ipAddress,
                'created_at' => now(),
            ]);
        }
        return $next($request);
    }
}
