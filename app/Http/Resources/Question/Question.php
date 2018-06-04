<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Resources\Json\JsonResource;

class Question extends JsonResource
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
            'customer' => $this->customer,
            'question' => $this->question,
            'answer' => $this->answer,
            'is_need_call' => $this->is_need_call,
            'tenantId' => $this->tenantId,
            'is_answered' => $this->is_answered,
            'syscreator' => $this->created_by,
            'created_at' => $this->created_at->format('d M Y H:i:sA'),
            'show_edit_url' => route('question_list.edit', $this->systemId)
        ];
    }
}
