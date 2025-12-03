<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class BoyApplicant extends Model
{
    protected $fillable = [
        'name'
    ];
    public function applicant(): MorphOne
    {
        return  $this->morphOne(Applicant::class, 'applicantable');
    }



    public function jobs(): MorphToMany
    {
        return $this->morphToMany(
            JobPost::class,
            'applicantable',
            'applicantables',
            'applicantable_id',
            'job_id'
        );
    }
}
