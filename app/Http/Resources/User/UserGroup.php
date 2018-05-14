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
            'syscreator' => ($this->syscreator == null ? null:$this->created_by->name)
        ];
    }
}
