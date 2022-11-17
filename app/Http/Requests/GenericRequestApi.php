<?php

namespace App\Http\Requests;

use App\Enums\GameLobbyAbourtCause;
use Illuminate\Foundation\Http\FormRequest;

class GenericRequestApi extends FormRequest
{
    public function rules(): array
    {
        return [
            'cause' => ['nullable', 'in:' . collect(array_column(GameLobbyAbourtCause::cases(), 'value'))->implode(',')],
            'url' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
