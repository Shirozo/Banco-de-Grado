<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function show(Request $request)
    {

        $users = User::all();
        return view("users", [
            "users" => $users
        ]);
    }

    public function store(Request $request)
    {
        try {

            $data = Validator::make($request->all(), [
                "name" => "required|min:1",
                "username" => "required|max:30",
                "password" => "required|min:8|max:30",
                "type" => "required|integer|in:1,2"
            ]);

            if ($data->fails()) {
                return response()->json([
                    "message" => "Data validation fails!"
                ], 403);
            }

            $has_data = User::where("username", "=", $request->username)->first();

            if ($has_data) {
                return response()->json([
                    "message" => "Username already taken!"
                ], 403);
            }

            User::create([
                "name" => $request->name,
                "username" => $request->username,
                "password" => $request->password,
                "type" => $request->type
            ]);

            return response()->json([
                "message" => "User Added!"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request)
    {
        if ($request->has("delete_id")) {
            $data = User::find($request->delete_id);

            if ($data) {
                $data->delete();

                return response()->json([
                    "message" => "User Deleted!"
                ], 200);
            }

            return response()->json([
                "message" => "User data not found!"
            ], 404);
        }
        return response()->json([
            "message" => "ID is required!"
        ], 403);
    }

    public function update(Request $request)
    {
        try {

            if (!$request->has("id")) {
                return response()->json([
                    "message" => "ID not found!"
                ], 404);
            }

            $username = User::where([
                ["username", "=", $request->update_username],
                ["id", "!=", $request->id]
            ])->first();

            if ($username) {
                return response()->json([
                    "message" => "Username Already Taken!"
                ], 403);
            }

            $data = Validator::make($request->all(), [
                "update_name" => "required|min:1",
                "update_username" => "required|max:30",
                "update_password" => "max:30",
                "update_type" => "required|integer|in:1,2"
            ]);

            if ($data->fails()) {
                return response()->json([
                    "message" => "Form validation fails!"
                ], 403);
            }

            $prev_data = User::find($request->id);

            if (!$prev_data) {
                return response()->json([
                    "message" => "User data not found!"
                ], 404);
            }

            if (strlen($request->update_password) >= 8) {
                $prev_data->update([
                    "name" => $request->update_name,
                    "username" => $request->update_username,
                    "password" => $request->update_password,
                    "user_type" => $request->update_type
                ]);
            } else {
                $prev_data->update([
                    "name" => $request->update_name,
                    "username" => $request->update_username,
                    "user_type" => $request->update_type
                ]);
            }

            return response()->json([
                "message" => "User data updated!",
                "type" => $request->update_type
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => $th->getMessage()
            ], 500);
        }
    }

    public function userDataApi(Request $request)
    {
        if ($request->has("id")) {
            $data = User::find($request->id);

            if ($data) {
                return response()->json([
                    "data" => $data
                ], 200);
            }

            return response()->json([
                "message" => "User Data not found!"
            ], 404);
        }
        return response()->json([
            "message" => "ID is required!"
        ], 404);
    }



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
                "text" => $data->name
            ];
        }

        return response()->json($formatted_data);
    }
}
