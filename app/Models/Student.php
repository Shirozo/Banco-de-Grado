<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;


class Student extends Model
{
    use Eloquence;


    protected $searchableColumns = [
        'name',
        'student_id'
    ];


    protected $fillable = [ 
        'name',
        'student_id',
        'course',
        'year',
        'section'
    ];
}
