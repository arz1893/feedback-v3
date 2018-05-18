<?php

namespace App\Http\Controllers\User;

use App\Http\Resources\User\UserGroupCollection;
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
        $userGroups = UserGroup::where('recOwner', null)->orWhere('recOwner', $tenant_id)->orderBy('name', 'asc')->get();
        return new UserGroupCollection($userGroups);
    }
}
