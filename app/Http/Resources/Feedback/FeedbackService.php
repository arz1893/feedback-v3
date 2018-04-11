<?php

namespace App\Http\Resources\Feedback;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackService extends JsonResource
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
            'customer_rating' => $this->customer_rating,
            'customer_feedback' => $this->customer_feedback,
            'is_need_call' => $this->is_need_call,
            'is_urgent' => $this->is_urgent,
            'customer' => $this->customer,
            'service' => $this->service,
            'serviceCategory' => $this->service_category->name,
            'tenantId' => $this->tenantId,
            'is_answered' => $this->is_answered,
            'attachment' => ($this->attachment == null ? null:asset($this->attachment)),
            'creator' => $this->created_by,
            'created_at' => $this->created_at->format('d-M-Y H:i:s')
        ];
    }
}
