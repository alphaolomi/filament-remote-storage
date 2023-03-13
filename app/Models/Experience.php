<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'featured_image',
    ];

    // cast the featured_image field to an array
    protected $casts = [
        'featured_image' => 'array',
    ];
}
