<?php

namespace App\Http\Controllers;

use App\Role;
use  App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->save();

            $user->attachRole(Role::where('name', 'user')->first());
            $user->save();


            //return successful response
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function remind(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'email' => 'required|email|exists:users',
        ]);

        $credentials = $request->only(['email']);
        $user = User::where('email', $credentials['email'])->first();

        $hash = bin2hex(random_bytes(16));
        $user->hash = $hash;
        $user->save();

        $to_name = 'TO_NAME';
        $to_email = $credentials['email'];
        $data = array('hash' => $hash);

        try {
            Mail::send('emails.remindEmail', $data, function ($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Password remind');
                $message->from('ipsistemos@gmail.com', 'Lumen framework');
            });
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Please check email driver credentials'], 500);
        }

        return response()->json(['message' => 'Email succesfuly sent'], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function reset(Request $request)
    {
        //validate incoming request
        $this->validate($request, [
            'hash' => 'required|string',
            'password' => 'required|confirmed',
        ]);

        $credentials = $request->only(['hash', 'password']);

        try {
            $user = User::where('hash', $credentials['hash'])->first();

            if (!$user) {
                return response()->json(['message' => 'Hash is invalid!'], 409);
            }

            $user->password = app('hash')->make($credentials['password']);
            $user->hash = null;
            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'Password updated successfuly'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'Password updated unsuccessfuly!'], 409);
        }
    }
}
