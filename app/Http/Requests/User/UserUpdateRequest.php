<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth('api')->user();
        return $user && ($user->role == 'admin' || $user->role == "user");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('id');
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', Rule::unique('users')->ignore($userId)],
            'password' => ['sometimes', 'string', 'min:8', 'max:32'],
            'role' => ['sometimes', 'in:user,admin'],
            'newImage' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }
    /**
     * Summary of messages
     * @return array{email.email: string, email.unique: string, name.max: string, name.string: string, newImage.image: string, newImage.max: string, newImage.mimes: string, password.max: string, password.min: string, password.string: string, role.in: string}
     */
    public function messages(): array
    {
        return [
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name may not be greater than 255 characters.',

            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email is already taken.',

            'password.string' => 'The password must be a valid string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password may not be greater than 32 characters.',

            'role.in' => 'The selected role is invalid. Only user or admin are allowed.',

            'newImage.image' => 'The uploaded file must be an image.',
            'newImage.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'newImage.max' => 'The image size must not exceed 2MB.',
        ];
    }
    /**
     * Summary of failedValidation
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     * @return never
     */
    public function  failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw  new HttpResponseException(
            response()->json([
                'messageErrors' => $validator->errors()
            ], 422)
        );
    }
}
