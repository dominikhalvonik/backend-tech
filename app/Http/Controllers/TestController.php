<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        echo 22;
    }

    public function testPost(Request $request)
    {
        $name = $request->post('meno', null);
        $surname = $request->post('priezvisko', null);
        $age = $request->post('vek', 0);

        if($age < 18) {
            return response()->json("Unable to join under 18", 422);
        } else {
            return response()->json([
                'status' => 200,
                'message' => $name . " " . $surname . " was correctly assigned",
            ]);
        }
    }

    public function testUpload(Request $request)
    {
        $number = $request->post('number', 0);
        file_put_contents("file.txt", $number);

        return response()->json("juchuchu");
    }

    public function findUserById(int $id): JsonResponse
    {
        $user = User::find($id);
        //$user = User::where('email', '=', $email)->first();

        if($user) {
            return response()->json($user);
        } else {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
    }
}
