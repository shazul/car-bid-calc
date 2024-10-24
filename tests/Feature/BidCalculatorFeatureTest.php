<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BidCalculatorFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_calculates_common_vehicle_bid(): void
    {
        $response = $this->postJson('/api/calculate-bid', [
            'basePrice' => 1000,
            'vehicleType' => 'common'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'basePrice' => 1000,
                    'basicBuyerFee' => 50,
                    'sellerSpecialFee' => 20,
                    'associationFee' => 10,
                    'storageFee' => 100,
                    'total' => 1180,
                ]
            ]);
    }

    public function test_calculates_luxury_vehicle_bid(): void
    {
        $response = $this->postJson('/api/calculate-bid', [
            'basePrice' => 5000,
            'vehicleType' => 'luxury'
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'basePrice' => 5000,
                    'basicBuyerFee' => 200,
                    'sellerSpecialFee' => 200,
                    'associationFee' => 20,
                    'storageFee' => 100,
                    'total' => 5520
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