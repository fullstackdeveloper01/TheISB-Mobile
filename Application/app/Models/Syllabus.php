<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;



class Syllabus extends Model

{

    use HasFactory;



	protected $table = 'syllabus';

    /**

     * The attributes that are mass assignable.

     *

     * @var string[]

     */

    protected $fillable = [
        'id',
        'class_name',
        'academic_year',
        'syllabus',
        'type',
        'campus',
        'shift',
        'section',
        'student_id',
        'status'
    ];

}

