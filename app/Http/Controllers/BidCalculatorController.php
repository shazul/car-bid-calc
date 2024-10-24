<?php


namespace App\Http\Controllers;

use App\Http\Requests\CalculateBidRequest;
use App\Services\BidCalculatorService;
use Illuminate\Http\JsonResponse;

class BidCalculatorController extends Controller
{
    public function __construct(
        private readonly BidCalculatorService $calculatorService
    ) {}

    /**
     * Calculate bid amount and fees breakdown
     *
     * @param CalculateBidRequest $request
     * @return JsonResponse
     */
    public function calculate(CalculateBidRequest $request): JsonResponse
    {
        $result = $this->calculatorService->calculate(
            basePrice: $request->validated('basePrice'),
            vehicleType: $request->validated('vehicleType')
        );

        return response()->json([
            'status' => 'success',
            'data' => $result
        ]);
    }
}