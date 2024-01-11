<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the Camp that owns the Checkout
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    //relation checkout table to camp_id
    public function Camp(): BelongsTo
    {
        return $this->belongsTo(Camp::class);
    }

    //relation checkout table to user_id
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
