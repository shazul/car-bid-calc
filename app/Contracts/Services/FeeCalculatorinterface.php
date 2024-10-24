<?php

namespace App\Contracts\Services;

/**
 * Interface for fee calculation strategies
 */
interface FeeCalculatorInterface
{
    /**
     * Calculate the fee amount
     *
     * @param float $basePrice
     * @param string $vehicleType
     * @return float
     */
    public function calculate(float $basePrice, string $vehicleType): float;
}
