<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Termwind\render;

class SubjectController extends Controller
{
    public function show(Request $request)
    {
        $all = Subject::all();
        return view("dashboard", [
            "subjects" => $all
        ]);
    }


    public function store(Request $request)
    {

        // TODO: Add instructor ID to the data
        
        $validate = Validator::make($request->all(), [
            "subject_name" => "required|max:50",
            "sy" => "required|max:9|min:9"
        ]);


        // if ($validate->fails()) {
        //     return redirect()->back()->withErrors($validate)->withInput();
        // }


        $subject = Subject::create([
            "subject_name" => $request->subject_name,
            "school_year" => $request->sy
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
        $data = Subject::find($request->delete_id);

        if ($data != null) {
            $data->delete();
            return redirect()->route("subject.show");
        } else {
            // Add error code
            return redirect()->route("subject.show");
        }
    }
}
