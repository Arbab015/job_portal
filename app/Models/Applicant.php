<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
     use SoftDeletes;
    protected $fillable = [
     'name',
     'email',
     'mobile_no',
     'notes',
     'experience',
     'skills',
     'job_id',
     'status',
     'file',
];
     public function jobPost()
    {
        return $this->belongsToMany(JobPost::class, 'applicant_jobs', 'applicant_id', 'job_id');
    }
}


