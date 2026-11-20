<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shortcut extends Model
{
    protected $fillable = [
        'title',
        'description',
        'url',
        'icon',
        'color_theme',
        'open_new_tab',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'open_new_tab' => 'boolean',
        'is_active' => 'boolean',
    ];
}
