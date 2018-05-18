<?php

namespace App\Http\Controllers\Auth;

use App\Invite;
use App\Tenant;
use App\User;
use App\Http\Controllers\Controller;
use App\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

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
            'systemId' => Uuid::generate(4),
            'name' => $data['name'],
            'email' => $data['email'],
            'country_id' => $data['country_id'],
            'address' => $data['address'],
            'description' => $data['description']
        ]);


        $userGroup = UserGroup::where('name', 'Administrator')->first();

        $user = User::create([
            'systemId' => Uuid::generate(4),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'usergroupId' => $userGroup->systemId,
            'tenantId' => $tenant->systemId,
            'active' => 1,
        ]);

        return $user;
    }

    protected function acceptInvitation($token) {
        $invitation = Invite::where('token', $token)->first();
        if($invitation != null) {
            if($invitation->is_expired == 1) {
                return view('layouts.errors.invitation_expired');
            } else if($invitation->is_expired == 0) {
                return view('auth.account_setup', compact('invitation'));
            }
        }
        return abort(404);
    }

    protected function registerViaEmail(Request $request, $id) {
        $this->validator($request->all());

        $invite = Invite::findOrFail($id);
        $user = User::create([
            'systemId' => Uuid::generate(4),
            'name' => $invite->name,
            'email' => $invite->email,
            'phone' => $request->phone,
            'tenantId' => $request->tenantId,
            'usergroupId' => $request->usergroupId,
            'password' => bcrypt($request->password),
            'active' => 1,
            'syscreator' => $invite->userId
        ]);

        $invite->is_expired = 1;
        $invite->update();

        Auth::login($user);
        return redirect($this->redirectTo);
    }
}
