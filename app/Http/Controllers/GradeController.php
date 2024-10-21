<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GradeController extends Controller
{

    public function show($id, Request $request)
    {  
        return view("grades", [
            "id" => $id
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
}
