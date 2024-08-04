<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @mixin Builder */
class Currency extends Model
{
    use HasFactory;

    protected $table = 'currencies';

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getCode(): string
    {
        return $this->getAttribute('code');
    }

    public function euroExchangeRates(): HasMany
    {
        return $this->hasMany(EuroExchangeRate::class, 'currency_id', 'id');
    }
}
