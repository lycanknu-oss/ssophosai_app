<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && !$user->isApproved()) {
            $status = $user->status;
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $message = $status === 'waiting'
                ? 'บัญชีของท่านอยู่ระหว่างรออนุมัติจากผู้ดูแลระบบ (Admin) กรุณารอการยืนยันก่อนเข้าใช้งาน'
                : 'บัญชีของท่านถูกระงับการใช้งาน กรุณาติดต่อผู้ดูแลระบบ';

            return redirect()->route('login')->withErrors(['email' => $message]);
        }

        return $next($request);
    }
}
