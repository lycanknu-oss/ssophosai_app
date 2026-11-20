<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'badge',
        'title',
        'subtitle',
        'image_path',
        'sort_order',
        'is_popup',
        'is_active',
    ];

    protected $casts = [
        'is_popup'  => 'boolean',
        'is_active' => 'boolean',
    ];
}
