<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBoat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'user_id',
        'boat_name',
        'boat_type',
        'boat_country_flag',
        'length',
        'draught',
        'width',
        'image',
        'status'
    ];

    /**
     * User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Boat 
     */
    public function boatType()
    {
        return $this->belongsTo(BoatType::class, 'boat_type');
    }
}
