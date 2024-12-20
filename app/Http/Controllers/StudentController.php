<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function show(Request $request)
    {
        $students = Student::all();

        return view("students", [
            "students" => $students
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = Validator::make($request->all(), [
                "name" => "required|max:100",
                "student_id" => "required|max:8|min:8",
                "course" => "required|max:50",
                "year" => "required|integer",
                "section" => "required|in:A,B,C,D"
            ]);

            if ($data->fails()) {
                return response()->json([
                    "message" => "Data Validation Fails!"
                ], 403);
            }

            $has_data = Student::where("student_id", "=", $request->student_id)->first();

            if ($has_data) {
                return response()->json([
                    "message" => "Student with the ID already exist!"
                ], 403);
            }

            Student::create([
                "name" => $request->name,
                "student_id" => $request->student_id,
                "course" => $request->course,
                "year" => $request->year,
                "section" => $request->section
            ]);

            return response()->json([
                "message" => "Student Added!"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            if (!$request->has("id")) {
                return response()->json([
                    "message" => "Student id don't exist!"
                ], 404);
            }

            $data = Validator::make($request->all(), [
                "update_name" => "required|max:100",
                "update_student_id" => "required|max:8|min:8",
                "update_course" => "required|max:50",
                "update_year" => "required|integer",
                "update_section" => "required|in:A,B,C,D"
            ]);

            if ($data->fails()) {
                return response()->json([
                    "message" => "Data Validation Fails!"
                ], 403);
            }

            $has_data = Student::where("id", "=", $request->id)->first();

            if (!$has_data) {
                return response()->json([
                    "message" => "Student data don't exist!"
                ], 404);
            }

            $has_data->update([
                "name" => $request->update_name,
                "student_id" => $request->update_student_id,
                "course" => $request->update_course,
                "year" => $request->update_year,
                "section" => $request->update_section
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        try {
            if ($request->has("delete_id")) {

                $data = Student::find($request->delete_id);

                if ($data) {
                    $data->delete();
                    return response()->json([
                        "message" => "Student deleted!"
                    ], 200);
                }
                return response()->json([
                    "message" => "Student data not found!"
                ], 404);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function dataApi(Request $request)
    {
        if ($request->has("id") && $request->has("i_id")) {
            $personal = Student::find($request->id);
            $grades = DB::table('grades')
                ->join('subjects', 'subjects.id', '=', 'grades.subject_id')
                ->select(
                    'grades.id',
                    'grades.first_sem',
                    'grades.second_sem',
                    'subjects.subject_name',
                    'subjects.school_year'
                )
                ->whereIn('grades.subject_id', function ($query) use ($request) {
                    $query->select('id')
                        ->from('subjects')
                        ->where('instructor_id', $request->i_id);
                })
                ->where('grades.student_id', $request->id)
                ->orderBy('subjects.school_year')
                ->get();


            if ($personal) {
                return response()->json([
                    "personal" => $personal,
                    "grades" => $grades
                ]);
            }

            return response()->json([
                "message" => "Can't find student data!"
            ], 403);
        }
        return response()->json([
            "message" => "Missing ID!"
        ], 403);
    }

    public function all(Request $request)
    {
        if ($request->has("id")) {
            $personal = Student::find($request->id);

            if (!$personal) {
                return response()->json([
                    "message" => "Student Don't Exist!"
                ], 200);
            }

            $grades = DB::table('grades')
                ->join('subjects', 'subjects.id', '=', 'grades.subject_id')
                ->select(
                    'grades.id',
                    'grades.first_sem',
                    'grades.second_sem',
                    'subjects.subject_name',
                    'subjects.school_year'
                )->where('grades.student_id', $request->id)
                ->orderBy('subjects.school_year')
                ->get();

            return response()->json([
                "personal" => $personal,
                "grades" => $grades
            ]);
        }

        return response()->json([
            "message" => "Can't find student data!"
        ], 403);
    }

    public function unique_sy(Request $request)
    {

        $schoolYears = DB::table('grades')
            ->join('subjects', 'subjects.id', '=', 'grades.subject_id')
            ->select('subjects.school_year')
            ->where('grades.student_id', $request->id)
            ->distinct()
            ->orderBy('subjects.school_year')
            ->get();

        return response()->json([
            "sy" => $schoolYears
        ]);
    }



    public function api(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $datas = Student::search($term)->limit(3)->get();

        $formatted_data = [];

        foreach ($datas as $data) {
            $formatted_data[] = [
                "id" => $data->id,
                "text" => $data->name
            ];
        }

        return response()->json($formatted_data);
    }

    public function upload(Request $request)
    {
        if ($request->has('filedata')) {
            try {
                $file = $request->file('filedata');
                if (!Storage::exists("csv_uploads_students")) {
                    Storage::createDirectory("csv_uploads_students");
                }
                // $filename = Auth::user()->username . "_" . time() . '_' . $file->getClientOriginalName();
                $filename = "HEllo_world" . "_" . time() . '_' . $file->getClientOriginalName();

                $filepath = $file->storeAs("csv_uploads_students", $filename);

                $handle = fopen($file->getRealPath(), 'r');
                fgetcsv($handle);
                DB::beginTransaction();

                $errors = [];

                while (($data = fgetcsv($handle)) !== false) {
                    list($student_id, $name, $course, $year, $section) = array_map('trim', $data);
                    try {

                        $valid = Validator::make([
                            'student_id' => $student_id,
                            'name' => $name,
                            'course' => $course,
                            'year' => $year,
                            'section' => $section
                        ], [
                            "name" => "required|max:100",
                            "student_id" => "required|max:8|min:8",
                            "course" => "required|max:50",
                            "year" => "required|integer",
                            "section" => "required|max:1"
                        ]);

                        if ($valid->fails()) {
                            array_push($errors, trim($student_id));
                        } else {
                            $student = Student::where('student_id', $student_id)->first();

                            if ($student) {
                                $student->update([
                                    "name" => $name,
                                    "student_id" => $student_id,
                                    "course" => $course,
                                    "year" => $year,
                                    "section" => $section
                                ]);
                            } else {
                                Student::create([
                                    "name" => $name,
                                    "student_id" => $student_id,
                                    "course" => $course,
                                    "year" => $year,
                                    "section" => $section
                                ]);
                            }
                        }
                    } catch (\Exception $e) {
                        array_push($errors, trim($student_id));
                    }
                }

                fclose($handle);

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
