<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required'],
            'data' => ['required', 'json'],
            'user_ids' => ['required', 'array', 'min:1'],
        ];
    }

    public function dataToObject()
    {
        return json_decode($this->data, true);
    }

    public function authorize(): bool
    {
        return true;
    }
}
