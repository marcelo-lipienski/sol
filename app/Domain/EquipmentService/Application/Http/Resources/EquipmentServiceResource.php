<?php

namespace App\Domain\EquipmentService\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'service_id' => $this->serviceId,
            'equipment' => [
                'name' => $this->name,
                'amount' => $this->amount
            ]
        ];
    }

    public function jsonOptions()
    {
        return JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES;
    }
}
