<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendPushNotification extends Model
{
    use HasFactory;

	protected $table = 'send_push_notification';
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'template_id',
        'app_name',
        'campus',
        'shift',
        'class_id',
        'section',
        'student_id',
        'title',
        'message',
        'image',
        'redirection',
        'academic_year',
        'status',
    ];
}
