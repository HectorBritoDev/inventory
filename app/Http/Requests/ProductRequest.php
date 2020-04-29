<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'category_id' => ['nullable', 'exists:categories,id'],
                    'code' => ['nullable', 'unique:products,code'],
                    'name' => ['required', 'string'],
                    'quantity' => ['required', 'numeric'],
                    'mayor_price' => ['nullable', 'numeric'],
                    'unit_price' => ['nullable', 'numeric'],
                    'minimum_to_apply_mayoritary_price' => ['nullable', 'integer'],
                ];

            case ('PUT' || 'PATCH'):
                return [
                    'category_id' => ['nullable', 'exists:categories,id'],
                    'name' => ['required', 'string'],
                    'unit_price' => ['nullable', 'integer'],
                    'mayor_price' => ['nullable', 'integer'],
                    'minimum_to_apply_mayoritary_price' => ['nullable', 'integer'],
                    'code' => [
                        'nullable',
                        'string',
                        Rule::unique('products')->ignore($this->product->id),
                    ],
                ];

            default:
                return [];
        }
    }
}
