<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class Customer extends JsonResource
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
            'address' => $this->address,
            'city' => $this->city,
            'email' => $this->email,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'birthdate' => date('d M Y', strtotime($this->birthdate)),
            'memo' => $this->memo,
            'tenantId' => $this->tenantId,
            'show_edit_url' => route('customer.edit', $this->systemId)
        ];
    }
}
