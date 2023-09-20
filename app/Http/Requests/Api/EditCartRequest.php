<?php

namespace App\Http\Requests\Api;

use App\Models\Cart;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditCartRequest extends FormRequest
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
            'uuid' => [
                'sometimes',
                'required',
                'uuid',
                Rule::exists(Cart::class),
            ],
            'products' => [
                'required',
                'array',
            ],
            'products.*' => [
                'required',
                'array:id,number',
            ],
            'products.*.*' => [
                'numeric',
            ],
        ];
    }
}
