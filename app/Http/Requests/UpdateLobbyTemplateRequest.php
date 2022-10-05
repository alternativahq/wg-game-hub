<?php

namespace App\Http\Requests;

use App\Enums\GameLobbyAlgorithmsType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLobbyTemplateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            //TODO: image need to be changed to image rule
            'image' => ['required', 'string'],
            'theme_color' => ['required', 'string'],
            'rules' => ['required', 'string'],
            'base_entrance_fee' => ['required', 'numeric'],
            'min_players' => ['required', 'numeric'],
            'max_players' => ['required', 'numeric'],
            'game_play_duration' => ['nullable', 'numeric'],
            'asset_id' => ['required', 'exists:assets,id'],
            'game_id' => ['required', 'exists:games,id'],
            'algorithm_id' => ['required', 'in:' . collect(array_column(GameLobbyAlgorithmsType::cases(), 'value'))->implode(',')],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
