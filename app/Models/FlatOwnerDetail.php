<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlatOwnerDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'flat_id',
        'owner_name',
        'members',
        'park_slott',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // FlatOwner.php
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($flatowner) {
            // Delete the associated user
            $flatowner->user()->delete();
        });
    }
}
