<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Termwind\Components\Raw;

class GradeController extends Controller
{

    public function show($id, Request $request)
    {

        $data = DB::table("grades")
            ->select(DB::raw("
                        grades.first_sem,
                        grades.second_sem,
                        grades.id, 
                        grades.status, 
                        grades.student_id, 
                        students.first_name, 
                        students.last_name,
                        students.middle_name
                    "))
            ->join("students", "grades.student_id", "=", "students.id")
            ->where("grades.subject_id", "=", $id)
            ->get();

        $subject = Subject::find($id);

        $baseQuery = DB::table("grades")
            ->join("students", "grades.student_id", "=", "students.id")
            ->where("grades.subject_id", "=", $id)
            ->whereRaw("status = 'active'");

        $passed = $baseQuery->whereRaw("grades.first_sem >= 1 AND grades.second_sem >= 1")
            ->whereRaw("((grades.first_sem + grades.second_sem) / 2) BETWEEN 1 AND 3")
            ->count();

        $failed = $baseQuery->whereRaw("grades.first_sem >= 1 AND grades.second_sem >= 1")
            ->whereRaw("((grades.first_sem + grades.second_sem) / 2) > 3")
            ->count();

        $no_grades = DB::table("grades")
            ->join("students", "grades.student_id", "=", "students.id")
            ->where("grades.subject_id", "=", $id)
            ->whereRaw("status = 'active'")
            ->whereRaw("grades.first_sem IS NULL OR grades.second_sem IS NULL")
            ->count();

        $dropped = DB::table("grades")
            ->join("students", "grades.student_id", "=", "students.id")
            ->where("grades.subject_id", "=", $id)
            ->whereRaw("status = 'dropped'")
            ->count();



        return view("grades", [
            "subject" => $subject,
            "data" => $data,
            "passed" => $passed,
            "failed" => $failed,
            "no_grades" => $no_grades,
            "dropped" => $dropped
        ]);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            "student_id" => "required|numeric",
            "subject_id" => "required|numeric"
        ]);

        if ($valid->fails()) {
            return response()->json([
                "message" => "Form Validation Fails"
            ], 403);
        }

        $has_data = Grade::where([
            ["student_id", "=", $request->student_id],
            ["subject_id", "=", $request->subject_id]
        ])->first();
        
        if ($has_data) {
            return response()->json([
                "message" => "Student is already enrolled!"
            ], 403);
        }

        Grade::create([
            "student_id" => $request->student_id,
            "subject_id" => $request->subject_id
        ]);

        return response()->json([
            "message" => "Student enrolled!"
        ], 200);
    }

    public function update(Request $request)
    {
        try {
            if (!$request->has("grade_id")) {
                return response()->json([
                    "message" => "User ID is required!"
                ], 403);
            }

            if (($request->first_sem >= .1 && $request->first_sem < 1) ||
                ($request->second_sem >= .1 && $request->second_sem < 1)
            ) {
                return response()->json([
                    "message" => "Invalid Grade Input!"
                ], 403);
            }

            $validation = Validator::make($request->all(), [
                "fullname" => "required",
                "status" => "required",
                "first_sem" => "required|numeric",
                "second_sem" => "required|numeric"
            ]);

            if ($validation->fails()) {
                return response()->json([
                    "message" => "Form Validation Fails!"
                ], 403);
            }

            $first_sem = $request->first_sem == 0 ? null : $request->first_sem;
            $second_sem = $request->second_sem == 0 ? null : $request->second_sem;

            $data = Grade::find($request->grade_id);

            $data->update([
                "status" => $request->status,
                "first_sem" => $first_sem,
                "second_sem" => $second_sem,
                "status" => $request->status
            ]);

            return response()->json([
                "message" => "Updated Success!"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            if (!$request->has("delete_id")) {
                return response()->json([
                    "message" => "User ID is required!"
                ], 403);
            }

            $data = Grade::find($request->delete_id);
            
            if ($data != null) {
                $data->delete();
                return response()->json([
                    "message" => "Deleted Success!"
                ], 200);
            }

            return response()->json([
                "message" => "Carnt Find User"
            ], 403);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function api(Request $request)
    {
        if ($request->has("id") && $request->has("s_id")) {
            $data = DB::table("grades")
                ->select(DB::raw("
                            students.first_name, 
                            students.last_name,
                            students.middle_name,
                            students.course,
                            students.student_id,
                            students.year,
                            students.section,
                            grades.first_sem,
                            grades.second_sem,
                            grades.id, 
                            grades.status
                        "))
                ->join("students", "grades.student_id", "=", "students.id")
                ->where([
                    ["grades.subject_id", "=", $request->s_id],
                    ["grades.student_id", "=", $request->id]
                ])->first();

            if ($data != null) {
                return response()->json($data, 200);
            }
            return response()->json([
                "message" => "Can't Find the data!"
            ]);
        }
        return response()->json([
            "message" => "Invalid Parameters"
        ], 404);
    }
}
