<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetCurrenciesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'dates' => 'sometimes|array',
            'currencies' => 'sometimes|array',
        ];
    }

    // better to use DTO, but don't want to load too many packages in such simple project
    public function filters(): array
    {
        return [
            'dates' => $this->input('dates'),
            'currencies' => $this->input('currencies'),
        ];
    }
}
