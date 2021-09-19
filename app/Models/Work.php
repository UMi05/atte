<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $table = 'works';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'date_id',
        'start_work',
        'end_work',
    ];

    protected $dates = [
        'start_work',
        'end_work'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function date()
    {
        return $this->belongsTo(Date::class);
    }

    public function rests() {
        return $this->hasMany(Rest::class);
    }
}
