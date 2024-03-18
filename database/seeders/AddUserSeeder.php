<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            $newUser = new User();
            $newUser->meno = "janko_" . mt_rand(1, 5000);
            $newUser->email = "janko_" . mt_rand(1, 5000) . "@gmail.com";
            $newUser->save();
        }
    }
}
