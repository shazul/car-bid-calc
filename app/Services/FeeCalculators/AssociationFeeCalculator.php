<?php

namespace App\Services\FeeCalculators;

use App\Contracts\Repositories\FeeConfigurationRepositoryInterface;
use App\Contracts\Services\FeeCalculatorInterface;

/**
 * Association fee calculator implementation
 */
class AssociationFeeCalculator implements FeeCalculatorInterface
{
    public function __construct(
        private readonly FeeConfigurationRepositoryInterface $repository
    ) {}

    public function calculate(float $basePrice, string $vehicleType): float
    {
        $thresholds = $this->repository->getAssociationThresholds();
        foreach ($thresholds as $threshold) {
            if (!$threshold['max'] || $basePrice <= $threshold['max']) {
                return $threshold['fee'];
            }
        }
        return end($thresholds)['fee'];
    }
}