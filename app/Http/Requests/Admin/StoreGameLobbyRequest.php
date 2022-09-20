<?php

namespace App\Http\Requests;

use App\Enums\GameLobbyType;
use App\Enums\GameLobbyStatus;
use App\Enums\GameLobbyAlgorithmsType;
use Illuminate\Foundation\Http\FormRequest;

class StoreLobbyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['required', 'string'],
            'theme_color' => ['required', 'string'],
            'type' => ['required', 'in:' . collect(array_column(GameLobbyType::cases(), 'value'))->implode(',')],
            'rules' => ['required', 'string'],
            'base_entrance_fee' => ['required', 'numeric'],
            'min_players' => ['required', 'numeric', 'lte:max_players'],
            'max_players' => ['required', 'numeric', 'gte:min_players'],
            'scheduled_at' => ['required', 'date'],
            'start_at' => ['required', 'date', 'after:scheduled_at'],
            'asset_id' => ['required', 'exists:assets,id'],
             //TODO: need to make sure value or name
             'algorithm_id' => ['required', 'in:' . collect(array_column(GameLobbyAlgorithmsType::cases(), 'value'))->implode(',')],
        ];
    }

    public function authorize()
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
