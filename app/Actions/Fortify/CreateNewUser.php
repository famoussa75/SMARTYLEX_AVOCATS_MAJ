<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $request = new Request;
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        if (isset($request->photo)) {

            $fichier = request()->file('photo');
            $filename = strtoupper(substr(str_shuffle(md5($request->_token . "" . rand(124, 345))), 0, 4)) . date('YmdHi') . '.' . $fichier->extension();
            $path = 'assets/upload/photos/'.$filename;
            $fichier->move(public_path('assets/upload/photos'), $filename);
        }else {
            $path ='assets/upload/photo.jpg';
        }

        
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'statut' => $input['statut'],
            'role' => 'Administrateur',
            'photo' => $path,
            'initial' => $input['initial'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
