<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flat extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'flat_no',
        'flat_type',
        'furniture_type',
    ];
}