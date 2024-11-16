<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    //

    protected $fillable = [
        "student_id",
        "subject_id",
        "first_sem",
        "second_sem",
        "status"
    ];
}
