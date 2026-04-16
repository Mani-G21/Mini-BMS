<?php

namespace App\Domain\Booking\Validators;

use Illuminate\Foundation\Http\FormRequest;

class LockSeatsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Authorization is already handled by the middleware
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'seat_ids' => 'required|array|max:5',
            'seat_ids.*' => 'required|string'
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'seat_ids.required' => 'Seat IDs are required',
            'seat_ids.array' => 'Seat IDs must be an array',
            'seat_ids.max' => 'You can only lock up to 5 seats at a time',
            'seat_ids.*.required' => 'Each seat ID is required',
            'seat_ids.*.string' => 'Each seat ID must be a string'
        ];
    }
}

