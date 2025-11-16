<?php

namespace App\Domain\Service\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'customer' => [
                'name' => $this->customer->name->value(),
                'email' => $this->customer->email->value(),
                'phone_number' => $this->customer->phoneNumber->value(),
                'document' => $this->customer->document->value(),
            ]
        ];
    }

    public function jsonOptions()
    {
        return JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES;
    }
}
