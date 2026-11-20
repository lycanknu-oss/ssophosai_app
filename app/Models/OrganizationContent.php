<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationContent extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'content',
        'image_path',
        'updated_by',
    ];

    public static function sections(): array
    {
        return [
            'general'        => 'ข้อมูลทั่วไป',
            'policy'         => 'นโยบายผู้บริหาร',
            'vision_mission' => 'วิสัยทัศน์ พันธกิจ',
            'structure'      => 'ข้อมูลโครงสร้างองค์กร',
            'staff_chart'    => 'ผังบุคลากร',
        ];
    }
}
