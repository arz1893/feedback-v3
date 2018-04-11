<?php

namespace App\Http\Resources\Feedback;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackServiceReply extends JsonResource
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
            'reply_content' => $this->reply_content,
            'customerId' => $this->customerId,
            'feedbackServiceId' => $this->feedbackServiceId,
            'syscreator' => $this->created_by,
            'syscreator_role' => $this->created_by->user_group->name,
            'created_at' => $this->created_at->format('d-M-Y H:i:s')
        ];
    }
}
