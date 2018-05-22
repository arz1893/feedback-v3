<?php

namespace App\Http\Resources\MasterData;

use Illuminate\Http\Resources\Json\JsonResource;

class Tag extends JsonResource
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
            'bgColor' => $this->bgColor,
            'defValue' => $this->defValue,
            'recOwner' => $this->recOwner,
            'edit_url' => route('tag.edit', $this->systemId),
            'report_url' => route('tag_detail_report_yearly', $this->systemId)
        ];
    }
}
