<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Check if user is logged in, is a student, and has missing profile data (e.g., nis is null)
        if ($user && $user->role === 'student' && $user->student) {
            if (is_null($user->student->nis) || empty($user->student->nis)) {
                
                // Allow them to visit the setup page itself or store action without redirect loop
                if (!$request->routeIs('student.setup') && !$request->routeIs('student.setup.store') && !$request->routeIs('logout')) {
                    return redirect()->route('student.setup')->with('onboarding_nudge', true);
                }
            }
        }

        return $next($request);
    }
}
