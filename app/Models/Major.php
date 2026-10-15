<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = ['name', 'code', 'description', 'icon'];

    public function classes()
    {
        return $this->hasMany(SchoolClass::class, 'major_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
