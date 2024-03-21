<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AddUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 10; $i++) {
            $newUser = new User();
            $newUser->meno = "Jano_" . mt_rand(1, 50000);
            $newUser->email = "jano_" . mt_rand(1, 50000) . "@gmail.com";
            $newUser->save();
        }
    }
}
