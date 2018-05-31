<?php

namespace App\Http\Resources\User;

use App\CustomerCrudRight;
use Illuminate\Http\Resources\Json\JsonResource;

class UserGroup extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'systemId' => $this->systemId,
            'name' => $this->name,
            'recOwner' => $this->recOwner,
            'syscreator' => ($this->syscreator == null ? null:$this->created_by->name),
            'master_data_rights' => $this->getMasterDataRights,
            'feedback_product_crud_rights' => $this->getFeedbackProductCrudRights,
            'feedback_product_list_crud_rights' => $this->getFeedbackProductListCrudRights,
            'feedback_service_crud_rights' => $this->getFeedbackServiceCrudRights,
            'feedback_service_list_crud_rights' => $this->getFeedbackServiceListCrudRights,
            'faq_crud_rights' => $this->getFaqCrudRights,
            'question_crud_rights' => $this->getQuestionCrudRights,
            'question_list_crud_rights' => $this->getQuestionListCrudRights,
            'customer_crud_rights' => $this->getCustomerCrudRights,
            'report_view_rights' => $this->getReportViewRights,
            'show_url' => route('user_group.show', $this->systemId)
        ];
    }
}
