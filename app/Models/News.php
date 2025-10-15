<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'thumbnail',
        'regions',
        'posted_by',
        'date_posted',
        'is_active'
    ];

    protected $casts = [
        'date_posted' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function getRegionsArrayAttribute()
    {
        return explode(',', $this->regions);
    }
}
