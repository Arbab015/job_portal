<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
         'title',
         'description',
         'job_type_id',
         'slug',
         'designation_id',

    ];

       public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
}
