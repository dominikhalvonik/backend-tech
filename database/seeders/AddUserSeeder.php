<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Phone;
use App\Models\Address;
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

            $newUserPhone = new Phone();
            $newUserPhone->phone_number = "+421" . mt_rand(1,500);
            $newUserPhone->user_id = $newUser->id;
            $newUserPhone->save();

            for ($j = 1; $j < 5; $j++) {
                $newUserAddr = new Address();
                $newUserAddr->street = "Dlha";
                $newUserAddr->street_number = mt_rand(5,500);
                $newUserAddr->city = "Nitra";
                $newUserAddr->user_id = $newUser->id;
                $newUserAddr->save();
            }
        }
    }
}
