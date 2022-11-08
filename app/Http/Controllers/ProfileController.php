<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Enums\GenderEnum;
use App\Services\Internal\UserProfileAPI;
use App\Http\Requests\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function __construct(protected UserProfileAPI $userProfileAPI){
    }

    public function show()
    {
        $response = $this->userProfileAPI->userProfileInfo();
        $genders =  GenderEnum::toSelect();

        return Inertia::render('Profile', [
            'userProfileInfo' => $response->json(),
            'genders' => $genders,
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $httpResponse = $this->userProfileAPI->updateUserProfileInfo($request->validated());
        if ($httpResponse->successful()) {
            session()->flash('success', 'Profile Updated successfully!');
        } else {
            session()->flash('error', 'Something went wrong, please try again later.');
        }
    }
}
