<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
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
                "name" => $data->first_name . " " . $data->middle_name . " " . $data->last_name
            ];
        }

        return response()->json($formatted_data);
    }
}
