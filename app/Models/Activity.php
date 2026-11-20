<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'category',
        'title',
        'summary',
        'content',
        'cover_image',
        'attachment_path',
        'published_date',
        'views',
        'is_pinned',
        'is_active',
        'is_popup',

    ];

    protected $casts = [
        'published_date' => 'date:Y-m-d',
        'is_pinned' => 'boolean',
        'is_active' => 'boolean',
        'is_popup' => 'boolean',
    ];

    // ชื่อหมวดหมู่ภาษาไทย
    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'recruitment' => 'ข่าวรับสมัครงาน',
            'procurement' => 'ข่าวจัดซื้อจัดจ้าง',
            default => 'ข่าวทั่วไป',
        };
    }
}
