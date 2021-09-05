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
        'start_work',
        'end_work',
        'attendance_date',
    ];

    // A work belogs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
