<?php

namespace App\Http\Requests;

use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use App\Enums\GameLobbyAlgorithmsType;
use Illuminate\Foundation\Http\FormRequest;

class ShowGameLobbyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'includeUsers' => ['nullable', 'boolean'],
            'includeGame' => ['nullable', 'boolean'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
