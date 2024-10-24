<script setup lang="ts">
import { ref, watch } from 'vue';

const VehicleTypes = {
  COMMON: 'common',
  LUXURY: 'luxury'
} as const;

type VehicleType = typeof VehicleTypes[keyof typeof VehicleTypes];

interface BidCalculation {
  basePrice: number;
  basicBuyerFee: number;
  sellerSpecialFee: number;
  associationFee: number;
  storageFee: number;
  total: number;
}

const basePrice = ref<string>('');
const vehicleType = ref<VehicleType>(VehicleTypes.COMMON);
const calculation = ref<BidCalculation | null>(null);
const isLoading = ref(false);
const error = ref<string | null>(null);

const calculateBid = async () => {
  if (!basePrice.value || isNaN(Number(basePrice.value)) || Number(basePrice.value) < 0) {
    error.value = 'Please enter a valid price';
    return;
  }

  isLoading.value = true;
  error.value = null;

  try {
    const response = await fetch('/api/calculate-bid', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        basePrice: Number(basePrice.value),
        vehicleType: vehicleType.value,
      }),
    });

    if (!response.ok) {
      throw new Error('Failed to calculate bid');
    }

    const data = await response.json();
    calculation.value = data.data;
  } catch (err) {
    error.value = 'An error occurred while calculating the bid';
  } finally {
    isLoading.value = false;
  }
};

watch([basePrice, vehicleType], () => {
  if (basePrice.value) {
    calculateBid();
  }
});
</script>

<template>
  <div class="max-w-2xl mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">
      <h1 class="text-2xl font-bold mb-6 text-gray-800">Car Auction Bid Calculator</h1>

      <div class="space-y-4">
        <!-- Input Fields -->
        <div class="space-y-4">
          <div>
            <label for="price" class="block text-sm font-medium text-gray-700">
              Vehicle Base Price ($)
            </label>
            <input
              id="price"
              type="number"
              min="0"
              step="0.01"
              v-model="basePrice"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
              placeholder="Enter base price"
            />
          </div>

          <div>
            <label for="type" class="block text-sm font-medium text-gray-700">
              Vehicle Type
            </label>
            <select
              id="type"
              v-model="vehicleType"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            >
              <option :value="VehicleTypes.COMMON">Common</option>
              <option :value="VehicleTypes.LUXURY">Luxury</option>
            </select>
          </div>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="text-red-600 text-sm">{{ error }}</div>

        <!-- Loading State -->
        <div v-if="isLoading" class="text-gray-500 text-sm">Calculating...</div>

        <!-- Results -->
        <div v-if="calculation" class="mt-6 space-y-4 border-t pt-4">
          <h2 class="text-lg font-semibold text-gray-800">Calculation Results</h2>

          <div class="space-y-2">
            <div class="flex justify-between">
              <span class="text-gray-600">Base Price:</span>
              <span class="font-medium">${{ calculation.basePrice.toFixed(2) }}</span>
            </div>

            <div class="flex justify-between">
              <span class="text-gray-600">Basic Buyer Fee:</span>
              <span class="font-medium">${{ calculation.basicBuyerFee.toFixed(2) }}</span>
            </div>

            <div class="flex justify-between">
              <span class="text-gray-600">Seller Special Fee:</span>
              <span class="font-medium">${{ calculation.sellerSpecialFee.toFixed(2) }}</span>
            </div>

            <div class="flex justify-between">
              <span class="text-gray-600">Association Fee:</span>
              <span class="font-medium">${{ calculation.associationFee.toFixed(2) }}</span>
            </div>

            <div class="flex justify-between">
              <span class="text-gray-600">Storage Fee:</span>
              <span class="font-medium">${{ calculation.storageFee.toFixed(2) }}</span>
            </div>

            <div class="flex justify-between border-t pt-2 text-lg font-semibold">
              <span>Total:</span>
              <span>${{ calculation.total.toFixed(2) }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>