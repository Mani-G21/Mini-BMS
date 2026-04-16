<?php

namespace App\Domain\Seat\Validators;

use App\Domain\Seat\Enums\SeatCategory;
use App\Domain\Seat\Enums\SeatStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreSeatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seats' => ['required', 'array', 'min:1'],
            'seats.*.label' => ['required', 'string', 'max:10'],
            'seats.*.row' => ['required', 'integer', 'min:1'],
            'seats.*.column' => ['required', 'integer', 'min:1'],
            'seats.*.category' => ['required', new Enum(SeatCategory::class)],
            'seats.*.status' => ['sometimes', new Enum(SeatStatus::class)],
        ];
    }
}
