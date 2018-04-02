<?php

namespace App\Http\Resources\MasterData;

use Illuminate\Http\Resources\Json\JsonResource;

class Service extends JsonResource
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
            'serviceTags' => $this->tags,
            'show_service_url' => route('service.show', $this->systemId),
            'show_edit_service_url' => route('service.edit', $this->systemId),
            'show_faq_url' => route('faq_service.show', $this->systemId),
            'show_complaint_url' => route('show_complaint_service', [$this->systemId, 0]),
            'show_suggestion_url' => route('show_suggestion_service', [$this->systemId, 0])
        ];
    }
}
