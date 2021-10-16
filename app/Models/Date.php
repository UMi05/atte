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


    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function works()
    {
        return $this->hasMany(Work::class);
    }
}
