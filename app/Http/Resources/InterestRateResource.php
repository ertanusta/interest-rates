<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InterestRateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'bank' => new BankResource($this->resource->bank()),
            'term_days' => $this->resource->term_days,
            'rate' => $this->resource->rate,
            'daily_rate' => $this->resource->daily_rate,
            'currency' => $this->resource->currency,
        ];
    }
}
