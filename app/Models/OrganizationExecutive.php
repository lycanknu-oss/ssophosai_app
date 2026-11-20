<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationExecutive extends Model
{
    protected $fillable = [
        'name',
        'position',
        'start_year',
        'end_year',
        'image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
