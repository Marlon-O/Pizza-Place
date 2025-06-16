<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PizzaTypeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pizza_type_id' => 'required|string|unique:pizza_types,pizza_type_id,' . $this->route('pizza_type') . ',pizza_type_id',
            'name' => 'required|string',
            'category' => 'required|string',
            'ingredients' => 'required|string',
        ];
    }
}
