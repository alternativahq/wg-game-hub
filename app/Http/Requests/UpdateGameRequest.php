<?php

namespace App\Http\Requests;

use App\Enums\GameStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['required', 'string'],
            'status' => ['required', 'in:' . collect(array_column(GameStatus::cases(), 'value'))->implode(',')],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
