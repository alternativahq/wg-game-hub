<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\UserAssetAccount;
use App\Http\Controllers\Controller;
use App\Http\Resources\AssetResource;
use App\Http\Resources\UserAssetAccountResource;
use App\Http\QueryPipelines\UserAssetAccountsPipeline\UserAssetAccountsPipeline;

class AssetAccountsController extends Controller
{
    public function __invoke(User $user, Request $request)
    {
        $assetAccounts = UserAssetAccountsPipeline::make(
            builder: UserAssetAccount::query()->whereBelongsTo($user),
            request: $request,
        );

        return Inertia::render('User/AssetAccounts', [
            'userAssetAccouns' => UserAssetAccountResource::collection($assetAccounts->with('asset')->paginate()->withQueryString()),
            'filters'          => $request->only('sort_by', 'sort_order', 'filter_by_asset'),
        ]);
    }
}
