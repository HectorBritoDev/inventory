<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProduct extends FormRequest
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
        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string'],
            'unit_price' => ['nullable', 'integer'],
            'mayor_price' => ['nullable', 'integer'],
            'purchase_price' => ['nullable', 'integer'],
            'code' => [
                'nullable',
                'string',
                Rule::unique('products')->ignore($this->product->id),
            ],
        ];
    }
}
