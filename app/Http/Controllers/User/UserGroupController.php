<?php

namespace App\Http\Controllers\User;

use App\CustomerCrudRight;
use App\FaqCrudRight;
use App\FeedbackCrudRight;
use App\FeedbackListCrudRight;
use App\FeedbackProductCrudRight;
use App\FeedbackProductListCrudRight;
use App\FeedbackServiceCrudRight;
use App\FeedbackServiceListCrudRight;
use App\Http\Resources\User\UserGroupCollection;
use App\MasterDataRight;
use App\QuestionCrudRight;
use App\QuestionListCrudRight;
use App\ReportViewRights;
use App\User;
use App\UserGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserGroup as UserGroupResource;
use Webpatser\Uuid\Uuid;

class UserGroupController extends Controller
{
    public function index() {
        return view('user_group.user_group_index');
    }

    public function create() {
        return view('user_group.user_group_add');
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

    public function getUserGroup($usergroup_id) {
        $userGroup = UserGroup::findOrFail($usergroup_id);
        return ['user_group' => $userGroup];
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

    public function updateRoleRights(Request $request, $usergroup_id) {
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

        $feedbackProductCrudRight = $userGroup->getFeedbackProductCrudRights;
        $feedbackProductCrudRight->view = $request->user_group['feedback_product_view'];
        $feedbackProductCrudRight->show = $request->user_group['feedback_product_show'];
        $feedbackProductCrudRight->update();

        $feedbackProductListCrudRight = $userGroup->getFeedbackProductListCrudRights;
        $feedbackProductListCrudRight->view = $request->user_group['feedback_product_list_view'];
        $feedbackProductListCrudRight->answer = $request->user_group['feedback_product_list_answer'];
        $feedbackProductListCrudRight->edit = $request->user_group['feedback_product_list_edit'];
        $feedbackProductListCrudRight->delete = $request->user_group['feedback_product_list_delete'];
        $feedbackProductListCrudRight->update();

        $feedbackServiceCrudRight = $userGroup->getFeedbackSerivceCrudRights;
        $feedbackServiceCrudRight->view = $request->user_group['feedback_service_view'];
        $feedbackServiceCrudRight->show = $request->user_group['feedback_service_show'];
        $feedbackServiceCrudRight->update();

        $feedbackServiceListCrudRight = $userGroup->getFeedbackServiceListCrudRights;
        $feedbackServiceListCrudRight->view = $request->user_group['feedback_service_list_view'];
        $feedbackServiceListCrudRight->answer = $request->user_group['feedback_service_list_view'];
        $feedbackServiceListCrudRight->edit = $request->user_group['feedback_service_list_edit'];
        $feedbackServiceListCrudRight->delete = $request->user_group['feedback_service_list_delete'];
        $feedbackServiceListCrudRight->update();

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

        $reportViewRights = $userGroup->getReportViewRights;
        $reportViewRights->view = $request->user_group['report_view'];
        $reportViewRights->action = $request->user_group['report_action'];
        $reportViewRights->update();

        return ['message' => 'Role updated!'];
    }

    public function updateUserGroup(Request $request, $usergoup_id) {
        $userGroup = UserGroup::findOrFail($usergoup_id);
        $userGroup->name = $request->usergroup_name;
        $userGroup->update();
        return ['message' => 'Role updated!'];
    }

    public function addUserGroup(Request $request) {
        $userGroup = UserGroup::create([
            'systemId' => Uuid::generate(4),
            'name' => $request->user_group['name'],
            'recOwner' => $request->tenant_id,
            'syscreator' => $request->syscreator
        ]);

        if($userGroup != null) {
            FaqCrudRight::create([
                'usergroupid' => $userGroup->systemId,
                'view' => $request->user_group['faq_view'],
                'create' => $request->user_group['faq_create'],
                'edit' => $request->user_group['faq_edit'],
                'delete' => $request->user_group['faq_delete']
            ]);

            MasterDataRight::create([
                'usergroupid' => $userGroup->systemId,
                'view' => $request->user_group['master_data_view'],
                'create' => $request->user_group['master_data_create'],
                'edit' => $request->user_group['master_data_edit'],
                'delete' => $request->user_group['master_data_delete']
            ]);

            FeedbackProductCrudRight::create([
                'usergroupid' => $userGroup->systemId,
                'view' => $request->user_group['feedback_product_view'],
                'show' => $request->user_group['feedback_product_show']
            ]);

            FeedbackProductListCrudRight::create([
                'usergroupid' => $userGroup->systemId,
                'view' => $request->user_group['feedback_product_list_view'],
                'answer' => $request->user_group['feedback_product_list_answer'],
                'edit' => $request->user_group['feedback_product_list_edit'],
                'delete' => $request->user_group['feedback_product_list_delete']
            ]);

            FeedbackServiceCrudRight::create([
                'usergroupid' => $userGroup->systemId,
                'view' => $request->user_group['feedback_service_view'],
                'show' => $request->user_group['feedback_service_show'],
            ]);

            FeedbackServiceListCrudRight::create([
                'usergroupid' => $userGroup->systemId,
                'view' => $request->user_group['feedback_service_list_view'],
                'answer' => $request->user_group['feedback_service_list_answer'],
                'edit' => $request->user_group['feedback_service_list_edit'],
                'delete' => $request->user_group['feedback_service_list_delete']
            ]);

            QuestionCrudRight::create([
                'usergroupid' => $userGroup->systemId,
                'view' => $request->user_group['question_view'],
                'create' => $request->user_group['question_create'],
                'edit' => $request->user_group['question_edit'],
                'delete' => $request->user_group['question_delete'],
            ]);

            QuestionListCrudRight::create([
                'usergroupid' => $userGroup->systemId,
                'view' => $request->user_group['question_list_view'],
                'answer' => $request->user_group['question_list_answer'],
                'edit' => $request->user_group['question_list_edit'],
                'delete' => $request->user_group['question_list_delete']
            ]);

            CustomerCrudRight::create([
                'usergroupid' => $userGroup->systemId,
                'view' => $request->user_group['customer_view'],
                'create' => $request->user_group['customer_create'],
                'edit' => $request->user_group['customer_edit'],
                'delete' => $request->user_group['customer_delete'],
            ]);

            ReportViewRights::create([
                'usergroupid' => $userGroup->systemId,
                'view' => $request->user_group['report_view'],
                'action' => $request->user_group['report_action']
            ]);

            return ['message' => 'Role has been added'];
        } else {
            return ['error' => 'There is something wrong within the process'];
        }
    }

    public function deleteUserGroup(Request $request) {
        $userGroup = UserGroup::findOrFail($request->usergroup_id);
        $result = $userGroup->delete();

        if($result == true) {
            return ['message' => 'Role has been deleted'];
        } else {
            return ['error' => 'Invalid role'];
        }
    }
}
