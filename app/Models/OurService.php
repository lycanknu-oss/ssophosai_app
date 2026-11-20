<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OurService extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'icon',
        'badge_color',
        'link_url',
        'is_external',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_external' => 'boolean',
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
    ];
}
