<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuPermission
{
    public function handle(Request $request, Closure $next, string $menu): Response
    {
        $user = $request->user();

        if (!$user || !$user->canAccessMenu($menu)) {
            abort(403, 'คุณไม่มีสิทธิ์เข้าถึงเมนูนี้ (สงวนสิทธิ์ตามระดับผู้ใช้งาน)');
        }

        return $next($request);
    }
}
