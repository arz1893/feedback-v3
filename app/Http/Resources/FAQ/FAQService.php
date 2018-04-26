<?php

namespace App\Http\Resources\FAQ;

use Illuminate\Http\Resources\Json\JsonResource;

class FAQService extends JsonResource
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
            'question' => $this->question,
            'answer' => $this->answer,
            'serviceId' => $this->serviceId
        ];
    }
}
