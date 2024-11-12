<?php

namespace App\Http\Controllers;

use App\Models\Grade;
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
        return view("grades", [
            "id" => $id,
            "data" => $data
        ]);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(), [
            "student_id" => "required|numeric",
            "subject_id" => "required|numeric"
        ]);

        // !: USE API HERE

        if ($valid->fails()) {
            //Add a va;idation error message
            return redirect()->back();
        }

        Grade::create([
            "student_id" => $request->student_id,
            "subject_id" => $request->subject_id
        ]);

        return redirect()->back();
    }

    public function update(Request $request)
    {
        try {
            if (!$request->has("grade_id")) {
                return response()->json([
                    "message" => "User ID is required!"
                ], 403);
            }

            $validation = Validator::make($request->all(), [
                "fullname" => "required",
                "status" => "required",
                "first_sem" => "required|numeric|min:0",
                "second_sem" => "required|numeric|min:0"
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
                "second_sem" => $second_sem
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

    public function api(Request $request)
    {
        if ($request->has("id") && $request->has("s_id")) {
            $data = DB::table("grades")
                ->select(DB::raw("
                            grades.first_sem,
                            grades.second_sem,
                            grades.id, 
                            grades.status, 
                            students.first_name, 
                            students.last_name,
                            students.middle_name
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
