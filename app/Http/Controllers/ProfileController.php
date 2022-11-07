<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Services\Internal\UserProfileAPI;

class ProfileController extends Controller
{
    public function __construct(protected UserProfileAPI $userProfileAPI){
    }

    public function __invoke()
    {
        $response = $this->userProfileAPI->userProfileInfo();
        // dd($response->json());
        return Inertia::render('Profile', [
            'userProfileInfo' => $response->json(),
        ]);
    }
}
