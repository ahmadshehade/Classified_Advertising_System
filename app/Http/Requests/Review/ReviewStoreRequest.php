<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReviewStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->check() && in_array(auth('api')->user()->role, ['admin', 'user']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ad_id'   => ['required', 'exists:ads,id'],
            'rating'  => ['required', 'integer', 'between:1,5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'ad_id.required'    => 'The ad ID is required.',
            'ad_id.exists'      => 'The selected ad does not exist.',
            'rating.required'   => 'The rating is required.',
            'rating.integer'    => 'The rating must be an integer.',
            'rating.between'    => 'The rating must be between 1 and 5.',
            'comment.string'    => 'The comment must be a valid text.',
            'comment.max'       => 'The comment may not be greater than 1000 characters.',
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
