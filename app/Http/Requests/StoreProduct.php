<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'code' => ['nullable', 'unique:products,code'],
            'name' => ['required', 'string'],
            'quantity' => ['required', 'integer'],
            'mayor_price' => ['nullable', 'integer'],
            'unit_price' => ['nullable', 'integer'],
            'purchase_price' => ['nullable', 'integer'],
        ];
    }
}
