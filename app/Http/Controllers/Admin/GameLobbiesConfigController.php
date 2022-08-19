<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GameLobby;
use App\Models\Game;
use Inertia\Inertia;
use App\Enums\GameStatus;
use App\Http\Resources\GameResource;
use App\Http\Resources\GameLobbyResource;
use App\Http\Requests\GameLobbyInsertRequest;

class GameLobbiesConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $games = Game::all();

        return Inertia::render('Admin/AddGameLobby', ['games' => $games]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $game_name = $request->game_name;
        $game = DB::table('games')
            ->where('name', $game_name)
            ->get();

        $gameLobby = GameLobby::create([
            'name' => $request->name,
            'image' => $request->image,
            'theme_color' => $request->theme_color,
            'type' => $request->type,
            'rules' => $request->rules,
            'base_entrance_fee' => $request->base_entrance_fee,
            'description' => $request->description,
            'available_spots' => $request->available_spots,
            'game_id' => $game->id,
        ]);

        $gameLobby->save();

        // DB::table('game_lobbies')
        // ->create(['name' => $request->name ,
        //           'image' => $request->image,
        //           'theme_color' =>$request->theme_color,
        //           'type' => $request->type,
        //           'rules'=>$request->rules,
        //           'base_entrance_fee'=> $request->base_entrance_fee,
        //           'description' => $request->description,
        //           'available_spots' => $request->available_spots,
        //         ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $gameLobby = GameLobby::find($id);

        return Inertia::render('Admin/EditGameLobby', [
            'gameLobby' => new GameLobbyResource($gameLobby),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GameLobbyInsertRequest $request, $id)
    {
        DB::table('game_lobbies')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'image' => $request->image,
                'theme_color' => $request->theme_color,
                'type' => $request->type,
                'rules' => $request->rules,
                'base_entrance_fee' => $request->base_entrance_fee,
                'description' => $request->description,
                'available_spots' => $request->available_spots,
            ]);

        $gamelobby = GameLobby::find($id);
        $gameId = $gamelobby->game_id;
        return redirect()->route('admin-control-panel-game-lobbies', ['game' => $gameId]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gamelobby = GameLobby::find($id);
        $gameId = $gamelobby->game_id;
        $gamelobby->delete();
        return redirect()->route('admin-control-panel-game-lobbies', ['game' => $gameId]);
    }
}
