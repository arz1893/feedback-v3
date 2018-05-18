<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\User\UserCollection;
use App\Invite;
use App\Mail\UserInvitation;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Webpatser\Uuid\Uuid;

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

    /* API Section */

    public function addUser(Request $request) {
        $token = str_random(16);
        $creator = User::findOrFail($request->creator_id);

        Invite::create([
            'systemId' => Uuid::generate(4),
            'name' => $request->user['name'],
            'email' => $request->user['email'],
            'token' => $token,
            'tenantId' => $request->tenant_id,
            'userId' => $creator->systemId,
            'usergroupId' => $request->user['role']
        ]);

        $mail = new \stdClass();
        $mail->sender_name = $creator->name;
        $mail->sender_email = $creator->email;
        $mail->receiver_name = $request->user['name'];
        $mail->receiver_email = $request->user['email'];
        $mail->token = $token;

        try {
            Mail::to($request->user['email'])->send(new UserInvitation($mail));
            return ['info' => 'message sent'];
        } catch (\Exception $ex) {
            return ['error' => $ex->getMessage()];
        }
    }

    public function deleteUser(Request $request) {
        $user = User::findOrFail($request->user_id);
        $user->delete();

        return ['message' => 'User has been deleted'];
    }
}
