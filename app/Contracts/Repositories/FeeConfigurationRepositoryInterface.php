<?php

namespace App\Contracts\Repositories;

/**
 * Interface for fee configuration repository
 */
interface FeeConfigurationRepositoryInterface
{
    /**
     * Get basic buyer fee configuration for a vehicle type
     *
     * @param string $vehicleType
     * @return array{percentage: int, min: int, max: int}
     */
    public function getBasicBuyerConfig(string $vehicleType): array;

    /**
     * Get seller special fee percentage for a vehicle type
     *
     * @param string $vehicleType
     * @return float
     */
    public function getSellerSpecialPercentage(string $vehicleType): float;

    /**
     * Get association fee thresholds
     *
     * @return array<array{max: ?int, fee: int}>
     */
    public function getAssociationThresholds(): array;

    /**
     * Get storage fee
     *
     * @return float
     */
    public function getStorageFee(): float;
}