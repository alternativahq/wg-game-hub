<?php

namespace App\Http\Requests;

use App\Enums\GameLobbyAbourtCause;
use Illuminate\Foundation\Http\FormRequest;

class GameLobbyAbortedRefunding extends FormRequest
{
    public function rules(): array
    {
        return [
            'cause' => ['required', 'in:' . collect(array_column(GameLobbyAbourtCause::cases(), 'value'))->implode(',')],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
