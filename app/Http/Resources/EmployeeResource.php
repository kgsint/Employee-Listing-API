<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'address' => $this->address,
            $this->mergeWhen($this->whenLoaded('user'), [
                'relationships' => [
                    'user' => UserResource::make($this->whenLoaded('user')), // show when eager load
                ]
            ])
        ];
    }
}
