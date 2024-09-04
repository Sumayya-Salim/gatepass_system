<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gatepass extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'visitor_name',
        'visitor_email',
        'visitor_phoneno',
        'purpose',
        'entry_time',
        'exit_time',
        'status',
        'otp',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}