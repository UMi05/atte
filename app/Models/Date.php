<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'dates';

    protected $fillable = [
        'date'
    ];

    protected $dates = [
        'date'
    ];

    public function user()
    {
        return $this->belongsToMany(Date_User::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }
}
