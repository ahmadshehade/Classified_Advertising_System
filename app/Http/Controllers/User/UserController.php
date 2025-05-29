<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserUpdateRequest;
use App\Interfaces\User\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected  $user;
    /**
     * Summary of __construct
     * @param \App\Interfaces\User\UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Summary of index
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->user->index();
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Summary of show
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data = $this->user->show($id);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Summary of destroy
     * @param mixed $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $data = $this->user->destroy($id);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }

    /**
     * Summary of update
     * @param mixed $id
     * @param \App\Http\Requests\User\UserUpdateRequest $requst
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update($id, UserUpdateRequest $requst)
    {
        $data = $this->user->update($id, $requst);
        return $this->formMesage($data['message'], $data['data'], $data['code']);
    }
}
