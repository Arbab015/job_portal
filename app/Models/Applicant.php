<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
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

    public function jobpost()
    {
        return $this->belongsTo(JobPost::class);
    }
}


