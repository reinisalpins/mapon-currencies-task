<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyCodeResource extends JsonResource
{
    /**
     * @var Currency
     */
    public $resource;

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getId(),
            'code' => $this->resource->getCode(),
        ];
    }
}
