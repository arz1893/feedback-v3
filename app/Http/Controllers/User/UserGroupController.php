<?php

namespace App\Http\Controllers\User;

use App\CustomerCrudRight;
use App\FaqCrudRight;
use App\Http\Resources\User\UserGroupCollection;
use App\User;
use App\UserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserGroup as UserGroupResource;

class UserGroupController extends Controller
{
    public function index() {
        return view('user_group.user_group_index');
    }

    public function show($usergorup_id) {
        $userGroup = UserGroup::findOrFail($usergorup_id);
        return view('user_group.user_group_show', compact('userGroup'));
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

    public function getRoleRights($usergroup_id) {
        $userGroup = UserGroup::findOrFail($usergroup_id);
        return new UserGroupResource($userGroup);
    }

    public function updateUserRole(Request $request, $usergroup_id) {
        $userGroup = UserGroup::findOrFail($usergroup_id);

        $faqCrudRight = $userGroup->getFaqCrudRights;
        $faqCrudRight->view = $request->user_group['faq_view'];
        $faqCrudRight->create = $request->user_group['faq_create'];
        $faqCrudRight->edit = $request->user_group['faq_edit'];
        $faqCrudRight->delete = $request->user_group['faq_delete'];
        $faqCrudRight->update();

        $masterDataRight = $userGroup->getMasterDataRights;
        $masterDataRight->view = $request->user_group['master_data_view'];
        $masterDataRight->create = $request->user_group['master_data_create'];
        $masterDataRight->edit = $request->user_group['master_data_edit'];
        $masterDataRight->delete = $request->user_group['master_data_delete'];
        $masterDataRight->update();

        $feedbackRights = $userGroup->getFeedbackCrudRights;
        $feedbackRights->view = $request->user_group['feedback_view'];
        $feedbackRights->create = $request->user_group['feedback_create'];
        $feedbackRights->edit = $request->user_group['feedback_edit'];
        $feedbackRights->delete = $request->user_group['feedback_delete'];
        $feedbackRights->update();

        $feedbackListRights = $userGroup->getFeedbackListCrudRights;
        $feedbackListRights->view = $request->user_group['feedback_list_view'];
        $feedbackListRights->answer = $request->user_group['feedback_list_answer'];
        $feedbackListRights->edit = $request->user_group['feedback_list_edit'];
        $feedbackListRights->delete = $request->user_group['feedback_list_delete'];
        $feedbackListRights->update();

        $questionCrudRights = $userGroup->getQuestionCrudRights;
        $questionCrudRights->view = $request->user_group['question_view'];
        $questionCrudRights->create = $request->user_group['question_create'];
        $questionCrudRights->edit = $request->user_group['question_edit'];
        $questionCrudRights->delete = $request->user_group['question_delete'];
        $questionCrudRights->update();

        $questionListCrudRights = $userGroup->getQuestionListCrudRights;
        $questionListCrudRights->view = $request->user_group['question_list_view'];
        $questionListCrudRights->answer = $request->user_group['question_list_answer'];
        $questionListCrudRights->edit = $request->user_group['question_list_edit'];
        $questionListCrudRights->delete = $request->user_group['question_list_delete'];
        $questionListCrudRights->update();

        $customerCrudRights = $userGroup->getCustomerCrudRights;
        $customerCrudRights->view = $request->user_group['customer_view'];
        $customerCrudRights->create = $request->user_group['customer_create'];
        $customerCrudRights->edit = $request->user_group['customer_edit'];
        $customerCrudRights->delete = $request->user_group['customer_delete'];
        $customerCrudRights->update();

        return ['message' => 'Role updated!'];
    }
}
