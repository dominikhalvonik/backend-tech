<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Phone;
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
        /** @var User $user */
        $user = User::find($id);

        if($user) {
            $response = [
                'id' => $user->id,
                'meno' => $user->meno,
                'email' => $user->email,
                'datum_vytvorenia' => $user->created_at,
                'tel.kontakt' => $user->phone->prefix . " " . $user->phone->phone_number,
                'addr' => $user->address()->get(['street', 'street_number', 'city', 'type'])
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => "User not found"
            ];

            return response()->json($response, 404);
        }
    }

    public function createUser(Request $request): JsonResponse
    {
        $name = $request->post('name', '');
        $email = $request->post('email', '');
        $prefix = $request->post('phone_prefix', null);
        $phone = $request->post('phone', null);

        if(!empty($name) && !empty($email)) {
            $newUser = new User();
            $newUser->meno = $name;
            $newUser->email = $email;
            $newUser->save();

            $userPhone = new Phone();
            $userPhone->prefix = $prefix;
            $userPhone->phone_number = $phone;
            $userPhone->user_id = $newUser->id;
            $userPhone->save();

            return response()->json('Data stored correctly', 201);

        } else {
            return response()->json('Incorrect data', 422);
        }
    }

    public function addUserAddress(Request $request): JsonResponse
    {
        $street = $request->post('street', null);
        $street_number = $request->post('street_number', null);
        $city = $request->post('city', null);
        $type = $request->post('type', 0);
        $user = $request->post('user_id', null);

        if(empty($street) || empty($street_number) || empty($city) || empty($user)) {
            return response()->json('Incorrect data', 422);
        } else {
            $userModel = User::query()->find($user);

            if($userModel) {
                $newUserAddress = new Address();
                $newUserAddress->street = $street;
                $newUserAddress->street_number = $street_number;
                $newUserAddress->city = $city;
                $newUserAddress->type = $type;
                $newUserAddress->user_id = $user;

                $newUserAddress->save();

                return response()->json('Data stored correctly', 201);
            } else {
                return response()->json('User not found', 422);
            }

        }
    }

    public function findUserByPhone(Request $request): JsonResponse
    {
        $prefix = $request->input('prefix', null);
        $number = $request->input('number', null);

        if($number && $prefix) {
            $phone = Phone::query()
                ->where('prefix', '=', $prefix)
                ->where('phone_number', '=', $number)
                ->first();
            if($phone) {
                $response = [
                    'id' => $phone->user->id,
                    'meno' => $phone->user->meno,
                    'email' => $phone->user->email,
                    'datum_vytvorenia' => $phone->user->created_at,
                    'tel.kontakt' => $phone->prefix . " " . $phone->phone_number,
                    'addr' => $phone->user->address()->get(['street', 'street_number', 'city', 'type'])
                ];
                return response()->json($response, 200);
            } else {
                return response()->json('Unable to find provided phone number', 404);
            }
        }

        return response()->json('Incorrect data', 422);
    }

    public function deleteUser(int $id): JsonResponse
    {
        $user = User::query()->find($id);

        if($user) {
            /** @var Address $address */
            foreach ($user->address as $address) {
                $address->delete();
            }
            /** @var Phone $phone */
            $phone = $user->phone;
            $phone->delete();

            $user->delete();
            return response()->json('User deleted');
        } else {
            return response()->json('User not found', 404);
        }
    }


    public function updateUser(int $id, Request $request): JsonResponse
    {
        $user = User::query()->find($id);

        if($user) {
            $email = $request->input('email', null);
            $name = $request->input('name', null);

            if($email && $name) {
                $user->email = $email;
                $user->meno = $name;
                $user->update();

                return response()->json('User updated correctly', 201);
            }

            return response()->json('Incorrect data', 422);
        }

        return response()->json('User not found', 404);
    }
}
