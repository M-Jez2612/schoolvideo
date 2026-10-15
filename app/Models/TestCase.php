<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    protected $fillable = [
        'case_number',
        'feature',
        'scenario',
        'expected_result',
        'status',
        'notes',
    ];
}
