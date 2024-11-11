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

    public function api(Request $request) {
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
