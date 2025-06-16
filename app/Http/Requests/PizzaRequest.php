<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PizzaRequest extends FormRequest
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
            'pizza_id' => 'required|string|unique:pizzas,pizza_id,' . $this->route('pizza') . ',pizza_id',
            'pizza_type_id' => 'required|exists:pizza_types,pizza_type_id',
            'size' => 'required|string|in:S,M,L',
            'price' => 'required|numeric|min:0',
        ];
    }
}
