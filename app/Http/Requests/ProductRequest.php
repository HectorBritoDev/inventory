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
                    'unit_price' => ['required', 'numeric'],
                    'minimum_to_apply_mayoritary_price' => ['nullable', 'integer'],
                ];

            case ('PUT' || 'PATCH'):
                return [
                    'category_id' => ['nullable', 'exists:categories,id'],
                    'name' => ['required', 'string'],
                    'unit_price' => ['nullable', 'integer'],
                    'quantity' => ['required', 'numeric'],
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

    public function prepareForValidation()
    {
        $this->merge([
            'category_id' => $this->category,
            'code' => $this->code,
            'name' => $this->name,
            'quantity' => $this->available,
            'mayor_price' => $this->mayoritary_price,
            'unit_price' => $this->unitary_price,
            'minimum_to_apply_mayoritary_price' => $this->apply_mayoritary_price_since,
        ]);
    }

    public function attributes()
    {
        return [
            'category_id' => 'category',
            'code' => 'code',
            'name' => 'name',
            'quantity' => 'available',
            'mayor_price' => 'mayoritary_price',
            'unit_price' => 'unitary_price',
            'minimum_to_apply_mayoritary_price' => 'apply_mayoritary_price_since',
        ];
    }

}
