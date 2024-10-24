<?php

namespace App\Services\FeeCalculators;

use App\Contracts\Repositories\FeeConfigurationRepositoryInterface;
use App\Contracts\Services\FeeCalculatorInterface;

/**
 * Basic buyer fee calculator implementation
 */
class BasicBuyerFeeCalculator implements FeeCalculatorInterface
{
    public function __construct(
        private readonly FeeConfigurationRepositoryInterface $repository
    ) {}

    public function calculate(float $basePrice, string $vehicleType): float
    {
        $config = $this->repository->getBasicBuyerConfig($vehicleType);
        $fee = $basePrice * ($config['percentage'] / 100);
        return max($config['min'], min($fee, $config['max']));
    }
}
