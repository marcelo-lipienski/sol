<?php

namespace App\Domain\Equipment\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'equipment' => [
                'name' => $this->name,
                'amount' => $this->pivot->amount
            ]
        ];
    }

    public function jsonOptions()
    {
        return JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES;
    }
}
