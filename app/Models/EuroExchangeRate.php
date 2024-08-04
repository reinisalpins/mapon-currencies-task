<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @mixin Builder */
class EuroExchangeRate extends Model
{
    use HasFactory;

    protected $casts = [
        'rate_relevance_date' => 'datetime',
    ];

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getRate(): float
    {
        return $this->getAttribute('rate');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function getRateRelevanceDate(): Carbon
    {
        return $this->getAttribute('rate_relevance_date');
    }
}
