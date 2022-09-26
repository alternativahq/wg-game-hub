<?php

namespace App\Http\Requests;

use App\Models\Achievement;
use App\Models\User;
use App\Rules\AllExistsInArrayOfObjects;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GameMatchResultsPayloadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'lobbyId' => ['required', 'string', 'exists:game_lobbies,id'],
            'gameId' => ['required', 'string', 'exists:games,id'],
            'scoreCard' => [
                'required',
                'array',
                new AllExistsInArrayOfObjects(modelClass: User::class, column: 'id', objectAttribute: 'userId'),
                // Todo: All belongs to lobby
            ],
            'achievements' => [
                'present',
                'array',
                new AllExistsInArrayOfObjects(
                    modelClass: Achievement::class,
                    column: 'id',
                    objectAttribute: 'achievementId',
                ),
                new AllExistsInArrayOfObjects(User::class, 'id', 'userId'),
                // Todo: All belongs to lobby
            ],
            'scores.*.userId' => ['required', 'uuid'],
            'scores.*.rank' => ['required', 'numeric'],
            'scores.*.score' => ['required', 'numeric'],
            'scores.*.timePlayed' => ['required', 'numeric'],
            'achievements.*.userId' => ['required', 'uuid'],
            'achievements.*.achievementId' => ['required', 'uuid'],
            'achievements.*.additionalInfo' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
