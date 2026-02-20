<?php

namespace App\Actions\Fortify;

use App\Helpers\PhoneHelper;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => [
                'nullable',
                'phone:FR',
                Rule::unique('users', 'phone')->ignore($user->id),
            ],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ], [
            // --- Messages personnalisés ---
            'photo.max' => 'La photo ne doit pas dépasser 1 Mo (1024 ko).',
            'photo.uploaded' => 'Le fichier est trop lourd. Merci de choisir une photo de moins de 1 Mo.',
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => PhoneHelper::toE164($input['phone'] ?? null),
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => PhoneHelper::toE164($input['phone'] ?? null),
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
