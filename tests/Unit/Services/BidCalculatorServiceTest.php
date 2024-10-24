<?php

namespace Tests\Unit\Services;

use App\Contracts\Services\FeeCalculatorInterface;
use App\Services\BidCalculatorService;
use Mockery;
use Tests\TestCase;

class BidCalculatorServiceTest extends TestCase
{
    private array $feeCalculators;
    private BidCalculatorService $service;
    private const STORAGE_FEE = 100.0;

    protected function setUp(): void
    {
        parent::setUp();

        $this->feeCalculators = [
            'basicBuyerFee' => Mockery::mock(FeeCalculatorInterface::class),
            'sellerSpecialFee' => Mockery::mock(FeeCalculatorInterface::class),
            'associationFee' => Mockery::mock(FeeCalculatorInterface::class),
        ];

        $this->service = new BidCalculatorService(
            $this->feeCalculators,
            self::STORAGE_FEE
        );
    }

    public function test_calculates_total_bid_correctly(): void
    {
        $basePrice = 1000;
        $vehicleType = 'common';

        $this->feeCalculators['basicBuyerFee']
            ->shouldReceive('calculate')
            ->with($basePrice, $vehicleType)
            ->once()
            ->andReturn(50.0);

        $this->feeCalculators['sellerSpecialFee']
            ->shouldReceive('calculate')
            ->with($basePrice, $vehicleType)
            ->once()
            ->andReturn(20.0);

        $this->feeCalculators['associationFee']
            ->shouldReceive('calculate')
            ->with($basePrice, $vehicleType)
            ->once()
            ->andReturn(10.0);

        $result = $this->service->calculate($basePrice, $vehicleType);

        $this->assertEquals([
            'basePrice' => 1000.0,
            'basicBuyerFee' => 50.0,
            'sellerSpecialFee' => 20.0,
            'associationFee' => 10.0,
            'storageFee' => self::STORAGE_FEE,
            'total' => 1180.0,
        ], $result);
    }
}