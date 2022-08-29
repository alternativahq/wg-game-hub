<?php

namespace App\Actions\Games\GameLobbies;

use App\DataTransferObjects\GameMatchResultData;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

class DistributePrizesAction
{
    public function execute(GameMatchResultData $gameMatchResultData): void
    {
        // Loop over each user and distribute the prizes. (each user has its own job in queue)
        //        $responses = Http::pool(function (Pool $pool) use ($gameMatchResultData) {
        //            // Prepare the requests
        //            return collect($gameMatchResultData->scores)
        //                ->map(function ($userScore) use ($pool) {
        //                    return $pool
        //                        ->as($userScore->user_id)
        //                        ->retry(3, 2000)
        //                        ->post('/');
        //                })
        //                ->toArray();
        //        });
        //
        //        collect($responses)->each(function () {
        //            // Update database transaction marked as delivered
        //        });
    }
}
