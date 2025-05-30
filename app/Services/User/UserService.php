<?php

namespace App\Services\User;

use App\Interfaces\User\UserInterface;
use App\Jobs\RemoveUserJob;
use App\Models\User;
use App\Traits\ManagerFile;
use App\Traits\ManagmentFiles;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService implements UserInterface
{
    use ManagmentFiles, AuthorizesRequests;
    /**
     * Summary of index
     * @return array{code: int, data: \Illuminate\Database\Eloquent\Collection<int, User>, message: string}
     */
    public function index()
    {
        $users = User::all();
        $this->authorize('viewAny', User::class);
        $data = [
            'message' => 'Successfully  Get All Users',
            'data' => $users->load('image'),
            'code' => 200
        ];
        return $data;
    }

    /**
     * Summary of show
     * @param mixed $id
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: User|\Illuminate\Database\Eloquent\Collection<int, User>, message: string}
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'User not Found'
                ], 404)
            );
        }
        $this->authorize('view', $user);
        $data = [
            'message' => 'Successfully get User Info',
            'data' => $user->load('image'),
            'code' => 200
        ];
        return $data;
    }



    /**
     * Summary of destroy
     * @param mixed $id
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return array{code: int, data: bool, message: string}
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new HttpResponseException(
                response()->json([
                    'message' => 'User not Found'
                ], 404)
            );
        }
        $this->authorize('delete', $user);

        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];
        $imageIds = $user->image->id;
        $this->deleteImages(
            User::class,
            $user->id,
            $imageIds
        );

        dispatch(new RemoveUserJob($userData));

        $user->delete();

        return [
            'message' => 'Successfully Deleted User',
            'data' => true,
            'code' => 200
        ];
    }





 
    public function update($id, $request)
    {
        try {
            DB::beginTransaction();
            $user = User::find($id);

            if (!$user) {
                throw new HttpResponseException(
                    response()->json([
                        'message' => 'User not Found'
                    ], 404)
                );
            }
            $this->authorize('update', $user);
            $validate = $request->validated();
            if (isset($validate['name'])) {
                $user->name = $validate['name'];
            }
            if (isset($validate['email'])) {
                $user->email = $validate['email'];
            }
            if (isset($validate['password'])) {
                $user->password = Hash::make($validate['password']);
            }
            if (isset($validate['role']) && auth('api')->user()->role == 'admin') {
                $user->role = $validate['role'];
            }
            $user->save();

            if ($request->hasFile('newImage')) {
                if ($user->image) {
                    $imageIds = $user->image->id;
                    $this->deleteImages(
                        User::class,
                        $user->id,
                        $imageIds
                    );
                }
                $this->uploadImages(
                    $request,
                    'newImage',
                    User::class,
                    $user->id,
                    'Users/' . $user->name . '_' . $user->id
                );
                DB::commit();
                $data = [
                    'message' => 'Successfully Update User Imformation',
                    'data' => $user->load('image'),
                    'code' => 200
                ];
                return $data;
            }
        } catch (Exception $e) {
            throw new HttpResponseException(
                response()->json([
                    'message' => ' Server error: ' . $e->getMessage(),
                ], 500)
            );
        }
    }
}
