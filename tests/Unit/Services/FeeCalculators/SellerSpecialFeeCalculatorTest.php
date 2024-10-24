<?php

namespace Tests\Unit\Services\FeeCalculators;

use App\Contracts\Repositories\FeeConfigurationRepositoryInterface;
use App\Services\FeeCalculators\SellerSpecialFeeCalculator;
use Mockery;
use Tests\TestCase;

class SellerSpecialFeeCalculatorTest extends TestCase
{
    private FeeConfigurationRepositoryInterface $repository;
    private SellerSpecialFeeCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(FeeConfigurationRepositoryInterface::class);
        $this->calculator = new SellerSpecialFeeCalculator($this->repository);
    }

    /**
     * @dataProvider feeCalculationProvider
     */
    public function test_calculates_fee_correctly(
        float $basePrice,
        string $vehicleType,
        float $percentage,
        float $expectedFee
    ): void {
        $this->repository
            ->shouldReceive('getSellerSpecialPercentage')
            ->with($vehicleType)
            ->once()
            ->andReturn($percentage);

        $fee = $this->calculator->calculate($basePrice, $vehicleType);

        $this->assertEquals($expectedFee, $fee);
    }

    public static function feeCalculationProvider(): array
    {
        return [
            'common vehicle fee' => [
                'basePrice' => 1000,
                'vehicleType' => 'common',
                'percentage' => 2,
                'expectedFee' => 20, // 2% of 1000
            ],
            'luxury vehicle fee' => [
                'basePrice' => 5000,
                'vehicleType' => 'luxury',
                'percentage' => 4,
                'expectedFee' => 200, // 4% of 5000
            ],
        ];
    }
}