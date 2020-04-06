<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
                    'name' => ['required', 'string', 'unique:categories,name'],
                ];
                break;

            case ('PUT' || 'PATCH'):
                return [
                    'name' => [
                        'required',
                        'string',
                        Rule::unique('categories')->ignore($this->category->id),
                    ],
                ];

            default:
                return [];
                break;
        }
    }
}
