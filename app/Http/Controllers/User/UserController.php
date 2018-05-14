<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\User\UserCollection;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index() {
        return view('user.user_management_index');
    }

    /* API Section */
    public function getAllUser($tenant_id) {
        $users = User::where('tenantId', $tenant_id)->orderBy('name', 'asc')->get();
        return new UserCollection($users);
    }

    public function addUser(Request $request) {
        return ['tenant_id' => $request->tenant_id, 'user\'s name' => $request->user['name'], 'user\'s phone' => $request->user['phone'], 'user\'s email' => $request->user['email'], 'role' => $request->user['role']];
    }
}
