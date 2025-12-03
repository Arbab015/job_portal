<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
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
        'applicantable_id',
        'applicantable_type',
    ];
    // public function jobPost()
    // {
    //     return $this->belongsToMany(JobPost::class, 'applicant_jobs', 'applicant_id', 'job_id');
    // }

    public function applicantable(): MorphTo
    {
        return $this->morphTo();
    }
    public function jobPosts()
    {
        return $this->applicantable->jobs();
    }
}
