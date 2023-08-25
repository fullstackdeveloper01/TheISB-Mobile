<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

	protected $table = 'events';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'title',
        'image',
        'short_description',
        'content',
        'event_type',
        'event_date',
        'status',
        'campus',
        'shift',
        'class_id',
        'section',
        'student_id'
    ];
}
