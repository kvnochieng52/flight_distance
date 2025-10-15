<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'version',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the active terms and conditions
     */
    public static function getActive()
    {
        return self::where('is_active', true)->first();
    }
}
