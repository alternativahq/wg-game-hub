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
            'scoreCard' => [
                'required',
                'array',
                new AllExistsInArrayOfObjects(modelClass: User::class, column: 'id', objectAttribute: 'user_id'),
                // Todo: All belongs to lobby
            ],
            'achievements' => [
                'present',
                'array',
                new AllExistsInArrayOfObjects(
                    modelClass: Achievement::class,
                    column: 'id',
                    objectAttribute: 'achievement_id',
                ),
                new AllExistsInArrayOfObjects(User::class, 'id', 'user_id'),
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
