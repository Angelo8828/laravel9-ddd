<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'username' => $this->username,
            'email'    => $this->email,
            'address'  => [
                'street'  => $this->address_street,
                'suite'   => $this->address_suite,
                'city'    => $this->address_city,
                'zipcode' => $this->address_zipcode,
                'geo'     => [
                    'lat' => $this->address_geo_lat,
                    'lng' => $this->address_geo_lng,
                ]
            ],
            'phone'    => $this->phone,
            'website'  => $this->website,
            'company'  => [
                'name'        => $this->company_name,
                'catchPhrase' => $this->company_catch_phrase,
                'bs'          => $this->company_business_strength,
            ]
        ];
    }
}
