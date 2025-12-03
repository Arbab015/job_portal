<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compression extends Model
{
    protected $fillable = [
        'file',
        'filetype',
        'size_before',
        'size_after',
    ];
}
