<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Query extends Model
{
    use HasFactory;

	protected $table = 'queries';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'student_id',
        'full_name',
        'phone_number',
        'your_query',
        'query_for',
        'class',
        'status'
    ];
}
