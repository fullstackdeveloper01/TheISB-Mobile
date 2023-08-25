<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;

	protected $table = 'notice_boards';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'title',
        'notice_type',
        'image',
        'content',
        'notice_date',
        'status',
        'campus',
        'shift',
        'class_id',
        'section',
        'student_id'
    ];
}
