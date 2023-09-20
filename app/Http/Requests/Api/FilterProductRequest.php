<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class FilterProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'folders' => [
                'sometimes',
                'required',
                'array',
            ],
            'folders.*' => [
                'numeric',
            ],
            'price' => [
                'sometimes',
                'required',
                'array:min,max',
            ],
            'price.*' => [
                'numeric',
            ],
            'param' => [
                'sometimes',
                'required',
                'array:length,width,height,weight',
            ],
            'param.*' => [
                'sometimes',
                'required',
                'array:min,max',
            ],
            'param.*.*' => [
                'numeric',
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
