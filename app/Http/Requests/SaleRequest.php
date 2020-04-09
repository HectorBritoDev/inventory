<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
            'items' => ['required', 'array'],
            'items.*.product_id' => ['required'],
            'items.*.quantity' => ['required', 'integer'],
            'items.*.discount_type' => ['nullable', 'string', 'in:percentage,number'],
            'items.*.discount' => ['required_with:items.*.discount_type', 'numeric'],
            'message' => ['nullable', 'string'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            foreach ($this->items as $key => $item) {
                if (array_key_exists('discount_type', $item)) {

                    if ($item['discount_type'] === 'percentage' && ($item['discount'] > 100 || $item['discount'] < 0)) {
                        $validator->errors()->add('discount', 'The % to discount cant be mayor than 100 or minor to 0');
                    }
                    if ($item['discount_type'] === 'number' && $item['discount'] < 0) {
                        $validator->errors()->add('discount', 'The amount to discount cant be minor minor to 0');
                    }
                }
            }
        });
    }

    // public function messages()
    // {
    //     return [
    //         'items.*.product_id.required' => 'The id of the product field is required ',
    //     ];
    // }
}
