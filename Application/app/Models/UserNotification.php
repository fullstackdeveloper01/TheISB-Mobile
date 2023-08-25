<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'notification_id',
        'student_id',
        'user_id',
        'title',
        'message',
        'device_id',
        'image',
        'type',
        'type_for',
        'link',
        'status',
    ];
}
