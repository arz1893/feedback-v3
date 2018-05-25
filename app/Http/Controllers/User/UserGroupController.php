<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\User\UserGroupCollection;
use App\User;
use App\UserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserGroupController extends Controller
{
    public function index() {
        return view('user_group.user_group_index');
    }

    /* API Section */
    public function getTenantUserRoles($tenant_id) {
        $userGroups = UserGroup::where('recOwner', $tenant_id)->orderBy('name', 'asc')->get();
        return new UserGroupCollection($userGroups);
    }

    public function getFaqCrudRights($user_id) {
        $user = User::findOrFail($user_id);
        $faqCrudRights = $user->user_group->getFaqCrudRights;
        return ['user_rights' => $faqCrudRights];
    }
}
