<template>
  <EcommerceLayout>
    <div class="min-h-screen bg-gray-50 py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
          <p class="text-gray-600 mt-2">Review your selected items and proceed to checkout</p>
        </div>

        <div v-if="cartItems.length === 0" class="text-center py-16">
          <ShoppingCartIcon class="w-24 h-24 text-gray-300 mx-auto mb-6" />
          <h2 class="text-2xl font-semibold text-gray-900 mb-4">Your cart is empty</h2>
          <p class="text-gray-600 mb-8">Add some products to get started</p>
          <Button as="a" href="/products" class="text-lg px-8 py-3">
            Browse Products
          </Button>
        </div>

        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Cart Items -->
          <div class="lg:col-span-2 space-y-6">
            <div
              v-for="item in cartItems"
              :key="item.id"
              class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm"
            >
              <div class="flex items-start space-x-6">
                <img
                  :src="item.image"
                  :alt="item.name"
                  class="w-24 h-24 object-cover rounded-xl flex-shrink-0"
                />
                
                <div class="flex-1 min-w-0">
                  <div class="flex items-start justify-between">
                    <div>
                      <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ item.name }}</h3>
                      <p class="text-gray-600 text-sm mb-2">{{ item.description }}</p>
                      <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span>Plan: {{ item.plan }}</span>
                        <span>Billing: {{ item.billing }}</span>
                      </div>
                    </div>
                    <Button
                      @click="removeItem(item.id)"
                      variant="ghost"
                      size="sm"
                      class="text-red-600 hover:text-red-700 hover:bg-red-50"
                    >
                      <TrashIcon class="w-4 h-4" />
                    </Button>
                  </div>

                  <div class="mt-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                      <label class="text-sm font-medium text-gray-700">Quantity:</label>
                      <div class="flex items-center border border-gray-300 rounded-lg">
                        <Button
                          @click="updateQuantity(item.id, item.quantity - 1)"
                          variant="ghost"
                          size="sm"
                          :disabled="item.quantity <= 1"
                          class="px-3 py-1"
                        >
                          <MinusIcon class="w-4 h-4" />
                        </Button>
                        <span class="px-4 py-1 text-sm font-medium">{{ item.quantity }}</span>
                        <Button
                          @click="updateQuantity(item.id, item.quantity + 1)"
                          variant="ghost"
                          size="sm"
                          class="px-3 py-1"
                        >
                          <PlusIcon class="w-4 h-4" />
                        </Button>
                      </div>
                    </div>
                    
                    <div class="text-right">
                      <div class="text-2xl font-bold text-gray-900">${{ item.price * item.quantity }}</div>
                      <div class="text-sm text-gray-500">${{ item.price }} each</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Continue Shopping -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
              <Button variant="outline" as="a" href="/products" class="flex items-center">
                <ArrowLeftIcon class="w-4 h-4 mr-2" />
                Continue Shopping
              </Button>
              
              <Button
                @click="clearCart"
                variant="ghost"
                class="text-red-600 hover:text-red-700 hover:bg-red-50"
              >
                Clear Cart
              </Button>
            </div>
          </div>

          <!-- Order Summary -->
          <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm sticky top-6">
              <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
              
              <div class="space-y-4 mb-6">
                <div class="flex justify-between">
                  <span class="text-gray-600">Subtotal</span>
                  <span class="font-medium">${{ subtotal }}</span>
                </div>
                
                <div class="flex justify-between">
                  <span class="text-gray-600">Setup Fee</span>
                  <span class="font-medium">${{ setupFee }}</span>
                </div>
                
                <div class="flex justify-between">
                  <span class="text-gray-600">Tax</span>
                  <span class="font-medium">${{ tax }}</span>
                </div>
                
                <div class="flex justify-between text-green-600">
                  <span>Annual Discount (20%)</span>
                  <span>-${{ discount }}</span>
                </div>
                
                <div class="border-t border-gray-200 pt-4">
                  <div class="flex justify-between text-lg font-semibold">
                    <span>Total</span>
                    <span>${{ total }}</span>
                  </div>
                  <p class="text-sm text-gray-500 mt-1">Billed {{ billingCycle }}</p>
                </div>
              </div>

              <!-- Promo Code -->
              <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Promo Code</label>
                <div class="flex">
                  <input
                    v-model="promoCode"
                    type="text"
                    placeholder="Enter code"
                    class="flex-1 px-3 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  />
                  <Button
                    @click="applyPromoCode"
                    class="rounded-l-none"
                    :disabled="!promoCode.trim()"
                  >
                    Apply
                  </Button>
                </div>
              </div>

              <!-- Billing Cycle Toggle -->
              <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-center justify-between mb-2">
                  <span class="font-medium text-gray-900">Billing Cycle</span>
                  <span class="text-sm text-green-600 font-medium">Save 20% yearly</span>
                </div>
                <div class="flex items-center space-x-4">
                  <label class="flex items-center">
                    <input
                      v-model="billingCycle"
                      type="radio"
                      value="monthly"
                      class="mr-2 text-blue-600 focus:ring-blue-500"
                    />
                    <span class="text-sm">Monthly</span>
                  </label>
                  <label class="flex items-center">
                    <input
                      v-model="billingCycle"
                      type="radio"
                      value="yearly"
                      class="mr-2 text-blue-600 focus:ring-blue-500"
                    />
                    <span class="text-sm">Yearly</span>
                  </label>
                </div>
              </div>

              <!-- Checkout Button -->
              <Button class="w-full text-lg py-3 mb-4" @click="proceedToCheckout">
                Proceed to Checkout
              </Button>
              
              <div class="text-center text-sm text-gray-500">
                <p class="mb-2">Secure checkout powered by Stripe</p>
                <div class="flex items-center justify-center space-x-2">
                  <ShieldCheckIcon class="w-4 h-4" />
                  <span>SSL secured</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import { Button } from '@/components/ui/button'
