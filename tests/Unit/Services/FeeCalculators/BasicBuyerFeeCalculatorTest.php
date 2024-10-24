<?php

namespace Tests\Unit\Services\FeeCalculators;

use App\Contracts\Repositories\FeeConfigurationRepositoryInterface;
use App\Services\FeeCalculators\BasicBuyerFeeCalculator;
use Mockery;
use Tests\TestCase;

class BasicBuyerFeeCalculatorTest extends TestCase
{
    private FeeConfigurationRepositoryInterface $repository;
    private BasicBuyerFeeCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(FeeConfigurationRepositoryInterface::class);
        $this->calculator = new BasicBuyerFeeCalculator($this->repository);
    }

    /**
     * @dataProvider feeCalculationProvider
     */
    public function test_calculates_fee_correctly(
        float $basePrice,
        string $vehicleType,
        array $config,
        float $expectedFee
    ): void {
        $this->repository
            ->shouldReceive('getBasicBuyerConfig')
            ->with($vehicleType)
            ->once()
            ->andReturn($config);

        $fee = $this->calculator->calculate($basePrice, $vehicleType);

        $this->assertEquals($expectedFee, $fee);
    }

    public static function feeCalculationProvider(): array
    {
        return [
            'common vehicle below minimum' => [
                'basePrice' => 50,
                'vehicleType' => 'common',
                'config' => ['percentage' => 10, 'min' => 10, 'max' => 50],
                'expectedFee' => 10, // minimum fee
            ],
            'common vehicle at percentage' => [
                'basePrice' => 300,
                'vehicleType' => 'common',
                'config' => ['percentage' => 10, 'min' => 10, 'max' => 50],
                'expectedFee' => 30, // 10% of 300
            ],
            'common vehicle at maximum' => [
                'basePrice' => 1000,
                'vehicleType' => 'common',
                'config' => ['percentage' => 10, 'min' => 10, 'max' => 50],
                'expectedFee' => 50, // maximum fee
            ],
        ];
    }
}
