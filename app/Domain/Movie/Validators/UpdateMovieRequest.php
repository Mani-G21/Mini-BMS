<?php

namespace App\Domain\Movie\Validators;

use App\Domain\Movie\Enums\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMovieRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'poster_url' => 'nullable|url|max:255',
            'trailer_url' => 'nullable|url|max:255',
            'release_date' => 'nullable|date',
            'duration' => 'nullable|integer|min:1',
            'language' => 'sometimes|required|string|max:50',
            'genre' => 'sometimes|required|string|max:100',
            'rating' => 'nullable|numeric|min:0|max:10',
            'status' => ['sometimes', 'required', Rule::in(StatusEnum::values())],
            'city_ids' => 'nullable|array',
            'city_ids.*' => 'exists:cities,id',
        ];

    }
}
