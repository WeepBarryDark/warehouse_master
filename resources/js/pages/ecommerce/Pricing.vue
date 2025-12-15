<template>
  <EcommerceLayout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-50 to-purple-50 py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
          Simple, Transparent Pricing
        </h1>
        <p class="text-xl text-gray-600 mb-8">
          Choose the perfect plan for your warehouse size and requirements. All plans include free setup and 24/7 support.
        </p>
        
        <!-- Billing Toggle -->
        <div class="flex items-center justify-center space-x-4 mb-8">
          <span :class="billingCycle === 'monthly' ? 'text-gray-900 font-medium' : 'text-gray-500'">Monthly</span>
          <Button
            @click="toggleBilling"
            :class="[
              'relative inline-flex h-6 w-11 items-center rounded-full transition-colors',
              billingCycle === 'yearly' ? 'bg-blue-600' : 'bg-gray-200'
            ]"
          >
            <span
              :class="[
                'inline-block h-4 w-4 transform rounded-full bg-white transition-transform',
                billingCycle === 'yearly' ? 'translate-x-6' : 'translate-x-1'
              ]"
            />
          </Button>
          <span :class="billingCycle === 'yearly' ? 'text-gray-900 font-medium' : 'text-gray-500'">
            Yearly
            <span class="ml-1 px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">Save 20%</span>
          </span>
        </div>
      </div>
    </section>

    <!-- Pricing Cards -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div
            v-for="plan in pricingPlans"
            :key="plan.id"
            :class="[
              'relative rounded-2xl border-2 p-8 shadow-lg transition-all duration-300 hover:shadow-xl',
              plan.popular ? 'border-blue-500 bg-blue-50' : 'border-gray-200 bg-white hover:border-blue-300'
            ]"
          >
            <!-- Popular Badge -->
            <div v-if="plan.popular" class="absolute -top-4 left-1/2 transform -translate-x-1/2">
              <span class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-full text-sm font-medium">
                Most Popular
              </span>
            </div>

            <div class="text-center">
              <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ plan.name }}</h3>
              <p class="text-gray-600 mb-6">{{ plan.description }}</p>
              
              <div class="mb-6">
                <span class="text-4xl font-bold text-gray-900">
                  ${{ billingCycle === 'yearly' ? plan.yearlyPrice : plan.monthlyPrice }}
                </span>
                <span class="text-gray-600 ml-2">
                  /{{ billingCycle === 'yearly' ? 'year' : 'month' }}
                </span>
              </div>

              <Button 
                :class="[
                  'w-full mb-8',
                  plan.popular ? 'bg-blue-600 hover:bg-blue-700' : ''
                ]"
                :variant="plan.popular ? 'default' : 'outline'"
              >
                {{ plan.buttonText }}
              </Button>
            </div>

            <!-- Features List -->
            <div class="space-y-4">
              <div
                v-for="feature in plan.features"
                :key="feature.name"
                class="flex items-start"
              >
                <CheckCircleIcon 
                  :class="[
                    'w-5 h-5 mr-3 mt-0.5 flex-shrink-0',
                    feature.included ? 'text-green-500' : 'text-gray-300'
                  ]"
                />
                <span 
                  :class="[
                    'text-sm',
                    feature.included ? 'text-gray-700' : 'text-gray-400'
                  ]"
                >
                  {{ feature.name }}
                  <span v-if="feature.limit" class="text-gray-500">({{ feature.limit }})</span>
                </span>
              </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 pt-6 border-t border-gray-200">
              <div class="text-sm text-gray-600 space-y-2">
                <div class="flex items-center">
                  <UsersIcon class="w-4 h-4 mr-2" />
                  Up to {{ plan.users }} users
                </div>
                <div class="flex items-center">
                  <BuildingStorefrontIcon class="w-4 h-4 mr-2" />
                  {{ plan.locations }} locations
                </div>
                <div class="flex items-center">
                  <PhoneIcon class="w-4 h-4 mr-2" />
                  {{ plan.support }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
            Frequently Asked Questions
          </h2>
          <p class="text-xl text-gray-600">
            Everything you need to know about our pricing and plans
          </p>
        </div>

        <div class="space-y-4">
          <div
            v-for="faq in faqs"
            :key="faq.id"
            class="bg-white rounded-2xl border border-gray-200 overflow-hidden"
          >
            <button
              @click="toggleFaq(faq.id)"
              class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors"
            >
              <span class="font-semibold text-gray-900">{{ faq.question }}</span>
              <ChevronDownIcon 
                :class="[
                  'w-5 h-5 text-gray-500 transition-transform',
                  openFaqs.includes(faq.id) ? 'rotate-180' : ''
                ]"
              />
            </button>
            <div 
              v-if="openFaqs.includes(faq.id)"
              class="px-6 pb-4 text-gray-600 leading-relaxed"
            >
              {{ faq.answer }}
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Enterprise CTA -->
    <section class="py-20 bg-gradient-to-r from-blue-900 to-purple-900">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
          Need a Custom Solution?
        </h2>
        <p class="text-xl text-blue-100 mb-8">
          For large enterprises with complex requirements, we offer custom solutions tailored to your specific needs.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Button size="lg" class="bg-white text-blue-900 hover:bg-gray-100 text-lg px-8 py-4">
            Contact Sales
          </Button>
          <Button variant="outline" size="lg" class="border-white text-white hover:bg-white hover:text-blue-900 text-lg px-8 py-4">
            Schedule Demo
          </Button>
        </div>
      </div>
    </section>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import { Button } from '@/components/ui/button'
