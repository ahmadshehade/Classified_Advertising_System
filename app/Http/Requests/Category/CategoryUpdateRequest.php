<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->user()->role == 'admin';
    }
    /**
     * Summary of prepareForValidation
     * @return void
     */
    public function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name) . '-' . uniqid()
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ['required', 'string', 'min:4', 'max:50'],
            "slug" => ['string'],
        ];
    }
    /**
     * Summary of messages
     * @return array{name.max: string, name.min: string, name.required: string, name.string: string, slug.string: string}
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.string'   => 'The category name must be a string.',
            'name.min'      => 'The category name must be at least 4 characters.',
            'name.max'      => 'The category name may not be greater than 50 characters.',
            'slug.string'   => 'The slug must be a string.',
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
