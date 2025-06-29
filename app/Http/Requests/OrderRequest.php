<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i:s'],
            'order_details' => ['required', 'array', 'min:1'],
            'order_details.*.pizza_id' => ['required', 'exists:pizzas,pizza_id'],
            'order_details.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
