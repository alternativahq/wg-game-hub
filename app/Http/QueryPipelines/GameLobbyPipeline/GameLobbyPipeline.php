<?php

namespace App\Http\QueryPipelines\GameLobbyPipeline;

use App\Http\QueryPipelines\Filters\ExactFilter;
use App\Http\QueryPipelines\Filters\GreaterThanFilter;
use App\Http\QueryPipelines\Filters\LessThanFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class GameLobbyPipeline extends Pipeline
{
    protected ?Request $request;

    public function setRequest(Request $request): static
    {
        $this->request = $request;
        return $this;
    }

    protected function pipes(): array
    {
        return [
            new LessThanFilter(
                column: 'available_spots',
                request: $this->request,
                queryParamName: 'available_spots_lt',
            ),
            new GreaterThanFilter(
                column: 'available_spots',
                request: $this->request,
                queryParamName: 'available_spots_gt',
            ),
            new LessThanFilter(column: 'max_players', request: $this->request, queryParamName: 'max_players_lt'),
            new GreaterThanFilter(column: 'max_players', request: $this->request, queryParamName: 'max_players_gt'),
            new LessThanFilter(column: 'min_players', request: $this->request, queryParamName: 'min_players_lt'),
            new GreaterThanFilter(column: 'min_players', request: $this->request, queryParamName: 'min_players_gt'),
            new ExactFilter(column: 'state', request: $this->request),
            new LessThanFilter(
                column: 'base_entrance_fee',
                request: $this->request,
                queryParamName: 'base_entrance_fee_lt',
            ),
            new GreaterThanFilter(
                column: 'base_entrance_fee',
                request: $this->request,
                queryParamName: 'base_entrance_fee_gt',
            ),
        ];
    }

    public static function make(Builder $builder, Request $request)
    {
        return app(static::class)
            ->setRequest(request: $request)
            ->send($builder)
            ->thenReturn();
    }
}
