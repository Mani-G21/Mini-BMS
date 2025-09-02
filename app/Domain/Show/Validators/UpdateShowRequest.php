<?php

namespace App\Domain\Show\Validators;

use App\Domain\Show\Enums\ShowFormat;
use App\Domain\Show\Enums\ShowStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateShowRequest extends FormRequest
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
            'movie_id' => ['required', 'string', 'exists:movies,id'],
            'theater_id' => ['required', 'string', 'exists:theaters,id'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'language' => ['required', 'string', 'max:50'],
            'format' => ['required', new Enum(ShowFormat::class)],
            'status' => ['required', new Enum(ShowStatus::class)],
            'price_tiers' => ['required', 'array'],
            'price_tiers.*.name' => ['required', 'string', 'max:50'],
            'price_tiers.*.price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
