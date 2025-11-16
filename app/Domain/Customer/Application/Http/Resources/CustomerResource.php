<?php

namespace App\Domain\Customer\Application\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $document = $this->formatDocument($this->document->value());

        return [
            'name' => $this->name->value(),
            'email' => $this->email->value(),
            'phone_number' => $this->phoneNumber->value(),
            'document' => $document,
        ];
    }

    private function formatDocument($document)
    {
        // Natural person document
        if (strlen($document) == 11) {
            return preg_replace(
                '/^(\d{3})(\d{3})(\d{3})(\d{2})$/',
                '$1.$2.$3-$4',
                $document
            );
        }

        return preg_replace(
            '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/',
            '$1.$2.$3/$4-$5',
            $document
        );
    }
}
