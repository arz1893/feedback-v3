<?php

namespace App\Http\Resources\MasterData;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'img' => ($this->img == null ? asset('default-images/no-image.jpg'):asset($this->img)),
            'productTags' => $this->tags,
            'show_product_url' => route('product.show', $this->systemId),
            'show_edit_product_url' => route('product.edit', $this->systemId),
            'show_feedback_url' => route('feedback_product.show', $this->systemId),
            'show_report_url' => route('feedback_product_report_detail_yearly', $this->systemId),
            'show_faq_url' => route('faq_product.show', $this->systemId)
        ];
    }
}
