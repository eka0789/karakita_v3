<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectByRole
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $role = auth()->user()->roles->first()->name ?? null;

            switch ($role) {
                case 'admin': return redirect()->route('admin.dashboard');
                case 'pengajar': return redirect()->route('teacher.dashboard');
                case 'orangtua': return redirect()->route('parent.dashboard');
                case 'siswa': return redirect()->route('student.dashboard');
            }
        }

        return $next($request);
    }
}
