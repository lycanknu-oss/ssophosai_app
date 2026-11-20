<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationJob extends Model
{
    protected $fillable = [
        'workgroup_id',
        'code',
        'name',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function workgroup(): BelongsTo
    {
        return $this->belongsTo(OrganizationWorkgroup::class, 'workgroup_id');
    }
}
