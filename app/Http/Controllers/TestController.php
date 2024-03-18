<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    private string $username = "admin";
    private string $password = "admin";

    public function test()
    {
        echo 22;
    }

    public function testPost(Request $request)
    {
        $username = $request->post('username', "fsdafsafds");
        $password = $request->post('password', "lol");
        $remember = $request->post('remember', false);

        if($username === $this->username && $password === $this->password) {
            $response = [
                'status' => 200,
                'message' => "Logged in",
            ];

            return response()->json($response);

        } else {
            $response = [
                'status' => 401,
                'message' => "Incorrect login",
            ];

            return response()->json($response, $response['status']);
        }
    }

    public function testFile(Request $request)
    {
        $name = $request->post('meno', "fsdafsafds");
        $surname = $request->post('priezvisko', "lol");

        file_put_contents("file.txt", json_encode([$name, $surname]));

        return response()->json("juchucu");
    }

    public function findUserById(int $id): JsonResponse
    {
        $user = User::find($id);

        if($user) {
            $response = [
                'id' => $user->id,
                'meno' => $user->meno,
                'email' => $user->email,
                'datum_vytvorenia' => $user->created_at,
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => "User not found"
            ];

            return response()->json($response, 404);
        }
    }
}
