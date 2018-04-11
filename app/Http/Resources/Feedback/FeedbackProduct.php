<?php

namespace App\Http\Resources\Feedback;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackProduct extends JsonResource
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
            'is_need_call' => $this->is_need_call,
            'is_urgent' => $this->is_urgent,
            'customer' => $this->customer,
            'customer_feedback' => $this->customer_feedback,
            'product' => $this->product,
            'productCategory' => $this->product_category->name,
            'tenantId' => $this->tenantId,
            'is_answered' => $this->is_answered,
            'attachment' => ($this->attachment == null ? null:asset($this->attachment)),
            'creator' => $this->created_by,
            'created_at' => $this->created_at->format('d-M-Y'),
            'show_edit_url' => route('feedback_product_list.edit', $this->systemId)
        ];
    }
}
