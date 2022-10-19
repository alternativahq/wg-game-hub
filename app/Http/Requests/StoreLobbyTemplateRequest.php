<?php

namespace App\Http\Requests;

use App\Enums\GameLobbyAlgorithmsType;
use Illuminate\Foundation\Http\FormRequest;

class StoreLobbyTemplateRequest extends FormRequest
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
            'algorithm_id' => ['required', 'in:' . collect(array_column(GameLobbyAlgorithmsType::cases(), 'value'))->implode(',')],
            'game_start_delay_time' => ['nullable', 'numeric'],
            'game_start_delay_limit' => ['nullable', 'numeric'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if (is_null($this->image)) {
            $this->merge([
                'image' => collect([
                    'tank/homepage_bg.png',
                    'tankx/tankx_1.png',
                    'wodoland/wodoland_1.jpg',
                    'wfps/wffps_7.png',
                ])->random(),
            ]);
        }
    }
}
