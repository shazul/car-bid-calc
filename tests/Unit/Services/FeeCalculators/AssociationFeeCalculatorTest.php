<?php

namespace Tests\Unit\Services\FeeCalculators;

use App\Contracts\Repositories\FeeConfigurationRepositoryInterface;
use App\Services\FeeCalculators\AssociationFeeCalculator;
use Mockery;
use Tests\TestCase;

class AssociationFeeCalculatorTest extends TestCase
{
    private FeeConfigurationRepositoryInterface $repository;
    private AssociationFeeCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(FeeConfigurationRepositoryInterface::class);
        $this->calculator = new AssociationFeeCalculator($this->repository);
    }

    /**
     * @dataProvider feeCalculationProvider
     */
    public function test_calculates_fee_correctly(
        float $basePrice,
        float $expectedFee
    ): void {
        $this->repository
            ->shouldReceive('getAssociationThresholds')
            ->once()
            ->andReturn([
                ['max' => 500, 'fee' => 5],
                ['max' => 1000, 'fee' => 10],
                ['max' => 3000, 'fee' => 15],
                ['max' => null, 'fee' => 20],
            ]);

        $fee = $this->calculator->calculate($basePrice, 'any');

        $this->assertEquals($expectedFee, $fee);
    }

    public static function feeCalculationProvider(): array
    {
        return [
            'price in first threshold' => [
                'basePrice' => 400,
                'expectedFee' => 5,
            ],
            'price in second threshold' => [
                'basePrice' => 800,
                'expectedFee' => 10,
            ],
            'price in third threshold' => [
                'basePrice' => 2500,
                'expectedFee' => 15,
            ],
            'price in final threshold' => [
                'basePrice' => 5000,
                'expectedFee' => 20,
            ],
        ];
    }
}
