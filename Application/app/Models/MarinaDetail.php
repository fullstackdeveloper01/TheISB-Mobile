<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarinaDetail extends Model
{
    protected $table = 'marina_details';
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'marina_id',
        'description',
        'book_show_status',
        'number_of_berth',
        'type_of_berth',
        'max_draft',
        'max_length',
        'cancellation_policy',
        'getting_to_marina',
        'status',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'marina_id', 'id');
    }
}
