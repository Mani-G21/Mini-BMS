<?php

namespace App\Domain\Seat\Validators;

use App\Domain\Seat\Enums\SeatCategory;
use App\Domain\Seat\Enums\SeatStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateSeatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label' => ['sometimes', 'string', 'max:10'],
            'row' => ['sometimes', 'integer', 'min:1'],
            'column' => ['sometimes', 'integer', 'min:1'],
            'category' => ['sometimes', new Enum(SeatCategory::class)],
            'status' => ['sometimes', new Enum(SeatStatus::class)],
        ];
    }
}

