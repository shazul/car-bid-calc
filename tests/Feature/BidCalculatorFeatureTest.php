<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BidCalculatorFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_calculates_common_vehicle_bid(): void
    {
        $response = $this->postJson('/api/calculate-bid', [
            'basePrice' => 1100,
            'vehicleType' => 'common'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'basePrice' => 1100,
                    'basicBuyerFee' => 50,
                    'sellerSpecialFee' => 22,
                    'associationFee' => 15,
                    'storageFee' => 100,
                    'total' => 1287,
                ]
            ]);
    }

    public function test_calculates_luxury_vehicle_bid(): void
    {
        $response = $this->postJson('/api/calculate-bid', [
            'basePrice' => 1800,
            'vehicleType' => 'luxury'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'basePrice' => 1800,
                    'basicBuyerFee' => 180,
                    'sellerSpecialFee' => 72,
                    'associationFee' => 15,
                    'storageFee' => 100,
                    'total' => 2167
                ]
            ]);
    }

    public function test_validates_request_input(): void
    {
        $response = $this->postJson('/api/calculate-bid', [
            'basePrice' => -100,
            'vehicleType' => 'invalid'
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['basePrice', 'vehicleType']);
    }
}