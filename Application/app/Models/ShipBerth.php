<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipBerth extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'length',
        'width',
        'depth',
        'rotation',
        'additional_params',
        'map_type',
        'lat',
        'lng',
        'coordinates',
        'status',
    ];

    // public function booking(){
    //     // Has one and only return the booking which is the latest and reserved
    //     return $this->hasOne(BerthBooking::class)
    //         ->latest()
    //         ->where('checkout_date', '>=', date('Y-m-d'))
    //         ->where('status', 'reserved');
    // }

}
