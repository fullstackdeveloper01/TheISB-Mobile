<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'campus',
        'shift',
        'class_id',
        'section',
        'student_id',
        'title',
        'homework_type',
        'assignment',
        'academic_year',
        'status'
    ];
}
