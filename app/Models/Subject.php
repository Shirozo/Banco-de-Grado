<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        "subject_name",
        "instructor_name",
        "school_year"
    ];
}
