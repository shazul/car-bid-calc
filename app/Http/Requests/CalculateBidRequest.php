<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculateBidRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'basePrice' => ['required', 'numeric', 'min:0'],
            'vehicleType' => ['required', 'string', 'in:common,luxury'],
        ];
    }
}