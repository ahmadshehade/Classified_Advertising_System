<?php

namespace App\Http\Requests\Ads;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('api')->user()->role == "admin" || auth('api')->user()->role == "user";
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'status' => 'sometimes|in:pending,active,rejected',
            'newImages' => ['sometimes', 'array'],
            'newImages.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title must not exceed 255 characters.',

            'description.string' => 'The description must be a string.',

            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',

            'category_id.exists' => 'The selected category is invalid.',

            'status.in' => 'The status must be one of: pending, active, rejected.',

            'newImages.array' => 'The images must be an array.',
            'newImages.*.image' => 'Each file must be an image.',
            'newImages.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg.',
            'newImages.*.max' => 'Each image may not be greater than 2MB.',
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
