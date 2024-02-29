<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function test()
    {
        echo 22;
    }

    public function random()
    {
        echo mt_rand(1, 5641651);
    }
}
