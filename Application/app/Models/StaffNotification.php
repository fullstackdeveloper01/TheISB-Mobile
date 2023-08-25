<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffNotification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $table = 'staff_notifications';

    protected $fillable = [
        'id',
        'notification_id',
        'staff_id',
        'title',
        'message',
        'device_id',
        'image',
        'type',
        'status',
    ];
}
