<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $fillable = [
        'title',
        'description',
        'slug',
        'job_type_id',
        'designation_id',
        'due_date'
    ];
    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    
    public function applicant()
    {
        return $this->hasMany(Applicant::class);
    }
}
