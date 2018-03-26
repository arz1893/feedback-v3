<?php

namespace App\Http\Controllers\Auth;

use App\Tenant;
use App\User;
use App\Http\Controllers\Controller;
use App\UserGroup;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];

        $messages = [
            'name.required' => 'Please enter your business name',
            'category_id' => 'You haven\'t select business category',
            'email.required' => 'PLease enter your email address',
            'email.unique' => 'This email address has already taken',
            'password.required' => 'Please enter your password',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $tenant = Tenant::create([
            'systemId' => (string) Str::orderedUuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'country_id' => $data['country_id'],
            'address' => $data['address'],
            'description' => $data['description']
        ]);


        $userGroup = UserGroup::where('name', 'Administrator')->first();

        $user = User::create([
            'systemId' => (string) Str::orderedUuid(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'usergroupId' => $userGroup->systemId,
            'tenantId' => $tenant->systemId,
            'active' => 1,
        ]);

        return $user;
    }
}
