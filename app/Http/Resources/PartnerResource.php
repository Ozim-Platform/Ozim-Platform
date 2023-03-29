<?php

namespace App\Http\Resources;

use App\Models\UserCertificates;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'title' => $this->title,
            'is_paid' => $this->is_paid,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'images' => $this->images,
            'is_changed' => UserCertificates::query()
                ->where('user_id', auth()->user()->id)
                ->where('partner_id', $this->id)
                ->exists(),
        ];
    }

}
