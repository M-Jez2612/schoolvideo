<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    protected $fillable = [
        'school_name',
        'npsn',
        'vision',
        'mission',
        'structure',
        'facilities',
        'address',
        'phone',
        'email',
    ];

    protected $casts = [
        'facilities' => 'array',
    ];
}
