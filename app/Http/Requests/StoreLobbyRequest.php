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
            'image' => ['required', 'string'],
            'themeColor' => ['required', 'string'],
            'type' => ['required', 'in:' . collect(array_column(GameLobbyType::cases(), 'value'))->implode(',')],
            'rules' => ['required', 'string'],
            'baseEntranceFee' => ['required', 'numeric'],
            'minPlayers' => ['required', 'numeric', 'lte:max_players'],
            'maxPlayers' => ['required', 'numeric', 'gte:min_players'],
            'scheduledAt' => ['required', 'date'],
            'startAt' => ['required', 'date', 'after:scheduled_at'],
            'assetId' => ['required', 'exists:assets,id'],
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