import { 
  ShoppingCartIcon,
  TrashIcon,
  MinusIcon,
  PlusIcon,
  ArrowLeftIcon,
  ShieldCheckIcon
} from '@heroicons/vue/24/outline'

const promoCode = ref('')
const billingCycle = ref('yearly')

// Mock cart data
const cartItems = ref([
  {
    id: 1,
    name: 'Professional Plan',
    description: 'Advanced warehouse management with analytics',
    plan: 'Professional',
    billing: 'Yearly',
    price: 159,
    quantity: 1,
    image: '/api/placeholder/150/150'
  },
  {
    id: 2,
    name: 'Mobile App Access',
    description: 'iOS and Android apps for warehouse staff',
    plan: 'Add-on',
    billing: 'Yearly',
    price: 29,
    quantity: 2,
    image: '/api/placeholder/150/150'
  }
])

const subtotal = computed(() => {
  return cartItems.value.reduce((sum, item) => sum + (item.price * item.quantity), 0)
})

const setupFee = computed(() => {
  return cartItems.value.length > 0 ? 50 : 0
})

const tax = computed(() => {
  return Math.round((subtotal.value + setupFee.value) * 0.08 * 100) / 100
})

const discount = computed(() => {
  if (billingCycle.value === 'yearly') {
    return Math.round(subtotal.value * 0.2 * 100) / 100
  }
  return 0
})

const total = computed(() => {
  return Math.round((subtotal.value + setupFee.value + tax.value - discount.value) * 100) / 100
})

const updateQuantity = (itemId: number, newQuantity: number) => {
  if (newQuantity < 1) return
  
  const item = cartItems.value.find(item => item.id === itemId)
  if (item) {
    item.quantity = newQuantity
  }
}

const removeItem = (itemId: number) => {
  cartItems.value = cartItems.value.filter(item => item.id !== itemId)
}

const clearCart = () => {
  if (confirm('Are you sure you want to clear your cart?')) {
    cartItems.value = []
  }
}

const applyPromoCode = () => {
  // Mock promo code functionality
  if (promoCode.value.toUpperCase() === 'SAVE10') {
    alert('Promo code applied! 10% additional discount.')
  } else {
    alert('Invalid promo code. Please try again.')
  }
  promoCode.value = ''
}

const proceedToCheckout = () => {
  // This would typically navigate to a checkout page
  alert('Proceeding to checkout...')
}
</script>