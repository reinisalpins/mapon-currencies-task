<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AvailableDateResourceCollection extends ResourceCollection
{
    public $collects = AvailableDateResource::class;
}
