<?php

namespace Database\Seeders;

use App\Models\User;
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
        for ($i = 0; $i <= 10; $i++) {
            $user = new User();
            $user->meno = "Jano_" . mt_rand(1, 500);
            $user->email = "jano." . mt_rand(1, 500) . "@gmail.com";
            $user->save();
        }
    }
}
