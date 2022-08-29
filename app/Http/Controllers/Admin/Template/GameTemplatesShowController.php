<?php

namespace App\Http\Controllers\Admin\Template;

use App\Models\Game;
use Inertia\Inertia;
use App\Models\GameLobby;
use Illuminate\Http\Request;
use App\Enums\GameLobbyStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\AdminGameLobbyTemplateResource;
use App\Http\QueryPipelines\AdminGameTemplatesPipeline\AdminGameTemplatesPipeline;


class GameTemplatesShowController extends Controller
{
    public function __invoke(Request $request, Game $game)
    {
        $gameTemplates = AdminGameTemplatesPipeline::make(
            builder: $game
                ->gameTemplates()
                ->getQuery(),
            request: $request,
        )
            ->with('asset:id,name,symbol')
            ->paginate();

        return Inertia::render('Admin/Template/GameTemplates', [
            'gameTemplates' => AdminGameLobbyTemplateResource::collection($gameTemplates->withQueryString()),
            'game' => $game,
            'filters' => $request->only('sort_by', 'sort_order','q'),
        ]);
    }
}
