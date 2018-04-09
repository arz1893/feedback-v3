<?php

namespace App\Http\Resources\Feedback;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackProductReply extends JsonResource
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
            'reply_content' => $this->systemId,
            'customerId' => $this->customerId,
            'feedbackProductId' => $this->feedbackProductId,
            'syscreator' => $this->created_by,
            'created_at' => $this->created_at->format('d-M-Y')
        ];
    }
}
