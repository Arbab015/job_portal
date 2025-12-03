<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class applicantable extends Model
{
    protected $table = 'applicantables';

    protected $fillable = [

        'job_id',
        'applicantable_id',
        'applicantable_type',
    ];

    public function applicantable()
    {
        return $this->morphTo();
    }
}
