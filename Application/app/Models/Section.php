<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "sections";

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'page',
        'section_type',
        'title',
        'title_color',
        'sub_title',
        'sub_title_color',
        'btn_text_color',
        'btn_color',
        'bg_type',
        'bg_value',
        'line_color',
        'app_icon',
        'status',
        'sort_id',
    ];
}
