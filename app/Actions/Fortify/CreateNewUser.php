<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

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
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'numeric', 'digits:11'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ], $this->messages())->validate();

        return User::create([
            'name' => $input['name'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ])->assignRole('client');
    }

    public function messages()
    {
        return [
            'name.required' => 'Debe indicar el nombre',
            'name.string' => 'Debe ser un texto',
            'name.max' => 'Debe contener máximo :max caracteres',
            'phone.required' => 'Debe indicar el teléfono',
            'phone.numeric' => 'Debe ser un número',
            'phone.digits' => 'Debe contener 11 dígitos',
            'email.required' => 'Debe indicar el correo electrónico',
            'email.string' => 'Debe ser un texto',
            'email.email' => 'Debe ser un correo electrónico válido',
            'email.max' => 'Debe contener máximo :max caracteres',
            'email.unique' => 'Este correo ya se encuentra registrado',
            'password.required' => 'Debe indicar la contraseña',
            'password.string' => 'Debe ser un texto',
        ];
    }
}
