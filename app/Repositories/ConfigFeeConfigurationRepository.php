<?php

namespace App\Repositories;

use App\Contracts\Repositories\FeeConfigurationRepositoryInterface;

/**
 * Configuration repository implementation using config files
 */
class ConfigFeeConfigurationRepository implements FeeConfigurationRepositoryInterface
{
    public function getBasicBuyerConfig(string $vehicleType): array
    {
        return config("fees.basic_buyer.$vehicleType");
    }

    public function getSellerSpecialPercentage(string $vehicleType): float
    {
        return config("fees.seller_special.$vehicleType");
    }

    public function getAssociationThresholds(): array
    {
        return config('fees.association.thresholds');
    }

    public function getStorageFee(): float
    {
        return config('fees.storage');
    }
}