<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Date_User extends Model
{
    use HasFactory;

    protected $table = 'date_users';

    protected $fillable = [
        'user_id',
        'date_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function date()
    {
        return $this->belongsTo(Date::class);
    }
}
