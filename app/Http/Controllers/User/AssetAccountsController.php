<?php

namespace App\Http\Controllers\User;

use App\Builders\AssetBuilder;
use App\Http\Resources\UserAssetAccountPageResource;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\QueryPipelines\UserAssetAccountsPipeline\UserAssetAccountsPipeline;

class AssetAccountsController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        $userAssetAccounts = $user->assets()->when(true, function (AssetBuilder $query) use ($request) {
            return UserAssetAccountsPipeline::make($query, $request);
        });

        $assets = Asset::get(['id', 'name', 'symbol', 'description']);

        return Inertia::render('User/AssetAccounts', [
            'userAssetAccounts' => UserAssetAccountPageResource::collection($userAssetAccounts->paginate()->withQueryString()),
            'assets' => $assets,
            'filters' => $request->only('sort_by', 'sort_order', 'q'),
        ]);
    }
}
