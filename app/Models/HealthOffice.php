<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HealthOffice extends Model
{
    protected $table = 'healthoffice';

    protected $fillable = [
        'name',
        'hospcode9_new',
        'hospcode9',
        'hospcode5',
        'license_no',
        'org_type',
        'service_unit_type',
        'ministry',
        'department',
        'hospital_level',
        'network_node_type',
        'actual_beds',
        'usage_status',
        'health_region',
        'address',
        'province_code',
        'province_name',
        'district_code',
        'district_name',
        'subdistrict_code',
        'subdistrict_name',
        'moo',
        'zipcode',
        'parent_hospital',
        'established_date',
        'closed_date',
        'source_updated_at',
    ];

    protected $casts = [
        'actual_beds'       => 'integer',
        'established_date'  => 'date',
        'closed_date'       => 'date',
        'source_updated_at' => 'datetime',
    ];
}
