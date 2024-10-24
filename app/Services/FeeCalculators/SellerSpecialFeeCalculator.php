<?php

namespace App\Services\FeeCalculators;

use App\Contracts\Repositories\FeeConfigurationRepositoryInterface;
use App\Contracts\Services\FeeCalculatorInterface;

/**
 * Seller special fee calculator implementation
 */
class SellerSpecialFeeCalculator implements FeeCalculatorInterface
{
    public function __construct(
        private readonly FeeConfigurationRepositoryInterface $repository
    ) {}

    public function calculate(float $basePrice, string $vehicleType): float
    {
        $percentage = $this->repository->getSellerSpecialPercentage($vehicleType);
        $fee = $basePrice * ($percentage / 100);
        return round($fee, 2);
    }
}
