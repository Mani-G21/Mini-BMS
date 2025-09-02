<?php

namespace App\Domain\Show\Validators;

use App\Domain\Show\Enums\ShowFormat;
use App\Domain\Show\Enums\ShowStatus;
use App\Domain\Show\Validators\Rules\NoShowOverlap;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreShowRequest extends FormRequest
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
            'end_time' => ['required', 'date', 'after:start_time'],
            'language' => ['required', 'string', 'max:50'],
            'format' => ['required', new Enum(ShowFormat::class)],
            'status' => ['required', new Enum(ShowStatus::class)],
            'price_tiers' => ['required', 'array'],
            'price_tiers.*.name' => ['required', 'string', 'max:50'],
            'price_tiers.*.price' => ['required', 'numeric', 'min:0'],
            'start_time' => [
                'required', 'date', 'after:now',
                new NoShowOverlap(
                    $this->input('theater_id'),
                    $this->input('start_time'),
                    $this->input('end_time'),
                    $this->route('id') // null on create, show_id on update
                )
            ],


        ];
    }
}
