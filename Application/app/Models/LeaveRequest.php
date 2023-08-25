<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'student_id',
        'class_id',
        'student_name',
        'father_name',
        'start_date',
        'end_date',
        'reason_for_leave',
        'other_reason',
        'application',
        'extension',
        'status'
    ];
}
