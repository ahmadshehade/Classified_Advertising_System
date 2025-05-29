<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = auth('api')->user();
        return $user->role == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'string', 'min:8', 'max:32'],
            'role' => ['sometimes', 'in:user,admin'],
            'image' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a valid string.',
            'name.max' => 'The name must not exceed 255 characters.',

            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already taken.',

            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password must not exceed 32 characters.',


            'role.in' => 'The selected role is invalid. Allowed values are user or admin.',

            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image may not be greater than 2 megabytes.',
        ];
    }
    public function  failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw  new HttpResponseException(
            response()->json([
                'messageErrors' => $validator->errors()
            ], 422)
        );
    }
}
