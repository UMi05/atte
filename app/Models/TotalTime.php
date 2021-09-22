<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalTime extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'work_time',
        'rest_time'
    ];
}
