<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
     protected $fillable = [
        'name',
    ];

      public function jobs()
    {
        return $this->hasMany(JobPost::class);
    }
}
