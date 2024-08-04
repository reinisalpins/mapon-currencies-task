<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EuroExchangeRateResourceCollection extends ResourceCollection
{
    public $collects = EuroExchangeRateResource::class;
}
