<?php

namespace App\Http\Requests;

use App\Enums\GenderEnum;
use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'familyName' => ['required', 'string'],
            'preferredUsername' => ['required', 'string'],
            'gender' => ['required', 'in:' . collect(array_column(GenderEnum::cases(), 'value'))->implode(',')],
            'phoneNumber' => ['nullable', 'string'],
            'birthDate' => ['nullable', 'date'],
            'address' => ['nullable', 'string'],
            'picture' => ['nullable', 'string'],
            'updatedAt' => ['required', 'string'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
