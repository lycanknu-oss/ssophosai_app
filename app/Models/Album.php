<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Album extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'activity_date',
        'cover_image',
        'is_active',
    ];

    protected $casts = [
        'activity_date' => 'date:Y-m-d',
        'is_active' => 'boolean',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(AlbumPhoto::class)->orderBy('sort_order')->orderBy('id');
    }
}
