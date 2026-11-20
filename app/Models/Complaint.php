<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'tracking_code',
        'category',
        'target_unit',
        'subject',
        'details',
        'incident_date',
        'attachment_path',
        'is_anonymous',
        'complainant_name',
        'complainant_phone',
        'complainant_email',
        'status',
        'admin_response',
        'resolved_at',
        'ip_address',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'is_anonymous'  => 'boolean',
        'resolved_at'   => 'datetime',
    ];

    public function getStatusLabelAttribute(): array
    {
        return match ($this->status) {
            'in_progress' => ['text' => 'กำลังตรวจสอบข้อเท็จจริง', 'class' => 'bg-sky-50 text-[#1675E8] border-sky-200'],
            'resolved'    => ['text' => 'ดำเนินการแล้วเสร็จ', 'class' => 'bg-emerald-50 text-[#16A34A] border-emerald-200'],
            'rejected'    => ['text' => 'ยุติเรื่อง / ข้อมูลไม่ครบถ้วน', 'class' => 'bg-rose-50 text-[#EF4444] border-rose-200'],
            default       => ['text' => 'รอรับเรื่อง / พิจารณา', 'class' => 'bg-amber-50 text-[#F59E0B] border-amber-200'],
        };
    }
}
