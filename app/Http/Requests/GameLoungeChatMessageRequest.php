<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameLoungeChatMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => ['required', 'max:10000'],
        ];
    }

    public function authorize(): bool
    {
        //TODO: Authorize if the user already joined the lounge
        return true;
    }
}
