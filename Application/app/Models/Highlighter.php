<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlighter extends Model
{
    use HasFactory;

	protected $table = 'highlighters';
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
        'status'
    ];
}
