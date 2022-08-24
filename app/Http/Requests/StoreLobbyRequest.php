<?php

namespace App\Http\Requests;

use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreLobbyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            //TODO: image need to be changed to image rule
            'image' => ['required', 'string'],
            'theme_color' => ['required', 'string'],
            'type' => ['required', 'in:'.collect(array_column(GameLobbyType::cases(),'value'))->implode(',')],
            'status' => ['required', 'in:'.collect(array_column(GameLobbyStatus::cases(),'value'))->implode(',')],
            'rules' => ['required', 'string'],
            'base_entrance_fee' => ['required', 'numeric'],
            'min_players' => ['required', 'numeric'],
            'max_players' => ['required', 'numeric'],
            'scheduled_at' => ['required', 'date'],
            'asset_id' => ['required', 'exists:assets,id'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
