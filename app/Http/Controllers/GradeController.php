<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        // Retreive subject data
        $subject = Subject::find($id);

        $baseQuery = DB::table("grades")
            ->join("students", "grades.student_id", "=", "students.id")
            ->where("grades.subject_id", "=", $id)
            ->whereRaw("status = 'active'");


        // Kuhaa an mga pinasar
        $passed = $baseQuery->whereRaw("grades.first_sem >= 1 AND grades.second_sem >= 1")
            ->whereRaw("((grades.first_sem + grades.second_sem) / 2) BETWEEN 1 AND 3")
            ->count();

        //  Kuhaa an mga failed
        $failed = $baseQuery->whereRaw("grades.first_sem >= 1 AND grades.second_sem >= 1")
            ->whereRaw("((grades.first_sem + grades.second_sem) / 2) > 3")
            ->count();

        // Kuhaa an wara grade
        $no_grades = DB::table("grades")
            ->join("students", "grades.student_id", "=", "students.id")
            ->where("grades.subject_id", "=", $id)
            ->whereRaw("status = 'active'")
            ->whereRaw("grades.first_sem IS NULL OR grades.second_sem IS NULL")
            ->count();

        // Kuhaa an mga dropped
        $dropped = DB::table("grades")
            ->join("students", "grades.student_id", "=", "students.id")
            ->where("grades.subject_id", "=", $id)
            ->whereRaw("status = 'dropped'")
            ->count();


        // Render the data
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
        // Check Validate User Input
        $valid = Validator::make($request->all(), [
            "student_id" => "required|numeric",
            "subject_id" => "required|numeric"
        ]);

        // Check if valid, return 403 if not
        if ($valid->fails()) {
            return response()->json([
                "message" => "Form Validation Fails"
            ], 403);
        }

        $has_data = Grade::where([
            ["student_id", "=", $request->student_id],
            ["subject_id", "=", $request->subject_id]
        ])->first();


        // Check if student already enroll, return error if already enrolled
        if ($has_data) {
            return response()->json([
                "message" => "Student is already enrolled!"
            ], 403);
        }

        // Add to db if not enrolled
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
            // Check if user has grade_id and return error if doesn't
            if (!$request->has("grade_id")) {
                return response()->json([
                    "message" => "User ID is required!"
                ], 403);
            }

            // Check if the first sem and second sem is in 0.1 - 0.9, return error
            if (($request->first_sem >= .1 && $request->first_sem < 1) ||
                ($request->second_sem >= .1 && $request->second_sem < 1)
            ) {
                return response()->json([
                    "message" => "Invalid Grade Input!"
                ], 403);
            }


            // Validate the data
            $validation = Validator::make($request->all(), [
                "fullname" => "required",
                "status" => "required",
                "first_sem" => "required|numeric",
                "second_sem" => "required|numeric"
            ]);

            // Return error if validation fails
            if ($validation->fails()) {
                return response()->json([
                    "message" => "Form Validation Fails!"
                ], 403);
            }

            $first_sem = $request->first_sem == 0 ? null : $request->first_sem;
            $second_sem = $request->second_sem == 0 ? null : $request->second_sem;

            $data = Grade::find($request->grade_id);

            // Check if student have record
            if ($data != null) {
                // Update if there's a record
                $data->update([
                    "status" => $request->status,
                    "first_sem" => $first_sem,
                    "second_sem" => $second_sem,
                    "status" => $request->status
                ]);

                return response()->json([
                    "message" => "Updated Success!"
                ], 200);
            }

            // return if no record
            return response()->json([
                "message" => "Data doesn't exist!"
            ], 403);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            // Chekk if has id, return error if no id
            if (!$request->has("delete_id")) {
                return response()->json([
                    "message" => "User ID is required!"
                ], 403);
            }

            $data = Grade::find($request->delete_id);

            // Check if there's data, return error if no data
            if ($data != null) {

                // Delete if data exist and return success
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

    public function upload(Request $request)
    {
        if ($request->has('filedata') && $request->has("subject_id")) {
            try {
                $file = $request->file('filedata');

                if (!Storage::exists("csv_uploads")) {
                    Storage::createDirectory("csv_uploads");
                }
                // $filename = Auth::user()->username . "_" . time() . '_' . $file->getClientOriginalName();
                $filename = "HEllo_world" . "_" . time() . '_' . $file->getClientOriginalName();

                $filepath = $file->storeAs("csv_uploads", $filename);

                $data = file($request->filedata);
                unset($data[0]);

                DB::beginTransaction();

                $errors = [];

                foreach ($data as $d) {
                    try {
                        $student =  Student::where("student_id", "=", trim($d))->first();

                        if ($student != null) {
                            $has_data = Grade::where([
                                ["student_id", "=", $student->id],
                                ["subject_id", "=", $request->subject_id]
                            ])->first();

                            if ($has_data == null) {
                                Grade::create([
                                    "student_id" => $student->id,
                                    "subject_id" => $request->subject_id
                                ]);
                            }
                            array_push($errors, trim($d));
                            
                        } else {
                            array_push($errors, trim($d));
                        }
                    } catch (\Throwable $th) {
                        array_push($errors, trim($d));
                    }
                }
                DB::commit();

                return response()->json([
                    'message' => 'File uploaded successfully!',
                    "errors" => $errors
                ], 200);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'Server Error!'], 403);
            }
        } else {
            return response()->json(['message' => 'No file selected!'], 403);
        }
    }
}
