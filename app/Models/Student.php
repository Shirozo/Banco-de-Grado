<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;


class Student extends Model
{
    use Eloquence;


    protected $searchableColumns = [
        'first_name',
        'last_name',
        'middle_name',
        'student_id'
    ];


    protected $fillable = [ 
        'first_name',
        'middle_name',
        'last_name',
        'student_id',
        'course',
        'year',
        'section'
    ];
}
