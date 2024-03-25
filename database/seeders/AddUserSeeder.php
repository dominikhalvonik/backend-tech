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
        for ($i = 0; $i <= 10; $i++) {
            $user = new User();
            $user->meno = "Jano_" . mt_rand(1, 500);
            $user->email = "jano." . mt_rand(1, 500) . "@gmail.com";
            $user->save();

            $prefix = "+421";
            $number = mt_rand(1, 10);
            $newPhoneNumber = new Phone();
            $newPhoneNumber->prefix = $prefix;
            $newPhoneNumber->phone_number = $number;
            $newPhoneNumber->user_id = $user->id;
            $newPhoneNumber->save();

            for ($j = 0; $j <= 5; $j++) {
                $dateTime = date("Y-m-d H:i:s", time());
                Address::query()->insert([
                    'street' => "Dlha",
                    'street_number' => mt_rand(1, 500),
                    'city' => "Nitra",
                    'user_id' => $user->id,
                    'type' => mt_rand(0, 3),
                    'created_at' => $dateTime,
                    'updated_at' => $dateTime,
                ]);
            }
        }
    }
}
