<?php

namespace App\Http\Controllers;

use App\Exports\GradeExport;
use App\Exports\GradeGeneration;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

use function Termwind\render;

class SubjectController extends Controller
{
    public function show(Request $request)
    {
        $all = Subject::where("instructor_id", "=", Auth::user()->id)->get();
        return view("dashboard", [
            "subjects" => $all
        ]);
    }


    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            "subject_name" => "required|max:50",
            "sy" => "required|max:9|min:9"
        ]);


        // if ($validate->fails()) {
        //     return redirect()->back()->withErrors($validate)->withInput();
        // }


        $subject = Subject::create([
            "subject_name" => $request->subject_name,
            "school_year" => $request->sy,
            "instructor_id" => Auth::user()->id
        ]);

        return redirect()->route("subject.show");
    }

    public function update(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "edit_subject_name" => "required|max:50",
            "edit_id" => "required|numeric"
        ]);

        // if ($validate->fails()) {
        // }

        $data = Subject::find($request->edit_id);

        $data->update([
            "subject_name" => $request->edit_subject_name
        ]);
        return redirect()->route("subject.show");
    }

    public function destroy(Request $request)
    {
        if ($request->has("delete_id")) {
            $data = Subject::find($request->delete_id);

            if ($data != null) {
                $data->delete();
                return redirect()->route("subject.show");
            } else {
                // Add error code
                return redirect()->route("subject.show");
            }
        }
        return redirect()->route("subject.show");
    }

    public function generateReport($id, Request $request) {
        return Excel::download(new GradeExport($id), 'Filename.xlsx');
    }
}
