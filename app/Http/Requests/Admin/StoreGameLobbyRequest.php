<?php

namespace App\Http\Requests\Admin;

use App\Enums\GameLobbyType;
use App\Enums\GameLobbyAlgorithmsType;
use Illuminate\Foundation\Http\FormRequest;

class StoreGameLobbyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => ['required', 'uuid'],
            'gameId' => ['required', 'uuid', 'exists:games,id'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'image' => ['required', 'string'],
            'themeColor' => ['required', 'string'],
            'gameMode' => [
                'required',
                'in:' .
                collect(GameLobbyType::cases())
                    ->map(fn(GameLobbyType $item) => $item->toGameLobbyServiceValue())
                    ->implode(','),
            ],
            'asset' => ['required', 'exists:assets,symbol'],
            'rules' => ['required', 'string'],
            'baseEntranceFee' => ['required', 'numeric'],
            'minPlayers' => ['required', 'numeric', 'lte:maxPlayers'],
            'maxPlayers' => ['required', 'numeric', 'gte:minPlayers'],
            'commission' => ['required', 'numeric'],
            'scheduledAt' => ['required', 'date'],
            'startsAt' => ['required', 'date', 'after:scheduled_at'],
            'gamePlayDuration' => ['required_unless:gameMode,ONE_V_ONE', 'numeric'],
            'algorithmId' => [
                'required',
                'in:' . collect(array_column(GameLobbyAlgorithmsType::cases(), 'value'))->implode(','),
            ],
            'gameStartDelayTime' => ['nullable', 'numeric'],
            'gameStartDelayLimit' => ['nullable', 'numeric'],
        ];
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

    public function authorize(): bool
    {
        return true;
    }
}
