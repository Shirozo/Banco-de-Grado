<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function show(Request $request)
    {
        $section = DB::table('students')->distinct()->pluck('section');

        $courses = DB::table('students')->distinct()->pluck('course');

        $data = Student::all();

        return view("index", [
            "section" => $section,
            "courses" => $courses,
            "data" => $data
        ]);
    }

    public function api(Request $request)
    {

        $query = Student::query();


        if (!is_null($request->course)) {
            $query->where('course', $request->course);
        }

        if (!is_null($request->year)) {
            $query->where('year', $request->year);
        }

        if (!is_null($request->section)) {
            $query->where('section', $request->section);
        }

        $filteredStudents = $query->get();

        return response()->json($filteredStudents);
    }
}
