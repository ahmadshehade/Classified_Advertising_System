<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\AuthInterface;
use App\Jobs\RemoveUserJob;
use App\Jobs\SendRegisterEmailJob;
use App\Models\User;
use App\Traits\ManagmentFiles;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthService implements AuthInterface
{
    use ManagmentFiles;

    /**
     * Summary of login
     * @param mixed $request
     * @throws \Illuminate\Http\Exceptions\ThrottleRequestsException
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: array{token: string, user: User, message: string}|array{code: int, data: null, message: string}}
     */
    public function login($request)
    {
        try {
            $validated = $request->validated();

            $key = 'login:' . Str::lower($validated['email']) . '|' . $request->ip();

            if (RateLimiter::tooManyAttempts($key, 5)) {
                $seconds = RateLimiter::availableIn($key);

                $data = [
                    'message' => "Too many login attempts. Please try again in {$seconds} seconds.",
                    'data' => null,
                    'code' => 429,
                ];
                return $data;
            }

            $user = User::where('email', $validated['email'])->first();

            if ($user && Hash::check($validated['password'], $user->password)) {
                RateLimiter::clear($key);

                $token = $user->createToken('auth_user')->plainTextToken;

                $data = [
                    'message' => 'Successfully logged in.',
                    'data' => [
                        'user' => $user,
                        'token' => $token,
                    ],
                    'code' => 200
                ];
                return $data;
            } else {
                RateLimiter::hit($key, 60);

                $data = [
                    'message' => 'Login failed. Please check your credentials and try again.',
                    'data' => null,
                    'code' => 401
                ];
                return $data;
            }
        } catch (Exception $e) {
            throw new HttpResponseException(response()->json([
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500));
        }
    }


    /**
     * Summary of register
     * @param mixed $request
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: array{token: string, user: User, message: string}}
     */
    public function register($request)
    {
        try {
            DB::beginTransaction();
            $validate = $request->validated();
            $user = new User();
            $user->name = $validate['name'];
            $user->email = $validate['email'];
            $user->password = Hash::make($validate['password']);
            if (isset($validate['role'])) {
                $user->role = $validate['role'];
            }
            $user->save();
            $token = $user->createToken('auth_user')->plainTextToken;
            $password = $validate['password'];
            $this->uploadImages(
                $request,
                'image',
                User::class,
                $user->id,
                'Users/'.$user->name.'_'.$user->id
            );
            DB::commit();
             dispatch(new SendRegisterEmailJob($user, $password));
            $data = [
                'message' => 'Successfully  Add New  User ',
                'data' => [
                    'user' => $user->load('image'),
                    'token' => $token
                ],
                'code' => 200
            ];
            return $data;
        } catch (Exception $e) {
            throw new HttpResponseException(
                response()->json([
                    'message' => ' Server error: ' . $e->getMessage(),
                ], 500)
            );
        }
    }


    /**
     * Summary of logout
     * @param mixed $request
     * @return array{code: int, data: bool, message: string}
     */
    public function logout($request)
    {
        $user = $request->user();
        $user->tokens()->delete();
        $data = [
            'message' => 'Successfully Logout User',
            'data' => true,
            'code' => 200
        ];
        return $data;
    }

  
}
