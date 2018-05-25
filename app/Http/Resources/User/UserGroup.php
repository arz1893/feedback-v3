<?php

namespace App\Http\Resources\User;

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
            'feedback_crud_rights' => $this->getFeedbackCrudRights,
            'feedback_list_crud_rights' => $this->getFeedbackListCrudRights,
            'faq_crud_rights' => $this->getFaqCrudRights,
            'question_crud_rights' => $this->getQuestionCrudRights,
            'question_list_crud_rights' => $this->getQuestionListCrudRights,
            'show_url' => route('user_group.show', $this->systemId)
        ];
    }
}
