<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'table_number',
        'guests',
        'reservation_date',
        'reservation_time',
        'special_requests',
        'status',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'reservation_time' => 'datetime:H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
