<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\EuroExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailableDateResource extends JsonResource
{
    /**
     * @var EuroExchangeRate
     */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'date' => $this->resource->getRateRelevanceDate()->toDateString(),
        ];
    }
}
