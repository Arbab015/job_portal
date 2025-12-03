<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class JobPost extends Model
{
    protected $fillable = [
        'title',
        'description',
        'slug',
        'job_type_id',
        'designation_id',
        'due_date',
        'address'
    ];
    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    // public function applicants(): BelongsToMany
    // {
    //     return $this->belongsToMany(Applicant::class, 'applicant_jobs', 'job_id', 'applicant_id');
    // }


    public function boyApplicants(): MorphToMany
    {
        return $this->morphedByMany(
            BoyApplicant::class,
            'applicantable',
            'applicantables',
            'job_id',
            'applicantable_id'
        );
    }

    public function girlApplicants(): MorphToMany
    {
        return $this->morphedByMany(
            GirlApplicant::class,
            'applicantable',
            'applicantables',
            'job_id',
            'applicantable_id'
        );
    }
}
