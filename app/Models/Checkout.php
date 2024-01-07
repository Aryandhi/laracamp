<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Checkout extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'camp_id', 
        'user_id', 
        'card_number', 
        'expired', 
        'cvc', 
        'is_paid'
    ];

    public function setExpiredAttribute($value) 
    {
        $this->attributes['expired'] = Carbon::parse($value)->endOfMonth()->toDateString();
    }

}
