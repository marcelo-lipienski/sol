<?php

namespace App\Domain\Service\Application\Http\Resources;

use App\Domain\Customer\Application\Http\Resources\CustomerResource;
use App\Domain\Equipment\Application\Http\Resources\EquipmentResource;
use App\Domain\Installation\Application\Http\Resources\InstallationResource;
use App\Domain\State\Application\Http\Resources\StateResource;
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
            'customer' => new CustomerResource($this->customer),
            'state' => new StateResource($this->state),
            'installation' => new InstallationResource($this->installation),
            'equipments' => EquipmentResource::collection($this->equipments)
        ];
    }

    public function jsonOptions()
    {
        return JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES;
    }
}
