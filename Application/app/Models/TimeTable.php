<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;
	
	protected $table = 'calendar_events';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'title', 'start', 'end', 'student_class', 'description', 'campus', 'shift', 'section', 'student_id'
    ];
}
