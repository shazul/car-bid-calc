<?php

namespace App\Services;

use App\Contracts\Services\FeeCalculatorInterface;

/**
 * Main service for calculating bids
 */
class BidCalculatorService
{
    /**
     * @param FeeCalculatorInterface[] $feeCalculators Array of fee calculators
     */
    public function __construct(
        private readonly array $feeCalculators,
        private readonly float $storageFee
    ) {}

    /**
     * Calculate the total bid amount and breakdown of all fees
     */
    public function calculate(float $basePrice, string $vehicleType): array
    {
        $fees = [
            'basePrice' => $basePrice,
            'storageFee' => $this->storageFee
        ];

        foreach ($this->feeCalculators as $name => $calculator) {
            $fees[$name] = $calculator->calculate($basePrice, $vehicleType);
        }

        $fees['total'] = $basePrice + array_sum(array_diff_key($fees, ['basePrice' => 0]));

        return $fees;
    }
}