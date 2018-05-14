<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index() {
        return view('user.user_management_index');
    }

    /* API Section */
    public function addUser(Request $request) {
        return ['tenant_id' => $request->tenant_id, 'user\'s name' => $request->user['name'], 'user\'s phone' => $request->user['phone'], 'user\'s email' => $request->user['email'], 'role' => $request->user['role']];
    }
}
