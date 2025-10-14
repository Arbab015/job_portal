<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    protected $fillable = [
        'title',
    ];

     public function jobs()
    {
        return $this->hasMany(JobPost::class);
    }
    
}
