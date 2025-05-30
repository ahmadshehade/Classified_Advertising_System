<?php

namespace  App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Interfaces\Auth\AuthInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $auth;

    /**
     * Summary of __construct
     * @param \App\Interfaces\Auth\AuthInterface $auth
     */
    public function __construct(AuthInterface $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Summary of login
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $data = $this->auth->login($request);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Summary of register
     * @param \App\Http\Requests\Auth\RegisterRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $data = $this->auth->register($request);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Summary of logout
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $data = $this->auth->logout($request);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }
}
