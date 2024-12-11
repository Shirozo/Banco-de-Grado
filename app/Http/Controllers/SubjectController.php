<?php

namespace App\Http\Controllers;

use App\Exports\GradeExport;
use App\Exports\GradeGeneration;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

use function Termwind\render;

class SubjectController extends Controller
{
    public function show(Request $request)
    {
        $all = DB::table('subjects')
            ->select(
                'subjects.id',
                'subjects.subject_name',
                'subjects.school_year',
                'subjects.semester',
                DB::raw('COUNT(grades.student_id) as student_count')
            )
            ->leftJoin('grades', 'subjects.id', '=', 'grades.subject_id')
            ->groupBy('subjects.id', 'subjects.subject_name')
            ->get();

        $uniqueStudents = DB::table('students')
            ->select('students.*')
            ->join('grades', 'students.id', '=', 'grades.student_id')
            ->join('subjects', 'grades.subject_id', '=', 'subjects.id')
            ->where('subjects.instructor_id', Auth::user()->id)
            ->distinct()
            ->count();

        return view("dashboard", [
            "subjects" => $all,
            "uniqueStudents" => $uniqueStudents
        ]);
    }


    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                "subject_name" => "required|max:50",
                "semester" => "required|in:1,2",
                "sy" => "required|max:9|min:9"
            ]);


            if ($validate->fails()) {
                return response()->json([
                    "message" => "Please Check your Fields!"
                ], 403);
            }


            $subject = Subject::create([
                "subject_name" => $request->subject_name,
                "school_year" => $request->sy,
                "semester" => $request->semester,
                "instructor_id" => Auth::user()->id
            ]);

            return response()->json([
                "message" => "Subject Added!"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Server Error!"
            ], 500);
        }
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "edit_subject_name" => "required|max:50",
            "edit_id" => "required|numeric",
            "edit_semester" => "required|in:1,2",
            "edit_sy" => "required|max:9|min:9"
        ]);

        if ($validate->fails()) {
            return response()->json([
                "message" => "Please Check your Fields!"
            ], 403);
        }

        $data = Subject::find($request->edit_id);

        if ($data) {
            $data->update([
                "subject_name" => $request->edit_subject_name,
                "school_year" => $request->edit_sy,
                "semester" => $request->edit_semester
            ]);

            return response()->json([
                "message" => "Subject Updated!"
            ], 200);
        }
        return response()->json([
            "message" => "Data Not Found!"
        ], 403);
    }

    public function destroy(Request $request)
    {
        if ($request->has("delete_id")) {
            $data = Subject::find($request->delete_id);

            if ($data != null) {
                $data->delete();
                return response()->json([
                    "message" => "Subject Deleted!"
                ], 200);
            } else {
                return response()->json([
                    "message" => "Data not found!"
                ], 404);
            }
        }
        return response()->json([
            "message" => "ID not found!"
        ], 404);
    }

    public function generateReport($id, Request $request)
    {
        $sub = Subject::find($id);
        return Excel::download(new GradeExport($id), $sub->subject_name . '.xlsx');
    }
}
