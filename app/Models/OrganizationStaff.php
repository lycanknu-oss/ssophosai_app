<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationStaff extends Model
{
    protected $table = 'organization_staffs';

    protected $fillable = [
        'name',
        'position',
        'employment_type',
        'admin_position',
        'workgroup_priority',
        'workgroup_id',
        'job_id',
        'workgroup_name',
        'image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'workgroup_priority' => 'integer',
        'workgroup_id'       => 'integer',
        'job_id'             => 'integer',
        'is_active'          => 'boolean',
    ];

    public function workgroup(): BelongsTo
    {
        return $this->belongsTo(OrganizationWorkgroup::class, 'workgroup_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(OrganizationJob::class, 'job_id');
    }

    public static function employmentTypes(): array
    {
        return [
            'ข้าราชการ',
            'พนักงานราชการ',
            'พกส.',
            'ลูกจ้างชั่วคราว(รายวัน)',
            'ลูกจ้างชั่วคราว(รายคาบ)',
            'ลูกจ้างชั่วคราว(รายเดือน)',
        ];
    }

    public static function priorityGroups(): array
    {
        return [
            1 => '1. ผู้บริหาร',
            2 => '2.1 รองผู้บริหาร (กลุ่มภารกิจ)',
            3 => '2.2 ผู้ช่วยผู้บริหาร',
            4 => '3. หัวหน้ากลุ่มงาน',
            5 => '4. หัวหน้างาน',
            6 => '5. เจ้าหน้าที่',
        ];
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::priorityGroups()[$this->workgroup_priority] ?? '5. เจ้าหน้าที่';
    }
}
