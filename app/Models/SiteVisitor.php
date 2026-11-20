<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteVisitor extends Model
{
    protected $fillable = [
        'visit_date',
        'ip_hash',
        'hits',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    /**
     * บันทึกการเข้าชมเว็บไซต์ (นับ 1 คนต่อ 1 วัน เพื่อความแม่นยำ)
     */
    public static function recordVisit(Request $request): void
    {
        $today  = now()->toDateString();
        $ipHash = hash('sha256', ($request->ip() ?? '0.0.0.0') . '|' . substr((string) $request->userAgent(), 0, 120));

        $visitor = static::where('visit_date', $today)
            ->where('ip_hash', $ipHash)
            ->first();

        if ($visitor) {
            $visitor->increment('hits');
        } else {
            static::create([
                'visit_date' => $today,
                'ip_hash'    => $ipHash,
                'hits'       => 1,
            ]);
        }
    }

    /**
     * จำนวนผู้เยี่ยมชมวันนี้
     */
    public static function todayCount(): int
    {
        return static::where('visit_date', now()->toDateString())->count();
    }

    /**
     * จำนวนผู้เยี่ยมชมทั้งหมด
     */
    public static function totalCount(): int
    {
        return static::count();
    }
}
