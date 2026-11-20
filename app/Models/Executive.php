<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Executive extends Model
{
    protected $fillable = [
        'name',
        'position',
        'start_date',
        'end_date',
        'image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
        'is_active' => 'boolean',
    ];
}
