<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintsRaise extends Model
{
    use HasFactory;

    protected $table = 'raise_complaints';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'id',
        'type',
        'student_id',
        'student_name',
        'father_name',
        'mother_name',
        'student_class',
        'student_section',
        'student_shift',
        'student_mobile',
        'student_complaint',
        'student_other_complaint',
        'status'
    ];
    
    /**
     * Relation with complaint type
     *
     * @var string[]
     */
    public function complaintType(){
        return $this->belongsTo(ComplaintType::class, 'student_complaint');
    }
}
