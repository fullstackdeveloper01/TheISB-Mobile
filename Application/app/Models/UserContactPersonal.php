<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserContactPersonal extends Model
{
    protected $table = 'user_contact_persons';
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'contact_person_image',
        'contact_person_firstname',
        'contact_person_surname',
        'contact_person_email',
        'contact_person_website',
        'contact_person_mobile',
        'cancellation_description',
        'check_in_description',
        'check_out_description',
        'berth_capacity',
        'max_boat_length',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
