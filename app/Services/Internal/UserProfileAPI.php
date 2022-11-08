<?php

namespace App\Services\Internal;

use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class UserProfileAPI
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('wodo.user-profile-base-url');
    }

    public function userProfileInfo(): Response
    {
        $url = $this->baseUrl .'/' . auth()->user()->id;

        return Http::get($url);
    }
}
