<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\Users;
use App\Models\StoreUsers; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): Users
    {
        
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:50'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            
            // create the user
            $user = Users::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'password' => Hash::make($input['password']),
            ]);

            // if exists store_id create a store user
            if (!empty($input['store_id'])) {

                StoreUsers::create([
                    'user_id' => $user->id,
                    'store_id' => $input['store_id'],
                    'access_level' => $input['access_level'] ?? 'USER',
                    'position' => $input['position'] ?? 'Colaborador', 
                    'created_by_user_id' => $user->id,
                ]);
                
            }

            return $user;
        });
    }

    /**
     * Create a personal team for the user.
     */
    protected function createTeam(Users $user): void
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));
    }
}