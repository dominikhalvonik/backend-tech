<?php

namespace App\Http\Controllers;

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
}
