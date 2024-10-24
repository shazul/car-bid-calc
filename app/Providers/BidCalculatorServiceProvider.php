<?php

namespace App\Providers;

use App\Contracts\Repositories\FeeConfigurationRepositoryInterface;
use App\Contracts\Services\FeeCalculatorInterface;
use App\Repositories\ConfigFeeConfigurationRepository;
use App\Services\BidCalculatorService;
use App\Services\FeeCalculators\AssociationFeeCalculator;
use App\Services\FeeCalculators\BasicBuyerFeeCalculator;
use App\Services\FeeCalculators\SellerSpecialFeeCalculator;
use Illuminate\Support\ServiceProvider;

class BidCalculatorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind repository implementation
        $this->app->bind(
            FeeConfigurationRepositoryInterface::class,
            ConfigFeeConfigurationRepository::class
        );

        // Register fee calculators
        $this->app->when(BidCalculatorService::class)
            ->needs('$feeCalculators')
            ->give(function ($app) {
                return [
                    'basicBuyerFee' => $app->make(BasicBuyerFeeCalculator::class),
                    'sellerSpecialFee' => $app->make(SellerSpecialFeeCalculator::class),
                    'associationFee' => $app->make(AssociationFeeCalculator::class),
                ];
            });

        // Register storage fee
        $this->app->when(BidCalculatorService::class)
            ->needs('$storageFee')
            ->give(function ($app) {
                return $app->make(FeeConfigurationRepositoryInterface::class)->getStorageFee();
            });
    }

    public function boot(): void
    {
        // Publish config file
        $this->publishes([
            __DIR__.'/../../config/fees.php' => config_path('fees.php'),
        ], 'config');
    }
}