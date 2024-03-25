<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Phone;
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
        $user = User::query()->find($id);
        if($user) {
            /** @var Phone $phone */
            $phone = $user->phone;
            $response = [
                'id' => $user->id,
                'meno' => $user->meno,
                'email' => $user->email,
                'tel.kontakt' => $phone->phone_number,
                'addr' => $user->address
            ];
            return response()->json($response);
        } else {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }
    }

    public function findUserByPhone(Request $request): JsonResponse
    {
        $phoneNumber = $request->post('phone', null);

        if($phoneNumber) {
            $phone = Phone::query()->where('phone_number', '=', $phoneNumber)->first();
            if ($phone) {
                $response = [
                    'id' => $phone->user->id,
                    'meno' => $phone->user->meno,
                    'email' => $phone->user->email,
                    'tel.kontakt' => $phone->phone_number,
                    'addr' => $phone->user->address
                ];
                return response()->json($response);
            } else {
                return response()->json('Phone not found', 404);
            }
        }

        return response()->json('Incorrect data', 422);
    }

    public function createUser(Request $request): JsonResponse
    {
        $meno = $request->post('name', null);
        $email = $request->post('email', null);
        $phoneNumber = $request->post('phone', null);

        if(empty($meno) || empty($email) || empty($phoneNumber)) {
            return response()->json('Incorrect data', 422);
        }

        $newUser = new User();
        $newUser->meno = $meno;
        $newUser->email = $email;
        $newUser->save();

        $newUserPhone = new Phone();
        $newUserPhone->phone_number = $phoneNumber;
        $newUserPhone->user_id = $newUser->id;
        $newUserPhone->save();

        return response()->json('User saved correctly', 201);
    }

    public function addUserAddress(int $user_id, Request $request): JsonResponse
    {
        $street = $request->input('street', false);
        $streetNumber = $request->input('street_number', false);
        $city = $request->input('city', false);

        $user = User::query()->find($user_id);
        if($user) {
            if($street && $streetNumber && $city) {
                $newAddress = new Address();
                $newAddress->street = $street;
                $newAddress->street_number = $streetNumber;
                $newAddress->city = $city;
                $newAddress->user_id = $user_id;
                //$newAddress->user_id = $user->id;
                $newAddress->save();

                return response()->json('Data stored correctly', 201);
            }

            return response()->json('Incorrect data', 422);
        }

        return response()->json('User not found', 404);
    }

    public function deleteUser(int $id): JsonResponse
    {
        $user = User::query()->find($id);

        if($user) {
            /** @var Phone $phone */
            $phone = $user->phone;
            $phone->delete();
            /** @var $address $address */
            foreach ($user->address as $address) {
                $address->delete();
            }

            $user->delete();

            return response()->json('User deleted');
        }

        return response()->json('User not found', 404);
    }

    public function updateUser(Request $request): JsonResponse
    {
        $email = $request->input('email', null);
        $name = $request->input('name', null);
        $id = $request->input('id', null);

        if($email && $name) {
            $user = User::query()->find($id);

            if($user) {
                $user->meno = $name;
                $user->email = $email;
                $user->update();

                return response()->json('User udpated', 201);
            }

            return response()->json('User not found', 404);
        }

        return response()->json('Incorrect data', 422);
    }
}
