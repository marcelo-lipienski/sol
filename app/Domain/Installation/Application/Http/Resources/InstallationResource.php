<?php

namespace App\Domain\Installation\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstallationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function jsonOptions()
    {
        return JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES;
    }
}
