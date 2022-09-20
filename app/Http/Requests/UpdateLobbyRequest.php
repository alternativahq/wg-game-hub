<?php

namespace App\Http\Requests;

use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use App\Enums\GameLobbyAlgorithmsType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLobbyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            //TODO: image need to be changed to image rule
            'image' => ['required', 'string'],
            'theme_color' => ['required', 'string'],
            'type' => ['required', 'in:' . collect(array_column(GameLobbyType::cases(), 'value'))->implode(',')],
            // 'state' => ['required', 'in:' . collect(array_column(GameLobbyStatus::cases(), 'value'))->implode(',')],
            'rules' => ['required', 'string'],
            'base_entrance_fee' => ['required', 'numeric'],
            'min_players' => ['required', 'numeric'],
            'max_players' => ['required', 'numeric'],
            'scheduled_at' => ['required', 'date'],
            'asset_id' => ['required', 'exists:assets,id'],
            'game_id' => ['required', 'exists:games,id'],
             //TODO: need to make sure value or name
            'algorithm_id' => ['required', 'in:' . collect(array_column(GameLobbyAlgorithmsType::cases(), 'value'))->implode(',')],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