import { 
  CheckCircleIcon,
  ChevronDownIcon,
  UsersIcon,
  BuildingStorefrontIcon,
  PhoneIcon
} from '@heroicons/vue/24/outline'

const billingCycle = ref('monthly')
const openFaqs = ref<number[]>([])

const toggleBilling = () => {
  billingCycle.value = billingCycle.value === 'monthly' ? 'yearly' : 'monthly'
}

const toggleFaq = (id: number) => {
  if (openFaqs.value.includes(id)) {
    openFaqs.value = openFaqs.value.filter(faqId => faqId !== id)
  } else {
    openFaqs.value.push(id)
  }
}

const pricingPlans = ref([
  {
    id: 1,
    name: 'Starter',
    description: 'Perfect for small warehouses getting started',
    monthlyPrice: 99,
    yearlyPrice: 79,
    users: 5,
    locations: '1 location',
    support: 'Email support',
    buttonText: 'Start Free Trial',
    popular: false,
    features: [
      { name: 'Real-time inventory tracking', included: true },
      { name: 'Basic reporting dashboard', included: true },
      { name: 'Barcode scanning', included: true },
      { name: 'Order management', included: true, limit: 'up to 1,000/month' },
      { name: 'Mobile app access', included: false },
      { name: 'Advanced analytics', included: false },
      { name: 'Workflow automation', included: false },
      { name: 'API access', included: false }
    ]
  },
  {
    id: 2,
    name: 'Professional',
    description: 'Ideal for growing businesses with advanced needs',
    monthlyPrice: 199,
    yearlyPrice: 159,
    users: 25,
    locations: 'Up to 5 locations',
    support: 'Priority phone & email',
    buttonText: 'Start Free Trial',
    popular: true,
    features: [
      { name: 'Everything in Starter', included: true },
      { name: 'Mobile app access', included: true },
      { name: 'Advanced analytics & reporting', included: true },
      { name: 'Multi-location support', included: true },
      { name: 'Order management', included: true, limit: 'up to 10,000/month' },
      { name: 'Quality control workflows', included: true },
      { name: 'Basic API access', included: true },
      { name: 'Workflow automation', included: false }
    ]
  },
  {
    id: 3,
    name: 'Enterprise',
    description: 'For large operations requiring maximum flexibility',
    monthlyPrice: 399,
    yearlyPrice: 319,
    users: 'Unlimited',
    locations: 'Unlimited locations',
    support: '24/7 dedicated support',
    buttonText: 'Contact Sales',
    popular: false,
    features: [
      { name: 'Everything in Professional', included: true },
      { name: 'Unlimited order processing', included: true },
      { name: 'Full workflow automation', included: true },
      { name: 'Custom integrations', included: true },
      { name: 'Advanced API access', included: true },
      { name: 'Custom reporting', included: true },
      { name: 'Dedicated account manager', included: true },
      { name: 'SLA guarantees', included: true }
    ]
  }
])

const faqs = ref([
  {
    id: 1,
    question: 'Can I change my plan at any time?',
    answer: 'Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately, and billing adjustments are prorated.'
  },
  {
    id: 2,
    question: 'Is there a free trial available?',
    answer: 'We offer a 14-day free trial for all plans. No credit card required to start your trial.'
  },
  {
    id: 3,
    question: 'What payment methods do you accept?',
    answer: 'We accept all major credit cards, ACH transfers, and can arrange invoicing for Enterprise customers.'
  },
  {
    id: 4,
    question: 'Is my data secure?',
    answer: 'Yes, we use enterprise-grade security with SSL encryption, regular backups, and SOC 2 compliance to keep your data safe.'
  },
  {
    id: 5,
    question: 'Do you offer implementation support?',
    answer: 'Yes, all plans include free setup assistance. Professional and Enterprise plans include dedicated onboarding and training.'
  },
  {
    id: 6,
    question: 'Can I integrate with my existing systems?',
    answer: 'We offer integrations with popular ERP, accounting, and e-commerce platforms. Custom integrations are available for Enterprise customers.'
  }
])
</script>