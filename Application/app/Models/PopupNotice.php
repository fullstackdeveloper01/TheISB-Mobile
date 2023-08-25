<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopupNotice extends Model
{
    use HasFactory;

	protected $table = 'popup_notices';
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
        'image',
        'status'
    ];
}
