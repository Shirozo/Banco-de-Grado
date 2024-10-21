<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function api(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $datas = User::search($term)->get();

        $formatted_data = [];

        foreach ($datas as $data) {
            $formatted_data[] = [
                "id" => $data->id,
                "text" => $data->first_name . " " . $data->middle_name . " " . $data->last_name
            ];
        }

        return response()->json($formatted_data);
    }
}
